<?php

declare(strict_types = 1);

namespace App\UI\Accessory\Datagrids\Users;

use App\Model\Users\User;
use App\Model\Users\UsersFacade;
use App\UI\Accessory\Forms\UsersFilter\UsersFilterFormFactory;
use App\UI\Accessory\Forms\UsersFilter\UsersFilterFormValues;
use Flexsyscz\Datagrids\DatagridControl\Datagrid;
use Nextras\Orm\Collection\Expression\LikeExpression;
use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Entity\IEntity;


final class UsersDatagrid extends Datagrid
{
	public function __construct(UsersFacade $usersFacade, UsersFilterFormFactory $usersFilterFormFactory)
	{
		$this->onAnchor[] = function() use ($usersFacade, $usersFilterFormFactory) {
			$this->setFilterFormFactory($usersFilterFormFactory)
				->onFilter[] = [$this, 'processFilter'];

			$this->setCollection($usersFacade->findNotDeleted())
				->getTable()
					->addColumn('id')
					->addColumn('username');

			$this->onSelect[] = [$this, 'processSelection'];
		};
	}


	public function processFilter(ICollection $collection, UsersFilterFormValues $values): ICollection
	{
		if ($values->username) {
			$collection = $collection->findBy([
				'username~' => LikeExpression::contains($values->username),
			]);
		}

		return $collection;
	}


	/**
	 * @param User[]|IEntity[] $rows
	 * @return void
	 */
	public function processSelection(array $rows): void
	{
	}
}
