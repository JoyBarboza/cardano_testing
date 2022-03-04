
@php $url = (auth()->check()) ? url(DIRECTORY_SEPARATOR.app()->getLocale().DIRECTORY_SEPARATOR.'home') :  url(DIRECTORY_SEPARATOR.app()->getLocale()); @endphp


<header class="header-area">
        <div class="header-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="navigation">
                            <nav class="navbar navbar-expand-lg navbar-light ">
                                <a class="navbar-brand" href="/">
                                    <img class="fav_icon_logo" src="{{ asset('/time/images/logo_icon.png?gh') }}" alt="">
                                </a>
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                </button> 
                                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                    <nav class="navbar"> 
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="/">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#about">About</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#services">Services</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="#whitepaper">Documents</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="#faq">Faqs</a>
                                        </li>
                                    </ul>
                                    </nav>
                                </div>

                                <div class="navbar-btn d-sm-flex">
                                    @guest
                                    <a title="login" href="{{ route('login') }}"> <img src="{{ asset('/time/images/login.png?vf') }}" alt=""></a>
                                    <a title="Register" href="{{ route('register') }}"><img src="{{ asset('/time/images/register.png?fg') }}" alt=""></a>
                                    @endguest
                                    @if(auth()->check())
                                    <a title="My Account" href="{{ route('home') }}"><img src="{{ asset('/time/images/profile.png?ghc') }}" alt=""></a>
                                    <a title="{{trans('layouts/front.logout')}}" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img src="{{ asset('/time/images/logout.png?fgc') }}" alt=""></a>
                                    @endif
                                </div>
 
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{csrf_field()}}
                                </form>
                            </nav>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        
    </header>
    <div class="padding_top"></div>



















