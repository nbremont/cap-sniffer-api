<?php

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

        $app->register(new JDesrosiers\Silex\Provider\CorsServiceProvider(), array(
            "cors.allowOrigin" => $app['host'],
        ));
        $app->register(new Api\ServiceProvider\CapServiceProvider());
        $app->register(new Api\ServiceProvider\ControllerServiceProvider());

        // Registers an after filter
        $this->after($app);
    }

    /**
     * @param Container $app
     */
    protected function after(Container $app)
    {
        $app->after($app["cors"]);
    }
}
