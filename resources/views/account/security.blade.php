@extends('layouts.master')
@section('page-content')

<main>
	<section>
		<div class="rows">
            <h1 class="main_heading">{{trans('account/security.security')}}</h1>
            <div class="box box-inbox">
            <div class="profile_section">
            <div class="send_request_background">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        @php $status = (auth()->user()->getMeta('google2fa_on') != 'started') ? '<span class="text-danger"><i class="fa fa-close"></i> Disabled</span>' : '<span class="text-success"><i class="fa fa-check"></i> Enabled</span>'; @endphp
                        <h3>{{trans('account/security.two_factor_authentication')}}</h3>
						<h4>{!! $status !!}</h4>
                        <hr>
                        <p>{{ trans('account/security.extra_account_security_1') }} {{ env('APP_NAME') }}  {{ trans('account/security.extra_account_security_2') }}
                       <br>
                    </div>
                </div>
            </div>

            <div class="send_request_background">
            {{trans('account/security.security')}}
                <hr>
                <div class="row">
                
                    <div class="col-md-4 col-sm-12">
                    @php $twofa = $google2fa; 
                        $user = auth()->user();
                        $google2fa_url = $twofa->getQRCodeGoogleUrl(
                            config('app.name'),
                            $user->email,
                            $user->getMeta('google2fa')
                            );
                        @endphp
                        <div class="print_code">
                            <img src="{{ $google2fa_url }}" alt=""><br />
                            <p>{{trans('account/security.16_digit_key')}}: <span style="color:red">{{$user->getMeta('google2fa')}}</span></p>
                        </div>
                        <a style="margin-bottom: 34px; display: block;" href="javascript:window.print()" class="standard">{{trans('account/security.print_backup')}}</a>
                        </div>
                        <div class="col-md-8 col-sm-12">
                        @include('flash::message')
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        <form class="" method="post" action="{{ route('account.fapost') }}">
                        {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputName2">{{trans('account/security.2fs_secret')}}</label>
                                    <input type="text" class="form-control" id="twofa_secret" name="twofa_secret" placeholder="6 digit code">
                                </div>
                                
                                <div class="form-check" style="padding-left:0px;">
                                    <label class="form-check-label">
                                    <Input type="checkbox"  class="form-check-input" name="2fa_confirm" /> {{trans('account/security.digit_key')}}
                                    </label>
                                </div>

                               
                                @php if($user->getMeta('google2fa_on') != 'started'){ @endphp
                                <button type="submit" class="btn btn-info">{{trans('account/security.enable_2fa')}}</button>
                                @php }else{ @endphp
                                <button type="submit" class="btn btn-info">{{trans('account/security.disable_2fa')}}</button>
                                @php } @endphp
                                
                        </form>
                        <p style="margin-top:20px;">{{trans('account/security.turning_on_fa')}}</p>
                        </div>
                    </div>
                </div>
          
            
            
        </div>
            </div>
		</div>
	</section>
</main> 


@endsection
