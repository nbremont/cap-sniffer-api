<?php

namespace Api\Handler;

use Pimple\Container;

/**
 * Class ExceptionHandler
 */
class ExceptionHandler
{
    /**
     * @param Container $app
     */
    public function handle(Container $app)
    {
        $app->error(function (\Exception $e, Request $request, $code) {
            return new Response($e->getMessage());
        });
    }
}