<?php namespace Facilinfo\Gallery\Facade;

use Illuminate\Support\Facades\Facade;

class Gallery extends Facade {

    protected static function getFacadeAccessor() { return 'gallery'; }

}