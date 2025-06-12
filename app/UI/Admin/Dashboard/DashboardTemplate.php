<?php

declare(strict_types=1);

namespace App\UI\Admin\Dashboard;

use App\UI\Accessory\Presenters\BaseTemplate;
use Flexsyscz\Application\UI\Presenters\Presenter;


final class DashboardTemplate extends BaseTemplate
{
	public DashboardPresenter|Presenter $presenter;
}
