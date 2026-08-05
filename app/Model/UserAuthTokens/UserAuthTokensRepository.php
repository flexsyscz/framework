<?php

declare(strict_types=1);

namespace App\Model\UserAuthTokens;

use Nextras\Orm\Repository\IDependencyProvider;
use Nextras\Orm\Repository\Repository;


/**
 * @extends Repository<UserAuthToken>
 */
final class UserAuthTokensRepository extends Repository
{
	public function __construct(UserAuthTokensMapper $mapper, ?IDependencyProvider $dependencyProvider = null)
	{
		parent::__construct($mapper, $dependencyProvider);
	}


	/**
	 * @return class-string[]
	 */
	public static function getEntityClassNames(): array
	{
		return [UserAuthToken::class];
	}
}
