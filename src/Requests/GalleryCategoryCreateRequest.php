<?php

namespace Facilinfo\Gallery\Requests;

use App\Http\Requests\Request;

class GalleryCategoryCreateRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255|unique:gallery_categories'
        ];
    }

}