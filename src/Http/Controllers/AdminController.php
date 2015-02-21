<?php
namespace TypiCMS\Modules\Galleries\Http\Controllers;

use TypiCMS\Modules\Galleries\Http\Requests\FormRequest;
use TypiCMS\Modules\Galleries\Repositories\GalleryInterface;
use TypiCMS\Http\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(GalleryInterface $gallery)
    {
        parent::__construct($gallery);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest $request
     * @return Redirect
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create($request->all());
        return $this->redirect($request, $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     * @param  FormRequest $request
     * @return Redirect
     */
    public function update($model, FormRequest $request)
    {
        $this->repository->update($request->all());
        return $this->redirect($request, $model);
    }
}
