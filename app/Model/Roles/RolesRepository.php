<?php

declare(strict_types=1);

namespace App\Model\Roles;

use Nextras\Orm\Repository\IDependencyProvider;
use Nextras\Orm\Repository\Repository;


/**
 * @extends Repository<Role>
 */
final class RolesRepository extends Repository
{
	public function __construct(RolesMapper $mapper, ?IDependencyProvider $dependencyProvider = null)
	{
		parent::__construct($mapper, $dependencyProvider);
	}


	/**
	 * @return class-string[]
	 */
	public static function getEntityClassNames(): array
	{
		return [Role::class];
	}
}
