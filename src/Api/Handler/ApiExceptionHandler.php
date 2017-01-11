<?php

namespace Api\Handler;

use Pimple\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiExceptionHandler
 */
class ApiExceptionHandler implements ApiHandlerInterface
{
    /**
     * @param Container $app
     *
     * @return void
     */
    public function handle(Container $app)
    {
        $app->error(function (\Exception $e, Request $request, $code) {
            return new JsonResponse([
                'error' => [
                    'code' => $code,
                    'message' => $e->getMessage(),
                ],
            ]);
        });
    }
}
