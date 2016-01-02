<?php namespace Facilinfo\Gallery\Controllers;

use Illuminate\Routing\Controller as Controller;
use Facilinfo\Gallery\Repositories\GalleryCategoryRepository;
use Facilinfo\Gallery\Models\GalleryCategory;

use Facilinfo\Gallery\Requests\GalleryCategoryCreateRequest;
use Facilinfo\Gallery\Requests\GalleryCategoryUpdateRequest;

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
    public function store(GalleryCategoryCreateRequest $request){
        $galleryCategory = $this->GalleryCategoryRepository->store($request->all());
        $galleryCategory->position = $this->GalleryCategoryRepository->getMaxPosition()+1;

        return redirect('gallery/photo-categories')->with('success',"La catégorie " .  $galleryCategory->name . " a été créée.");
    }

    public function show(){
        dd('sdfgsdfgsd');
    }
    public function edit(){
        dd('sdfgsdfgsd');
    }
    public function destroy(){
        dd('sdfgsdfgsd');
    }
}