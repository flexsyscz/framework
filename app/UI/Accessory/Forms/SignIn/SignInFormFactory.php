<?php

declare(strict_types = 1);

namespace App\UI\Accessory\Forms\SignIn;

use App\UI\Accessory\Forms\FormFactory;
use Flexsyscz\Application\DI\Injectable;
use Flexsyscz\Localization\Translations\TranslatedComponent;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;


final class SignInFormFactory implements Injectable
{
	use TranslatedComponent;

	private FormFactory $formFactory;
	private User $user;

	/** @var callable */
	private $callback;


	public function __construct(FormFactory $formFactory, User $user)
	{
		$this->formFactory = $formFactory;
		$this->user = $user;
	}


	public function create(callable $callback): Form
	{
		$this->callback = $callback;
		$form = $this->formFactory->create();
		$form->setTranslator($this->translatorNamespace);
		$form->getElementPrototype()
			->setAttribute('class', 'ajax')
			->setAttribute('data-naja-force-redirect', true);

		$form->addText('username', 'username.label')
			->setRequired('username.rules.required');

		$form->addPassword('password', 'password.label')
			->setRequired('password.rules.required');

		$form->addSubmit('submit', 'submit.label');

		$form->onSuccess[] = [$this, 'onSuccess'];

		return $form;
	}


	public function onSuccess(Form $form, SignInFormValues $values): void
	{
		try {
			$this->user->login($values->username, $values->password);
			call_user_func($this->callback);

		} catch (AuthenticationException $e) {
			sleep(3);
			$form->addError($e->getMessage());
		}
	}
}
