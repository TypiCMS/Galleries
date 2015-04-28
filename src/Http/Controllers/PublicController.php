<?php
namespace TypiCMS\Modules\Galleries\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Str;
use Input;
use TypiCMS;
use TypiCMS\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Galleries\Repositories\GalleryInterface;
use View;

class PublicController extends BasePublicController
{

    public function __construct(GalleryInterface $gallery)
    {
        parent::__construct($gallery);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page = Input::get('page');
        $perPage = config('typicms.galleries.per_page');
        $data = $this->repository->byPage($page, $perPage, ['translations']);
        $models = new Paginator($data->items, $data->totalItems, $perPage, null, ['path' => Paginator::resolveCurrentPath()]);

        return view('galleries::public.index')
            ->with(compact('models'));
    }

    /**
     * Show gallery.
     *
     * @return Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug, ['translations', 'files', 'files.translations']);
        return view('galleries::public.show')
            ->with(compact('model'));
    }
}
