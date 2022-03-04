<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @include('layouts.partial.user.htmlheader')

<body>

@include('layouts.partial.user.header')



    @yield('content')

@include('layouts.partial.user.notification')

@include('layouts.partial.user.scripts')


    
</body>
</html>
