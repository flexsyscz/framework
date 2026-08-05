<?php

declare(strict_types=1);

namespace App;

use Nette;
use Nette\Bootstrap\Configurator;


class Bootstrap
{
	private Configurator $configurator;
	private string $rootDir;


	public function __construct()
	{
		$this->rootDir = dirname(__DIR__);
		$this->configurator = new Configurator;
		$this->configurator->setTempDirectory($this->rootDir . '/temp');
	}


	public function bootWebApplication(): Nette\DI\Container
	{
		$this->initializeEnvironment();
		$this->setupContainer();
		return $this->configurator->createContainer();
	}


	public function initializeEnvironment(): void
	{
		$debugEnablerFile = $this->rootDir . '/config/.debug';
		$debugMode = false;
		if (file_exists($debugEnablerFile)) {
			$contents = @file_get_contents($debugEnablerFile);
			if ($contents !== false) {
				$debugMode = explode("\n", $contents);
			}
		}

		$this->configurator->setDebugMode($debugMode);
		$this->configurator->enableTracy($this->rootDir . '/log');

		$this->configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();
	}


	private function setupContainer(): void
	{
		$configDir = $this->rootDir . '/config';
		$this->configurator->addConfig($configDir . '/local.neon');
		$this->configurator->addConfig($configDir . '/common.neon');
		$this->configurator->addConfig($configDir . '/model.neon');
		$this->configurator->addConfig($configDir . '/services.neon');
	}
}
