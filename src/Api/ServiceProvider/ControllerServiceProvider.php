<?php

namespace Api\ServiceProvider;

use Api\Controller\CalendarController;
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
        $app['api.training.controller'] = function () use ($app) {
            $controller = new TrainingController($app['cp.cap_sniffer'], $app['jms.serializer'], $app['cp.provider.type']);
            $controller->setConfigurationProvider($app['cp.provider.configuration']);

            return $controller;
        };

        $app['api.calendar.controller'] = function () use ($app) {
            return new CalendarController($app['cp.cap_sniffer'], $app['jms.serializer'], $app['cp.provider.type']);
        };
    }
}
