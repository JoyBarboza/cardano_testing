@extends('layouts.master')
@section('page-content')
<main>
  <section>
    <div class="rows">
        
            <h1 class="main_heading">{{trans('presale/buy.buy_now')}}</h1>
            <div class="" style="color: #000">
             <label>Note : 1 CSM = {{$bnb_csm->bnb}} BNB</label>
                <!--
                  <div class="progress-bar" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                  <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                  <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                -->
                <!-- @foreach ($presales as $pre_sale)
                    <?php
                    //~ $sold_coin = $pre_sale->total_coin_unit - $pre_sale->remaining_volume;
                    $sold_coin = $pre_sale->sold_coin;
                    //$sold_percent = round(($sold_coin/$pre_sale->total_coin_unit)*100);
                    $width_percent = round(100/sizeof($presales));
                    if($pre_sale->end_date < date('Y-m-d')){
                        $progress_class = "progress-bar-warning";
                    }else if($pre_sale->start_date<=date('Y-m-d') && $pre_sale->end_date>=date('Y-m-d')){
                        $progress_class = "progress-bar-success";
                    }else{
                        $progress_class = "";
                    }
                    ?>
                    <div
                            class="{{$progress_class}} progress-bar progress-bar-striped"
                            role="progressbar"
                            style="width: {{$width_percent}}%"
                            aria-valuenow="{{$width_percent}}"
                            aria-valuemin="0"
                            aria-valuemax="100">{{ $pre_sale->remaining_volume }}/{{ $pre_sale->total_coin_unit }}</div>
                @endforeach -->
            </div>
            <div class="box box-inbox">@include('flash::message')
            <!-- <form class="form-horizontal onSubmitdisableButton" action="{{ route('presale.buy.post') }}" method="post"> -->
            <!-- <form class="form-horizontal onSubmitdisableButton" action="{{ route('presale.buyCSM.post') }}" method="post"> -->
                <!-- {{ csrf_field() }} -->
                <div class="row">
                  <input type="hidden" name="bnb_price" value="{{$bnb_csm->bnb}}" id="bnb_price" class="bnb_price">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <!-- <label>{{trans('presale/buy.pay_currency')}} (USD):</label> -->
                            <!--<label> Buy Currency (ETH):</label>-->
                            <label style="color: black"> CSM Token:</label>

                            <!-- <input type="text" class="form-control" name="amount" id="inp_amount" aria-describedby="helpId" placeholder="Enter Amount In ETH"> -->

                            <input id="inp_amount" type="text" class="form-control"
                               value="{{ request()->usd_amount }}"
                               name="eth_amount" autocomplete="off"
                               placeholder="CSM Token" type="text"
                               onpaste="return false" oncut="return false"
                               data-original-title="Enter Token Aomunt you want to purchase"
                               onkeypress="return isNumberKey(event)" required onblur="getBNBAmt(this.value)" >
                            @if($errors->has('usd_amount'))
                                <span class="help-text text-danger">{{ $errors->first('usd_amount') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label style="color: black"> BNB:</label>
                            <input type="text" class="form-control"
                               value="{{ request()->eth }}"
                               name="czm_amount" autocomplete="off"
                               placeholder="BNB Amount" type="text"
                               onpaste="return false" oncut="return false"
                               data-original-title="Enter Token Aomunt you want to purchase"
                               onkeypress="return isNumberKey(event)" readonly="" id="csm_amount">
                        @if($errors->has('eth'))
                            <span class="help-text">{{ $errors->first('eth') }}</span>
                        @endif
                        </div>
                    </div>
                </div>


                 <input type="hidden" name="received_res" value="" id="received_res">
          <input type="hidden" name="transaction_id" value="" id="transaction_id">

                <div class="form-group">
                    <div class="col-md-12">
                        <div class="text-center">
                            <!-- <button class="btn btn-info submitButton">{{trans('presale/buy.Buy')}}</button> -->
                            <!-- <button class="btn btn-info submitButton">BUY CSM</button> -->
                             <!-- <button type="button" onClick="startProcess()" class="btn btn-info btn-block submitButton">{{trans('deposit/usd.Proceed')}}</button>  -->
   Status: <span id="status">Loading...</span>
                             <!-- <button class="btn btn-info btn-block submitButton" onclick="printCoolNumber();">Print Cool Number</button> -->
                              <button class="btn btn-info btn-block" onclick="changetransferToken();">Buy</button>
                        </div>
                    </div>
                </div>
            <!-- </form> -->
            </div>
  </section>
</main> 



@endsection
@push('js')
 <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.34/dist/web3.min.js"></script>
 <script>
  function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function getBNBAmt(amt)
    {
      console.log(amt);

      var csm_amount = amt;
      console.log(csm_amount);


      if (csm_amount < 0 || csm_amount == '') {
            alert('Please Enter Valid Amount');
            return;
      }

      var bnb_price = $('.bnb_price').val();

      var bnb_amount = bnb_price * csm_amount;
      // $('#csm_amount').val('120');
      // $('#csm_amount').val(bnb_amount);
         
      console.log(bnb_amount);
      // const weiValue = Web3.utils.toBN(bnb_amount, 'ether');
      // const weiValue = Web3.utils.toBN(bnb_amount);

      // var tokens = web3.utils.toWei(bnb_amount.toString(), 'ether')

      // var weiValue = web3.utils.toBN(tokens)


      // console.log("The weiValue is: ",weiValue);

      $('#csm_amount').val(bnb_amount);

    }

    </script>

 

    <script type="text/javascript">


        async function loadWeb3() {

            if (window.ethereum) {
                window.web3 = new Web3(window.ethereum);
                window.ethereum.enable();
            }else {
                $("#checkMetamask").modal('show');
            }
        }

        async function loadContract() {
            // let web3js;

          // return await new window.web3.eth.Contract([ { "inputs": [ { "internalType": "contract CSMToken", "name": "_address", "type": "address" } ], "stateMutability": "payable", "type": "constructor" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "tokenOwner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "spender", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "tokens", "type": "uint256" } ], "name": "Approval", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "amount", "type": "uint256" } ], "name": "Bought", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "previousOwner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "newOwner", "type": "address" } ], "name": "OwnershipTransferred", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "amount", "type": "uint256" } ], "name": "Sold", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "from", "type": "address" }, { "indexed": true, "internalType": "address", "name": "to", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "tokens", "type": "uint256" } ], "name": "Transfer", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "address", "name": "_from", "type": "address" }, { "indexed": false, "internalType": "address", "name": "_destAddr", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "_amount", "type": "uint256" } ], "name": "TransferSent", "type": "event" }, { "inputs": [], "name": "APY", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "CSM", "outputs": [ { "internalType": "contract CSMToken", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "_decimalFactor", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "delegate", "type": "address" } ], "name": "allowance", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "delegate", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "approve", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "tokenOwner", "type": "address" } ], "name": "balanceOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "calculateReward", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_numberOfTokens", "type": "uint256" } ], "name": "createStake", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [], "name": "decimalFactor", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "decimals", "outputs": [ { "internalType": "uint8", "name": "", "type": "uint8" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "distributeRewards", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_address", "type": "address" } ], "name": "isStakeholder", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "name", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "owner", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_numberOfTokens", "type": "uint256" } ], "name": "removeStake", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "rewardOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "stakeOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "", "type": "address" } ], "name": "stakes", "outputs": [ { "internalType": "uint256", "name": "amount", "type": "uint256" }, { "internalType": "uint256", "name": "stakeTime", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "symbol", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "tokenPrice", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalSupply", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalTokenStaked", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "receiver", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transfer", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "buyer", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transferFrom", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "newOwner", "type": "address" } ], "name": "transferOwnership", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "uint256", "name": "amount", "type": "uint256" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transferToken", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "viewReward", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "withdrawReward", "outputs": [], "stateMutability": "nonpayable", "type": "function" } ],'0x009e685D8d02b525815294dd3853300dBD8ADeE9');

          return await new window.web3.eth.Contract([ { "inputs": [ { "internalType": "contract CSMToken", "name": "_address", "type": "address" } ], "stateMutability": "payable", "type": "constructor" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "tokenOwner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "spender", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "tokens", "type": "uint256" } ], "name": "Approval", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "delegate", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "approve", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "amount", "type": "uint256" } ], "name": "Bought", "type": "event" }, { "inputs": [ { "internalType": "uint256", "name": "_numberOfTokens", "type": "uint256" } ], "name": "createStake", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [], "name": "distributeRewards", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "previousOwner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "newOwner", "type": "address" } ], "name": "OwnershipTransferred", "type": "event" }, { "inputs": [ { "internalType": "uint256", "name": "_numberOfTokens", "type": "uint256" } ], "name": "removeStake", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "payable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "amount", "type": "uint256" } ], "name": "Sold", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "receiver", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transfer", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "from", "type": "address" }, { "indexed": true, "internalType": "address", "name": "to", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "tokens", "type": "uint256" } ], "name": "Transfer", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "buyer", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transferFrom", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "newOwner", "type": "address" } ], "name": "transferOwnership", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "address", "name": "_from", "type": "address" }, { "indexed": false, "internalType": "address", "name": "_destAddr", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "_amount", "type": "uint256" } ], "name": "TransferSent", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "uint256", "name": "amount", "type": "uint256" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transferToken", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [], "name": "withdrawReward", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [], "name": "_decimalFactor", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "delegate", "type": "address" } ], "name": "allowance", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "APY", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "tokenOwner", "type": "address" } ], "name": "balanceOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "calculateReward", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "CSM", "outputs": [ { "internalType": "contract CSMToken", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "decimalFactor", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "decimals", "outputs": [ { "internalType": "uint8", "name": "", "type": "uint8" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_address", "type": "address" } ], "name": "isStakeholder", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "name", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "owner", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "rewardOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "stakeOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "", "type": "address" } ], "name": "stakes", "outputs": [ { "internalType": "uint256", "name": "amount", "type": "uint256" }, { "internalType": "uint256", "name": "stakeTime", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "symbol", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "tokenPrice", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalSupply", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalTokenStaked", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "viewReward", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" } ],'0xb7a44c40d96b1d37166fc8b717bedbe2de4e155b');

        }

        
        async function getCurrentAccount() {
            const accounts = await window.web3.eth.getAccounts();
            return accounts[0];r
        }


        async function changetransferToken() 
        {

         

          updateStatus('transferToken');

          var csm_amount = $('#inp_amount').val();
          console.log('CSM token',csm_amount);


          if (csm_amount < 0 || csm_amount == '') {
                // alert('Please Enter Valid Amount');
                toastr.error('Please Enter Valid Amount'); 
                return;
          }

          if (ethereum && ethereum.isMetaMask) {
              console.log('Ethereum successfully detected!');
          } else {
              $("#checkMetamask").modal('show');
          }

          var bnb_price = $('.bnb_price').val();

          var bnb_amount = bnb_price * csm_amount;
             
          console.log(bnb_amount);
          console.log(bnb_amount.toString());

          // var tokens = web3.utils.toWei(bnb_amount.toString(), 'ether')

          // var weiValue = web3.utils.toBN(tokens)


          var amount = bnb_amount.toFixed(5);
          var tokens = web3.utils.toWei(amount.toString(), 'ether')
          var bntokens = web3.utils.toBN(tokens)


          console.log('tokens',tokens);
          console.log('weiValue',bntokens);


          $('#csm_amount').val(bnb_amount);

            const account = await getCurrentAccount();
            // // console.log(loadContract);
            // console.log(account);
            // const owner = "0x79319A973Be6C6F0cbad2206ea4F6573A9ecF223";
            // const amount = "10";
            // const numTokens = "5";

            // const transferToken = await window.contract.methods.transferToken(owner,amount,numTokens).call({from: account,gas: 3000000});

            // console.log(transferToken);
            
            const senderAddress = "0x79319A973Be6C6F0cbad2206ea4F6573A9ecF223";
            const receiverAddress = account;


            console.log(senderAddress);
            console.log(receiverAddress);

          //   await window.contract.methods.balanceOf(receiverAddress).call(function (err, res) {
          //   if (err) {
          //     console.log("An error occured", err)
          //     return
          //   }
          //   console.log("The balance is: ", res)
          // });

// eth.sendTransaction({from:eth.accounts[0], to:'0x[ADDRESS_HERE]', value: web3.toWei(5, "ether"), gas:100000});
          

          await window.contract.methods
            // .transferToken("0x79319A973Be6C6F0cbad2206ea4F6573A9ecF223", weiValue,'120')
            .transferToken("0x79319A973Be6C6F0cbad2206ea4F6573A9ecF223", bntokens,csm_amount)
            .send({ from: receiverAddress, value: bntokens,gas: 4000000 }, function (err, res) {
              if (err) {
                console.log("An error occured", err)
                return
              }
              console.log('done');
              console.log("Hash of the transaction: " + res)

              $('#transaction_id').val(res);
          });



          await window.contract.methods.balanceOf(receiverAddress).call(function (err, received_res) {
            if (err) {
              console.log("An error occured", err)
              return
            }
            console.log("The balanceOf is: ", received_res)

            $('#received_res').val(received_res);
          });



          var get_total_csm  = $('#received_res').val();
          var get_transaction_id = $('#transaction_id').val();
          // var csm_amount = $('#csm_amount').val();
          var csm_amount = $('#inp_amount').val();

          console.log(get_total_csm);
          console.log(get_transaction_id);
          console.log(bnb_amount);
          console.log(csm_amount);
          
          $.ajax({
            url: "{{ route('presale.buyCSM.post') }}",
            type: "post",
            dataType: "json",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { 
              csm_wallet: get_total_csm,
              transaction_id: get_transaction_id,
              bnb_amount: bnb_amount,
              csm_amount: csm_amount,

            },
            success: function(response) 
            {
                console.log('done');
                console.log(response);

                if(response == 200){
                  toastr.success('You get CSM successfully');
                }else{
                  toastr.error('Something went wrong'); 
                }
                 location.reload()
            }
          });
        }


        async function load() {
            await loadWeb3();
            window.contract = await loadContract();
            updateStatus('Ready!');
        }

        function updateStatus(status) {
            const statusEl = document.getElementById('status');
            statusEl.innerHTML = status;
            console.log(status);
        }

        load();
    </script>
@endpush
