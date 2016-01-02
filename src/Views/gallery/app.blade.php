<!DOCTYPE html>
<html ng-app lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf_token" content="{!! csrf_token() !!}"/>
	<title>Back-Office</title>




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
@yield('tab')
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
					<li><a href="{{ url('/') }}">Accueil du site</a></li>
					@if(Auth::user() && Auth::user()->role=='admin')
						<li @if($tab=='users') class="active" @endif>
							<a href="{{ url('/user') }}">Utilisateurs</a>
						</li>
					@endif
					@if(Auth::user() && (Auth::user()->role=='admin' || Auth::user()->role=='author'))
						<li @if($tab=='categories') class="active" @endif>
							<a href="{{ url('/category/private_index') }}">Catégories</a>
						</li>
					@endif
					@if(Auth::user() && (Auth::user()->role=='admin' || Auth::user()->role=='author'))
						<li @if($tab=='posts') class="active" @endif>
							<a href="{{ url('/post/private_index') }}">Articles</a>
						</li>
					@endif
					@if(Auth::user())
						<li @if($tab=='comments') class="active" @endif>
							<a href="{{ url('/comment') }}">Commentaires</a>
						</li>
					@endif

					@if(Auth::user() && Auth::user()->role=='admin')
					<li class="dropdown @if($tab=='photos') active @endif">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Photos <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{{ url('/photo_category') }}">Catégories</a></li>
							<li><a href="{{ url('/photo_serie') }}">Séries</a></li>
						</ul>
					</li>
					@endif

				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Se connecter</a></li>
						<li><a href="{{ url('/auth/register') }}">S'inscrire</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/user/profile') }}">Profil</a></li>
								<li><a href="{{ url('/auth/logout') }}">Se déconnecter</a></li>

								@if(Auth::user()->avatar)
									<br/>
								<li class="text-center"><img class="img-circle" src="{{ url('/').'/img/avatars/'.Auth::user()->id.'.png' }}"/></li>
									<br/>
								@endif

							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
	@include('flash')
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
	<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/jquery-ui-min.js') }}"></script>
<script src="{{ asset('/js/laravel.js') }}"></script>
<script type="text/javascript">
	$.ajaxSetup({
		headers: { 'X-CSRF-Token' : $('meta[name=csrf_token]').attr('content') }
	});
</script>
	@yield('additional-scripts')
	@yield('scripts')
</body>
</html>
