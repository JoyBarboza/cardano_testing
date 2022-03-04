@extends('layouts.master')
@section('page-content')
    <div class="col-md-9 col-sm-8">
        @include('flash::message')
        <div class="profile_section">
            <div class="send_request_background">
                <strong>{{trans('auth/passwords/change.password_renewal')}} </strong>
                <hr>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <img class="profile_img" src="{{ asset('images/defaultavatar.png') }}" alt="img">
                        <small style="display:block; text-align:center;">{{ $user->email }}</small>
                    </div>
                    <div class="col-md-9 col-sm-9">
                        <form action="{{ route('account.password.change') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('old_password')?' has-error':'' }}">
                                <label class="col-sm-4 control-label">{{trans('auth/passwords/change.old_password')}} :</label>
                                <div class="col-sm-8">
                                    <input name="old_password" class="form-control" type="password" >
                                    @if($errors->has('old_password'))
                                        <span class="help-text">{{ $errors->first('old_password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('password')?' has-error':'' }}">
                                <label class="col-sm-4 control-label">{{trans('auth/passwords/change.new_password')}} :</label>
                                <div class="col-sm-8">
                                    <input name="password" class="form-control" type="password" >
                                    @if($errors->has('password'))
                                        <span class="help-text">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">{{trans('auth/passwords/change.confirm_password')}} : </label>
                                <div class="col-sm-8">
                                    <input name="password_confirmation" class="form-control" type="password">
                                </div>
                            </div>
                            <input style="margin-top: 0px !important;" type="submit" class="account_btn" value="{{trans('auth/passwords/change.change_password')}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
