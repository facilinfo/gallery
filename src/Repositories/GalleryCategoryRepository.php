<?php

namespace Facilinfo\Gallery\Repositories;

use Facilinfo\Gallery\Models\GalleryCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GalleryCategoryRepository
{

    protected $galleryCategory;

    public function __construct(GalleryCategory $galleryCategory)
    {
        $this->galleryCategory = $galleryCategory;

    }

    public function getMaxPosition(){
        return $maxPosition = DB::table('gallery_categories')->max('position');
    }


    public function get(){
        return $galleryCategory=$this->galleryCategory->all()->sortBy('position');
    }

    private function save(GalleryCategory $galleryCategory, Array $inputs)
    {

        $galleryCategory->name = $inputs['name'];
        $galleryCategory->slug =  Str::slug($inputs['name'],'-');
        if(!isset($galleryCategory->position)) $galleryCategory->position =$this->getMaxPosition()+1;

        $galleryCategory->save();
    }

    public function store(Array $inputs)
    {

        $galleryCategory = new $this->galleryCategory;
        $inputs['name']=ucfirst($inputs['name']);
        $this->save($galleryCategory, $inputs);

        return $galleryCategory;
    }

    public function getById($id)
    {
        return $this->galleryCategory->findOrFail($id);
    }

    public function update($id, Array $inputs)
    {
        $inputs['name']=ucfirst($inputs['name']);

        $this->save($this->getById($id), $inputs);
    }

    public function removeDirectory($path) {

        $files = glob($path . '/*');
        foreach ($files as $file) {
            is_dir($file) ? $this->removeDirectory($file) : unlink($file);
        }
        if(is_dir($path)){
            rmdir($path);
        }

        return;
    }

    public function destroy($id)
    {
        $category=GalleryCategory::where('id','=', $id)->firstOrFail();

        $path=config('gallery.path').$category->slug;

        $this->removeDirectory($path);

        $this->getById($id)->delete();
    }


}