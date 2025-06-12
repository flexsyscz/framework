<?php

declare(strict_types=1);

namespace App\UI\Accessory\Forms\UsersFilter;

use Flexsyscz\Datagrids\DatagridControl\Accessory\Forms\Filter\FilterFormValues;


class UsersFilterFormValues extends FilterFormValues
{
	public function __construct(
		public ?string $username = null,
	)
	{}
}
