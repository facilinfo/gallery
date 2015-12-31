@extends('app')

@section('active_tab')
    <?php $tab='photos';?>
@endsection

@section('content')
    <h4>Ajouter une Catégorie</h4>

    @include('gallery.categories.form', ['action' => 'store'])
@endsection