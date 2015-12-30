<?php

namespace TypiCMS\Modules\Galleries\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Galleries\Http\Requests\FormRequest;
use TypiCMS\Modules\Galleries\Models\Gallery;
use TypiCMS\Modules\Galleries\Repositories\GalleryInterface;

class AdminController extends BaseAdminController
{
    public function __construct(GalleryInterface $gallery)
    {
        parent::__construct($gallery);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Galleries\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $gallery = $this->repository->create($request->all());

        return $this->redirect($request, $gallery);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Galleries\Models\Gallery            $gallery
     * @param \TypiCMS\Modules\Galleries\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Gallery $gallery, FormRequest $request)
    {
        $this->repository->update($request->all());

        return $this->redirect($request, $gallery);
    }
}
