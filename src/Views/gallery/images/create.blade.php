@extends('gallery.app')

@section('title')
    Ajouter des photos
@endsection

@section('active_tab')
    <?php $tab='gallery_images';?>
@endsection


@section('content')

    <h4>Ajouter des photos</h4>



    {!! BootForm::open()->multipart()->action(route('gallery.photo-images.store')) !!}

    {!! BootForm::hidden('serie_id')->value($serie_id) !!}

    {!! BootForm::file('', 'images[]')->multiple(true)->addClass('btn btn-primary') !!}
    {!! BootForm::submit('<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Sauvegarder')->addClass('btn-primary') !!}
    {!! BootForm::close() !!}



@endsection