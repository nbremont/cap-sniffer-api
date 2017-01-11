<?php

namespace Api\Handler;

use Pimple\Container;

/**
 * Interface ApiHandlerInterface
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
