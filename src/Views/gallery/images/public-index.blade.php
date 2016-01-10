@extends('gallery.front')

@section('title')
    Photos de la série {!! $galleryImages[0]->serie->name !!}
@endsection



@section('content')
    <h1>Séries de photos de la série {!! $galleryImages[0]->serie->name !!}</h1>

            @foreach($galleryImages as $image)
                <img src="{!! url('/'). $image->path.'/'.$image->id.'_thumb.'.$image->extension !!}">

            @endforeach

@endsection

