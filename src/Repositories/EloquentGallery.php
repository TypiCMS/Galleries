<?php

namespace TypiCMS\Modules\Galleries\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Repositories\RepositoriesAbstract;
use TypiCMS\Modules\Files\Models\File;

class EloquentGallery extends RepositoriesAbstract implements GalleryInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Delete model and attached files.
     *
     * @return bool
     */
    public function delete($model)
    {
        if ($model->files) {
            $model->files->each(function (File $file) {
                $file->delete();
            });
        }
        if ($model->delete()) {
            return true;
        }

        return false;
    }
}
