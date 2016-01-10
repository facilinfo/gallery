<!DOCTYPE html>
<html ng-app lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title')</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>



<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
	@yield('content')
		</div>
	</div>
</div>







</html>
