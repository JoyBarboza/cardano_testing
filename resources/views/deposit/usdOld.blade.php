@extends('layouts.master')
@section('page-title') {{trans('deposit/usd.Deposit_Fiat_Currency')}} @endsection 
@section('page-content')

<main>
	<section>
		<div class="rows">
			 
            <h1 class="main_heading">USD Wallet (${{ round(auth()->user()->usd,8)}})</h1>
              @if (count($errors) > 0)
                    <div class = "alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
           <div class="box box-inbox">
				<h1 class="main_heading">{{trans('deposit/usd.Deposit_Crypto_Currency')}}</h1>
               
                @php $transaction = session('transaction')?session('transaction'):null @endphp
                @if($transaction)
                    <div class="col-md-8">
                        <p><strong>{{trans('deposit/usd.Address')}} : </strong>{{ $transaction->address }}</p>
                        <p><strong>{{trans('deposit/usd.TxnID')}} : </strong>{{ $transaction->txn_id }}</p>
                        <p><strong>{{trans('deposit/usd.Amount')}} : </strong>{{ $transaction->amount }}</p>
                        <p><strong>{{trans('deposit/usd.Currency')}} : </strong>{{ $transaction->currency2 }}</p>
                        <a class="btn btn-primary" href="{{ $transaction->status_url }}" target="_blank"> {{trans('deposit/usd.Check_Status')}} </a>
                    </div>
                    <div class="col-md-4">
                        <p class="text-center"><storng>  {{trans('deposit/usd.Deposit_amount_address')}} </storng></p>
                        <img src="{{ $transaction->qrcode_url }}" alt="{{ $transaction->address }}">
                    </div>
                @else
               <form class="form-horizontal onSubmitdisableButton" name="payment" action="{{ route('user.deposit.currency.make', 'usd') }}" method="post">
                        {{ csrf_field() }}
                        @include('flash::message')
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label>USD {{trans('deposit/usd.Amount')}}:</label>
                                    <input type="text" class="form-control" name="amount">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label>{{trans('deposit/usd.Payment_method')}}</label>
                                    <select name="payable_currency" class="form-control">
										<option value="TRX">Tron (TRX)</option>
										<option value="BTC">Bitcoin (BTC)</option>
                                        <option value="ETH">Ethereum (ETH)</option>
                                        {{--<option value="USDT.ERC20">Tether USD (ERC20)</option>
                                        <option value="USDT.BEP20">Tether USD (BSC Chain)</option>
                                        <option value="USDT.BEP2">Tether USD (BC Chain)</option>
                                        
                                        
                                        
                                        
                                        <option value="BUSD">Binance USD (ERC20)</option>
                                        <option value="BUSD.BEP2">BUSD Token (BC Chain)</option>
                                        <option value="BUSD.BEP20">BUSD Token (BSC Chain)</option>
                                        
                                        
                                        <option value="USDC">USD//C</option>
                                        <option value="USDC.BEP20">USD Coin (BSC Chain)</option>
                                        <option value="TUSD">TrueUSD</option>
                                        
                                        
                                        <option value="BTC">Bitcoin (BTC)</option>
                                        <option value="ETH">Ethereum (ETH)</option>
                                        <option value="BCH">Bitcoin Cash (BCH)</option>
                                        <option value="BNB">BinanceCoin (BNB)</option>
                                        <option value="LTC">{{trans('deposit/usd.Litecoin')}} (LTC)</option>
                                        <option value="XMR">{{trans('deposit/usd.Monereo')}} (XMR)</option>
                                        <option value="DASH">{{trans('deposit/usd.Dash')}} (DASH)</option>
                                        <option value="ADA">Cardano (ADA) </option>--}}
                              
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button class="btn btn-info btn-block submitButton" type="submit">{{trans('deposit/usd.Proceed')}}</button>
                                </div>
                            </div>
                        </div>


                       
                    </form> 
                @endif

            </div>
            {{--
            <div class="box box-inbox">
            <div class="panel">
            <div class="panel-heading">
               @php $sueecsspaypal = session('sueecss-paypal')?session('sueecss-paypal'):null @endphp
                @if($sueecsspaypal)
                <div class="alert alert-success alert-dismissible">
                {{ $sueecsspaypal }}
                </div>
                @endif
               <h3>{{trans('deposit/usd.Deposit_Paypal')}}</h3>
            </div><hr>
            <div class="panel-body text-center">
				<div class="alert alert-danger alert-dismissible hide" id="paypalClose">
					{{trans('deposit/usd.Cancel_payment_by_user')}}
			    </div>
				<div class="alert alert-danger alert-dismissible hide" id="paypalError">
					{{trans('deposit/usd.Paypal_payment_error')}}
			    </div>
				
				<div class="row">					
				<div class="col-md-12">					
					<label for="amount" class="col-md-2 control-label">USD {{trans('deposit/usd.Amount')}}:</label>
					<div class="col-md-4">
						<input type="number" class="form-control" id="usd_amount_paypal" min="1" value="100" max="10000">
					</div>
					<div class="col-md-6">
						<div id="paypal-button"></div>
					</div>
				</div>
				</div>
				
            </div>
        </div>
<hr>
         </div>
       --}}   
        @if (count($errors) > 0)
                    <div class = "alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
          <div class="box box-inbox">
				 <div class="panel" style="margin-top:20px;">
            <div class="panel-heading">
               @php $sueecsspaypal = session('sueecss-wire')?session('sueecss-wire'):null @endphp
                @if($sueecsspaypal)
                <div class="alert alert-success alert-dismissible">
                {{ $sueecsspaypal }}
                </div>
                @endif
               <h3>USDT Deposit</h3>
               
            </div>
             <hr>
            <div class="panel-body">
            
				<div class="form-group">	 			
					{{--<h4>{{trans('deposit/usd.Step_1')}}</h4>
                   
                    <p>{!! nl2br(e($wire_transfer)) !!}</p>
                    <hr />
                    <h4> {{trans('deposit/usd.Step_2')}}</h4>--}}
                    <p>{{ trans('deposit/usd.confirm_deposit_reference') }}</p>
                    @php $bankdeposit = \App\BankDeposit::where('status','pending')->where('uid',Auth::user()->id); @endphp
                    
                    @if(!$bankdeposit->exists())
                    <br>
                    <form class="form-horizontal onSubmitdisableButton" name="depositConfirm" action="{{ route('user.deposit.confirm.ref') }}" method="post">
                        {{ csrf_field() }}

                        @include('flash::message')
                        <div class="row">
							<div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>Select Deposit Coin</label>
                                    <select class="form-control deposit_coin" name="deposit_coin">
                                    @php $getcoins=App\DepositCoinDetail::where('status',1)->get(); @endphp
                                    <option value="">Select</option>
                                    @foreach($getcoins as $coindet)
										<option data-address="{{$coindet->address }}" value="{{$coindet->coin }}">{{$coindet->coin }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>Wallet Address</label>
                                    <input type="text" class="form-control wallet_address" id="left-code" value="">
                                    <a title="{{ __('Copy Address') }}" href="javascript:;" class="mt-clipboard copy-address" style="display:none;" data-clipboard-action="copy" data-clipboard-target="#left-code">
													<img style="width: 30px; margin-left: 30px; margin-right: 10px;" src="{{ asset('images/link-copy.png') }}" alt="" />{{ __('Copy Address') }} </a> 
												</a>
                                   
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <div class="form-group">
                                    <label>USD {{trans('deposit/usd.Amount')}}</label>
                                    <input type="text" class="form-control" name="amount">
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>{{trans('deposit/usd.reference_no')}}</label>
                                    <input type="text" class="form-control" name="ref_no">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <input type="text" class="form-control" name="user_remarks">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button class="btn btn-info btn-block submitButton" type="submit">{{trans('deposit/usd.confirm')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="alert alert-success alert-dismissible">
                    {{ trans('deposit/usd.waiting_review')}}
                    </div>
                    @endif
				</div>
            </div>
        </div>
          
            </div>
           
		</div>
	</section>
</main> 



@endsection

@push('css')
<link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{asset('jstree/css/style.min.css')}}?v={{time()}}" />

@endpush
@push('js')
<script type="text/javascript"  src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/ui-toastr.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/global/plugins/clipboardjs/clipboard.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/components-clipboard.js') }}" ></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
	$('.mt-clipboard').click(function () {
            Command: toastr["success"]("The address is copied to your clipboard.", "Copied");

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        });
        
	$(document).on('submit', '.onSubmitdisableButton', function(e) {	
		  if (confirm("Are You Sure ?") == true) {
			$('.submitButton').attr('disabled',true);
			return true;
		  } else {
			return false;
		  }
	});

	paypal.Button.render({

        env: '{{ env("PAYPAL_MODE") }}', // Or 'sandbox' || 'production'

        client: {
            sandbox:    '{{ env("PAYPAL_CLIENT_SENDBOX") }}',
            production: '{{ env("PAYPAL_CLIENT_PRODUCTION") }}'
        },
		
		style: { size: 'small',
        color: 'gold',
        shape: 'pill',
        label: '' },
		
        commit: true, // Show a 'Pay Now' button
        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: document.getElementById('usd_amount_paypal').value, currency: 'USD' }
                        }
                    ]
                }
            });
        },

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function(payment) {
				console.log(payment);
                if(payment.state=='approved'){

                    var paypal_form=document.createElement('FORM');
                    paypal_form.name='paypalSubmit';
                    paypal_form.method='POST';
                    paypal_form.action='{{ route("paypal.return") }}';

                    var paypal_amount=document.createElement('INPUT');
                    paypal_amount.type='hidden';
                    paypal_amount.name='amount';
                    paypal_amount.value=document.getElementById('usd_amount_paypal').value;

                    var paypal_txn=document.createElement('INPUT');
                    paypal_txn.type='hidden';
                    paypal_txn.name='txn';
                    paypal_txn.value=payment.id;

                    var paypal_user_id=document.createElement('INPUT');
                    paypal_user_id.type='hidden';
                    paypal_user_id.name='user_id';
                    paypal_user_id.value='{{ Auth::user()->id }}';

                    paypal_form.appendChild(paypal_amount);
                    paypal_form.appendChild(paypal_txn);
                    paypal_form.appendChild(paypal_user_id);
                    document.body.appendChild(paypal_form);
                    paypal_form.submit();


                }else{

                    $("#paypalError").attr('style','display:block !important');
                }
                // The payment is complete!
                // You can now show a confirmation message to the customer
            });
        },
		
		onCancel: function(data, actions) {
			$("#paypalClose").attr('style','display:block !important');
            //console.log(payment);
		},
		onError: function(err) {
			$("#paypalError").attr('style','display:block !important');
            console.log(err);
		}

    }, '#paypal-button');
    
    $(".deposit_coin").change(function(){
		$('.copy-address').attr('style','display:none;');
	  var deposit_coin=$(".deposit_coin option:selected").val();
	  var deposit_address=$(".deposit_coin option:selected").attr('data-address');
	  $(".wallet_address").val(deposit_address);
	  if(deposit_address){
		  $('.copy-address').attr('style','display:block;');
		}
	  
	});
</script>
@endpush

