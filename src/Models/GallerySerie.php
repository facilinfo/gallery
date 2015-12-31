<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GallerySerie extends Model
{

    protected $table = 'gallery_series';


    protected $fillable = array ('name', 'slug', 'description', 'position', 'category_id');

    public function category()
    {
        return $this->belongsTo('App\PhotoCategory');
    }

    public function images()
    {
        return $this->hasMany('App\PhotoImage');
    }
}
