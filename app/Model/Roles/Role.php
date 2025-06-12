<?php

declare(strict_types=1);

namespace App\Model\Roles;

use App\Model\Users\User;
use Flexsyscz\Model\Entity;
use Nette;
use Nextras\Orm\Relationships\ManyHasMany;


/**
 * @property 		string         					$id      					{primary}
 * @property 		string						    $name
 * @property        string|null                     $module
 * @property 		string							$title
 * @property 		string|null						$description
 *
 * @property 		ManyHasMany|User[]				$users						{m:m User::$roles}
 */
final class Role extends Entity implements Nette\Security\Role
{
	public function getRoleId(): string
	{
		return $this->name;
	}
}
