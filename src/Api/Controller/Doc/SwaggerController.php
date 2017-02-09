<?php

namespace Api\Controller\Doc;

use Doctrine\Common\Cache\MemcachedCache;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
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
     * @var string
     */
    protected $controllerDir;

    /**
     * SwaggerController constructor.
     *
     * @param MemcachedCache $memcacheCache
     * @param string         $controllerDir
     */
    public function __construct(MemcachedCache $memcacheCache, $controllerDir)
    {
        $this->memcache = $memcacheCache;
        $this->controllerDir = $controllerDir;
    }

    /**
     * @return JsonResponse
     */
    public function indexAction()
    {
        $apiDocContent = $this->memcache->fetch(self::MEMCACHE_DOC_KEY);
        if (false === $apiDocContent) {
            $apiDocContent = \Swagger\scan($this->controllerDir);
            $this->memcache->save(self::MEMCACHE_DOC_KEY, $apiDocContent);
        }

        return $apiDocContent;
    }

    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
    }
}
