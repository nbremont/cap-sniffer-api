<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

require_once __DIR__ . '/../vendor/autoload.php';

AnnotationRegistry::registerLoader('class_exists');

$app = new Silex\Application();

require_once __DIR__ . '/../resources/config/dev.php';
$app['debug'] = true;

$app->register(new JDesrosiers\Silex\Provider\CorsServiceProvider(), array(
    "cors.allowOrigin" => "http://localhost:8080",
));
$app->register(new Api\ServiceProvider\CapServiceProvider());
$app->register(new Api\ServiceProvider\ControllerServiceProvider());

$app->after($app["cors"]);

$app->run();
