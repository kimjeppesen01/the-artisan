<?php

namespace Shipmondo\Tools;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class ClassLoader
{
	protected string $root;
	protected string $rootNamespace;

	public function __construct(string $root, string $rootNamespace)
	{
		$this->root = wp_normalize_path(trailingslashit($root));
		$this->rootNamespace = $rootNamespace;
	}

	protected function getClassName(SplFileInfo $file) {
		$path = wp_normalize_path($file->getPathname());

		$path = str_replace($this->root, '', $path);

		$path = substr($path, 0, -4); // Remove ".php"

		$path = str_replace('/', '\\', $path);

		return $this->rootNamespace . '\\' . $path;
	}

	public function loadClasses(string $directory, $call = '__construct', $callArgs = [])
	{
		$directory = wp_normalize_path($this->root . $directory);

		if(!is_dir($directory)) {
			return;
		}

		$directoryIterator = new RecursiveDirectoryIterator($directory, FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS);

		foreach(new RecursiveIteratorIterator($directoryIterator) as $file) {
			if($file->getExtension() !== 'php') {
				continue;
			}

			$className = $this->getClassName($file);

			if(class_exists($className)) {
				if($call == '__construct') {
					new $className(...$callArgs);
				} else if(method_exists($className, $call)) {
					$className::{$call}(...$callArgs);
				}
			}
		}
	}
}