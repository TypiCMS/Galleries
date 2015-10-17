<?php

namespace TypiCMS\Modules\Galleries\Repositories;

use TypiCMS\Modules\Core\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements GalleryInterface
{
    public function __construct(GalleryInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get all items name.
     *
     * @return array with names
     */
    public function getNames()
    {
        $cacheKey = md5(config('app.locale').'getNames');

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->getNames();

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Delete model and attached files.
     *
     * @return bool
     */
    public function delete($model)
    {
        $this->cache->flush();
        $this->cache->flush('dashboard');

        return $this->repo->delete($model);
    }
}
