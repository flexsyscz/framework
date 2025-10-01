<?php

declare(strict_types=1);

namespace App\Model\Roles;

use Flexsyscz\Model\Facade;
use Flexsyscz\Model\Values;
use Nextras\Orm\Entity\IEntity;
use Ramsey\Uuid\Uuid;


/**
 * @extends Facade<IEntity>
 * @method RolesRepository      getRepository()
 */
final class RolesFacade extends Facade
{
	/**
	 * @param RoleValues $values
	 * @return Role
	 */
	public function create(Values $values): Role
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


	/**
	 * @param Role $entity
	 * @param RoleValues $values
	 * @return void
	 */
	public function update(IEntity $entity, Values $values): void
	{
		$entity->title = $values->title;
		$entity->description = $values->description;

		$this->getRepository()->persist($entity);
	}


	/**
	 * @param Role $entity
	 * @return void
	 */
	public function delete(IEntity $entity): void
	{
		$this->getRepository()->remove($entity);
	}
}
