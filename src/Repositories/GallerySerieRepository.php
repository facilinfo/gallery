<?php

namespace Facilinfo\Gallery\Repositories;

use Facilinfo\Gallery\Models\GallerySerie;
use Facilinfo\Gallery\Models\GalleryImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class GallerySerieRepository
{

    protected $gallerySerie;

    public function __construct(GallerySerie $gallerySerie)
    {
        $this->gallerySerie = $gallerySerie;
    }

    public function getMaxPosition(){
        return $maxPosition = DB::table('gallery_series')->max('position');
    }



    public function get(){
       return $gallerySerie=$this->gallerySerie->all()->sortBy('position');
    }

    private function save(GallerySerie $gallerySerie, Array $inputs)
    {
        $gallerySerie->name = $inputs['name'];
        $gallerySerie->slug =  Str::slug($inputs['name'],'-');
        $gallerySerie->description = $inputs['description'];
        if(!isset($gallerySerie->position)) $gallerySerie->position =$this->getMaxPosition()+1;
        $gallerySerie->category_id=$inputs['category_id'];
        if(isset( $inputs['active'])) $active=1; else $active=0;
        $gallerySerie->active = $active;
        $gallerySerie->save();

    }



    public function store(Array $inputs)
    {
        $gallerySerie = new $this->gallerySerie;
        $inputs['name']=ucfirst($inputs['name']);
        $this->save($gallerySerie, $inputs);

        return $gallerySerie;
    }

    public function getById($id)
    {
        return $this->gallerySerie->findOrFail($id);
    }

    public function update($id, Array $inputs)
    {
        $inputs['name']=ucfirst($inputs['name']);
        if(isset( $inputs['active'])) $active=1; else $active=0;
        $this->active = $active;
        $this->save($this->getById($id), $inputs);
    }

    public function removeDirectory($path) {

        $files = glob($path . '/*');
        foreach ($files as $file) {
            is_dir($file) ? $this->removeDirectory($file) : unlink($file);
        }
       if(is_dir($path)) rmdir($path);

        return;
    }

    public function destroy($id)

    {

        $serie=GallerySerie::with('category')->where('id','=', $id)->firstOrFail();

        $path=public_path().config('gallery.path').$serie->category->slug.'/'.$serie->slug;

        $this->removeDirectory($path);

        $this->getById($id)->delete();
    }


}