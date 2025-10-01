<?php

declare(strict_types=1);

namespace App\UI\Accessory\Presenters;

use App\Model;
use App\Model\Languages\Languages;
use App\Security\Authentication\UserIdentity;
use Flexsyscz\Application\UI\Presenters\Presenter;
use Flexsyscz\Application\UI\Presenters\Template;
use Flexsyscz\Security\User\LoggedUser;
use Nette\Security\IIdentity;
use Nette\Security\User;


abstract class BaseTemplate extends Template
{
	public BasePresenter|Presenter $presenter;
	public ?Languages $language;
	public ?string $scope = null;
	public User|LoggedUser $user;
	public ?Model\Users\User $userEntity;
	public UserIdentity|IIdentity|null $identity;
}
