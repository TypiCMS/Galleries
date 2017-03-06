<?php

namespace TypiCMS\Modules\Galleries\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\News\Models\News;
use TypiCMS\Modules\Pages\Models\Page;

class Gallery extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Galleries\Presenters\ModulePresenter';

    protected $guarded = ['id', 'exit'];

    public $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    protected $appends = ['thumb', 'title_translated'];

    public $attachments = [
        'image',
    ];

    /**
     * One gallery has many files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files()
    {
        return $this->belongsToMany(File::class)->order();
    }

    /**
     * One gallery has many news.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function news()
    {
        return $this->morphedByMany(News::class);
    }

    /**
     * One gallery has many pages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function pages()
    {
        return $this->morphedByMany(Page::class);
    }

    /**
     * Append title_translated attribute.
     *
     * @return string
     */
    public function getTitleTranslatedAttribute()
    {
        $locale = config('app.locale');
        return $this->translate('title', config('typicms.content_locale', $locale));
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
}
