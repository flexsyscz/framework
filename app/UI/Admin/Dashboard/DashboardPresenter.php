<?php

declare(strict_types=1);

namespace App\UI\Admin\Dashboard;

use App\UI\Accessory\Datagrids\Users\UsersDatagrid;
use App\UI\Accessory\Datagrids\Users\UsersDatagridFactory;
use App\UI\Accessory\Presenters\BasePresenter;
use Flexsyscz\Security\Authorizator\Traits\AuthenticationRequired;


/**
 * @property-read DashboardTemplate $template
 */
final class DashboardPresenter extends BasePresenter
{
	use AuthenticationRequired;

	private UsersDatagridFactory $usersDatagridFactory;


	public function __construct(UsersDatagridFactory $usersDatagridFactory)
	{
		parent::__construct();

		$this->usersDatagridFactory = $usersDatagridFactory;
	}


	public function actionDefault(): void
	{
	}


	public function renderDefault(): void
	{
	}


	protected function createComponentUsersDatagrid(): UsersDatagrid
	{
		return $this->usersDatagridFactory->create();
	}
}
