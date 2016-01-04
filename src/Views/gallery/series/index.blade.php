@extends('app')

@section('active_tab')
    <?php $tab='photos';?>
@endsection

@section('content')


    <h1>Gérer les series</h1>


    <p class="text-right">
        <a class="btn btn-primary" href="{{ action('\Facilinfo\Gallery\Controllers\GallerySerieController@create') }}">  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ajouter une série</a>
    </p>

    <table class="db table table-striped">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>En ligne</th>

        </tr>
        </thead>
        <tbody>


        @foreach($gallerySeries as $gallerySerie)
            <tr id="item_{{ $gallerySerie->id}}">

                <td class="handle">{{ $gallerySerie->name}}</td>
                <td class="handle">{{ $gallerySerie->category->name}}</td>
                <td class="handle">{{ $gallerySerie->active ? "oui" : "non"}}</td>

                <td class="text-right">
                    <a class="btn btn-default" href="{{ url('gallery/photo-images/filter/'.$gallerySerie->id) }}"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Photos</a>
                    <a class="btn btn-primary" href="{{ action('\Facilinfo\Gallery\Controllers\GallerySerieController@edit', $gallerySerie) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editer</a>
                    <a class="btn btn-danger" href="{{ action('\Facilinfo\Gallery\Controllers\GallerySerieController@destroy', $gallerySerie) }}" data-method="delete" data-confirm="Voulez vous vraiment supprimer cette série ?"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection

@section('additional-scripts')


    <script>
        $('table.db tbody').sortable({
            'containment': 'parent',
            'revert': true,
            helper: function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });

                return $helper;
            },
            'handle': '.handle',
             update: function(event, ui){

                $.post('{{ url('gallery/photo-series/reposition') }}', $(this).sortable('serialize'), function(data) {
                }, 'json');
            }
        });
        $(window).resize(function() {
            $('table.db tr').css('min-width', $('table.db').width());
        });
    </script>





@endsection