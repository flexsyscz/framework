<?php

declare(strict_types=1);

namespace App\UI\Front\Sign;

use App\UI\Accessory\Forms\SignIn\SignInFormFactory;
use App\UI\Accessory\Presenters\BasePresenter;
use App\UI\Front\Home\HomeTemplate;
use Flexsyscz\Application\UI\Accessory\JsScope;
use Nette\Application\UI\Form;


/**
 * @property-read HomeTemplate $template
 */
final class SignPresenter extends BasePresenter
{
	use JsScope;

	private SignInFormFactory $signInFormFactory;


	public function __construct(SignInFormFactory $signInFormFactory)
	{
		parent::__construct();

		$this->signInFormFactory = $signInFormFactory;
	}


	public function actionIn(): void
	{
		if ($this->getUser()->isLoggedIn()) {
			$this->redirect(':Front:Home:');
		}
	}


	public function renderIn(): void
	{
		$this->redrawControl('main');
	}


	public function actionOut(): void
	{
		$this->getUser()->logout();
		$this->redirect(':Front:Home:');
	}


	protected function createComponentSignInForm(): Form
	{
		return $this->signInFormFactory->create(function() {
			$this->redirect(':Front:Home:');
		});
	}
}
