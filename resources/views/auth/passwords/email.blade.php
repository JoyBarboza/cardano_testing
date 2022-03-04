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
                        <form method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}
                            <div class="input-box mt-10 has-feedback {{ $errors->has('email') ? 'has-error' : 'has-feedback' }}">
                                <label>Email</label> 
                                <input placeholder="Email" id="email" type="email" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-box mt-10 has-feedback" style="overflow: hidden;">
                            <label>{{trans('auth/login.Enter_what_you_see')}}</label>
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-4">
                                        <div class="captcha_img">
                                            <img style="border-radius: 5px;" src="<?php echo $builder->inline(); ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-8 col-8">
                                    <div class="captcha_text">
                                            <input type="text" name="captcha" class="captcha_input" placeholder="{{trans('auth/login.Enter_what_you_see')}}">
                                            @if ($errors->has('captcha'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('captcha') }}</strong>
                                                </span>
                                            @endif
                                        </div>	
                                    </div>
                                </div>
                                        
                                                                    
                            </div>
                            <br>
                            <div class="input-btn mt-10">
                                <button class="main-btn" type="submit">{{trans('auth/passwords/email.reset_link')}} <i class="fal fa-arrow-right"></i></button>
                            
                                <span>Go Back To <a href="{{ route('login') }}">{{trans('auth/passwords/email.login')}}</a></span>
                            
                            </div>
                        </form>
                        

                    </div>
                </div>
            </div>
        </div>
    </section>

 
@endsection
