<?php

declare(strict_types=1);

namespace App\Model\Users;

use App\Model\Roles\Role;
use App\Model\UserAuthTokens\UserAuthToken;
use Flexsyscz\Model\Entity;
use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Relationships\ManyHasMany;
use Nextras\Orm\Relationships\OneHasMany;


/**
 * @property        string                              $id      					                    {primary}
 * @property        string                              $username
 * @property        string                              $password
 * @property        DateTimeImmutable                   $createdAt
 * @property        DateTimeImmutable|null              $updatedAt
 * @property        DateTimeImmutable|null              $deletedAt
 *
 * @property        OneHasMany|UserAuthToken[]          $authTokens                                     {1:m UserAuthToken::$user}
 * @property        ManyHasMany|Role[]                  $roles                                          {m:m Role::$users, isMain=true}
 */
final class User extends Entity
{
}
