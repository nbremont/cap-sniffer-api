<?php

use Api\Handler\ExceptionHandler;
use Pimple\Container;

/**
 * Class AppKernel
 */
class AppKernel
{
    /**
     * @var string
     */
    public static $env;

    /**
     * AppKernel constructor.
     *
     * @param string $env
     */
    public function __construct($env = 'prod')
    {
        self::$env = $env;
    }

    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        // initialize env
        $app['env'] = self::$env;

        $app->register(new Silex\Provider\ServiceControllerServiceProvider());
        $app->register(new Api\ServiceProvider\CapServiceProvider());
        $app->register(new Api\ServiceProvider\ControllerServiceProvider());
        $app->register(new Api\ServiceProvider\HandlerServiceProvider());

        $this->loadConfiguration($app);
    }

    /**
     * @param Container $app
     */
    public function registerHandler(Container $app)
    {
        $handler = new ExceptionHandler();
        $handler->handle($app);
    }

    /**
     * Load configuration file by env
     *
     * @param Container $app
     */
    protected function loadConfiguration(Container $app)
    {
        require_once __DIR__ . '/../resources/config/' . $app['env'] . '.php';
        require_once __DIR__ . '/../resources/routes/' . $app['env'] . '.php';
    }
}
