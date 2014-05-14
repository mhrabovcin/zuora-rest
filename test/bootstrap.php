<?php

$autoloadFile = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadFile)) {
    throw new RuntimeException('Install dependencies to run phpunit.');
}
require_once $autoloadFile;

$loader = new \Composer\Autoload\ClassLoader();
$loader->add('Zuora\Test', 'test');
$loader->register();
