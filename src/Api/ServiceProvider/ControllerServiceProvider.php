<?php

namespace Api\ServiceProvider;

use Api\Controller\CalendarController;
use Api\Controller\Doc\SwaggerController;
use Api\Controller\TrainingController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ControllerServiceProvider
 */
class ControllerServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['api.controller.training'] = function () use ($app) {
            $controller = new TrainingController($app['cp.cap_sniffer'], $app['jms.serializer'], $app['cp.provider.type']);
            $controller->setConfigurationProvider($app['cp.provider.configuration']);

            return $controller;
        };

        $app['api.controller.calendar'] = function () use ($app) {
            return new CalendarController($app['cp.cap_sniffer'], $app['jms.serializer'], $app['cp.provider.type']);
        };

        if ('dev' === $app['env']) {
            $app['api.controller.swagger'] = function () use ($app) {
                return new SwaggerController();
            };
        }

        // mount controller by env
        $this->mountController($app);
    }

    /**
     * @param Container $app
     */
    protected function mountController(Container $app)
    {
        $app->mount('/api', $app['api.controller.training']);
        $app->mount('/api', $app['api.controller.calendar']);

        if ('dev' == $app['env']) {
            $app->mount('/api', $app['api.controller.swagger']);
        }

    }
}
