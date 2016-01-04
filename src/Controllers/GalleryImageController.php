<?php

namespace Facilinfo\Gallery\Controllers;


use Illuminate\Routing\Controller as Controller;
use Facilinfo\Gallery\Repositories\GalleryImageRepository;
use Facilinfo\Gallery\Models\GallerySerie;
use Facilinfo\Gallery\Models\GalleryImage;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as IntImage;



class GalleryImageController extends Controller
{

    protected $galleryImageRepository;

    public function __construct(GalleryImageRepository $galleryImageRepository)
    {
        $this->galleryImageRepository = $galleryImageRepository;
    }

    public function index()
    {
       return view('errors.404');
    }

    public function create($serie_id)
    {
        $galleryImage = new GalleryImage();
        $gallerySeries = [0=>'Aucune']+GallerySerie::lists('name', 'id')->all();

        return view('gallery.images.create', compact('galleryImage', 'gallerySeries', 'serie_id'));
    }

    public function store(Request $request)
    {
        $photoSerie_id=$request->serie_id;

        $result = $this->galleryImageRepository->store($request->all());

        switch($result){
            case('nf'):
                return redirect('gallery/photo-images/create/' . $photoSerie_id)->with('problem', "Vous n'avez pas sélectionné de fichier.");
            break;

            case('pb'):
                return redirect('gallery/photo-images/create/' . $photoSerie_id)->with('problem', "Un problème est survenu. Veuillez réessayer");
            break;

            case('valid_fails'):
                return redirect('gallery/photo-images/create/' . $photoSerie_id)->with('problem', "Seules les images sont autorisées.");
            break;

            case ('ok'):
                return redirect('gallery/photo-images/filter/' . $photoSerie_id)->with('success', "Les images ont été enregistrées.");
        }

    }


    public function show()
    {
        return view('errors.404');
    }


    public function edit($id)
    {
        return view('errors.404');
    }

    public function update(Request $request, $id)
    {
        $this->galleryImageRepository->update($id, $request->all());
        $gallerySerie_id=$this->galleryImageRepository->getById($id)['serie_id'];

        return redirect('gallery/photo-images/filter/'.$gallerySerie_id);
    }

    public function destroy($id)
    {
        $image = $this->galleryImageRepository->getById($id);
        $gallerySerie = GallerySerie::where('id', '=', $image->serie_id)->firstOrFail();

        $this->galleryImageRepository->destroy($id);

        return redirect('gallery/photo-images/filter/'.$gallerySerie['id'])->with('success', "L'image a été supprimée.");
    }



    public function filter($gallerySerie_id)
    {
        $galleryImages = GalleryImage::where('serie_id','=', $gallerySerie_id)->orderBy('position')->get();

        $gallerySerie = GallerySerie::where('id','=', $gallerySerie_id)->firstOrFail();

        return view('gallery.images.index', compact('galleryImages', 'gallerySerie', 'gallerySerie_id'));
    }

    public function reposition()
    {
        if(\Request::has('item'))
        {
            $i = 0;
            foreach(\Request::get('item') as $id)
            {
                $i++;
                $item = GalleryImage::find($id);
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