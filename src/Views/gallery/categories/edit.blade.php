@extends('app')

@section('active_tab')
    <?php $tab='photos';?>
@endsection

@section('content')
    <h4>Modifier {{ $photoCategory->name }}</h4>

    @include('photo_categories.form', ['action' => 'update'])
@endsection