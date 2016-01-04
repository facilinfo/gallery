<?php

namespace Facilinfo\Gallery\Repositories;

use Facilinfo\Gallery\Models\GalleryImage;
use Illuminate\Support\Facades\DB;


class GalleryImageRepository
{

    protected $galleryImage;

    public function __construct(GalleryImage $galleryImage)
    {
        $this->galleryImage = $galleryImage;

    }

    public function getMaxPosition(){
        return $maxPosition = DB::table('gallery_images')->max('position');
    }



    public function get(){
        return $galleryImage=$this->galleryImage->all()->sortBy('position');
    }

    private function save(GalleryImage $galleryImage, Array $inputs)
    {

        $galleryImage->title = $inputs['title'];
        $galleryImage->legend = $inputs['legend'];
        $galleryImage->alt = $inputs['alt'];
        if(!isset($galleryImage->position)) $galleryImage->position =$this->getMaxPosition()+1;

        $galleryImage->save();
    }



      public function getById($id)
    {
        return $this->galleryImage->findOrFail($id);
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