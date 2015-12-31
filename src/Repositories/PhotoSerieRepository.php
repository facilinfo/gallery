<?php

namespace App\Repositories;

use App\PhotoImage;
use App\PhotoSerie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Contracts\Mail\Mailer;
use App\User;


class PhotoSerieRepository
{

    protected $photoSerie;

    public function __construct(Mailer $mailer, PhotoSerie $photoSerie)
    {
        $this->photoSerie = $photoSerie;
        $this->mailer = $mailer;
    }

    public function notify($id){

        $photoSerie=PhotoSerie::where('id', '=', $id)->firstOrFail();

        if(!$photoSerie->notification_sent){

            $users=User::where('notify_me', '=', true)->get();
            foreach($users as $user){
                $this->mailer->send(['emails.html-notify-serie', 'emails.text-notify-serie'],compact('user', 'photoSerie'), function($message) use ($user) {
                    $message->to($user->email)->subject('De nouvelles photos sont en ligne');
                });
            }

            $photoSerie->notification_sent==true;
            $photoSerie->save();
        }
    }

    public function getMaxPosition(){
        return $maxPosition = DB::table('photos_series')->max('position');
    }



    public function get(){
       return $photoSerie=$this->photoSerie->all()->sortBy('position');
    }

    private function save(PhotoSerie $photoSerie, Array $inputs)
    {




        $photoSerie->name = $inputs['name'];
        $photoSerie->slug =  Str::slug($inputs['name'],'-');
        $photoSerie->description = $inputs['description'];
        if(!isset($photoSerie->position)) $photoSerie->position =$this->getMaxPosition()+1;
        $photoSerie->category_id=$inputs['category_id'];
        if(isset( $inputs['active'])) $active=1; else $active=0;
        $photoSerie->active = $active;
        $photoSerie->save();

        if( !$photoSerie->notification_sent && $photoSerie->active==true)
        {
            $this->notify($photoSerie->id);
            $photoSerie->notification_sent=true;

            $photoSerie->save();
        }
    }



    public function store(Array $inputs)
    {
        $photoSerie = new $this->photoSerie;
        $inputs['name']=ucfirst($inputs['name']);
        $this->save($photoSerie, $inputs);

        return $photoSerie;
    }

    public function getById($id)
    {
        return $this->photoSerie->findOrFail($id);
    }

    public function update($id, Array $inputs)
    {
        $inputs['name']=ucfirst($inputs['name']);
        if(isset( $inputs['active'])) $active=1; else $active=0;
        $this->active = $active;
        $this->save($this->getById($id), $inputs);
    }

    public function removeDirectory($path) {

        $files = glob($path . '/*');
        foreach ($files as $file) {
            is_dir($file) ? $this->removeDirectory($file) : unlink($file);
        }
       if(is_dir($path)) rmdir($path) ;

        return;
    }

    public function destroy($id)

    {
        $serie=PhotoSerie::with('category')->where('id','=', $id)->firstOrFail();

        $path=(public_path().'/uploads/photos_images/'.$serie->category->slug.'/'.$serie->slug);

        $this->removeDirectory($path);





        $this->getById($id)->delete();
    }


}