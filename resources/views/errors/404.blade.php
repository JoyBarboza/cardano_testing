<!DOCTYPE html>
<html lang="en">
<head>
  <title>caesiumlab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="{{ asset('css/home3/style.css') }}">
 <link rel="stylesheet" href="{{ asset('css/home3/responsive.css') }}">
 <link rel="stylesheet" href="{{ asset('css/home3/bootstrap.min.css') }}"> 
</head>
<body>

<div class="error_section">
	<div class="container">
		<img class="" src="{{ asset('images/home3/error404.png') }}" alt="img">
		<h3>{{trans('errors/404.url_not_exist')}}</h3>
		<a href="{{url('/')}}">GO TO HOME</a>
	</div>
</div>



</body>
</html>
















