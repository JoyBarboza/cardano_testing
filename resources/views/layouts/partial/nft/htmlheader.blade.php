<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/time/images/favicon.ico') }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta content="{{ csrf_token() }}" name="csrf-token" />

    <!-- SETUP BASE TAG -->
    <base href="{{ url('/') }}/{{ app()->getLocale() }}">
    <!-- END BASE TAG SETUP-->
    
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    
    <!-- BEGIN THEME LAYOUT STYLES -->

    <link href="{{ asset('assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/layouts/layout/css/themes/darkblue.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ asset('assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/layouts/layout/css/flags.css') }}" rel="stylesheet" type="text/css" />

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

    <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
    <!-- END THEME LAYOUT STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->
    @stack('css')
    <!-- END PAGE LEVEL STYLES -->

    <style>
        .table .btn{margin-top:2px!important}
        .page-sidebar
        .page-sidebar-menu
        .sub-menu li > a,
        .page-sidebar-closed.page-sidebar-fixed
        .page-sidebar:hover
        .page-sidebar-menu
        .sub-menu li > a{
            padding: 6px 15px 6px 17px!important;
        }
    </style>
    <style type="text/css">
      .parsley-errors-list{
          color: red;
          list-style-type: none;
          padding: 0;
          margin: 0;
      }
    </style>
    
</head>


<!-- END HEAD -->
