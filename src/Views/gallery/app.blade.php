<!DOCTYPE html>
<html ng-app lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf_token" content="{!! csrf_token() !!}"/>
	<title>Back-Office | @yield('title')</title>


	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->



</head>
<body>
@yield('active_tab')
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Back-Office</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">


							<li @if($tab=='gallery_categories') class="active" @endif><a href="{{ route('gallery.photo-categories.index') }}">Catégories</a></li>
							<li @if($tab=='gallery_series') class="active" @endif ><a href="{{ route('gallery.photo-series.index') }}">Séries</a></li>


				</ul>


			</div>
		</div>
	</nav>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
	@include('gallery.flash')
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
	@yield('content')
		</div>
	</div>
</div>
			<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript">
	$.ajaxSetup({
		headers: { 'X-CSRF-Token' : $('meta[name=csrf_token]').attr('content') }
	});
</script>

<script src="{{ asset('/js/gallery/destroy-confirm.js') }}"></script>
@yield('additional-scripts')
</html>
