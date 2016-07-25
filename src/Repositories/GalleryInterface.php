<?php

namespace TypiCMS\Modules\Galleries\Repositories;

use TypiCMS\Modules\Core\Repositories\RepositoryInterface;

interface GalleryInterface extends RepositoryInterface
{
    /**
     * Get all galleries with files_count for back end.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allRaw();

    /**
     * Delete model and attached files.
     *
     * @return bool
     */
    public function delete($model);
}
