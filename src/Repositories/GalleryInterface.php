<?php

namespace TypiCMS\Modules\Galleries\Repositories;

use TypiCMS\Modules\Core\Repositories\RepositoryInterface;

interface GalleryInterface extends RepositoryInterface
{
    /**
     * Delete model and attached files.
     *
     * @return bool
     */
    public function delete($model);
}
