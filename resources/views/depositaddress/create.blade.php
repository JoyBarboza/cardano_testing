@extends('layouts.admin')
@section('page-bar')
        <!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('announcement/create.home')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    Deposit Address Details
    <!-- <small>{{trans('announcement/create.panel')}}</small> -->
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')

    <div class="row">
        <div class="col-md-12">
            <!-- @include('errors.input') -->
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-share font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Create Deposit Address Details</span>
                    </div>
                </div>
                <div class="portlet-body">
                    @include('flash::message')
                    <form class="form-horizontal" role="form" action="{{ route('admin.depositaddress.store') }}"  method="post">
                        {{ csrf_field() }}
                        <div class="form-body">

                            <div class="form-group {{ $errors->has('coin')?'has-error':'' }}">
                                <label class="col-md-3 control-label">Coin Name:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    
                                                </span>
                                        <input name="coin" value ="{{request()->coin}}" type="text" class="form-control" >
                                    </div>
                                    @if($errors->has('coin'))
                                        <span class="help-box">{{ $errors->first('coin') }}</span>
                                    @endif
                                </div>
                            </div>
                           <div class="form-group {{ $errors->has('address')?'has-error':'' }}">
                                <label class="col-md-3 control-label">Coin Address:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    
                                                </span>
                                        <input name="address" value ="{{request()->address}}" type="text" class="form-control" >
                                    </div>
                                    @if($errors->has('address'))
                                        <span class="help-box">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>
                           

                            <div class="form-group {{ $errors->has('bonus_discount')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('announcement/create.status')}}:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <!-- <i class="fa fa-cart-arrow-down"></i> -->
                                        </span>
                                        <select class="form-control" name="status">
                                            <option value="1">{{trans('announcement/create.enable')}}</option>
                                            <option value="0">{{trans('announcement/create.disable')}}</option>
                                        </select>
                                    </div>
                                    @if($errors->has('bonus_discount'))
                                        <span class="help-box">{{ $errors->first('bonus_discount') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">One Time Password:</label>
                            <div class="col-md-9">
								<input type="text" name="one_time_password" placeholder="Enter One time Password" class="form-control" >
								@if($errors->has('one_time_password'))
									<span class="help-box">{{ $errors->first('one_time_password') }}</span>
								@endif
							 </div>
							
                        </div>
                       
                        <div class="form-group">
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<a style="color:#03a9f3;cursor:pointer;" id="send_otp">Click Here To Receive One Time Password On Your Email.</a>
								<label class="otp_success"></label>	
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <button type="button" class="btn default">{{trans('announcement/create.cancel')}}</button>
                            <button type="submit" class="btn blue check_unit">{{trans('announcement/create.submit')}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
	var url = $('base').attr('href');
	$('#send_otp').click(function(){		
		$.ajax({
                    type: 'GET',
                    url: url + '/account/send-otp',
                    //dataType: 'JSON',
                    success: function() {
                        $('.otp_success').text('{{ __("One Time Password Sent To Your Registered Email.") }}').css('color','#00c292');
                    },
                    error:function(){
                        //bootbox.alert('{{ __("There is a temporary error sending OTP please try later") }}');
                    }
                });
	});
    $(document).on('submit', '.onSubmitdisableButton', function(e) {	
		  if (confirm("Are You Sure ?") == true) {
			$('.submitButton').attr('disabled',true);
			return true;
		  } else {
			return false;
		  }
	});
</script>
@endpush
