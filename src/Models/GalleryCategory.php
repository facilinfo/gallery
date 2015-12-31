<?php
namespace Facilinfo\Gallery\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Category
 */
class GalleryCategory extends Model {

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'gallery_categories';

    protected $fillable = array ('name', 'slug', 'position');

    public function series()
    {
        return $this->hasMany('Facilinfo\Gallery\Models\GallerySerie');
    }

}