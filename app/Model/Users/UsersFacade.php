<?php

declare(strict_types=1);

namespace App\Model\Users;

use Flexsyscz;
use Flexsyscz\Model\Values;
use Nextras;
use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Entity\IEntity;
use Ramsey\Uuid\Uuid;


/**
 * @extends Flexsyscz\Model\Users\UsersFacade<IEntity>
 *
 * @method getRepository()  UsersRepository
 */
final class UsersFacade extends Flexsyscz\Model\Users\UsersFacade
{
	/**
	 * @param UserValues $values
	 * @return User
	 */
	public function create(Values $values): User
	{
		$entity = new User();
		$entity->id = Uuid::uuid4();
		$entity->username = $values->username;
		$entity->password = $values->password;

		$this->getRepository()->persist($entity);
		return $entity;
	}


	/**
	 * @param User $entity
	 * @param UserValues $values
	 * @return void
	 */
	public function update(IEntity $entity, Values $values): void
	{
	}


	/**
	 * @param User $entity
	 * @return void
	 */
	public function delete(IEntity $entity): void
	{
	}


	/**
	 * @return ICollection<User>
	 */
	public function findNotDeleted(): ICollection
	{
		return $this->getRepository()->findBy(['deletedAt' => null]);
	}


	public function getByUsername(string $username): User|null
	{
		$user = $this->findNotDeleted()->getBy(['username' => $username]);
		if ($user instanceof User) {
			return $user;
		}

		return null;
	}


	public function setPasswordHash(User $user, string $hash): void
	{
		$user->password = $hash;
		$this->getRepository()->persist($user);
	}
}
