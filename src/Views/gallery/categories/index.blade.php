@extends(config('gallery.views-template'))

@section('title')
    Gérer les catégories de photos
@endsection

@section('active_tab')
    <?php $tab='gallery_categories';?>
@endsection


@section('content')


    <h1>Gérer les catégories de photos</h1>

    <p class="text-right">
        <a class="btn btn-primary" href="{{ action('\Facilinfo\Gallery\Controllers\GalleryCategoryController@create') }}">  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ajouter une catégorie</a>
    </p>

    <table class="db table table-striped">
        <thead>
        <tr>

            <th>Nom</th>

        </tr>
        </thead>
        <tbody>
        @foreach($galleryCategories as $category)
            <tr id="item_{{ $category->id}}">

                <td class="handle">{{ $category->name}}</td>
                <td class="text-right">
                    <a class="btn btn-primary" href="{{ action('\Facilinfo\Gallery\Controllers\GalleryCategoryController@edit', $category) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editer</a>
                    <a class="btn btn-danger" href="{{ action('\Facilinfo\Gallery\Controllers\GalleryCategoryController@destroy', $category) }}" data-method="delete" data-confirm="Voulez vous vraiment supprimer cette catégorie ?"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer</a>
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

                $.post('{{ url('gallery/photo-categories/reposition') }}', $(this).sortable('serialize'), function(data) {}, 'json');
            }
        });
        $(window).resize(function() {
            $('table.db tr').css('min-width', $('table.db').width());
        });
    </script>
@endsection