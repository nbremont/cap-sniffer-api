<?php

namespace Api\ServiceProvider;

use Api\DependencyInjection\DependencyInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Application;

/**
 * Class LoaderServiceProvider
 */
class LoaderServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app) {}

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
        if (!isset($app['service.loader'])) {
            throw new \Exception(sprintf('Service configuration for "%s" not set', LoaderServiceProvider::class));
        }

        foreach ($app['service.loader'] as $service) {
            if ($service instanceof DependencyInterface) {
                $service->load($app);
            } else {
                throw new \Exception(sprintf(
                    'Class %s must implements %s',
                    get_class($service),
                    DependencyInterface::class
                ));
            }
        }
    }
}
