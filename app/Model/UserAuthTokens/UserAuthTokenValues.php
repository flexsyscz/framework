<?php

declare(strict_types=1);

namespace App\Model\UserAuthTokens;

use App\Model\Users\User;
use Flexsyscz\Model\Values;


final class UserAuthTokenValues implements Values
{
	public function __construct(
		public readonly User $user,
		public readonly string $remoteAddress,
		public readonly string $userAgent,
	) {
	}
}
