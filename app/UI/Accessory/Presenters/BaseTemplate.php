<?php

declare(strict_types=1);

namespace App\UI\Accessory\Presenters;

use App\Model\Languages\Languages;
use App\Security\Authentication\UserIdentity;
use Flexsyscz\Application\UI\Presenters\Presenter;
use Flexsyscz\Application\UI\Presenters\Template;
use Nette\Security\IIdentity;
use Nette\Security\User;


abstract class BaseTemplate extends Template
{
	public BasePresenter|Presenter $presenter;
	public ?Languages $language;
	public ?string $scope = null;
	public User $user;
	public UserIdentity|IIdentity|null $identity;
}
