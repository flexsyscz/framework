<?php

declare(strict_types=1);

namespace App\Model\Roles;

use App\Exceptions\InvalidArgumentException;
use Flexsyscz\Model\Facade;
use Flexsyscz\Model\Values;
use Nextras\Orm\Entity\IEntity;
use Ramsey\Uuid\Uuid;


/**
 * @method RolesRepository      getRepository()
 */
final class RolesFacade extends Facade
{
	public function create(RoleValues|Values $values): Role
	{
		$entity = new Role();
		$entity->id = Uuid::uuid4();
		$entity->name = $values->name;
		$entity->module = $values->module;
		$entity->title = $values->title;
		$entity->description = $values->description;

		$this->getRepository()->persist($entity);
		return $entity;
	}


	public function update(Role|IEntity $entity, RoleValues|Values $values): void
	{
		$entity->title = $values->title;
		$entity->description = $values->description;

		$this->getRepository()->persist($entity);
	}


	public function delete(Role|IEntity $entity): void
	{
		$this->getRepository()->remove($entity);
	}
}
