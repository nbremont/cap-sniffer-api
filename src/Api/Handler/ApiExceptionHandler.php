<?php

namespace Api\Handler;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiExceptionHandler
 */
class ApiExceptionHandler implements ApiHandlerInterface
{
    /**
     * @param Application $app
     *
     * @return void
     */
    public function handle(Application $app)
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
