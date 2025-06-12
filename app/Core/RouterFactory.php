<?php

declare(strict_types=1);

namespace App\Core;

use App\Model\Languages\Languages;
use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;


	public static function createRouter(): RouteList
	{
		$defaultLanguage = Languages::Czech;

		$router = new RouteList;
		$router->withModule('Admin')
			->addRoute(sprintf('admin/<locale=%s [a-z]{2}>[-<country>]/<presenter>/<action>[/<id>]', $defaultLanguage->getShortCode()), 'Dashboard:default');

		$router->withModule('Front')
			->addRoute(sprintf('<locale=%s [a-z]{2}>[-<country>]/<presenter>/<action>[/<id>]', $defaultLanguage->getShortCode()), 'Home:default');

		return $router;
	}
}
