<?php

namespace Api\ServiceProvider;

use Api\Handler\ApiExceptionHandler;
use Api\Handler\ApiHandlerInterface;
use Api\Handler\ApiViewHandler;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Application;

/**
 * Class HandlerServiceProvider
 */
class HandlerServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['api.handler.exception'] = function () {
            return new ApiExceptionHandler();
        };

        $app['api.handler.view'] = function () {
            return new ApiViewHandler();
        };
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
        $handlerIdList = array_filter($app->keys(), function($value) {
            if (strstr($value, 'api.handler')) {
                return $value;
            }
        });

        foreach ($handlerIdList as $idDefinition) {
            if ($app->offsetExists($idDefinition) && $app[$idDefinition] instanceof ApiHandlerInterface) {
                $app[$idDefinition]->handle($app);
            }
        }

    }
}
