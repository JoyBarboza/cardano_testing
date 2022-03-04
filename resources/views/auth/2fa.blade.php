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
                        <h3 class="title">{{trans('auth/2fa.2fa_authentication')}}</h3>
						<form>
							<div class="flag_right">
								<div class="flagstrap" id="select_country" data-input-name="NewBuyer_country" data-selected-country=""></div>
							</div>
						</form>
                    </div>
			
					<div class="login-input">
						@include('flash::message')
						<form method="POST" action="{{ route('account.faverify') }}">
							{{ csrf_field() }}
							<div  class="form-group{{ $errors->has('twofa_secret') ? ' has-error' : ' has-feedback' }}">
								<label>{{trans('auth/2fa.authentication_code')}} :</label>
								<input class="form-control" placeholder="{{trans('auth/2fa.six_digit_code')}}" type="password" name="twofa_secret" required>
								<span class="help-block"> {{ $errors->first('twofa_secret') }} </span>
							</div>
							<div class="form-group">
								<input class="btn btn-info btn-block btn-lg" type="submit" value="{{trans('auth/2fa.verify')}}">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	

@endsection
