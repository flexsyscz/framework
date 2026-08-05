<?php

declare(strict_types=1);

namespace App\UI\Error\Error4xx;

use App\Model;
use Flexsyscz;
use Flexsyscz\Application\UI\Presenters\Template;


final class Error4xxTemplate extends Template
{
	public ?int $httpCode = null;
	public string $locale = 'cs';
	public string $errorTitle = '';
	public string $errorDescription = '';
	public string $backLabel = '';
}
