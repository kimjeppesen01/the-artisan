<?php

namespace Shipmondo\Tools;

class Boot {
	protected ClassLoader $classLoader;

	public function __construct(string $root, string $rootNamespace)
	{
		$this->classLoader = new ClassLoader($root, $rootNamespace);

		$this->loadClasses();
	}

	public function loadClasses()
	{
		$this->classLoader->loadClasses('Hooks', 'register');

		add_action('rest_api_init', [$this, 'registerRestRoutes']);
	}

	public function registerRestRoutes()
	{
		$this->classLoader->loadClasses('Api', 'registerRestRoutes');
	}
}