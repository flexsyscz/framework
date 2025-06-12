<?php

declare(strict_types=1);

namespace App\Model\UserAuthTokens;

use App\Model\Users\User;
use Flexsyscz\Model\Entity;
use Nextras\Dbal\Utils\DateTimeImmutable;


/**
 * @property        string                                  $id                                 {primary}
 * @property 		User									$user                               {m:1 User::$authTokens}
 * @property 		string									$tokenValue
 * @property 		string									$remoteAddress
 * @property 		string									$userAgent
 * @property        DateTimeImmutable                       $createdAt
 * @property        DateTimeImmutable|null                  $updatedAt
 */
final class UserAuthToken extends Entity
{
}
