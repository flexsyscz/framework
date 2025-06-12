<?php

declare(strict_types=1);

namespace App\UI\Front\Home;

use App\UI\Accessory\Presenters\BaseTemplate;
use Flexsyscz\Application\UI\Presenters\Presenter;


final class HomeTemplate extends BaseTemplate
{
	public HomePresenter|Presenter $presenter;
}
