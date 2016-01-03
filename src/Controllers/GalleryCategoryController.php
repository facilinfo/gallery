<?php

namespace Facilinfo\Gallery\Controllers;

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
      return redirect('errors.404');
    }
    public function edit($id){
        $galleryCategory = $this->GalleryCategoryRepository->getById($id);
        return view('gallery.categories.edit',  compact('galleryCategory'));
    }

    public function update(GalleryCategoryUpdateRequest $request, $id){

        $this->GalleryCategoryRepository->update($id, $request->all());

        return redirect('gallery/photo-categories')->with('success', "La catégorie " . $request->input('name') . " a été modifiée.");
    }
    public function destroy($id){
        $category=$this->GalleryCategoryRepository->getById($id);
        $this->GalleryCategoryRepository->destroy($id);
        return redirect('gallery/photo-categories')->with('success', "La catégorie " . $category->name . " a été supprimée.");
    }

    public function reposition(){
        if(\Request::has('item'))
        {
            $i = 0;
            foreach(\Request::get('item') as $id)
            {
                $i++;
                $item = GalleryCategory::find($id);
                $item->position = $i;
                $item->save();
            }
            return \Response::json(array('success' => true));
        }
        else
        {
            return \Response::json(array('success' => false));
        }
    }
}