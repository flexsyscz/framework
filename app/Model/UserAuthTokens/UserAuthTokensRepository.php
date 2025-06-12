<?php

declare(strict_types=1);

namespace App\Model\UserAuthTokens;

use Nextras\Orm\Repository\Repository;


final class UserAuthTokensRepository extends Repository
{
	public function __construct(UserAuthTokensMapper $mapper, ...$ags)
	{
		parent::__construct($mapper, ...$ags);
	}


	/**
	 * @return class-string[]
	 */
	public static function getEntityClassNames(): array
	{
		return [UserAuthToken::class];
	}
}
