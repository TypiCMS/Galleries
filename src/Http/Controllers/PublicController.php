<?php

namespace TypiCMS\Modules\Galleries\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Request;
use TypiCMS;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Galleries\Repositories\EloquentGallery;

class PublicController extends BasePublicController
{
    public function __construct(EloquentGallery $gallery)
    {
        parent::__construct($gallery);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $page = Request::input('page');
        $perPage = config('typicms.galleries.per_page');
        $models = $this->repository->paginate($perPage, ['*'], 'page', $page);

        return view('galleries::public.index')
            ->with(compact('models'));
    }

    /**
     * Show gallery.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug, ['translations', 'files', 'files.translations']);

        return view('galleries::public.show')
            ->with(compact('model'));
    }
}
