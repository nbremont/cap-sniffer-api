<?php

namespace Api\Controller\Doc;

use Doctrine\Common\Cache\MemcachedCache;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SwaggerController
 */
class SwaggerController implements ControllerProviderInterface
{
    const MEMCACHE_DOC_KEY = 'api.doc';

    /**
     * @var MemcachedCache
     */
    protected $memcache;

    /**
     * SwaggerController constructor.
     *
     * @param MemcachedCache $memcacheCache
     */
    public function __construct(MemcachedCache $memcacheCache)
    {
        $this->memcache = $memcacheCache;
    }

    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->get('/doc', function () use ($app) {
            $apiDocContent = $this->memcache->fetch(self::MEMCACHE_DOC_KEY);
            if (false === $apiDocContent) {
                $apiDocContent = \Swagger\scan($app['api.doc.controller.dir']);
                $this->memcache->save(self::MEMCACHE_DOC_KEY, $apiDocContent);
            }

            return new JsonResponse($apiDocContent);
        });

        return $controllers;
    }
}