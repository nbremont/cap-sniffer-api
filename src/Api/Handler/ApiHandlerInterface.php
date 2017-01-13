<?php

namespace Api\Handler;

use Silex\Application;

/**
 * Interface ApiHandlerInterface
 */
interface ApiHandlerInterface
{
    /**
     * @param Application $app
     *
     * @return void
     */
    public function handle(Application $app);
}
