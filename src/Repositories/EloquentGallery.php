<?php

namespace TypiCMS\Modules\Galleries\Repositories;

use Illuminate\Support\Facades\DB;
use TypiCMS\Modules\Core\Repositories\EloquentRepository;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Galleries\Models\Gallery;

class EloquentGallery extends EloquentRepository
{
    protected $repositoryId = 'galleries';

    protected $model = Gallery::class;

    /**
     * Get all galleries with files_count for back end.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allRaw()
    {
        $query = $this->createModel()
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
        if ($this->delete($model)) {
            return true;
        }

        return false;
    }
}
