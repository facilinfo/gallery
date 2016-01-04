@extends('app')

@section('active_tab')
    <?php $tab='series';?>
@endsection

@section('content')
    <h4>Modifier {{ $gallerySerie->name }}</h4>
    @include('flash')
    @include('gallery.series.form', ['action' => 'update'])
@endsection