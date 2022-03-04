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
                        <h3 class="title">{{trans('auth/login.register_to_time')}}</h3>
						<form>
							<div class="flag_right">
								<div class="flagstrap" id="select_country" data-input-name="NewBuyer_country" data-selected-country=""></div>
							</div>
						</form>
                    </div>
                    <div class="login-input">
                    @include('flash::message')
                        <form method="POST" action="{{ route('register') }}">
						  {{ csrf_field() }}
						  	<div class="">
							  	<h4 style="font-weight: normal; color:#fff;">
									{{trans('auth/register.Account_type')}}
								</h4>
							</div>

							<div class="mt-10">
								<div class="custom-control custom-radio custom-control-inline">
									<input id="check1" type="radio" class="custom-control-input" name="account_type" value="individual" {{ old('account_type')?((old('account_type')=='individual')?"checked":""):"checked" }}>
									<label class="custom-control-label" for="check1">{{trans('auth/register.Individual')}}</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input id="check2" type="radio" class="custom-control-input" name="account_type" value="company" {{ (old('account_type')=='company')?"checked":"" }}>
									<label class="custom-control-label" for="check2">{{trans('auth/register.Company')}}</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input id="check3" type="radio" class="custom-control-input" name="account_type" value="partner" {{ (old('account_type')=='partner')?"checked":"" }}>
									<label class="custom-control-label" for="check3">Partner</label>
								</div>
							</div>

                            <div class="input-box mt-10 {{ $errors->has('first_name') ? 'has-error' : 'has-feedback' }}">
                                <label>{{trans('auth/register.Name')}} *</label>
                                <input id="name" type="text" autocomplete="off"  placeholder="" name="first_name" value="{{ old('first_name') }}"  >
								@if ($errors->has('first_name'))
									<span class="help-block text-danger">
									<strong>{{ $errors->first('first_name') }}</strong>
								</span>
								@endif
                            </div>
                            {{--
                            <div class="input-box mt-10 {{ $errors->has('username') ? 'has-error' : 'has-feedback' }}">
                                <label>{{trans('auth/register.Tax_ID')}} *</label>
                                <input id="username" type="text" autocomplete="off" placeholder="Enter Tax id *"  name="username" value="{{ old('username') }}" placeholder="" required>
								@if ($errors->has('username'))
									<span class="help-block text-danger">
									<strong>{{ $errors->first('username') }}</strong>
								</span>
								@endif                                
							</div>
                            --}}

							{{--<div class="input-box mt-10">
								<div class="row">
									<div class="col-md-6 col-sm-6 col-lg-6">
										<label>{{trans('auth/register.Email')}} *</label>
										<input id="email_name" type="text" placeholder="{{trans('auth/register.your_email_id_here')}}"  name="email_name" value="{{ old('email_name') }}" placeholder="" required>
										@if ($errors->has('email'))
											<span class="help-block text-danger">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-md-6 col-sm-6 col-lg-6">
										<label>&nbsp;</label>
										<select name="email_remaining_part" class="email_remaining_part">
											<option value="gmail.com">gmail.com</option>
											
										</select>
										
									</div>
									
								</div>
								<!-- <a style="color:#03a9f3;cursor:pointer;" id="send_otp">Click Here To Receive One Time Password On Your Email.</a>
								<p><label class="otp_success"></label>	</p>
								<input id="email" type="hidden" name="email" value=""> -->
										
							</div>--}}

							<div class="input-box mt-10  form-group{{ $errors->has('email') ? 'has-error' : 'has-feedback' }}">
								<label>{{trans('auth/register.Email')}} *</label>
								<input id="email" type="email" autocomplete="off" placeholder="{{trans('auth/register.your_email_id_here')}}"  name="email" value="{{ old('email') }}" placeholder="" required>
								@if ($errors->has('email'))
									<span class="help-block text-danger">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
								<!-- <a style="color:#03a9f3;cursor:pointer;" id="send_otp">Click Here To Receive One Time Password On Your Email.</a>
								<p><label class="otp_success"></label>	</p> -->
							</div>

							

							<!-- <div class="input-box mt-10  form-group{{ $errors->has('one_time_password') ? 'has-error' : 'has-feedback' }}">
								<label>Email OTP *</label>
								<input id="one_time_password" type="text" autocomplete="off" placeholder="Enter OTP"  name="one_time_password" value="{{ old('one_time_password') }}" required>
								@if ($errors->has('one_time_password'))
									<span class="help-block text-danger">
										<strong>{{ $errors->first('one_time_password') }}</strong>
									</span>
								@endif
								
							</div> -->
							

							<div class="input-box mt-10 {{ $errors->has('phone') ? 'has-error' : 'has-feedback' }}">
								<label>{{trans('auth/register.Phone')}} *</label>
								<input id="phone" type="text" autocomplete="off" placeholder="{{trans('auth/register.phone_with_area_code')}}"  name="phone" value="{{ old('phone') }}"  required>
								@if ($errors->has('phone'))
									<span class="help-block text-danger">
										<strong>{{ $errors->first('phone') }}</strong>
									</span>
								@endif
							</div>
							<div class="input-box mt-10 {{ $errors->has('password') ? ' has-error' : 'has-feedback' }}">
								<label>{{trans('auth/register.your_password_here')}} </label>
								<input id="password" type="password" autocomplete="off" placeholder="{{trans('auth/register.your_password_here')}}"  name="password" placeholder="" required>
								@if ($errors->has('password'))
									<span class="help-block text-danger">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
								@endif
							</div>
							<div class="input-box mt-10">
								<label>{{trans('auth/register.confirm_your_password')}} *</label>
								<input id="password-confirm" autocomplete="off" type="password" placeholder="{{trans('auth/register.confirm_your_password')}}"  name="password_confirmation" placeholder="" required>
							</div>
							<div class="input-box mt-10  {{ $errors->has('referral_code') ? 'has-error' : 'has-feedback' }}">
								<label>{{trans('auth/register.referral_code')}}</label>
								<input id="referral_code" type="text"  name="referral_code" value="" autocomplete="off" placeholder="{{trans('auth/register.referral_code')}}">
								@if ($errors->has('referral_code'))
									<span class="help-block text-danger">
									<strong>{{ $errors->first('referral_code') }}</strong>
								</span>
								@endif
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
                                <button class="main-btn register_button" type="submit">{{trans('auth/register.Register')}}  <i class="fal fa-arrow-right"></i></button>
								{{--<span>{{trans('auth/login.register_now')}} <a href="{{ route('login') }}">{{trans('auth/register.have_account')}}</a></span>--}}
								<span>{{trans('auth/register.have_account')}} <a class="areat_account" href="{{ route('login') }}">{{trans('auth/register.login')}}</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      
    </section>

       <!-- <h2 class="text-center">{{trans('auth/register.registration_form')}}</h2>
       <hr>
       <div class="login_container" >
         <form method="POST" action="{{ route('register') }}">
			{{ csrf_field() }}
			
			
			
			<div class="row">
				<div class="col-md-12">							
					<div class="form-group {{ $errors->has('account_type') ? 'has-error' : 'has-feedback' }} ">
						<div>
							<label><b>{{trans('auth/register.Account_type')}} :</b> </label>
						</div>
						<br>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-6">
								<input id="check1" type="radio" class="account_type cust_check" name="account_type" value="individual" {{ old('account_type')?((old('account_type')=='individual')?"checked":""):"checked" }}>
								<label for="check1">{{trans('auth/register.Individual')}}</label>
							</div>
							<div class="col-md-6 col-sm-6 col-6">
								<input id="check2" type="radio" class="account_type cust_check" name="account_type" value="company" {{ (old('account_type')=='company')?"checked":"" }}>
								<label for="check2">{{trans('auth/register.Company')}}</label>
							</div>
						</div>
					</div>
				</div>
			
				<div class="col-md-12">
					<div class="form-group {{ $errors->has('first_name') ? 'has-error' : 'has-feedback' }}">
						<input id="name" type="text" autocomplete="off"  placeholder="" name="first_name" value="{{ old('first_name') }}"  >
						@if ($errors->has('first_name'))
							<span class="help-block">
							<strong>{{ $errors->first('first_name') }}</strong>
						</span>
						@endif
					</div>
				</div>
							
				
			</div>
			
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group {{ $errors->has('username') ? 'has-error' : 'has-feedback' }}">
				<input id="username" type="text" autocomplete="off" placeholder="Enter Tax id *"  name="username" value="{{ old('username') }}" placeholder="" required>
				@if ($errors->has('username'))
					<span class="help-block text-danger">
					<strong>{{ $errors->first('username') }}</strong>
				</span>
				@endif
			</div>
			
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="form-group form-group{{ $errors->has('email') ? 'has-error' : 'has-feedback' }}">
						<input id="email" type="email" autocomplete="off" placeholder="{{trans('auth/register.your_email_id_here')}}"  name="email" value="{{ old('email') }}" placeholder="" required>
						@if ($errors->has('email'))
							<span class="help-block text-danger">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="form-group form-group{{ $errors->has('phone') ? 'has-error' : 'has-feedback' }}">
						<input id="phone" type="text" autocomplete="off" placeholder="Enter Your Phone Number With Area Code"  name="phone" value="{{ old('phone') }}"  required>
						@if ($errors->has('phone'))
							<span class="help-block text-danger">
								<strong>{{ $errors->first('phone') }}</strong>
							</span>
						@endif
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group {{ $errors->has('password') ? 'has-error' : 'has-feedback' }}">
						<input id="password" type="password" autocomplete="off" placeholder="{{trans('auth/register.your_password_here')}}"  name="password" placeholder="" required>
						@if ($errors->has('password'))
							<span class="help-block text-danger">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<input id="password-confirm" autocomplete="off" type="password" placeholder="{{trans('auth/register.confirm_your_password')}}"  name="password_confirmation" placeholder="" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group {{ $errors->has('referral_code') ? 'has-error' : 'has-feedback' }}">
						<input
							id="referral_code"
							type="text"
							class="form-control"
							name="referral_code"
							value="{{ old('referral_code') }}"
							autocomplete="off"
							placeholder="{{trans('auth/register.referral_code')}}">
						@if ($errors->has('referral_code'))
							<span class="help-block text-danger">
							<strong>{{ $errors->first('referral_code') }}</strong>
						</span>
						@endif
					</div>
			
				</div>
				
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
				<input class="btn btn-info btn-block btn-lg" value="{{trans('auth/register.Register')}}" type="submit">
			</div>
		</form>
		
          <a class="areat_account" href="{{ route('login') }}">{{trans('auth/register.have_account')}}</a>
</div> -->


@endsection

@push('js')
<!-- Add event to the button's click handler -->
<script type="text/javascript">
	$('.register_button').click(function(){
qp('track', 'CompleteRegistration'); // Call this function when inline action happens
});
</script>


<script>
	$(document).ready(function() {
		
		
		var account_type= $("input[name='account_type']:checked").val();
		if(account_type=='individual'){
			
			$('#name').attr("placeholder","Enter Your Name Here");
			
		}else if(account_type=='company'){
			
			$('#name').attr("placeholder","Enter Company Name Here");
		}
	});


	$("input[name='account_type']").click(function() {
		var account_type= $("input[name='account_type']:checked").val();
		if(account_type=='individual'){
			
			$('#name').attr("placeholder","Enter Your Name Here");
		}else if(account_type=='company'){
			
			$('#name').attr("placeholder","Enter Company Name Here");
		}
	});
</script>
      
<script>
	var url = $('base').attr('href');
	$('#send_otp').click(function(){
		$('.otp_success').text('');
		
		var usrMail=$('#email').val();
		
		//var emailname= $('input[name=email_name]').val();
		//var emailremaining= $('.email_remaining_part option:selected').val(); 
		
		//var usrMail=emailname+'@'+emailremaining;
		//$('#email').val(usrMail);
		
		var isemail=isEmail(usrMail);
		if(isemail){
			 usrMail= encodeURIComponent(usrMail); 
			
			
				$.ajax({
						type: 'GET',
						url: url + '/account/send-otp/'+usrMail,
						
						//dataType: 'JSON',
						success: function() {
							$('.otp_success').text('{{ __("One Time Password Sent To Your Registered Email.") }}').css('color','#00c292');
						},
						error:function(){
							 $('.otp_success').text('{{ __("There is a temporary error sending OTP please try later") }}').css('color','red');
							//bootbox.alert('{{ __("There is a temporary error sending OTP please try later") }}');
						}
                });
		}else{
			 $('.otp_success').text('{{ __("Please enter a valid Email") }}').css('color','red');
					
		}
	});
	
    function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
	
	//~ $('input[name=email_name]').focus(function(){ 
		//~ var email_name= $('input[name=email_name]').val();
		//~ var email_remaining_part= $('.email_remaining_part option:selected').val();
		//~ $('#email').val(email_name+'@'+email_remaining_part);
	//~ });
	//~ $('input[name=email_name]').mouseout(function(){ 
		//~ var email_name= $('input[name=email_name]').val();
		//~ var email_remaining_part= $('.email_remaining_part option:selected').val();
		//~ $('#email').val(email_name+'@'+email_remaining_part);
	//~ });
	
	//~ $('.email_remaining_part').click(function(){
		//~ var email_name= $('input[name=email_name]').val();
		//~ var email_remaining_part= $('.email_remaining_part option:selected').val();
		//~ $('#email').val(email_name+'@'+email_remaining_part);
	//~ });
	
	//~ $('.register_button').click(function(){
		//~ var email_name= $('input[name=email_name]').val();
		//~ var email_remaining_part= $('.email_remaining_part option:selected').val();
		//~ $('#email').val(email_name+'@'+email_remaining_part);
		//~ return true;
	//~ });
</script>
@endpush

