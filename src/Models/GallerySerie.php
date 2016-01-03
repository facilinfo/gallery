<?php

namespace Facilinfo\Gallery\Models;

use Illuminate\Database\Eloquent\Model;

class GallerySerie extends Model
{

    protected $table = 'gallery_series';


    protected $fillable = array ('name', 'slug', 'description', 'active', 'position', 'category_id');

    public function category()
    {
        return $this->belongsTo('Facilinfo\Gallery\Models\GalleryCategory');
    }

    public function images()
    {
        return $this->hasMany('Facilinfo\Gallery\Models\GalleryImage');
    }
}
