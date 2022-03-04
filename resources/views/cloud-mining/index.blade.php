@extends('layouts.master')

@section('page-content')

<main>
	<section>
		<div class="rows">
		<h1 class="main_heading">{{trans('user/cloudMining.cloud_mining')}}</h1>
		@include('flash::message')
			<div class="box box-inbox">
				<form class="form-horizontal onSubmitdisableButton" action="{{ route('cloudMining.oparetion') }}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group{{ $errors->has('plan')?' has-error':' has-feedback' }}">
                    <label class="form__label">{{trans('user/cloudMining.select_plan')}}:</label>
                    <div class="input-wrap">
								<select name="plan" autocomplete="off" class="form-control plan"> 
										<option value="">- {{trans('user/cloudMining.select_plan')}} -</option>
										@foreach($roiPlan as $plan)
										<option value="{{$plan->id}}" data-return={{$plan->token_price}} data-payin="{{$plan->payin_coin}}" data-payout="{{$plan->payout_coin}}" {{($plan->id==old('plan'))?'selected':''}}>{{$plan->name}} ({{$plan->duration}} Days)</option>
										@endforeach
							   
							   </select>
							   
                               @if($errors->has('plan'))
								<span class="help-text text-danger">{{ $errors->first('plan') }}</span>
								@endif
								<small class="plan_details text-success"></small><br>
								<small class="tokenreturn text-success"></small>
                    </div>
                </div>
            </div>
			
           <div class="col-md-6 col-sm-6">
                <div class="form-group{{ $errors->has('investment')?' has-error':' has-feedback' }}">
                    <label class="form__label">{{trans('user/cloudMining.enter_amount')}}: ({{env('TOKEN_SYMBOL')}} {{trans('user/cloudMining.Balance')}}: {{env('TOKEN_SYMBOL')}} {{ round(auth()->user()->csm,8).' ) ( ADA '.trans('user/cloudMining.Balance').' : '.round(auth()->user()->usd,8) }}) </label>
                    <div class="input-wrap">
                        <input type="text" class="form-control investment"
                               value="{{ old('investment') }}"
                               name="investment" autocomplete="off"
                               placeholder="0.00"
                               data-original-title="Enter BRC Aomunt for cloud mining"
                               onkeypress="return isNumberKey(event)">
							   
                               @if($errors->has('investment'))
								<span class="help-text text-danger">{{ $errors->first('investment') }}</span>
							   @endif
                    </div>
                </div>
            </div>
             <div class="col-md-12 col-sm-12 text-center">
				<button class="btn btn-info submitButton">{{trans('user/cloudMining.submit')}}</button>
			</div>
        </div>
		 </form>
            </div>
			<div class="box box-inbox">
			<div class="panel">
					<div class="panel-body">
						<div class="table-responsive table-scrollable">
                        <table class="table">
							<thead>
								<tr>
									<th>{{trans('user/cloudMining.date')}}</th>
									<th>{{trans('user/cloudMining.mining_plan')}}</th>
									<th>{{trans('user/cloudMining.mining_amount')}}</th>
									<th>{{trans('user/cloudMining.return_amount')}}</th>
									<th>{{trans('user/cloudMining.status')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($roiInvestments as $roiInvestment)
								<tr>
									<td>{{$roiInvestment->created_at}}</td>
									<td>{{$roiInvestment->roiPlan->name}} ( {{$roiInvestment->roiPlan->duration}} Days )</td>
									<td> {{ round($roiInvestment->amount_investment,8) }} {{$roiInvestment->payin_coin}}</td>
									<td> {{ round($roiInvestment->amount_return,8) }} {{$roiInvestment->payout_coin}}</td>
									<td>{{$roiInvestment->status}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
                        <div class="portlet-footer">
								<span>{{ __('Showing') }} {{ $roiInvestments->firstItem() }} {{ __('to') }} {{ $roiInvestments->lastItem() }} of {{ $roiInvestments->total() }} {{ __('records') }}</span>
								<span class="text-right">{{ $roiInvestments->links() }}</span>
							</div>
                    </div>
                    
						
					</div>
				</div>
            </div>
		</div>
	</section>
</main> 




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

function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode != 46 && charCode > 31
			&& (charCode < 48 || charCode > 57))
		return false;

	return true;
}

$(document).ready(function() { getWallet(); });

$(".plan").change(function() {
  getWallet();
});

$(".investment").keyup(function() {
  getWallet();
});

$(".investment").mouseout(function() {
  getWallet();
});

function getWallet(){
	 var payin= $('.plan :selected').attr('data-payin');
	 var payout= $('.plan :selected').attr('data-payout');
	 var tokenreturn= $('.plan :selected').attr('data-return');
	 var amount= $('.investment').val();
	 var str='';
	 var tokenstr='';
	 
	 
	 
	 if(tokenreturn && amount && payin && payout){ tokenstr = "Payable Amount is "+amount+" "+payin+" and Received Amount is "+(tokenreturn*amount)/100+" "+payout; }
	 else if(tokenreturn && amount){ tokenstr = "Received Amount is "+(tokenreturn*amount)/100; }
	 else{
		if(payin){ str +="Payable Wallet is "+payin+" ,"; }
		if(payout){ str +="Received Wallet is "+payout; } 
	 }
	 
	 $('.plan_details').html(str);
	 $('.tokenreturn').html(tokenstr);
}
</script>
@endpush
