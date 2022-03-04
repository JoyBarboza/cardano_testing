@php $user = auth()->user(); @endphp
@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('user/profile.home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span> {{trans('user/profile.my_profile')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">{{trans('user/profile.profile')}} <small>{{trans('user/profile.management')}}</small></h1>
<!-- END PAGE TITLE-->
@endsection

@section('contents')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="{{ route('photo.get', [ $user->getDocumentPath('PHOTO'), $user->username]) }}" class="img-responsive" alt=""> </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> {{ $user->full_name }} </div>

                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons">
                    <button type="button" class="btn btn-circle green btn-sm">{{trans('user/profile.administrator')}}</button>
                </div>
                <!-- END SIDEBAR BUTTONS -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li>
                            <a href="javascript:;"><i class="icon-info"></i>  {{trans('user/profile.username')}} : {{ $user->username }}</a>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="glyphicon glyphicon-envelope"></i>  {{trans('user/profile.email')}} : {{ $user->email }}</a>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="glyphicon glyphicon-phone"></i>  {{trans('user/profile.mobile')}} : {{ $user->phone_no  }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">{{trans('user/profile.account_profile')}}</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="{{ session()->get('basic') }}" >
                                    <a href="#profile-info" data-toggle="tab">{{trans('user/profile.basic_info')}}</a>
                                </li>
                                <li  class="{{ session()->get('avatar') }}" >
                                    <a href="#change-profile-photo" data-toggle="tab">{{trans('user/profile.avatar')}}</a>
                                </li>
                                <li  class="{{ session()->get('password') }}" >
                                    <a href="#change-password" data-toggle="tab">{{trans('user/profile.password')}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            @include('errors.input')
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane {{ session()->get('basic') }}" id="profile-info">
                                    <form role="form" action="{{ route('admin.user.profileUpdate') }}" method="post">
                                        {{csrf_field()}}
                                        <div class="form-group{{$errors->has('firstname')?' has-error':' has-feedback'}}">
                                            <label class="control-label">{{trans('user/profile.first_name')}}</label>
                                            <input type="text" name="firstname" value="{{ $user->first_name }}" class="form-control" />
                                            <p class="help-block">{{ $errors->first('firstname') }}</p>
                                        </div>
                                        <div class="form-group{{$errors->has('middlename')?' has-error':' has-feedback'}}">
                                            <label class="control-label">{{trans('user/profile.middle_name')}}</label>
                                            <input type="text" name="middlename" value="{{ $user->middle_name }}" class="form-control" />
                                            <p class="help-block">{{ $errors->first('middlename') }}</p>
                                        </div>
                                        <div class="form-group{{$errors->has('lastname')?' has-error':' has-feedback'}}">
                                            <label class="control-label">{{trans('user/profile.last_name')}}</label>
                                            <input type="text" name="lastname" value="{{ $user->last_name }}" class="form-control" />
                                            <p class="help-block">{{ $errors->first('lastname') }}</p>
                                        </div>
                                        <div class="form-group{{$errors->has('email')?' has-error':' has-feedback'}}">
                                            <label class="control-label"> {{trans('user/profile.email')}}</label>
                                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" />
                                            <p class="help-block">{{ $errors->first('email') }}</p>
                                        </div>
                                        <div class="form-group{{$errors->has('mobile_no')?' has-error':' has-feedback'}}">
                                            <label class="control-label">{{trans('user/profile.mobile_no')}}.</label>
                                            <input type="text" name="mobile_no" value="{{ $user->phone_no }}" class="form-control" />
                                            <p class="help-block">{{ $errors->first('mobile_no') }}</p>
                                        </div>
                                        <div class="form-group{{$errors->has('address')?' has-error':' has-feedback'}}">
                                            <label class="control-label">{{trans('user/profile.address')}}</label>
                                            <textarea class="form-control" rows="2" name="address">{{ $user->profile->address  }}</textarea>
                                            <p class="help-block">{{ $errors->first('address') }}</p>
                                        </div>

                                        <div class="form-group{{$errors->has('city')?' has-error':' has-feedback'}}">
                                            <label class="control-label">{{trans('user/profile.city')}}</label>
                                            <input type="text" name="city" value="{{ $user->profile->city }}" class="form-control" />
                                            <p class="help-block">{{ $errors->first('city') }}</p>
                                        </div>
                                        <div class="form-group{{$errors->has('state')?' has-error':' has-feedback'}}">
                                            <label class="control-label">{{trans('user/profile.state')}}</label>
                                            <input type="text" name="state" value="{{ $user->profile->state }} " class="form-control" />
                                            <p class="help-block">{{ $errors->first('state') }}</p>
                                        </div>
                                        <div class="form-group{{$errors->has('pincode')?' has-error':' has-feedback'}}">
                                            <label class="control-label">{{trans('user/profile.pincode')}}</label>
                                            <input type="text" name="pincode" value="{{ $user->profile->pin_code }}" class="form-control" />
                                            <p class="help-block">{{ $errors->first('pincode') }}</p>
                                        </div>

                                        <div class="margiv-top-10">
                                            <button type="submit" class="btn green"> {{trans('user/profile.save_changes')}} </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- END PERSONAL INFO TAB -->

                                <!-- CHANGE AVATAR TAB -->
                                <div class="tab-pane {{ session()->get('avatar') }}" id="change-profile-photo">
                                    <form action="{{ route('admin.user.changePicture') }}" role="form" method="post" enctype="multipart/form-data">
                                        {{  csrf_field() }}
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    <img src="{{ route('photo.get', [ $user->getDocumentPath('PHOTO'), $user->username]) }}" alt="No Image" />
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                <div>
                                                    <span class="btn default btn-file">
                                                    <span class="fileinput-new"> {{trans('user/profile.select_profile_picture')}}</span>
                                                    <span class="fileinput-exists"> {{trans('user/profile.change')}} </span>
                                                    <input type="file" name="profile_pic" accept="image/*"> </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> {{trans('user/profile.remove')}} </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="margin-top-10">
                                            <button type="submit" class="btn green"> {{trans('user/profile.submit')}} </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- END CHANGE AVATAR TAB -->

                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane {{ session()->get('password') }}" id="change-password">
                                    <form action="{{route('admin.user.changePassword')}}" method="post" >
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label">{{trans('user/profile.current_password')}}</label>
                                            <input type="password" name="old_password" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">{{trans('user/profile.new_password')}}</label>
                                            <input type="password" name="password" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">{{trans('user/profile.Retype_new_password')}}</label>
                                            <input type="password" name="password_confirmation" class="form-control" />
                                        </div>
                                        <div class="margin-top-10">
                                            <button type="submit" class="btn green"> {{trans('user/profile.change_password')}} </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- END CHANGE PASSWORD TAB -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>
    <!-- END CONTENT BODY -->
@endsection

@push('css')
<link href="{{ asset('assets/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
<script src="{{asset('assets/pages/scripts/profile.min.js')}}"></script>
<script src="{{asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
<script src="{{asset('assets/global/plugins/bootbox/bootbox.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var url = '{!! url('/') !!}';
        $('a#change-profile').click(function () {
            @if(auth()->user()->hasRole('admin'))
                $('#profile-info').find('input, textarea, button')
                    .attr('disabled', false);
            @else
                $('#profile-info').find('input, textarea, button')
                    .not('input[name*=name], input[name=email], input[name=mobile_no]')
                    .attr('disabled', false);
            @endif

        });


        // Check Useravailability

        $('input[name=username]').blur(function () {
            var route = url + '/member/checkUsername';
            $('#useravailibilty').removeClass('');
            $.ajax({
                type: 'GET',
                url: route,
                data: {username: this.value},
                dataType: 'JSON',
                success: function (result) {
                    $('#useravailibilty').attr('class', result.class);
                    $('#useravailibilty').text(result.message);
                }
            });
        });


        /*
         Address Proof Verification
         */

        $('.response-pan').click(function () {
            var response = $(this).attr('data-value');
            var user_id = $('.response-pan').attr('data-id');

            $.ajax({
                type: 'GET',
                url: url + 'member/document/approve',
                data: {user_id: user_id, doc_type: 'pan_no',response:response},
                dataType: 'JSON',
                success: function (result) {
                    if (result.status) {
                        $('#doc_verfication').css('display', 'block').text('Address Proof Document Verified');
                    }
                }
            });
        });

        /*
         SSID Verification
         */
        $('.response-ssid').click(function () {
            debugger;
            var user_id = $('.response-pan').attr('data-id');

            $.ajax({
                type: 'GET',
                url: url + 'member/document/approve',
                data: {user_id: user_id, doc_type: 'ssid'},
                dataType: 'JSON',
                success: function (result) {
                    if (result.status) {
                        $('#doc_verfication').css('display', 'block').text('SSID Document Verified');
                    }
                }
            });
        });

        $('form').submit(function(e) {
            var currentForm = $(this);
            e.preventDefault();

            var sendOTP = function() {
                return $.ajax({
                    type: 'GET',
                    url: url + '/profile/send-otp',
                    dataType: 'JSON',
                    success: function() {
                        takeOTP();
                    },
                    error:function(){
                        bootbox.alert('There is a temporary error sending OTP please try later');
                    }
                });
            };

            var takeOTP = function() {
                bootbox.prompt({
                    title: "Please Enter OTP received on your email",
                    inputType: 'password',
                    callback: function (result) {
                        if(result != null || result != undefined) {
                            verifyOTP(result);
                        }
                    }
                });
            };

            var counter = 1;

            var verifyOTP = function(input) {
                return $.ajax({
                    type: 'POST',
                    url: url + '/profile/verify-otp',
                    data:{onetimepassword:input},
                    dataType: 'JSON',
                    success: function(result) {
                        if(result.status) {
                            currentForm.append('<input type="hidden" name="onetimepassword" value="'+ input +'"/>')
                            currentForm.unbind();
                            currentForm.submit();
                        } else if(!result.status && counter < 3) {
                            takeOTP();
                        }
                        counter++;
                    },
                    error: function(result) {
                        verifyOTP(input);
                    }
                });
            };
            sendOTP();
        });

    });
</script>
@endpush
