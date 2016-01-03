<?php

namespace Facilinfo\Gallery\Requests;

use App\Http\Requests\Request;

class GallerySerieCreateRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255|unique:gallery_series',
            'category_id' => 'required|numeric|min:1'
        ];
    }

    public function messages(){
        return [
            'category_id.min'=>'Veuillez sélectionner une catégorie'
            ];
    }


}