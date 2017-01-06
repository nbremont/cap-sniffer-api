<?php

namespace Api\Handler;

use Pimple\Container;

/**
 * Interface HandlerInterface
 */
interface ApiHandlerInterface
{
    /**
     * @param Container $app
     *
     * @return void
     */
    public function handle(Container $app);
}