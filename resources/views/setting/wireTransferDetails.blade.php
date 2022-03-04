@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('setting/banner.home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Core mining Settings</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    Core mining Settings
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
             @include('flash::message')
            <div class="portlet-body flip-scroll">
                <form role="form" class="onSubmitdisableButton" name="search" method="post" action="{{ route('admin.setting.wire.transfer.post') }}">
					{{csrf_field()}}
                    <div class="row">
                     
                         <div class="col-md-6">
                            <label for="" class="col-md-6">Min Amount:</label>
                            <input name="min_amount_cloud_mining" class="form-control" placeholder="Enter minimum core mining amount" value="{{ $min_amount_cloud_mining }}">
							<span class="help-block text-danger">{{ $errors->first('min_amount_cloud_mining') }}</span>
                        </div>
                       <div class="col-md-6">
                            <label for="" class="col-md-6">Max amount :</label>
                            <input name="max_amount_cloud_mining" class="form-control" placeholder="Enter maximum core mining amount" value="{{ $max_amount_cloud_mining }}">
							<span class="help-block text-danger">{{ $errors->first('max_amount_cloud_mining') }}</span>
                        </div>
                       
                        <div class="col-md-12">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-primary submitButton" name="search" value="true">Submit</button>
                        </div>
                        
                        
                           {{--<div class="col-md-12">
                            <label for="" class="col-md-2">Account Details:</label>
                            <textarea name="account_details" class="form-control" placeholder="Account Details">{{ $wire_transfer }}</textarea>
							<span class="help-block text-danger">{{ $errors->first('account_details') }}</span>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="col-md-2">One Time Password:</label>
								<input type="text" name="one_time_password" placeholder="Enter One time Password" class="form-control" >
							  <span class="help-block text-danger">{{ $errors->first('one_time_password') }}</span>
							  <a style="color:#03a9f3;cursor:pointer;" id="send_otp">Click Here To Receive One Time Password On Your Email.</a>
							<label class="otp_success"></label>	
                        </div>--}}
                    </div>
                </form>
            </div>
        </div>                                
       
    </div>
</div>
<div id="dialog" class="modal" role="dialog"></div>

@include('template.loader')

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
