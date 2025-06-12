<?php

declare(strict_types=1);

namespace App\Model\UserAuthTokens;

use App\Model\Users\User;
use Flexsyscz\DateTime\DateTimeProvider;
use Flexsyscz\Model\Facade;
use Flexsyscz\Model\Values;
use Nette\Utils\Random;
use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Entity\IEntity;
use Ramsey\Uuid\Uuid;


/**
 * @method UserAuthTokensRepository      getRepository()
 */
final class UserAuthTokensFacade extends Facade
{
	private const TokenValueLength = 20;
	private const TokenValueExpires = '3 months';


	public function create(UserAuthTokenValues|Values $values): UserAuthToken|IEntity
	{
		$entity = new UserAuthToken();
		$entity->id = Uuid::uuid4();
		$entity->user = $values->user;
		$entity->tokenValue = Random::generate(self::TokenValueLength);
		$entity->remoteAddress = $values->remoteAddress;
		$entity->userAgent = $values->userAgent;


		$this->getRepository()->persist($entity);
		return $entity;
	}


	public function update(UserAuthToken|IEntity $entity, UserAuthTokenValues|Values $values): void
	{
		$entity->user = $values->user;
		$entity->remoteAddress = $values->remoteAddress;
		$entity->userAgent = $values->userAgent;

		$this->getRepository()->persist($entity);
	}


	public function delete(UserAuthToken|IEntity $entity): void
	{
		$this->getRepository()->remove($entity);
	}


	public function getByToken(string $token): UserAuthToken|IEntity|null
	{
		return $this->getRepository()->getBy(['tokenValue' => $token]);
	}


	public function flushInvalidTokens(User $user): void
	{
		$threshold = DateTimeProvider::now()->modify(sprintf('-%s', self::TokenValueExpires));
		$authTokens = $user->authTokens->toCollection()->findBy([
			ICollection::AND,
			[
				ICollection::AND,
				'createdAt<' => $threshold,
			],
			[
				ICollection::OR,
				'updatedAt' => null,
				'updatedAt<' => $threshold,
			],
		]);

		foreach ($authTokens->fetchAll() as $authToken) {
			$this->delete($authToken);
		}
	}
}
