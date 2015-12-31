<?php

namespace TypiCMS\Modules\Galleries\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Request;
use TypiCMS;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Galleries\Repositories\GalleryInterface;

class PublicController extends BasePublicController
{
    public function __construct(GalleryInterface $gallery)
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
        $data = $this->repository->byPage($page, $perPage, ['translations']);
        $models = new Paginator($data->items, $data->totalItems, $perPage, null, ['path' => Paginator::resolveCurrentPath()]);

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
