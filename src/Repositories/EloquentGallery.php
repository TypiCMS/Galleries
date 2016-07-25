<?php

namespace TypiCMS\Modules\Galleries\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use TypiCMS\Modules\Core\Repositories\RepositoriesAbstract;
use TypiCMS\Modules\Files\Models\File;

class EloquentGallery extends RepositoriesAbstract implements GalleryInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all galleries with files_count for back end.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allRaw()
    {
        $query = $this->make(['translations'])
            ->select(
                'id',
                'name',
                'image',
                DB::raw('(SELECT COUNT(*) FROM `'.
                    DB::getTablePrefix().
                    'files` WHERE `gallery_id` = `'.
                    DB::getTablePrefix().
                    "galleries`.`id`) AS 'files_count'")
                )
            ->order();

        // Get
        return $query->get();
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
