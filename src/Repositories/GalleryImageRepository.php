<?php

namespace Facilinfo\Gallery\Repositories;

use Illuminate\Support\Facades\DB;
use Facilinfo\Gallery\Models\GallerySerie;
use Facilinfo\Gallery\Models\GalleryImage;
use Facilinfo\Gallery\Models\GalleryCategory;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as IntImage;



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

    public function getAll($serie_id){
        return $galleryImages=$this->galleryImage->with('serie')->where('serie_id', $serie_id)->get()->sortBy('position');
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

    public function store(Array $inputs)
    {
        $photoSerie_id=$inputs['serie_id'];
        $photoSerie = GallerySerie::where('id', '=', $photoSerie_id)->firstOrFail();
        $photoCategory = GalleryCategory::where('id', '=', $photoSerie['category_id'])->firstOrFail();

        $path = config('gallery.path') . $photoCategory['slug'] . '/' . $photoSerie['slug'];

        $first=GalleryImage::where('serie_id', '=', $photoSerie_id)->count();
        $first>0 ? $first=0 :$first=1;

        $valid=true;
        $files_count=0;
        $uploads_count=0;

        $files =  Input::file('images');

        foreach ($files as $file) {
            // Validate each file
            $rules = array('file' => 'image');
            $validator = Validator::make(array('file'=> $file), $rules);

            if($validator->fails()) {
                $valid=false;
            }
            $files_count++;
        }

        if($valid==true) {
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();

                $image = new GalleryImage (array(
                    'extension' => $extension,
                    'path' => $path,
                    'serie_id' => $photoSerie_id,
                    'first' => $first

                ));
                $image->save();

                $id = GalleryImage::max('id');

                //On sauve le fichier
                $destinationPath = public_path() . $path;

                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $filename = $id . '.' . $extension;
                $file->move($destinationPath, $filename);
                $img = IntImage::make($destinationPath . '/' . $filename)->orientate();
                $img->save($destinationPath . '/' . $id . '.' . $extension);

                $img->resize(null, 125, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($destinationPath . '/' . $id . '_thumb.' . $extension);

                $uploads_count++;
            }
        }

        if ($uploads_count == $files_count)
        {
            $result = 'ok';
        }
        elseif ($files_count ==0 )
        {
             $result = 'nf'; //no files selected
        }
        elseif($valid==false)
        {
            $result = 'valid_fails'; //some files are not images
        }
        else
        {
          $result='pb';// a problem occurred
        }

        return $result;
    }

    public function destroy($id)
    {
        $image = $this->getById($id);
        $gallerySerie = GallerySerie::where('id', '=', $image->serie_id)->firstOrFail();
        $galleryCategory = GalleryCategory::where('id', '=', $gallerySerie['category_id'])->firstOrFail();

        $path = public_path().config('gallery.path') . $galleryCategory['slug'] . '/' . $gallerySerie['slug'];
        $file=$path.'/'.$id.'.'.$image->extension;
        $thumb=$path.'/'.$id.'_thumb.'.$image->extension;

        if(is_file($file)){
            unlink($file);
        }
        if(is_file($thumb)){
            unlink($thumb);
        }

        $this->getById($id)->delete();

    }


}