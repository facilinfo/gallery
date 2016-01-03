<?php

namespace Facilinfo\Gallery\Requests;

use App\Http\Requests\Request;

class GallerySerieUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

        public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id=$this->get('id');
        return [
            'name' => "required|min:2|unique:gallery_series,name,$id",


        ];
    }
}
