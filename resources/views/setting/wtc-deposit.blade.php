@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">        
        <li>
            <span>{{trans('setting/wtc_deposit.settings')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
JPC
    <small>{{trans('setting/wtc_deposit.deposit')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
             <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-share font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">{{trans('setting/wtc_deposit.deposit_address')}}</span>
                </div>
            </div>
            <div class="portlet-body">
               <ul class="address_li">
					@forelse ($coinaddress as $address)
						<li style="list-style: none;text-align: center;font-size: 20pt;">{{ $address->address }}</li>
					@empty
						<p>{{trans('setting/wtc_deposit.no_address_available')}}</p>
					@endforelse
						
					</ul>	
					
                    
               
            </div>
        </div>

        <div class="portlet light bordered">
             <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-share font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">{{trans('setting/wtc_deposit.transaction_history')}}</span>
                </div>
            </div>
            <div class="portlet-body">
               <div class="send_request_background">
					
					<hr>
					<table class="table">
					<thead>
						<tr>
						<th>{{trans('setting/wtc_deposit.txnID')}}</th>
						<th>{{trans('setting/wtc_deposit.type')}}</th>
						<th>{{trans('setting/wtc_deposit.amount')}}</th>
						<th>{{trans('setting/wtc_deposit.transaction_at')}}</th></tr>
					</thead>
					
					<tbody>
					
					@forelse ($payments as $payment)
						<tr>
						<td>{{trans('setting/wtc_deposit.hash')}}: <a href="http://www.wtcexplorer.com/tx/{{$payment->reference_no}}" target="_blank">{{$payment->reference_no}}</a><br />
						{{trans('setting/wtc_deposit.address')}}: {{ $payment->address }}
						</td>
						@if ($payment->remarks=='WTCDeposit')
						<td>{{trans('setting/wtc_deposit.deposit')}}</td>
					@endif
					@if ($payment->remarks=='WTCWithdrawal')
					<td>{{trans('setting/wtc_deposit.withdrawal')}}</td>
					@endif

					<td>@php $transaction= App\Payment::find($payment->id)->transaction; @endphp
					{{$transaction->amount}}
					</td>
					<td>{{$payment->created_at}}</td></tr>

					@empty
						<tr><td colspan="5" align="center">{{trans('setting/wtc_deposit.No_transaction_available')}}</td></tr>
					@endforelse
					</tbody>
					</table>

					
				</div>
            </div>
        </div>

        
    </div>
</div>
@endsection
            
