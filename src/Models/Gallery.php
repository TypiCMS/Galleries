<?php

namespace TypiCMS\Modules\Galleries\Models;

use Dimsav\Translatable\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Gallery extends Base
{
    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Galleries\Presenters\ModulePresenter';

    protected $fillable = [
        'name',
        'image',
        // Translatable columns
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    protected $appends = ['status', 'title', 'files_count', 'thumb'];

    /**
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = [
        'image',
    ];

    /**
     * One gallery has many files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('TypiCMS\Modules\Files\Models\File')->order();
    }

    /**
     * One gallery has many news.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function news()
    {
        return $this->morphedByMany('TypiCMS\Modules\News\Models\News');
    }

    /**
     * One gallery has many pages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function pages()
    {
        return $this->morphedByMany('TypiCMS\Modules\Pages\Models\Page');
    }

    /**
     * Append status attribute from translation table.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->status;
    }

    /**
     * Append title attribute from translation table.
     *
     * @return string title
     */
    public function getTitleAttribute()
    {
        return $this->title;
    }

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 22);
    }

    /**
     * Append files_count attribute.
     *
     * @return string
     */
    public function getFilesCountAttribute()
    {
        return $this->files->count();
    }
}
