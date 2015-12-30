<?php namespace Facilinfo\Gallery\Controllers;

use App\Http\Controllers\Controller;

class PhotoCategoryController extends Controller {
    public function index() {
        return view('gallery::categories.index');
    }
}