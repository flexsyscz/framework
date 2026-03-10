<?php

declare (strict_types = 1);

namespace App\UI\Accessory\Presenters;

use App\Model\Languages\Languages;
use Nette\Application\Attributes\Persistent;


trait PresenterCompositionTrait
{
	#[Persistent]
	public ?string $locale;

	#[Persistent]
	public ?string $country;


	public function __construct()
	{
		$this->onStartup[] = function () {
			$this->registerDefaultTranslations();
		};
	}


	protected function registerDefaultTranslations(): void
	{
		$repository = $this->translatorNamespace->repository;
		$defaultNamespace = $repository->getConfigurator()->defaultNamespace;

		if (!$repository->has($defaultNamespace)) {
			$repository->add(__DIR__ . '/translations');
			if (isset($this->locale)) {
				$languageCode = sprintf('%s_%s', $this->locale, $this->country ?? $this->locale);
				foreach (Languages::cases() as $language) {
					if ($language->getShortCode() === $this->locale || $language->value === $languageCode) {
						$this->translatorNamespace->translator->setLanguage($language);
					}
				}
			}
		}
	}
}
