@extends('gallery.app')

@section('title')
    Modifier la série {{ $gallerySerie->name }}
@endsection

@section('active_tab')
    <?php $tab='gallery_series';?>
@endsection

@section('content')
    <h4>Modifier la série {{ $gallerySerie->name }}</h4>
    @include('flash')
    @include('gallery.series.form', ['action' => 'update'])
@endsection