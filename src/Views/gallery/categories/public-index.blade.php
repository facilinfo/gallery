@extends('gallery.front')

@section('title')
    Catégories de photos
@endsection



@section('content')
    <h1>Catégories de photos</h1>

        @foreach($galleryCategories as $category)
              <h2>{{ $category->name}}</h2>

              @foreach($category->series as $serie)
                    <div class="row">
                        <h3>{{ $serie->name}}</h3>
                        @foreach($serie->images as $image)
                            <img src="{!! url('/'). $image->path.'/'.$image->id.'_thumb.'.$image->extension !!}">

                        @endforeach
                    </div>
              @endforeach
        @endforeach
@endsection

