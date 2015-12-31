<br/>


{!!Form::model($galleryCategory, ['url' => action('\Facilinfo\Gallery\Controllers\GalleryCategoryController@'.$action, $galleryCategory->id), 'method' => $action == "store" ? "Post" : "Put"]) !!}
{!! Form::hidden('id', null) !!}
<div class="form-group">

    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
</div>


<div class="form-group">
    <button type="submit" class="btn btn-primary">
        <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Sauvegarder
    </button>
</div>


{!! Form::close() !!}