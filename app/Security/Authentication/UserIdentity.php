<?php

declare(strict_types=1);

namespace App\Security\Authentication;

use App\Model\Users\User;
use Nette\Security\SimpleIdentity;


final class UserIdentity extends SimpleIdentity
{
	private User $user;


	public function __construct(User $user, $roles = null, ?iterable $data = null)
	{
		parent::__construct($user->id, $roles, $data);
		$this->user = $user;
	}


	public function getEntity(): User
	{
		return $this->user;
	}
}
