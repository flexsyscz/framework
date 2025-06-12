<?php

declare(strict_types=1);

namespace App\Model\Users;

use Flexsyscz\Model\Values;


final class UserValues implements Values
{
	public function __construct(
		public readonly string $username,
		public readonly string $password,
	)
	{
	}
}
