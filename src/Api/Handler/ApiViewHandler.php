<?php

namespace Api\Handler;

use Silex\Application;

/**
 * Class ApiViewHandler
 */
class ApiViewHandler implements ApiHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(Application $app)
    {
        $app->view(function (array $controllerResult) use ($app) {
            return $app->json($controllerResult);
        });
    }
}