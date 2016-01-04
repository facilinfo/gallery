@extends('gallery.app')

@section('title')
    Modifier la catégorie {{ $galleryCategory->name }}
@endsection

@section('active_tab')
    <?php $tab='gallery_categories';?>
@endsection

@section('content')
    <h4>Modifier la catégorie {{ $galleryCategory->name }}</h4>

    @include('gallery.categories.form', ['action' => 'update'])
@endsection