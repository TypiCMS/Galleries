<?php

namespace TypiCMS\Modules\Galleries\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'name'    => 'required|max:255|alpha_dash',
            '*.title' => 'max:255',
            '*.slug'  => 'alpha_dash|max:255',
        ];
    }
}
