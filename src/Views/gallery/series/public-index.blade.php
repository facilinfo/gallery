@extends('gallery.front')

@section('title')
    Séries de photos de la catégorie {!! $gallerySeries[0]->category->name !!}
@endsection



@section('content')
    <h1>Séries de photos de la catégorie {!! $gallerySeries[0]->category->name !!}</h1>

    @foreach($gallerySeries as $serie)

            <div class="row">
                <h2>{{ $serie->name}}</h2>
                @foreach($serie->images as $image)
                    <img src="{!! url('/'). $image->path.'/'.$image->id.'_thumb.'.$image->extension !!}">

                @endforeach
            </div>
        @endforeach

@endsection

