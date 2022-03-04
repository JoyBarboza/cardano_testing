@extends('layouts.auth')
@section('content')
    
    
    <section class="error-area">
        <div class="container">
            <div class="login_inner">
            
                <div class="login-box">
                <div class="text-center">
                    <a href="{{ route('page.welcome') }}">
                      <img class="login_logo" src="{{ asset('/time/images/logo_icon.png?dfd') }}" alt="logo">
                    </a>
                  </div>
                    <div class="login-title text-center mb-20">
                        <h3 class="title">{{ trans('auth/passwords/email.reset_password') }}</h3>
                        <form>
                            <div class="flag_right">
                                <div class="flagstrap" id="select_country" data-input-name="NewBuyer_country" data-selected-country=""></div>
                            </div>
                        </form>
                    </div>  
                   
                    <div class="login-input">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.request') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group {{ $errors->has('email') ? ' has-error' : 'has-feedback' }}">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="{{ trans('auth/passwords/reset.email_address') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('password') ? ' has-error' : 'has-feedback' }}">
                                <input id="password" type="password" class="form-control" name="password" placeholder="{{ trans('auth/passwords/reset.password') }}" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : 'has-feedback' }}">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{trans('auth/passwords/reset.confirm_password')}}" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <input type="submit" value="Reset" class="btn btn-info btn-block btn-lg">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

        


@endsection
