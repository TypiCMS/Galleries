<?php

namespace TypiCMS\Modules\Galleries\Facades;

use Illuminate\Support\Facades\Facade;

class Galleries extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Galleries';
    }
}
