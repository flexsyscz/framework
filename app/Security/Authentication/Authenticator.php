<?php

declare(strict_types=1);

namespace App\Security\Authentication;

use App\Model\Roles\RolesEnum;
use App\Model\UserAuthTokens\UserAuthTokensFacade;
use App\Model\UserAuthTokens\UserAuthTokenValues;
use App\Model\Users\User;
use App\Model\Users\UsersFacade;
use Flexsyscz\Application\DI\Injectable;
use Flexsyscz\Localization\Translations\TranslatedComponent;
use Nette;
use Nette\Security\IdentityHandler;
use Nette\Security\IIdentity;
use Nette\Security\SimpleIdentity;
use Nextras\Dbal\Drivers\Exception\DriverException;
use Nextras\Orm\Entity\ToArrayConverter;

final class Authenticator implements Nette\Security\Authenticator, IdentityHandler, Injectable
{
	use TranslatedComponent;

	private UsersFacade $usersFacade;
	private UserAuthTokensFacade $userAuthTokensFacade;
	private Nette\Security\Passwords $passwords;


	public function __construct(UsersFacade $usersFacade, UserAuthTokensFacade $userAuthTokensFacade, Nette\Security\Passwords $passwords)
	{
		$this->usersFacade = $usersFacade;
		$this->userAuthTokensFacade = $userAuthTokensFacade;
		$this->passwords = $passwords;
	}


	public function authenticate(string $username, #[\SensitiveParameter] string $password): UserIdentity
	{
		$user = $this->usersFacade->getByUsername($username);
		if (!$user) {
			throw new Nette\Security\AuthenticationException($this->translate('userNotFound'), self::IdentityNotFound);
		}

		if (!$this->passwords->verify($password, $user->password)) {
			// @todo sign in attempts
			throw new Nette\Security\AuthenticationException($this->translate('invalidCredentials'), self::InvalidCredential);
		}

		try {
			if ($this->passwords->needsRehash($user->password)) {
				$this->usersFacade->setPasswordHash($user, $this->passwords->hash($password));
			}
		} catch (DriverException $e) {
			throw new Nette\Security\AuthenticationException($this->translatorNamespace->translate('failure'), self::Failure, $e);
		}

		$this->userAuthTokensFacade->flushInvalidTokens($user);
		$userAuthToken = $this->userAuthTokensFacade->create(new UserAuthTokenValues(
			$user,
			$_SERVER['REMOTE_ADDR'],
			$_SERVER['HTTP_USER_AGENT'],
		));
		$this->userAuthTokensFacade->flush();

		list($roles, $data) = $this->hydrateUser($user);
		$data['token'] = $userAuthToken->tokenValue;

		return new UserIdentity($user, $roles, $data);
	}


	public function sleepIdentity(IIdentity $identity): SimpleIdentity
	{
		return new SimpleIdentity($identity->getData()['token']);
	}


	/**
	 * @param IIdentity $identity
	 * @return IIdentity|null
	 * @throws Nette\Security\AuthenticationException
	 */
	public function wakeupIdentity(IIdentity $identity): ?IIdentity
	{
		try {
			$userAuthToken = $this->userAuthTokensFacade->getByToken($identity->getId());
			if ($userAuthToken) {
				$user = $userAuthToken->user;
				$this->userAuthTokensFacade->update($userAuthToken, new UserAuthTokenValues(
					$user,
					$_SERVER['REMOTE_ADDR'],
					$_SERVER['HTTP_USER_AGENT'],
				));
				$this->userAuthTokensFacade->flush();

				list($roles, $data) = $this->hydrateUser($user);
				return new UserIdentity($user, $roles, $data);

			}
		} catch (DriverException $e) {
			throw new Nette\Security\AuthenticationException($this->translatorNamespace->translate('failure'), self::Failure, $e);
		}

		return null;
	}


	private function hydrateUser(User $user): array
	{
		$roles = [];
		foreach ($user->roles as $role) {
			$roles[] = $role->name;
		}

		if (!$roles) {
			$roles[] = RolesEnum::Guest->value;
		}

		$data = $user->toArray(ToArrayConverter::RELATIONSHIP_AS_ID);
		unset($data['password']);

		return [$roles, $data];
	}
}
