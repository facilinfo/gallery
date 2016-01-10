@extends(config('gallery.views-template'))

@section('title')
    Ajouter une série de photos
@endsection

@section('active_tab')
    <?php $tab='gallery_series';?>
@endsection

@section('content')
    <h4>Ajouter une série de photos</h4>

    @include('gallery.series.form', ['action' => 'store'])
@endsection