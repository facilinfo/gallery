<?php

namespace Facilinfo\Gallery\Controllers;


use Illuminate\Routing\Controller as Controller;



use Facilinfo\Gallery\Repositories\GalleryImageRepository;
use Facilinfo\Gallery\Models\GallerySerie;
use Facilinfo\Gallery\Models\GalleryImage;
use Facilinfo\Gallery\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as IntImage;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Session;
use \Illuminate\Support\Facades\Input;


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


            $photoSerie = GallerySerie::where('id', '=', $request->serie_id)->firstOrFail();
            $photoCategory = GalleryCategory::where('id', '=', $photoSerie['category_id'])->firstOrFail();
            $path = config('gallery.path') . $photoCategory['slug'] . '/' . $photoSerie['slug'];


        $first=GalleryImage::where('serie_id', '=', $photoSerie_id)->count();
        $first>0 ? $first=0 :$first=1;

        // getting all of the post data
        $files = Input::file('images');

        // Making counting of uploaded photos_images
        $file_count = count($files);
        // start count how many uploaded
        $uploadcount = 0;
        $i=0;

        foreach ($files as $file) {

            if($first==1 && $i==0) $first=1; else $first=0;

            if ($file!=null) {
                $extension = $file->getClientOriginalExtension();

                //Validation
                $rules=[
                    'images.'.$i => 'required|image',
                    'serie_id' => 'required|numeric|min:1',

                ];
                $messages=[
                    'image' => 'Seules les images sont autorisées !',
                    'serie_id.min'=>'Veuillez sélectionner une série',
                ];

                Validator::make($request->all(),$rules, $messages);

                //On sauve en base si la validation passe


                $image = new GalleryImage (array(
                    ///'position' =>$photoSerie_id.str_pad($i+1, 6, '0', STR_PAD_LEFT),
                    'extension' => $extension,
                    'path' => $path,
                    'serie_id' => $photoSerie_id,
                    'first' => $first

                ));
                $image->save();

                $id = GalleryImage::max('id');

                //On sauve le fichier
                $destinationPath = public_path() . $path;

                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $filename = $id . '.' . $extension;
                $upload_success = $file->move($destinationPath, $filename);
                $img = IntImage::make($destinationPath . '/' . $filename)->orientate();
                $img->save($destinationPath . '/' . $id . '.' . $extension);

                $img->resize(null, 125, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($destinationPath . '/' . $id . '_thumb.' . $extension);

                $uploadcount++;

            } else {

                return redirect('gallery/photo-images/create/'.$photoSerie_id)->with('error', "Vous n'avez pas séléctionné de fichier. ");
            }
            $i++;
        }

        if ($uploadcount == $file_count) {

            return redirect('gallery/photo-images/filter/' . $photoSerie_id)->with('success', "Les images ont été enregistrées.");
        } else {
            return redirect('gallery/photo-images/create/'.$photoSerie_id)->with('error', "Un problème est survenu. Veuillez réessayer. ");
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
        $this->galleryImageRepository->destroy($id);

        $gallerySerie = GallerySerie::where('id', '=', $image->serie_id)->firstOrFail();
        $galleryCategory = GalleryCategory::where('id', '=', $gallerySerie['category_id'])->firstOrFail();


        $path = public_path().config('gallery.path') . $galleryCategory['slug'] . '/' . $gallerySerie['slug'];
        $file=$path.'/'.$id.'.'.$image->extension;
        $thumb=$path.'/'.$id.'_thumb.'.$image->extension;
        if(is_file($file)){
            unlink($file);
        }
        if(is_file($thumb)){
            unlink($thumb);
        }

        return redirect('gallery/photo-images/filter/'.$gallerySerie['id'])->with('success', "L'image a été supprimée.");
    }



    public function filter($gallerySerie_id)
    {

        $galleryImages = GalleryImage::where('serie_id','=', $gallerySerie_id)->orderBy('position')->get();

        $gallerySerie = GallerySerie::where('id','=', $gallerySerie_id)->firstOrFail();

        return view('gallery.images.index', compact('galleryImages', 'gallerySerie', 'gallerySerie_id'));

    }

    public function reposition(){
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