@extends('gallery.app')

@section('title')
    Gérer les photos
@endsection

@section('active_tab')
    <?php $tab='gallery_images';?>
@endsection

@section('content')
    <h1>Gérer les photos</h1>

    <div class="form-group">
       <h2>Série : <?php echo $gallerySerie->name;?></h2>

    </div>


    <p class="text-right">
        <a class="btn btn-primary" href="{{ route('photo_image_create',$gallerySerie_id)}}">  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ajouter des photos</a>
    </p>

    <table class="db table table-striped">
        <thead>
        <tr>

            <th></th>
            <th>Légende</th>

            <th></th>


        </tr>
        </thead>
        <tbody>


        @foreach($galleryImages as $galleryImage)
            <tr id="item_{{ $galleryImage->id}}">


                <td width="20%" style="text-align:center; vertical-align: middle">
                    <img class="handle" src="{!! url('/'). $galleryImage->path.'/'.$galleryImage->id.'_thumb.'.$galleryImage->extension !!}"/>

                </td>
                <td width="60%">
                    {!! BootForm::open()->action(route('gallery.photo-images.update', $galleryImage))->id('form_'.$galleryImage->id) !!}
                    {!! BootForm::hidden('id', null)->value ($galleryImage->id) !!}
                    {!! BootForm::hidden('_method', null)->value('Put') !!}
                    <div class="form-group">

                        {!! BootForm::text('Titre', 'title')->id('title_'.$galleryImage->id)->value($galleryImage->title) !!}
                        {!! BootForm::text('Légende', 'legend')->id('legend_'.$galleryImage->id)->value($galleryImage->legend) !!}
                        {!! BootForm::text('Texte alternatif', 'alt')->id('alt_'.$galleryImage->id)->value($galleryImage->alt) !!}

                    </div>

                    {!! BootForm::close() !!}
                </td>

                <td width="5%" style="text-align:center; vertical-align: middle"> <div id='DIVloading_<?php echo $galleryImage->id;?>' style="visibility:hidden">
                        <img src="<?php echo url('/');?>/img/loading.gif"/>
                    </div></td>


                <td width="15%" style="text-align:center; vertical-align: middle">
                    <a class="btn btn-danger" href="{{ action('\Facilinfo\Gallery\Controllers\GalleryImageController@destroy', $galleryImage) }}" data-method="delete" data-confirm="Voulez vous vraiment supprimer cette photo ?"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer</a>
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
                $.post('{{ url('gallery/photo-images/reposition') }}', $(this).sortable('serialize'), function(data) {
                }, 'json');
            }
        });
        $(window).resize(function() {
            $('table.db tr').css('min-width', $('table.db').width());
        });
    </script>

    <script>
        (function($) {
            $.fn.invisible = function() {
                return this.each(function() {
                    $(this).css("visibility", "hidden");
                });
            };
            $.fn.visible = function() {
                return this.each(function() {
                    $(this).css("visibility", "visible");
                });
            };
        }(jQuery));

    @foreach($galleryImages as $galleryImage)
    $("#legend_<?php echo $galleryImage->id;?>, #title_<?php echo $galleryImage->id;?>,  #alt_<?php echo $galleryImage->id;?>").bind("change paste", function() {

                var scroll = $(document).scrollTop();

                $("#DIVloading_<?php echo $galleryImage->id;?>").visible();
                setTimeout(function () {
                        $("#DIVloading_<?php echo $galleryImage->id;?>").invisible();
                },1500);

                //$("#DIVloading_<?php echo $galleryImage->id;?>").invisible();
                var TITLE=$("#title_<?php echo $galleryImage->id;?>").val();
                var LEGEND=$("#legend_<?php echo $galleryImage->id;?>").val();
                var ALT=$("#alt_<?php echo $galleryImage->id;?>").val();

                  $.ajax({
                      type: 'post',
                      url:"{{route('gallery.photo-images.update', $galleryImage)}}",
                      headers: {"X-HTTP-Method-Override": "PUT"},
                      data: {title: TITLE, legend:LEGEND, alt:ALT}
                  });

            });


    @endforeach
    </script>

@endsection