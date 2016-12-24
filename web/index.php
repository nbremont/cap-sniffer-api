<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

require_once __DIR__ . '/../vendor/autoload.php';

AnnotationRegistry::registerLoader('class_exists');

$app = new Silex\Application();

require_once __DIR__ . '/../resources/config/dev.php';

$app->register(new Api\ServiceProvider\CapServiceProvider());
$app->mount('/api', $app['api.training.controller']);
$app->mount('/api', $app['api.calendar.controller']);

$app->run();
