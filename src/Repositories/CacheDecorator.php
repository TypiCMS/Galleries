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
