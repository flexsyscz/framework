<?php

declare(strict_types=1);

namespace App\UI\Accessory\Presenters;

use App\Model\Languages\Languages;
use Flexsyscz\Application\UI\Presenters\Presenter;
use Nette\Application\Attributes\Persistent;


/**
 * @property-read BaseTemplate $template
 */
abstract class BasePresenter extends Presenter
{
	#[Persistent]
	public ?string $locale;

	#[Persistent]
	public ?string $country;


	public function startup(): void
	{
		parent::startup();

		$this->translatorNamespace->repository->add(__DIR__ . '/translations');
		if (isset($this->locale)) {
			$languageCode = sprintf('%s_%s', $this->locale, $this->country ?? $this->locale);
			foreach (Languages::cases() as $language) {
				if ($language->getShortCode() === $this->locale || $language->value === $languageCode) {
					$this->translatorNamespace->translator->setLanguage($language);
				}
			}
		}
	}


	public function checkRequirements(mixed $element): void
	{
		if (method_exists($this, 'checkPermissions')) {
			if (!$this->checkPermissions($element)) {
				$this->redirect(':Front:Sign:in');
			}
		}

		parent::checkRequirements($element);
	}


	public function beforeRender(): void
	{
		parent::beforeRender();

		$this->template->user = $this->getUser();
		$this->template->identity = $this->getUser()->getIdentity();

		$language = Languages::tryFrom($this->translatorNamespace->translator->getLanguage());
		$this->template->language = $language;

		if (method_exists($this, 'setJsScope')) {
			$this->setJsScope();
		}
	}
}
