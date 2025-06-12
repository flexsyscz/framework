<?php

declare(strict_types=1);

namespace App\Model\Users;

use Nextras\Orm\Repository\Repository;


final class UsersRepository extends Repository
{
	public function __construct(UsersMapper $mapper, ...$ags)
	{
		parent::__construct($mapper, ...$ags);
	}


	/**
	 * @return class-string[]
	 */
	public static function getEntityClassNames(): array
	{
		return [User::class];
	}
}
