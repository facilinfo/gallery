<?php

namespace Facilinfo\Gallery\Controllers;

use Facilinfo\Gallery\Requests\GallerySerieCreateRequest;
use Facilinfo\Gallery\Requests\GallerySerieUpdateRequest;

use Illuminate\Routing\Controller as Controller;

use Facilinfo\Gallery\Repositories\GallerySerieRepository;

use Facilinfo\Gallery\Models\GallerySerie;
use Facilinfo\Gallery\Models\GalleryCategory;




class GallerySerieController extends Controller
{

    protected $gallerySerieRepository;


    public function __construct(GallerySerieRepository $gallerySerieRepository)
    {
        $this->gallerySerieRepository = $gallerySerieRepository;
    }

    public function index()
    {
        $gallerySeries = GallerySerie::with('category')->orderBy('position')->get();

        return view('gallery.series.index',  compact('gallerySeries'));
    }

    public function create()
    {
        $gallerySerie= new GallerySerie();
        $galleryCategories = [0=>'Aucune']+GalleryCategory::lists('name', 'id')->all();

        return view('gallery.series.create',  compact('gallerySerie', 'galleryCategories'));
    }

    public function store(GallerySerieCreateRequest $request)
    {
        $gallerySerie = $this->gallerySerieRepository->store($request->all());
        $gallerySerie->position = $this->gallerySerieRepository->getMaxPosition()+1;

        return redirect('gallery/photo-series')->with('success',"La série " . $gallerySerie->name . " a été créée.");
    }

    public function show($id)
    {
        return redirect('errors.404');
    }



    public function edit($id)

    {
        $gallerySerie = $this->gallerySerieRepository->getById($id);
        $galleryCategories = GalleryCategory::lists('name','id');

        return view('gallery.series.edit',  compact('gallerySerie', 'galleryCategories'));
    }



    public function update(GallerySerieUpdateRequest $request, $id)
    {
        $this->gallerySerieRepository->update($id, $request->all());

        return redirect('gallery/photo-series')->with('success', "La série " . $request->input('name') . " a été modifiée.");
    }

    public function destroy($id)
    {
        $gallerySerie = $this->gallerySerieRepository->getById($id);
        $this->gallerySerieRepository->destroy($id);

        return redirect('gallery/photo-series')->with('success', "La série " . $gallerySerie->name . " a été supprimée.");
    }



    public function filter($category_id)
    {

        $gallerySeries = GallerySerie::where('category_id','=', $category_id)->orderBy('position')->get();

        $galleryCategories = GalleryCategory::lists('name','id');

        return view('gallery-series.index', compact('gallerySeries', 'galleryCategories', 'category_id'));

    }

    public function reposition(){
        if(\Request::has('item'))
        {
            $i = 0;
            foreach(\Request::get('item') as $id)
            {
                $i++;
                $item = GallerySerie::find($id);
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