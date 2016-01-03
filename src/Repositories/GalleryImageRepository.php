<?php

namespace App\Repositories;

use App\PhotoImage;
use Illuminate\Support\Facades\DB;


class PhotoImageRepository
{

    protected $photoImage;

    public function __construct(PhotoImage $photoImage)
    {
        $this->photoImage = $photoImage;

    }

    public function getMaxPosition(){
        return $maxPosition = DB::table('photo_images')->max('position');
    }



    public function get(){
        return $photoImage=$this->photoImage->all()->sortBy('position');
    }

    private function save(PhotoImage $photoImage, Array $inputs)
    {

        $photoImage->legend = $inputs['legend'];
        if(!isset($photoImage->position)) $photoImage->position =$this->getMaxPosition()+1;

        $photoImage->save();
    }



      public function getById($id)
    {
        return $this->photoImage->findOrFail($id);
    }

    public function update($id, Array $inputs)
    {
        $this->save($this->getById($id), $inputs);
    }

    public function destroy($id)
    {
        $this->getById($id)->delete();

    }


}