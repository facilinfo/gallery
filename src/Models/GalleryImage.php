<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoImage extends Model
{
    protected $table = 'photos_images';


    protected $fillable = array ('legend', 'extension', 'path',  'position', 'serie_id', 'first');

    public function serie()
    {
        return $this->belongsTo('App\PhotoSerie');
    }
}
