<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

require_once __DIR__ . '/../vendor/autoload.php';

AnnotationRegistry::registerLoader('class_exists');

$app = new Silex\Application();

require_once __DIR__ . '/../resources/config/dev.php';
require_once __DIR__ . '/../resources/routes/dev.php';
require_once __DIR__ . '/../app/AppKernel.php';

$appKernel = new AppKernel('dev');
$appKernel->register($app);

$app->run();
