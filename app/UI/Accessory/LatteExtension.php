<?php

declare(strict_types=1);

namespace App\UI\Accessory;

use Flexsyscz\Application;


final class LatteExtension extends Application\UI\Accessory\LatteExtension
{
	public function getFilters(): array
	{
		$filters = [];
		return array_merge(parent::getFilters(), $filters);
	}


	public function getFunctions(): array
	{
		$functions = [];
		return array_merge(parent::getFunctions(), $functions);
	}
}
