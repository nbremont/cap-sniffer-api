<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../resources/config/dev.php';

AnnotationRegistry::registerLoader('class_exists');

$app = new Silex\Application();

$app->register(new Api\ServiceProvider\CapServiceProvider());
$app->mount('/api', $app['api.training.controller']);

$app->run();
