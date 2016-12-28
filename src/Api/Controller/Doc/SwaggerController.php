<?php

namespace Api\Controller\Doc;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SwaggerController
 */
class SwaggerController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/doc', function () use ($app) {
            return new JsonResponse(\Swagger\scan($app['api.doc.controller.dir']));
        });

        return $controllers;
    }
}