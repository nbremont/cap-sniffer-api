<?php

namespace Api\Cache;

use Doctrine\Common\Cache\MemcachedCache;

/**
 * Class DevCache
 */
class DevCache extends MemcachedCache
{
    /**
     * {@inheritdoc}
     */
    public function fetch($id)
    {
        return false;
    }
}
