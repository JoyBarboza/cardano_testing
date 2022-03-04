<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.partial.front.htmlheader')

<body data-spy="scroll" data-target=".navbar" data-offset="50">
    @include('layouts.partial.front.header')

    @yield('content')

    @include('layouts.partial.front.footer')

    <a id="scroll_up" class="main-btn"><i class="far fa-angle-up"></i></a>
    
    @include('layouts.partial.front.scripts')
</body>
</html>

