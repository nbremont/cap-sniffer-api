<?php

namespace Api\DependencyInjection;

use Silex\Application;

/**
 * Interface DependencyInterface
 */
interface DependencyInterface
{
    /**
     * @param Application $app
     *
     * @return void
     */
    public function load(Application $app);
}
