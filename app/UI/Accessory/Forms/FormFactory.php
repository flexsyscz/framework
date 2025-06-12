<?php

declare(strict_types=1);

namespace App\UI\Accessory\Forms;

use Flexsyscz;
use Flexsyscz\Forms\Renderers\Bootstrap5;
use Nette\Application\UI\Form;


final class FormFactory extends Flexsyscz\Forms\FormFactory
{
	public function onRender(Form $form): void
	{
		Bootstrap5::make($form);
	}
}
