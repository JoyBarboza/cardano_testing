@extends('layouts.master')
@section('page-title') {{trans('deposit/usd.Deposit_Fiat_Currency')}} @endsection 
@section('page-content')

<main>
    <section>
        <div class="rows">
             
            <h1 class="main_heading">ADA Wallet ({{ round(auth()->user()->eth_wallet,8)}})</h1>
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
            
             @include('flash::message')
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                <h1 class="main_heading">{{trans('deposit/usd.Deposit_Crypto_Currency')}}</h1>
               
                @php $transaction = session('transaction')?session('transaction'):null @endphp
                @if($transaction)
                   <!--  <div class="col-md-8">
                        <p><strong>{{trans('deposit/usd.Address')}} : </strong>{{ $transaction->address }}</p>
                        <p><strong>{{trans('deposit/usd.TxnID')}} : </strong>{{ $transaction->txn_id }}</p>
                        <p><strong>{{trans('deposit/usd.Amount')}} : </strong>{{ $transaction->amount }}</p>
                        <p><strong>{{trans('deposit/usd.Currency')}} : </strong>{{ $transaction->currency2 }}</p>
                        <a class="btn btn-primary" href="{{ $transaction->status_url }}" target="_blank"> {{trans('deposit/usd.Check_Status')}} </a>
                    </div> -->
                    <div class="col-md-4">
                        <p class="text-center"><storng>  {{trans('deposit/usd.Deposit_amount_address')}} </storng></p>
                        <img src="{{ $transaction->qrcode_url }}" alt="{{ $transaction->address }}">
                    </div>
                @else
               

               <form class="form-horizontal onSubmitdisableButton" name="payment" action="{{ route('user.deposit.currency.make', 'usd') }}" method="post">
                        {{ csrf_field() }}
                        
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label>ADA {{trans('deposit/usd.Amount')}}:</label>
                                    <!-- <input type="text" class="form-control" name="amount"> -->
                                    <input type="text" class="form-control" name="amount" id="inp_amount" aria-describedby="helpId" placeholder="Enter Amount In ADA">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label>{{trans('deposit/usd.Payment_method')}}</label>
                                    <input type="text" class="form-control" name="payable_currency" value="ADA" readonly="">
                                    <!-- <select name="payable_currency" class="form-control">
                                        <option value="TRX">Tron (TRX)</option>
                                        <option value="BTC">Bitcoin (BTC)</option>
                                        <option value="ETH">Ethereum (ETH)</option>
                                    </select> -->
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <!-- <button class="btn btn-info btn-block submitButton" type="submit">{{trans('deposit/usd.Proceed')}}</button> -->
                                    <!--<button type="button" onClick="startProcess()" class="btn btn-info btn-block submitButton">{{trans('deposit/usd.Proceed')}}</button>-->
                                    <button type="button" onClick="startProcess()" class="btn btn-info btn-block submitButton">{{trans('deposit/usd.Proceed')}}</button>
                                </div>
                            </div>
                        </div>


                       
                    </form> 
                @endif

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
<!-- <script type="text/javascript"  src="{{ asset('assets/pages/scripts/ui-toastr.js') }}" ></script> -->
<!-- <script type="text/javascript"  src="{{ asset('assets/global/plugins/clipboardjs/clipboard.js') }}" ></script> -->
<!-- <script type="text/javascript"  src="{{ asset('assets/pages/scripts/components-clipboard.js') }}" ></script> -->
<!-- <script src="https://www.paypalobjects.com/api/checkout.js"></script> -->



<script>

    function startProcess(txHash, amount) {
      // console.log(txHash)

          // var a = ((amount * 1000000000000000000).toString(16));
          // console.log(a)

        if ($('#inp_amount').val() > 0) {

            var amount = $('#inp_amount').val();

            $.ajax({
                url: "{{ route('user.deposit_eth') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    // txHash: txHash,
                    amount: amount,
                },
                success: function (response) {
                    // reload page after success
                    window.location.reload();
                }
            });
        } else {
            alert('Please Enter Valid Amount');
        }


        
    }
        function startProcessOld() {
            if ($('#inp_amount').val() > 0) {
                // run metamsk functions here
                EThAppDeploy.loadEtherium();
            } else {
                alert('Please Enter Valid Amount');
            }
        }

        EThAppDeploy = {
            loadEtherium: async () => {
                if (typeof window.ethereum !== 'undefined') {
                    EThAppDeploy.web3Provider = ethereum;
                    EThAppDeploy.requestAccount(ethereum);
                } else {
                    alert(
                        "Not able to locate an Ethereum connection, please install a Metamask wallet"
                    );
                }
            },
            /****
             * Request A Account
             * **/
            requestAccount: async (ethereum) => {
                ethereum
                    .request({
                        method: 'eth_requestAccounts'
                    })
                    .then((resp) => {
                        //do payments with activated account
                        EThAppDeploy.payNow(ethereum, resp[0]);
                    })
                    .catch((err) => {
                        // Some unexpected error.
                        console.log(err);
                    });
            },
            /***
             *
             * Do Payment
             * */
            payNow: async (ethereum, from) => {
                var amount = $('#inp_amount').val();
                ethereum
                    .request({
                        method: 'eth_sendTransaction',
                        params: [{
                            from: from,
                            to: "0xa7D0e2d99C29074Bb4415Bc10b35bf8c3f9B8638",
                            value: '0x' + ((amount * 1000000000000000000).toString(16)),
                        }, ],
                    })
                    .then((txHash) => {
                        if (txHash) {
                            console.log(txHash);
                            storeTransaction(txHash, amount);
                        } else {
                            console.log("Something went wrong. Please try again");
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
        }
     function storeTransaction(txHash, amount) {
      // console.log(txHash)
      var a = ((amount * 1000000000000000000).toString(16));
      console.log(a)

        $.ajax({
                url: "{{ route('user.deposit_eth') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    txHash: txHash,
                    amount: amount,
                },
                success: function (response) {
                    // reload page after success
                    window.location.reload();
                }
        });
    }
</script>

@endpush