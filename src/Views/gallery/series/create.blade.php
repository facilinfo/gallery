@extends('app')

@section('active_tab')
    <?php $tab='photos';?>
@endsection

@section('content')
    <h4>Ajouter une série</h4>

    @include('gallery.series.form', ['action' => 'store'])
@endsection