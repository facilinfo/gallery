{!! BootForm::open()->action(route('gallery.photo-categories.'.$action),$galleryCategory ) !!}
{!! BootForm::bind($galleryCategory) !!}
{!! BootForm::text('Nom', 'name') !!}
{!! BootForm::submit()->addClass('btn-primary') !!}
{!! BootForm::close() !!}