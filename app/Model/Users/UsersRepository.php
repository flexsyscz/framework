<?php

declare(strict_types=1);

namespace App\Model\Users;

use Nextras\Orm\Repository\IDependencyProvider;
use Nextras\Orm\Repository\Repository;


/**
 * @extends Repository<User>
 */
final class UsersRepository extends Repository
{
	public function __construct(UsersMapper $mapper, ?IDependencyProvider $dependencyProvider = null)
	{
		parent::__construct($mapper, $dependencyProvider);
	}


	/**
	 * @return class-string[]
	 */
	public static function getEntityClassNames(): array
	{
		return [User::class];
	}
}
