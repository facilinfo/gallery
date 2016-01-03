<?php $action == "store" ? $method="Post" : $method="Put";
//dd($method);

?>

{!! BootForm::open()->action(route('gallery.photo-categories.'.$action, $galleryCategory)) !!}
{!! BootForm::bind($galleryCategory) !!}
{!! BootForm::hidden('_method')->value($method) !!}
{!! BootForm::hidden('id', null) !!}

{!! BootForm::text('Nom', 'name') !!}
{!! BootForm::submit('<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Sauvegarder')->addClass('btn-primary') !!}
{!! BootForm::close() !!}