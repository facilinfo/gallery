@extends('app')

@section('active_tab')
    <?php $tab='photos';?>
@endsection

@section('content')
    <h4>Modifier {{ $galleryCategory->name }}</h4>

    @include('gallery.categories.form', ['action' => 'update'])
@endsection