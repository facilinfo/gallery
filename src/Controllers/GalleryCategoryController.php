<?php namespace Facilinfo\Gallery\Controllers;

use Illuminate\Routing\Controller as Controller;
use Facilinfo\Gallery\Repositories\GalleryCategoryRepository;
use Facilinfo\Gallery\Models\GalleryCategory;

class GalleryCategoryController extends Controller {


    protected $GalleryCategoryRepository;


    public function __construct(GalleryCategoryRepository $galleryCategoryRepository)
    {
        $this->GalleryCategoryRepository = $galleryCategoryRepository;
    }


    public function index() {


        $galleryCategories = $this->GalleryCategoryRepository->get();

        return view('gallery.categories.index', compact('galleryCategories'));
    }

    public function create(){
        $galleryCategory= new GalleryCategory();

        return view('gallery.categories.create', compact('galleryCategory'));
    }
}