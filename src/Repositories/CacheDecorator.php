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
     * Get all galleries with files_count for back end.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allRaw()
    {
        $cacheKey = md5(config('app.locale').'allRaw');

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->allRaw();

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
