<?php

declare(strict_types=1);

namespace App\UI\Accessory\Forms\SignIn;

use Flexsyscz\Forms\FormValues;


final class SignInFormValues extends FormValues
{
	public function __construct(
		public string $username,
		public string $password,
	) {
	}
}
