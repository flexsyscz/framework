<?php

declare(strict_types=1);

namespace App\Model\Roles;

use Nextras\Orm\Repository\Repository;


final class RolesRepository extends Repository
{
	public function __construct(RolesMapper $mapper, ...$ags)
	{
		parent::__construct($mapper, ...$ags);
	}


	/**
	 * @return class-string[]
	 */
	public static function getEntityClassNames(): array
	{
		return [Role::class];
	}
}
