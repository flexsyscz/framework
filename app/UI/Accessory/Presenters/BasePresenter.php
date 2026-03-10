<?php

declare(strict_types=1);

namespace App\UI\Accessory\Presenters;

use App\Model\Languages\Languages;
use Flexsyscz\Application\UI\Presenters\Presenter;
use Flexsyscz\Security\User\LoggedUser;


/**
 * @property-read BaseTemplate $template
 */
abstract class BasePresenter extends Presenter
{
	use PresenterCompositionTrait;


	public function checkRequirements(mixed $element): void
	{
		if (method_exists($this, 'checkPermissions')) {
			if (!$this->checkPermissions($element)) {
				$this->registerDefaultTranslations();
				if ($this->getUser()->isLoggedIn()) {
					$this->flashError('!app.flashes.notAuthorized');
				}
				$this->redirect(':Front:Sign:in');
			}
		}

		parent::checkRequirements($element);
	}


	public function beforeRender(): void
	{
		parent::beforeRender();

		$user = $this->getUser();

		$this->template->user = $user;
		$this->template->userEntity = $user instanceof LoggedUser ? $this->getUser()->getEntity() : null;
		$this->template->identity = $this->getUser()->getIdentity();

		$language = Languages::tryFrom($this->translatorNamespace->translator->getLanguage());
		$this->template->language = $language;

		if (method_exists($this, 'setJsScope')) {
			$this->setJsScope();
		}
	}
}
