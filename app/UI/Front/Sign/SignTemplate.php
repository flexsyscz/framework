<?php

declare(strict_types=1);

namespace App\UI\Front\Sign;

use App\UI\Accessory\Presenters\BaseTemplate;
use Flexsyscz\Application\UI\Presenters\Presenter;


final class SignTemplate extends BaseTemplate
{
	public SignPresenter|Presenter $presenter;
}
