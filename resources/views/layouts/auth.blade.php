<!doctype html>
<html lang="{{app()->getLocale()}}">
@include('layouts.partial.front.htmlheader')
<body class="login_bg">
    
    @yield('content')
    @include('layouts.partial.front.scripts')
</body>

{{--<body class="login_section">
  <div class="container">
    <div class="box box-inbox">
       
        <div class="text-center">
        <a href="{{ route('page.welcome') }}">
            <img class="login_logo" src="/masonicoin/img/logo.png?dfx" alt="">
        </a>
        <form>
            <div class="flag_right">
                <div class="flagstrap" id="select_country" data-input-name="NewBuyer_country" data-selected-country=""></div>
            </div>
        </form>
        </div>
        <br>

    @yield('content')


    </div>
  </div>


    @include('layouts.partial.user.scripts')
</body>--}}
</html>


