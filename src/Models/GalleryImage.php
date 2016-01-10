<?php

namespace Facilinfo\Gallery\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $table = 'gallery_images';


    protected $fillable = array ('legend', 'extension', 'path',  'position', 'serie_id', 'first');

    public function serie()
    {
        return $this->belongsTo('Facilinfo\Gallery\Models\GallerySerie');
    }
}
