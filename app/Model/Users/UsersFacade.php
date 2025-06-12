<?php

declare(strict_types=1);

namespace App\Model\Users;

use Flexsyscz\Model\Facade;
use Flexsyscz\Model\Values;
use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Entity\IEntity;
use Ramsey\Uuid\Uuid;


final class  UsersFacade extends Facade
{
	public function create(UserValues|Values $values): User|IEntity
	{
		$entity = new User();
		$entity->id = Uuid::uuid4();
		$entity->username = $values->username;
		$entity->password = $values->password;

		$this->getRepository()->persist($entity);
		return $entity;
	}


	public function update(User|IEntity $entity, UserValues|Values $values): void
	{
	}


	public function delete(User|IEntity $entity): void
	{
	}


	public function findNotDeleted(): ICollection
	{
		return $this->getRepository()->findBy(['deletedAt' => null]);
	}


	public function getByUsername(string $username): User|IEntity|null
	{
		return $this->findNotDeleted()->getBy(['username' => $username]);
	}


	public function setPasswordHash(User $user, string $hash): void
	{
		$user->password = $hash;
		$this->getRepository()->persist($user);
	}
}
