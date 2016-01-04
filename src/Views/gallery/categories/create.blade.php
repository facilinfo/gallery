@extends('gallery.app')

@section('title')
    Ajouter une catégorie de photos
@endsection

@section('active_tab')
    <?php $tab='gallery_categories';?>
@endsection

@section('content')
    <h4>Ajouter une catégorie de photos</h4>

    @include('gallery.categories.form', ['action' => 'store'])
@endsection