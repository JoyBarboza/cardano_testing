@extends('layouts.nft')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('nft.setting')}}</span>
        </li>
    </ul>
</div>

<style>
    .mint_form #left-code {
        width: 300px;
        font-size: 16px;
    }
    .mint_form {
        display: inline-block;
        width: 100%;
        padding: 25px;
        background: #fff;
        box-shadow: 0 0 10px 0 rgb(0 0 0 / 50%);
    }
    .mint_form .col-md-12 {
        display: flex;
        align-items: center;
        margin: 5px auto;
    }
    .mint_form input, .mint_form textarea {
        width: calc(100% - 350px);
        /*margin-left: auto;
        border: 1px solid #ddd;*/
    }
    
    .mint_form input {
        height: 38px;
    }
    .mint_form textarea {
        height: 100px;
    }
    .mint_submit {
        margin: 15px auto;
        display: block;
        width: 250px !important;
        font-size: 17px !important;
    }
</style>
<!-- END PAGE TITLE-->
@endsection

@section('contents')
    <div class="row">

        <div class="col-md-12 col-sm-12">
            <h3>{{trans('nft.create_wallet')}}</h3><hr>

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
                
            <!-- <form method="POST" action="{{ route('nft.change_setting') }}" enctype="multipart/form-data" data-parsley-validate> -->
                <!-- {{ csrf_field() }} -->
                <input type="hidden" name="daedalus_wallet" id="daedalusWallet" value="{{ auth()->user()->daedalus_wallet }}">
                <div class="card-widget white">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card-widget white mint_form">
                                 <div class="col-md-12">
                                    <!-- <button type="submit" onClick="startWallet()" class="btn mint_submit btn-block btn-primary">{{trans('nft.create_wallet')}}</button> -->

                                    <a href="{{ route('csm_wallet') }}" target="_blank" class="btn mint_submit btn-block btn-primary">Your Wallet</a>
                                </div>


                                 <!-- <div class="col-md-12  daedalus_wallet">
                                    <center class="mint_submit">
                                        <p>Generate your existing wallet address below:</p>
                                    </center>
                                </div> -->

                                
                                <!-- <a href="{{ route('csm_wallet') }}" target="_blank">Your Wallet</a> -->


                               <!--  <form method="POST" action="{{ route('presale.account') }}" enctype="multipart/form-data" data-parsley-validate>
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">

                                    <div class="card-widget white">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="card-widget white mint_form">

                                                     <div class="col-md-12  daedalus_wallet">
                                                        <center class="mint_submit">
                                                            <p>Generate your existing wallet address below:</p>
                                                        </center>
                                                    </div>

                                                    <div class="col-md-12 daedalus_wallet">
                                                       <textarea type='text' name="daedalus_wallet" id="daedalus_wallet" required data-parsley-required data-parsley-required-message="Enter account">{{ auth()->user()->daedalus_wallet }} </textarea>
                                                    </div>
                                                </div>                                                
                                            </div>
                                            <button class="btn btn-info submitButton">Submit</button>
                                        </div>
                                    </div>
                                </form> -->
                            </div>

                        </div>
                    </div>
                </div>
        </div>
                
    </div>
@endsection
@push('css')
<link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

<style>
.create_wallet_modal .modal-header {
    padding: 10px 25px;
    background: #121212;
    color: #fff;
    display: flex;
    align-items: center;
}
.create_wallet_modal .modal-title {
    font-size: 22px;
}
.create_wallet_modal .close {
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    font-size: 29px;
    opacity: 1;
    color: #fff;
    line-height: 25px;
    padding: 15px;
}
.create_wallet_modal .modal-body {
    padding: 25px;
}
.label_name {
    font-size: 20px;
    font-weight: 500;
    color: #121212;
}
.create_wallet_modal .modal-footer {
    border: 0;
    padding: 0 25px 25px;
}

.create_wallet_modal .cancle_btn {
    margin: 15px auto;
    padding: 8px 35px;
    background: #2fc3ee;
    color: #fff;
    border-radius: 0px;
    font-size: 17px;
}
.create_wallet_modal .modal-dialog {
    margin-top: 85px;
}

</style>


 <div id="checkModal" class="modal create_wallet_modal fade" tabindex="-1">
        <form method="POST" action="{{ route('presale.account') }}" enctype="multipart/form-data" data-parsley-validate>
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wallet</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- <input type="hidden" name="id" value="{{auth()->user()->id}}"> -->
                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                    <div class="modal-body">
                       <label class="label_name">Account</label>
                       <!-- <input type='text' name="daedalus_wallet" id="daedalus_wallet" required data-parsley-required data-parsley-required-message="Enter account"/> -->
                       <textarea type='text' name="daedalus_wallet" id="daedalus_wallet" required data-parsley-required data-parsley-required-message="Enter account">
                           {{ auth()->user()->daedalus_wallet }}
                       </textarea>
                        <p class="m-4"> <b>Note :</b> You need CSM wallet to deposite ADA and buy CSM </p>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="submit" class="btn mint_submit btn-block btn-primary">{{trans('nft.submit')}}</button> -->

                        <button class="btn btn-info submitButton">Submit</button>

                        <button type="button" class="btn btn-secondary cancle_btn" data-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </div>
        </form>
    </div>
@push('js')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.pie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.stack.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.crosshair.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.axislabels.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.time.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="{{ asset('assets/pages/scripts/charts-flotcharts.js') }}?v={{time()}}" type="text/javascript"></script> 
    <!-- END PAGE LEVEL SCRIPTS -->
    
<script type="text/javascript"  src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/ui-toastr.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/global/plugins/clipboardjs/clipboard.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/components-clipboard.js') }}" ></script>
<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js"></script>
<script type="text/javascript">
                
</script>
@endpush
@push('js')
<script type="text/javascript"  src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" ></script>
<script>
    function startWallet() {
        var daedalus_wallet = $('#daedalusWallet').val();

        if (daedalus_wallet != '') {
           $('.daedalus_wallet').show();
        } else {
           // window.location.href = "https://testnets.cardano.org/en/testnets/cardano/get-started/wallet/";

           var url = 'https://testnets.cardano.org/en/testnets/cardano/get-started/wallet/';
            window.open(url, '_blank');
        }
    }

</script>


<script type="text/javascript">

    const { ethereum } = window;

    function checkMetamask(){

        if (ethereum && ethereum.isMetaMask) {
            console.log('Ethereum successfully detected!');
        // Access the decentralized web!
             // myFunction();
       

        } else {

            // console.log('Please install MetaMask!');
            alert('You need metamask extenstion to deposite ADA and buy CZM.');

            var url = 'https://testnets.cardano.org/en/testnets/cardano/get-started/wallet/';
            window.open(url, '_blank');
        }
    }

    // // var web3js;
    // if(typeof web3 == 'undefined'){
    // //     web3js = new Web3(web3.currentProvider);
    // //     console.log("found web3?")

    // //     const ethereumButton = document.querySelector('.enableEthereumButton');

    // //     ethereumButton.addEventListener('click', () => {
    // //       //Will Start the metamask extension
    // //       ethereum.request({ method: 'eth_requestAccounts' });
    // //     });
    // // }else{
    //     console.log("No Web3!");
    //     web3js = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"))
    // }


    const ethereumButton = document.querySelector('.enableEthereumButton');
    const showAccount = document.querySelector('.showAccount');

    // ethereumButton.addEventListener('click', () => {
    //   //Will Start the metamask extension
    //   ethereum.request({ method: 'eth_requestAccounts' });
    // });


    ethereumButton.addEventListener('click', () => {
      getAccount();

    });

    async function getAccount() {
        // alert(1);
      // const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
      // const account = accounts[0];
      // showAccount.innerHTML = account;

      // if(account){
      //   $("#checkModal").modal('show');
      // }else{
      //   $("#checkModal").modal('hide');
      // }

      $("#checkModal").modal('show');
    }



</script>

@endpush