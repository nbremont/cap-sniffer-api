<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

require_once __DIR__ . '/../vendor/autoload.php';

AnnotationRegistry::registerLoader('class_exists');

$app = new Silex\Application();

require_once __DIR__ . '/../resources/config/dev.php';

$app->register(new JDesrosiers\Silex\Provider\CorsServiceProvider(), array(
    "cors.allowOrigin" => "http://localhost:8080",
));
$app->register(new Api\ServiceProvider\CapServiceProvider());
$app->register(new Api\ServiceProvider\ControllerServiceProvider());

$app->mount('/api', $app['api.controller.training']);
$app->mount('/api', $app['api.controller.calendar']);
$app->mount('/api', $app['api.controller.swagger']);

$app->after($app["cors"]);

$app->run();
