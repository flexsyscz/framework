<?php

declare(strict_types=1);

namespace App\Model\Roles;

use Flexsyscz\Model\Values;


final class RoleValues implements Values
{
	public function __construct(
		public readonly string $name,
		public readonly ?string $module = null,
		public readonly ?string $title = null,
		public readonly ?string $description = null,
	) {
	}
}
