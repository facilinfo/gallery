
<?php
$action == "store" ? $method="Post" : $method="Put";

?>


{!! BootForm::open()->action(route('gallery.photo-series.'.$action, $gallerySerie)) !!}
{!! BootForm::bind($gallerySerie) !!}
{!! BootForm::hidden('_method')->value($method) !!}
{!! BootForm::hidden('id', null) !!}

{!! BootForm::text('Nom', 'name') !!}
{!! BootForm::textarea('Description', 'description') !!}
{!! BootForm::select('Catégorie', 'category_id')->options($galleryCategories) !!}
{!! BootForm::checkbox('En ligne ?','active')->value($gallerySerie->active) !!}
{!! BootForm::submit('<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Sauvegarder')->addClass('btn-primary') !!}
{!! BootForm::close() !!}


