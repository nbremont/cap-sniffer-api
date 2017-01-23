<?php

namespace Api\DependencyInjection;

use Api\Controller\CalendarController;
use Api\Controller\Doc\SwaggerController;
use Api\Controller\TrainingController;
use Api\Handler\ApiExceptionHandler;
use Api\Handler\ApiViewHandler;
use Silex\Application;

/**
 * Class ApiService
 */
class ApiService implements DependencyInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(Application $app)
    {
        $app['training.controller'] = function () use ($app) {
            $controller = new TrainingController(
                $app['cp.cap_sniffer'],
                $app['jms.serializer'],
                $app['cp.provider.type']
            );
            $controller->setConfigurationProvider($app['cp.provider.configuration']);

            return $controller;
        };

        $app['calendar.controller'] = function () use ($app) {
            return new CalendarController($app['cp.cap_sniffer'], $app['jms.serializer'], $app['cp.provider.type']);
        };

        if ('dev' === $app['env']) {
            $app['swagger.controller'] = function () use ($app) {
                return new SwaggerController($app['doctrine.cache'], $app['api.doc.controller.dir']);
            };
        }
    }
}