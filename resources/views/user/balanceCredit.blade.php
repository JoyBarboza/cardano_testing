@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('user/balanceCredit.home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('user/balanceCredit.credit_balance')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('user/balanceCredit.credit_balance')}}
    <small>{{--trans('user/index.management')--}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption"><p>USD Balance : {{ number_format($user->getBalance('USD'), 8) }}</p>
                <p>{{env('TOKEN_SYMBOL')}} Balance : {{ number_format($user->getBalance(env('TOKEN_SYMBOL')), 8) }}</p></div>
            </div>
            
            <div class="portlet-body flip-scroll">
				
                <form  class="onSubmitdisableButton"  role="form" name="search" method="post" action="{{ route('admin.account.credit.post') }}">
					{{csrf_field()}}
                    <div class="row">
                        <div class="col-md-12">
                            <label for="" class="col-md-2">{{trans('user/balanceCredit.usd_balance')}}:</label>
                            <input type="text" name="usd_balance" value="" class="form-control" placeholder="{{trans('user/balanceCredit.usd_balance')}}">
                        </div>
                        <div class="col-md-12">
                            <label for="" class="col-md-2">{{env('TOKEN_SYMBOL')}}:</label>
                            <input type="text" name="msc_balance" value="" class="form-control" placeholder="{{trans('user/balanceCredit.jpc_balance')}}">
                        </div>
                         <div class="col-md-12">
                            <label class="col-md-2">Description : </label>
                            <textarea  name="description" placeholder="Description" class="form-control"></textarea>
                            @if($errors->has('description'))
                                <span class="help-box">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <label for="">&nbsp;</label>
                            <input type="hidden" name="user_id" value="{{$userid}}" >
                            <button type="submit" class="btn btn-block btn-primary submitButton" name="search" value="true">{{trans('user/balanceCredit.submit')}}</button>
                        </div>
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
