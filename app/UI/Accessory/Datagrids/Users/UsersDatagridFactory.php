<?php

declare(strict_types = 1);

namespace App\UI\Accessory\Datagrids\Users;


interface UsersDatagridFactory
{
	function create(): UsersDatagrid;
}
