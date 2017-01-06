<?php

namespace Api\ServiceProvider;

use Api\Handler\ApiHandlerInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ExceptionHandler
 */
class HandlerServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
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