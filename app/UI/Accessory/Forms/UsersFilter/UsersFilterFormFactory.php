<?php

declare(strict_types = 1);

namespace App\UI\Accessory\Forms\UsersFilter;

use App\UI\Accessory\Forms\FormFactory;
use Flexsyscz\Application\DI\Injectable;
use Flexsyscz\Datagrids\DatagridControl\Accessory\Forms\Filter\FilterFormFactory;
use Flexsyscz\Localization\Translations\TranslatedComponent;
use Nette\Application\UI\Form;
use Nette\Http\SessionSection;
use Nette\InvalidArgumentException;


final class UsersFilterFormFactory extends FilterFormFactory implements Injectable
{
	use TranslatedComponent;


	public function __construct(FormFactory $formFactory)
	{
		parent::__construct($formFactory);
	}


	public function create(SessionSection $filterStorage, callable $callback): Form
	{
		$form = parent::create($filterStorage, $callback);
		$form->setTranslator($this->translatorNamespace);
		$form->getElementPrototype()
			->setAttribute('class', 'ajax')
			->setAttribute('data-naja-force-redirect', true);

		try {
			$form->addText('username', 'username.label');
		} catch (InvalidArgumentException) {}

		$this->setDefaults($form);
		return $form;
	}


	public function onSuccess(Form $form, UsersFilterFormValues $values): void
	{
		$this->saveValues($values);
		call_user_func($this->callback);
	}
}
