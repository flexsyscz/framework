<?php

declare(strict_types=1);

namespace App\Model\Languages;

use Flexsyscz\Localization\Translations\SupportedLanguages;


enum Languages: string implements SupportedLanguages {
	case Czech = 'cs_CZ';
	case English = 'en_US';


	public function getShortCode(): string
	{
		return preg_replace('#_.+#', '', $this->value);
	}


	public function getDescription(): string
	{
		$descriptions = [
			self::Czech->value => 'Čeština',
			self::English->value => 'English',
		];

		return $descriptions[$this->value];
	}
}
