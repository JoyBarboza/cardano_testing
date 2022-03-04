<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="{{ config('app.name') }} is built on Blockchain Technology and is offering Pre-Sale of {{ env('TOKEN_NAME') }}. Get exclusive deals for every purchase and be a part of the best Cryptocurrency Pre-Sale offers. Contact us  to know more.">
	<meta name="keywords" content="Cryptocurrency, Blockchain, Cryptocoin, Pre-sale cryptocoin, {{ config('app.name') }}, Digital Currency, best ico to invest">
	<meta name="author" content="{{ config('app.name') }}">

        <title>{{ config('app.name') }}</title>
        <base href="{{ url('/') }}/{{ app()->getLocale() }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('/time/images/favicon.ico?fhc') }}">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('/masonicoin/css/bootstrap4-alpha3.min.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <!-- <link rel="stylesheet" href="http://fonts.googleapis.com/icon?family=Material+Icons"> -->
        <!-- <link rel="stylesheet" href="{{ url('/') }}/masonicoin/css/style.css?v={{time()}}">   -->
        <link rel="stylesheet" href="https://anandisha.com/alpha_game_code/public/masonicoin/css/style.css?v=1625746258">  
        <link rel="stylesheet" type="text/css" href="{{ asset('/masonicoin/css/flags.css?dfz') }}">

        <!-- <link rel="stylesheet" href="/masonicoin/css/responsive.css?v={{time()}}">   -->
        <link rel="stylesheet" href="https://anandisha.com/alpha_game_code/public/masonicoin/css/responsive.css?v=1625746258">  
       
        {{--<title>ICO</title>
        <link rel="shortcut icon" href="{{ asset('/time/images/favicon.ico?ghcg') }}" type="image/png">

        <link rel="stylesheet" href="{{ asset('/time/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/time/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('/time/css/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('/time/css/default.css') }}">
        <link rel="stylesheet" href="{{ asset('/time/css/style.css') }}">--}}
		
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-200507153-1"></script>

		  <link rel="stylesheet" href="{{ asset('assets/staking_assest/css/bootstrap.min.css') }} ">
		  <link rel="stylesheet" href="{{ asset('assets/staking_assest/css/all.css') }} ">

		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- staking_assest -->
		  <!-- <link rel="apple-touch-icon" sizes="180x180" href="images/favicon_package/apple-touch-icon.png">
		  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon_package/favicon-32x32.png">
		  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon_package/favicon-16x16.png">
		  <link rel="manifest" href="images/favicon_package/site.webmanifest">
		  <link rel="mask-icon" href="images/favicon_package/safari-pinned-tab.svg" color="#5bbad5">
		  <meta name="msapplication-TileColor" content="#da532c">
		  <meta name="theme-color" content="#ffffff"> -->


		  <!-- font css here -->
		  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
		  <!-- Admin style css here -->
		  <link rel="stylesheet" href="{{ asset('assets/staking_assest/css/admin_style.css') }} ">
		  <!-- animation css here  -->
		  <link rel="stylesheet" href="{{ asset('assets/staking_assest/css/aos.css') }}">


		  		<script type="text/javascript" src="{{ asset('parsley.min.js') }}"></script>

    <script src="{{ asset('toastr.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('toastr.min.css') }}">

    <style type="text/css">
    .parsley-errors-list{
        color: red;
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
  </style>

		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-200507153-1');
		</script>
		
		<!-- DO NOT MODIFY -->
		<!-- Quora Pixel Code (JS Helper) -->
		<script>
		!function(q,e,v,n,t,s){if(q.qp) return; n=q.qp=function(){n.qp?n.qp.apply(n,arguments):n.queue.push(arguments);}; n.queue=[];t=document.createElement(e);t.async=!0;t.src=v; s=document.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s);}(window, 'script', 'https://a.quora.com/qevents.js');
		qp('init', '46cba5e214094f57ab37733eafca9f82');
		qp('track', 'ViewContent');
		</script>
		<noscript><img height="1" width="1" style="display:none" src="https://q.quora.com/_/ad/46cba5e214094f57ab37733eafca9f82/pixel?tag=ViewContent&noscript=1"/></noscript>
		<!-- End of Quora Pixel Code -->
		<script>qp('track', 'CompleteRegistration');</script>

		<!-- Reddit Pixel -->
		<script>
		!function(w,d){if(!w.rdt){var p=w.rdt=function(){p.sendEvent?p.sendEvent.apply(p,arguments):p.callQueue.push(arguments)};p.callQueue=[];var t=d.createElement("script");t.src="https://www.redditstatic.com/ads/pixel.js",t.async=!0;var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(t,s)}}(window,document);rdt('init','t2_cnmmignu');rdt('track', 'PageVisit');
		</script>
		<!-- DO NOT MODIFY -->
		<!-- End Reddit Pixel -->
		
		<!-- Reddit Pixel -->
		<script>
		!function(w,d){if(!w.rdt){var p=w.rdt=function(){p.sendEvent?p.sendEvent.apply(p,arguments):p.callQueue.push(arguments)};p.callQueue=[];var t=d.createElement("script");t.src="https://www.redditstatic.com/ads/pixel.js",t.async=!0;var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(t,s)}}(window,document);rdt('init','t2_cnmmignu');rdt('track', 'SignUp');
		</script>
		<!-- DO NOT MODIFY -->
		<!-- End Reddit Pixel -->

    @stack('css')
</head>



    
