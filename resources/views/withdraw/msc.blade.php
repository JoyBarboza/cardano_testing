@php $user = auth()->user(); @endphp
@extends('layouts.master')
@section('page-title') {{trans('withdraw/usd.USD_Withdrawal')}} @endsection
@section('page-content')


<main>
	<section>
		<div class="rows">
            <h1 class="main_heading">{{trans('withdraw/usd.Withdraw')}}<small> Token ($ {{number_format(auth()->user()->msc,8)}})</small></h1>
            <div class="box box-inbox">
            @include('flash::message')
           @if(! $is_withdraw->withdraw)
           <div class="well text-center">{{trans('withdraw/index.Currently_PreSale_coins')}}  <span class="text-danger">{{trans('withdraw/index.disabled')}}</span></div><hr>
           @endif
                <h3>{{trans('withdraw/usd.Generate_Withdraw_Request')}} :</h3><hr>
                 <form class="form-horizontal onSubmitdisableButton" name="withdraw" action="" method="post">
                    {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group{{ $errors->has('payable_currency')?' has-error':' has-feedback' }}">
                            <label>{{trans('withdraw/usd.Payment_Method')}}</label>
                            <select name="currency" class="form-control">
                                <option value="MSC" @if(old('payable_currency') == 'MSC') selected @endif>Token</option>
                            </select>
                            <span class="help-block text-danger">{{$errors->first('payable_currency') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group{{ $errors->has('caddress')?' has-error':' has-feedback' }}">
                            <label>{{trans('withdraw/usd.Address')}}:</label>
                            <input type="text" class="form-control" name="caddress" value="{{ old('caddress') }}">
                            <span class="help-block text-danger">{{$errors->first('caddress') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group{{ $errors->has('camount')?' has-error':' has-feedback' }}">
                            <label>Token {{trans('withdraw/usd.Amount')}}:</label>
                            <input type="text" class="form-control" name="camount" value="{{ old('camount') }}">
                            <span class="help-block text-danger">{{$errors->first('camount') }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-info submitButton" type="submit">{{trans('withdraw/usd.Proceed')}}</button>
                </div>
                </form>
            </div>
            
            
            <div class="box box-inbox">
				<table class="table table-de mb-0" style="color: #878787;">
								 <thead>
									<tr>
										<th>{{trans('withdraw/usd.Date')}}</th>
										<th>{{trans('withdraw/usd.Amount')}} (Token)</th>
										<th>{{trans('withdraw/usd.Fees')}} (Token)</th>
										<th>{{trans('withdraw/usd.Amount_Received')}}(Token)</th>
										<th>{{trans('withdraw/usd.Payment_Method')}}</th>
										<th>{{trans('withdraw/usd.Address')}}</th>							
										<th>{{trans('withdraw/usd.Description')}}</th>							
											
										<th>{{trans('withdraw/usd.Status')}}</th>										
										
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
										<td style="white-space:pre-wrap; word-wrap:break-word">{{$transaction->description}}</td>
	
										<td>{{$transaction->status}}</td>
										
										
									 </tr>
									 @empty
											<tr><td class="text-center" colspan="6">{{trans('withdraw/usd.No_data')}}</td>
									
									 @endforelse
								 </tbody>
							 </table>
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
