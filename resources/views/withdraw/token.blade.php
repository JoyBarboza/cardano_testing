@php $user = auth()->user(); @endphp
@extends('layouts.master')
@section('page-title') {{trans('withdraw/msc.USD_Withdrawal')}} @endsection
@section('page-content')


<main>
	<section>
		<div class="rows">
			<h1 class="main_heading">{{trans('withdraw/msc.Withdraw')}}<small> {{$symbol}} ({{round(auth()->user()->time,8)}})</small></h1>
            
			@php if((auth()->user()->profile->address=='') && (auth()->user()->profile->ide_no=='') && (!auth()->user()->profile->kyc_verified)){ @endphp
			<div class="alert alert-danger alert-dismissible hide" id="paypalClose">
				{{trans('home.complete_kyc')}} <a href="{{route('account.profile')}}">{{trans('home.Profile')}}</a>  {{trans('home.withdraw_MSC')}} 
			 
			</div>
			@php }else if (!auth()->user()->profile->kyc_verified){ @endphp
			<div class="alert alert-danger alert-dismissible hide" id="paypalClose">
				{{trans('home.kyc_progress')}}
			</div>
			@php } @endphp
            <div class="box box-inbox">
            @include('flash::message')
           @if(! $is_withdraw->withdraw)
           <div class="well text-center">{{trans('withdraw/msc.Currently_PreSale_coins')}}  <span class="text-danger">{{trans('withdraw/msc.disabled')}}</span></div><hr>
           @endif
                <h3>{{trans('withdraw/msc.Generate_Withdraw_Request')}} :</h3><hr>
                 <form class="form-horizontal onSubmitdisableButton" name="withdraw" action="" method="post">
                    {{ csrf_field() }}
                <div class="row">
                    {{--<div class="col-md-4 col-sm-4">
                        <div class="form-group{{ $errors->has('currency')?' has-error':' has-feedback' }}">
                            <label>{{trans('withdraw/msc.Payment_Method')}}</label>
                            <select name="currency" class="form-control">
                                <option value="BTCS" @if(old('currency') == 'BTCS') selected @endif>{{$symbol}}</option>
                            </select>
                            <span class="help-block text-danger">{{$errors->first('currency') }}</span>
                        </div>
                    </div>--}}
                    <input type="hidden" name="currency" value="BTCS">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group{{ $errors->has('caddress')?' has-error':' has-feedback' }}">
                            <label>{{trans('withdraw/msc.Address')}}:</label>
                            <input type="text" class="form-control" name="caddress" value="{{ old('caddress') }}">
                            <span class="help-block text-danger">{{$errors->first('caddress') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group{{ $errors->has('camount')?' has-error':' has-feedback' }}">
                            <label>{{$symbol}} {{trans('withdraw/msc.Amount')}}:</label>
                            <input type="text" class="form-control" name="camount" value="{{ old('camount') }}">
                            <span class="help-block text-danger">{{$errors->first('camount') }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-info submitButton" type="submit">{{trans('withdraw/msc.Proceed')}}</button>
                </div>
                </form>
            </div>
            
            
            <div class="box box-inbox">
            <div class="table-responsive">
				<table class="table table-de mb-0" style="color: #878787;">
					<thead>
					<tr>
						<th>{{trans('withdraw/msc.Date')}}</th>
						<th>{{trans('withdraw/msc.Amount')}} ({{$symbol}})</th>
						<th>{{trans('withdraw/msc.Fees')}} ({{$symbol}})</th>
						<th>{{trans('withdraw/msc.Amount_Received')}} ({{$symbol}})</th>
						<th>{{trans('withdraw/msc.Payment_Method')}}</th>
						<th>{{trans('withdraw/msc.Address')}}</th>							
						<th>{{trans('withdraw/msc.RefID')}}</th>							
						<th>{{trans('withdraw/msc.Decline_reason')}}</th>							
							
						<th>{{trans('withdraw/msc.Status')}}</th>										
						
					</tr>
					</thead>
					<tbody>
						@forelse($withdraws as $transaction)  
						<tr>
							<td>{{$transaction->created_at}}</td>
						<td>{{$transaction->amount}}</td>
						<td>{{$transaction->fees}}</td>
						<td>{{$transaction->net_amount}}</td>
						<td>{{$transaction->currency->name}}</td>
						<td>{{$transaction->address}}</td>
						<td style="white-space:pre-wrap; word-wrap:break-word">{{$transaction->t_hash}}</td>
						<td style="white-space:pre-wrap; word-wrap:break-word">{{$transaction->decline_reason}}</td>

						<td>{{$transaction->status}}</td>
						
						
						</tr>
						@empty
							<tr><td class="text-center" colspan="9">{{trans('withdraw/msc.No_data')}}</td>
					
						@endforelse
					</tbody>
				</table>
			</div>
							 {{--<div class="portlet-footer">
								 <span>{{trans('user/cloudMining.Showing')}} {{ $withdraws->firstItem() }} {{trans('user/cloudMining.to')}} {{ $withdraws->lastItem() }} {{trans('user/cloudMining.of')}} {{ $withdraws->total() }} {{trans('user/cloudMining.records')}}</span>

								<span  style="float:right">{{ $withdraws->links() }}</span>
							</div>--}}

							<div class="portlet-footer">
								<span style="float:left">{{ __('Showing') }} {{ $withdraws->firstItem() }} {{ __('to') }} {{ $withdraws->lastItem() }} of {{ $withdraws->total() }} {{ __('records') }}</span>
								<span  style="float:right">{{ $withdraws->links() }}</span>
							</div>
			</div>
		</div>
	</section>
</main> 


@endsection
@push('js')
<script type="text/javascript">
	var confirm_msg="{{trans('home.ARE_YOU_SURE')}}";
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
