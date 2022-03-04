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
                        <h3 class="title">{{trans('auth/login.Welcome_to_Login')}}</h3>
                        <form>
                          <div class="flag_right">
                              <div class="flagstrap" id="select_country" data-input-name="NewBuyer_country" data-selected-country=""></div>
                          </div>
                        </form>
            
                    </div>
                    <div class="login-input">
                    @include('flash::message')
                        <form method="POST" action="{{ route('login') }}">
                          {{ csrf_field() }}
                            <div class="input-box mt-10 {{ $errors->has('email') ? ' has-error' : 'has-feedback' }}">
                                <label>{{trans('auth/login.Email_Address')}}</label>
                                <input placeholder="{{trans('auth/login.your_email_id_here')}}" type="text" name="email" value="{{ old('email') }}" required>
                                <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                            </div>
                            <div class="input-box mt-10 {{ $errors->has('password') ? ' has-error' : 'has-feedback' }}">
                                <label>{{trans('auth/login.Password')}}</label>
                                <input placeholder="{{trans('auth/login.your_password_here')}}" type="password" name="password" required >
                                
                            </div>
                            <div class="input-box mt-10">
                              <label>{{trans('auth/login.Enter_what_you_see')}}</label>
                              <div class="row">
                                <div class="col-md-3 col-sm-4 col-4">
                                  <div class="captcha_img">
                                    <img style="border-radius: 5px;" src="<?php echo $builder->inline(); ?>" />
                                  </div>
                                </div>
                                <div class="col-md-9 col-sm-8 col-8">
                                  <div class="captcha_text">
                                    <input  type="text" name="captcha" class="captcha_input" placeholder="{{trans('auth/login.Enter_what_you_see')}}">
                                    @if ($errors->has('captcha'))
                                      <span class="text-danger">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                      </span>
                                    @endif
                                  </div>	
                                </div>
                              </div>
                              <a href="{{ route('password.request') }}">{{trans('auth/login.forget')}} {{trans('auth/login.password')}}</a>
                            </div>
                            <div class="input-btn mt-10">
                                <button class="main-btn" type="submit">{{trans('auth/login.signin')}}  <i class="fal fa-arrow-right"></i></button>
                                <span>{{trans('auth/login.register_now')}} <a href="{{ route('register') }}">{{trans('auth/login.Signup')}}</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      
    </section>


  
   
@endsection


 <!-- <h2 class="text-center">{{trans('auth/login.login')}}</h2>
       <hr>
       <div class="login_container">
		   @include('flash::message')
          <form method="POST" action="{{ route('login') }}">
             {{ csrf_field() }}
           <div class="form-group {{ $errors->has('email') ? ' has-error' : 'has-feedback' }}">
             <input class="form-control" placeholder="{{trans('auth/login.your_email_id_here')}}" type="text" name="email" value="{{ old('email') }}" required>
			<span class="help-block text-danger">{{ $errors->first('email') }}</span>
           </div>
           <div class="form-group {{ $errors->has('password') ? ' has-error' : 'has-feedback' }}">
				<input class="form-control" placeholder="{{trans('auth/login.your_password_here')}}" type="password" name="password" required />
				<span class="help-block text-danger"> {{ $errors->first('password') }} </span>
			</div>

        <div class="form-group" style="overflow: hidden;">
          <div class="row">
            <div class="">
              <div class="captcha_img">
                <img src="<?php echo $builder->inline(); ?>" />
              </div>
            </div>
            <div class="col-md-8 col-sm-8 col-8">
              <div class="captcha_text">
                <input style="padding-left: 10px;" type="text" name="captcha" class="form-control captcha_input" placeholder="{{trans('auth/login.Enter_what_you_see')}}">
                @if ($errors->has('captcha'))
                  <span class="text-danger">
                    <strong>{{ $errors->first('captcha') }}</strong>
                  </span>
                @endif
              </div>	
            </div>
          </div>
									
																
								</div>
            <div class="form-group">
             <input class="btn btn-info btn-block btn-lg" value="{{trans('auth/login.signin')}}" type="submit">
           </div>
         </form>
          <a class="areat_account" href="{{ route('register') }}">{{trans('auth/login.register_now')}}</a>
          <a class="areat_account pull-right" style="margin-top: 5px;" href="{{ route('password.request') }}">{{trans('auth/login.forget')}} {{trans('auth/login.password')}}</a>
       </div> -->
