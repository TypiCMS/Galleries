<?php
namespace TypiCMS\Modules\Galleries\Http\Controllers;

use TypiCMS\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Galleries\Repositories\GalleryInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
