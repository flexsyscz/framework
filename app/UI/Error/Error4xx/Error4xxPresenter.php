<?php

declare(strict_types=1);

namespace App\UI\Error\Error4xx;

use App\Model\Languages\Languages;
use Nette;
use Nette\Application\Attributes\Requires;


/**
 * Handles 4xx HTTP error responses.
 *
 * @property-read Error4xxTemplate $template
 */
#[Requires(methods: '*', forward: true)]
final class Error4xxPresenter extends Nette\Application\UI\Presenter
{
	public function renderDefault(Nette\Application\BadRequestException $exception): void
	{
		$code = $exception->getCode();
		$locale = $this->resolveLocale();
		[$title, $description] = $this->resolveMessage($code, $locale);

		$this->template->httpCode = $code;
		$this->template->locale = $locale;
		$this->template->errorTitle = $title;
		$this->template->errorDescription = $description;
		$this->template->backLabel = $locale === 'en' ? 'Back to homepage' : 'Zpět na úvodní stránku';
		$this->template->setFile(__DIR__ . '/4xx.latte');
	}


	/**
	 * Returns the localized [title, description] for the given HTTP status code;
	 * unknown codes fall back to a generic message.
	 *
	 * @return array{string, string}
	 */
	private function resolveMessage(int $code, string $locale): array
	{
		$messages = [
			'cs' => [
				403 => ['Přístup odepřen', 'Nemáte oprávnění zobrazit tuto stránku.'],
				404 => ['Stránka nenalezena', 'Požadovanou stránku se nepodařilo najít. Je možné, že adresa není správná nebo stránka už neexistuje.'],
				410 => ['Stránka odstraněna', 'Tato stránka byla z webu odstraněna. Omlouváme se za nepříjemnosti.'],
				0 => ['Něco se pokazilo', 'Tvůj požadavek se nepodařilo zpracovat.'],
			],
			'en' => [
				403 => ['Access Denied', 'You do not have permission to view this page.'],
				404 => ['Page Not Found', 'The page you requested could not be found. The address may be incorrect or the page no longer exists.'],
				410 => ['Page Removed', 'This page has been taken off the site. We apologize for the inconvenience.'],
				0 => ['Oops...', 'Your request could not be processed.'],
			],
		];

		return $messages[$locale][$code] ?? $messages[$locale][0];
	}


	/**
	 * Resolves the display locale from the original request path; Czech takes precedence
	 * when no supported locale is present in the URL.
	 */
	private function resolveLocale(): string
	{
		$path = trim($this->getHttpRequest()->getUrl()->getPath(), '/');
		$firstSegment = explode('/', $path)[0];

		return Languages::fromLocale($firstSegment)->getShortCode();
	}
}
