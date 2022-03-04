@extends('layouts.master')
@section('page-content')
<main>
	<section>
		<div class="rows">
        
            <h1 class="main_heading" style="margin-top: 20px">Staking</h1>

<input type="hidden" name="user_stake" value="{{auth()->user()->stake_amt}}" class="user_stake">
        </div>
        <div class="dashboard_content">
        @include('flash::message')
          <div class="dash_box_txt">
            <div class="harvestReward_box">
              <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                  <h4 class="dashbrd_heading">Staking</h4>
                  <div class="frmg_harvest_box">
                    <div class="frmg_harvest_head">
                      <ul class="list-inline">
                        <li class="list-inline-item">
                          <div class="frmg_brand_dtl">
                            <img src="{{ asset('assets/staking_assest/images/farming/Y47.svg') }}" class="img-fluid frm_logo">
                          </div>
                        </li>
                      </ul>
                    </div>
                    <input type="hidden" name="loginAddress" value="" class="loginAddress">
                    <!-- <form class="form-horizontal onSubmitdisableButton" action="{{ route('presale.stake_amt') }}" method="post"> -->
                    	{{ csrf_field() }}
                      <div class="frmg_harvest_body">
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>APY</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="apy">12%</span>
                          </li>
                        </ul>
                       <!--  <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Start Date</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="start_time">{{\Carbon\Carbon::now()->format('Y-m-d')}}</span>
                            <input type="hidden" name="stake_start_time" class="start_time" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
                          </li>
                        </ul> -->

                        <input type="hidden" name="stake_timestamp" class="stake_timestamp" value="1640001035">

                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Start</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="start_time">1 Jun, 2021 1:30 AM</span>
                            
                            <input type="hidden" name="start_time" value="" class="startTime">
                          </li>
                        </ul>
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Finish</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="finish_time">11 Jul, 2021 1:30 AM</span>
                            <input type="hidden" name="finish_time" value="" class="finishTime">
                            
                          </li>
                        </ul>
                        <!-- <ul class="list-inline end_time" style="display: none;">
                          <li class="list-inline-item">
                            <h5>End Date</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="stake_end_time"></span>
                            <input type="hidden" name="stake_end_time" class="stake_end_time" value="">
                          </li>
                        </ul> -->
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Your Stake</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="your_stake">0 CSM</span>
                            <input type="hidden" name="stakeAmount" value="" class="stakeAmount">
                          </li>
                        </ul>
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Your Reward</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="your_reward">0 BNB</span>
                            <input type="hidden" name="stakeReward" value="" class="stakeReward">
                          </li>
                        </ul>
                        <!-- <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Stake Month</h5>
                          </li>
                          <li class="list-inline-item">
                            <select name="stake_month" id="stake_month">
              							  <option value="">Select Days</option>
              							  <option value="30">30 Day</option>
              							  <option value="45">45 Day</option>
              							  <option value="60">60 Day</option>
              							</select>
                          </li>
                        </ul> -->

                        <!-- <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Your Reward</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="your_reward">CMS</span>
                          </li>
                        </ul> -->
                      </div>
                      <div class="frmg_harvest_footer">
                        <div class="farmin_deposit">
                          <input id="numberOfstakeTokens" class="form-control input-lg" type="number" name="number" value="1" min="1" pattern="[0-9]">
                          <input type="hidden" name="staketransaction_id" value="1555" id="staketransaction_id">
                          
                          <!-- <input id="numberOfstakeTokens" class="form-control input-lg" type="number" name="number" value="1" min="1" pattern="[0-9]" onblur="getStakeValue(this.value)"> -->
                          
                        </div>
                        <div class="farmin_pool">
                          <!-- <button type="submit" class="btn subscribe_btn" >Stake</button> -->
                          <!-- <button type="submit" class="btn subscribe_btn" onClick="startStaking()">Stake</button> -->

                           <button type="submit" class="btn subscribe_btn" onclick="startStaking();">Stake</button>

                        </div>
                      </div>
                  <!-- </form> -->
              </div>
                </div>
                <div class="col-lg-2 col-md-2"></div>
                 <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                  <h4 class="dashbrd_heading">Withdraw Staking</h4>
                  <div class="frmg_harvest_box">
                    <div class="frmg_harvest_head">
                      <ul class="list-inline">
                        <li class="list-inline-item">
                          <div class="frmg_brand_dtl">
                            <img src="{{ asset('assets/staking_assest/images/farming/Y47.svg') }} " class="img-fluid frm_logo">
                          </div>
                        </li>
                        <li class="list-inline-item ml-auto">
                        </li>
                      </ul>
                    </div>
                     <!-- <form class="form-horizontal onSubmitdisableButton" action="{{ route('presale.unstake_amt') }}" method="post"> -->
                      <!-- {{ csrf_field() }} -->
                      <div class="frmg_harvest_body">
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>APY</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="apy">12%</span>
                          </li>
                        </ul>


                         <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Start</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="start_time">1 Jun, 2021 1:30 AM</span>
                            
                            <input type="hidden" name="start_time" value="" class="startTime">
                          </li>
                        </ul>
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Finish</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="finish_time">11 Jul, 2021 1:30 AM</span>
                            <input type="hidden" name="finish_time" value="" class="finishTime">
                          </li>
                        </ul>

                        <!-- <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Date</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="start_time">{{\Carbon\Carbon::now()->format('Y-m-d')}}</span>
                            <input type="hidden" name="unstake_start_time" class="start_time" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
                          </li>
                        </ul> -->
                        <!-- <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Sake Amount</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="start_time">{{auth()->user()->stake_amt}} CSM</span>
                            <input type="hidden" name="stake_amt" class="stake_amt" value="{{auth()->user()->stake_amt}}">
                          </li>
                        </ul>
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Your UnStake</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="your_unstake">0 CSM</span>
                            <input type="hidden" name="unstake_amt" class="your_unstake" value="">
                          </li>
                        </ul> -->

                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Your Stake</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="your_stake">0 CSM</span>
                               <input type="hidden" name="stakeAmount" value="" class="stakeAmount">
                          </li>
                        </ul>
                        <ul class="list-inline">
                          <li class="list-inline-item">
                            <h5>Your Reward</h5>
                          </li>
                          <li class="list-inline-item">
                            <span class="your_reward">BNB</span>
                            <input type="hidden" name="stakeReward" value="" class="stakeReward">
                          </li>
                        </ul>
                      </div>
                      <div class="farmin_deposit">
                        <input id="numberOfunstakeTokens" class="form-control input-lg" type="number" name="number" value="1" min="1" pattern="[0-9]" onblur="getUnStakeValue(this.value)">
                        <input type="hidden" name="unstaketransaction_id" value="ddertrgfd43" id="unstaketransaction_id">
                      </div>
                      <div class="farmin_pool">
                        <!-- <button type="submit" class="btn subscribe_btn">Unstake</button> -->
                        <button type="submit" class="btn subscribe_btn" onclick="startUnStaking()">Unstake</button>
                      <!-- </div> -->
                  </form>
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
 <!-- <script src=" https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
  <script src="{{ asset('assets/staking_assest/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/staking_assest/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/staking_assest/js/web3.min.js') }}"></script>
  <script src="{{ asset('assets/staking_assest/js/truffle-contract.min.js') }}"></script>
  <script src="{{ asset('assets/staking_assest/js/app.js') }}"></script>
  <!-- <script src="assets/js/jquery-3.2.1.slim.min.js"></script> -->

  <!-- <script src="assets/js/bootstrap.min.js"></script> -->
  <!-- animation js here -->
  <!-- <script src="js/aos.js"></script> -->
  <!-- custom js here -->
  <script src="{{ asset('assets/staking_assest/css/aos.css') }} "></script>

  <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.34/dist/web3.min.js"></script>
  <script type="text/javascript">

        async function loadWeb3() {
          // console.log('gfdg',window.ethereum);
            if (window.ethereum) {
                window.web3 = new Web3(window.ethereum);
                window.ethereum.enable();   

                const accounts = await window.web3.eth.getAccounts();
                $('.loginAddress').val(accounts[0]);             
            }else {
                $("#checkMetamask").modal('show');
            }
            
        }

      async function loadContract() {

          // return await new window.web3.eth.Contract([ { "inputs": [ { "internalType": "contract CSMToken", "name": "_address", "type": "address" } ], "stateMutability": "payable", "type": "constructor" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "tokenOwner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "spender", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "tokens", "type": "uint256" } ], "name": "Approval", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "amount", "type": "uint256" } ], "name": "Bought", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "previousOwner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "newOwner", "type": "address" } ], "name": "OwnershipTransferred", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "amount", "type": "uint256" } ], "name": "Sold", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "from", "type": "address" }, { "indexed": true, "internalType": "address", "name": "to", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "tokens", "type": "uint256" } ], "name": "Transfer", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "address", "name": "_from", "type": "address" }, { "indexed": false, "internalType": "address", "name": "_destAddr", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "_amount", "type": "uint256" } ], "name": "TransferSent", "type": "event" }, { "inputs": [], "name": "APY", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "CSM", "outputs": [ { "internalType": "contract CSMToken", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "_decimalFactor", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "delegate", "type": "address" } ], "name": "allowance", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "delegate", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "approve", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "tokenOwner", "type": "address" } ], "name": "balanceOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "calculateReward", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_numberOfTokens", "type": "uint256" } ], "name": "createStake", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [], "name": "decimalFactor", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "decimals", "outputs": [ { "internalType": "uint8", "name": "", "type": "uint8" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "distributeRewards", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_address", "type": "address" } ], "name": "isStakeholder", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "name", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "owner", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_numberOfTokens", "type": "uint256" } ], "name": "removeStake", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "rewardOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "stakeOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "", "type": "address" } ], "name": "stakes", "outputs": [ { "internalType": "uint256", "name": "amount", "type": "uint256" }, { "internalType": "uint256", "name": "stakeTime", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "symbol", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "tokenPrice", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalSupply", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalTokenStaked", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "receiver", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transfer", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "buyer", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transferFrom", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "newOwner", "type": "address" } ], "name": "transferOwnership", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "uint256", "name": "amount", "type": "uint256" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transferToken", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "viewReward", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "withdrawReward", "outputs": [], "stateMutability": "nonpayable", "type": "function" } ],'0x009e685D8d02b525815294dd3853300dBD8ADeE9');

          return await new window.web3.eth.Contract([ { "inputs": [ { "internalType": "contract CSMToken", "name": "_address", "type": "address" } ], "stateMutability": "payable", "type": "constructor" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "tokenOwner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "spender", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "tokens", "type": "uint256" } ], "name": "Approval", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "delegate", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "approve", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "amount", "type": "uint256" } ], "name": "Bought", "type": "event" }, { "inputs": [ { "internalType": "uint256", "name": "_numberOfTokens", "type": "uint256" } ], "name": "createStake", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [], "name": "distributeRewards", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "previousOwner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "newOwner", "type": "address" } ], "name": "OwnershipTransferred", "type": "event" }, { "inputs": [ { "internalType": "uint256", "name": "_numberOfTokens", "type": "uint256" } ], "name": "removeStake", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "payable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "amount", "type": "uint256" } ], "name": "Sold", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "receiver", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transfer", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "from", "type": "address" }, { "indexed": true, "internalType": "address", "name": "to", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "tokens", "type": "uint256" } ], "name": "Transfer", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "buyer", "type": "address" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transferFrom", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "newOwner", "type": "address" } ], "name": "transferOwnership", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "address", "name": "_from", "type": "address" }, { "indexed": false, "internalType": "address", "name": "_destAddr", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "_amount", "type": "uint256" } ], "name": "TransferSent", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "uint256", "name": "amount", "type": "uint256" }, { "internalType": "uint256", "name": "numTokens", "type": "uint256" } ], "name": "transferToken", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [], "name": "withdrawReward", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [], "name": "_decimalFactor", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "delegate", "type": "address" } ], "name": "allowance", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "APY", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "tokenOwner", "type": "address" } ], "name": "balanceOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "calculateReward", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "CSM", "outputs": [ { "internalType": "contract CSMToken", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "decimalFactor", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "decimals", "outputs": [ { "internalType": "uint8", "name": "", "type": "uint8" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_address", "type": "address" } ], "name": "isStakeholder", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "name", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "owner", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "rewardOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "stakeOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "", "type": "address" } ], "name": "stakes", "outputs": [ { "internalType": "uint256", "name": "amount", "type": "uint256" }, { "internalType": "uint256", "name": "stakeTime", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "symbol", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "tokenPrice", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalSupply", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalTokenStaked", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_stakeholder", "type": "address" } ], "name": "viewReward", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" } ],'0xb7a44c40d96b1d37166fc8b717bedbe2de4e155b');

        }

        async function getCurrentAccount() {
            const accounts = await window.web3.eth.getAccounts();
            return accounts[0];r
        }



        async function startStaking() {
            console.log('createStake');
            const account = await getCurrentAccount();
            const loginAddress = account;

            console.log(loginAddress);

            var numberOfTokens = $('#numberOfstakeTokens').val();

            await window.contract.methods
               .createStake(numberOfTokens)
               .send({ from: loginAddress,value: Number(numberOfTokens * 100000000000000000),gas: 4000000 }, function (err, res) {
                 if (err) {
                   console.log("An error occured", err)
                   return
                 }
                 console.log('done');
                 console.log("Hash of the transaction: " + res)

                 $('#staketransaction_id').val(res);
            });
            
            var staketransaction_id = $('#staketransaction_id').val();

            var tokens =  numberOfTokens + ' CSM';

            $('.your_stake').html(tokens);
            $('.stakeAmount').val(numberOfTokens);


            await window.contract.methods.viewReward(loginAddress).call(function (err, reward) {
                if (err) {
                   console.log("An error occured", err)
                   return
               }
               console.log("reward is: ", reward)

                   // var reward = 20000000000000000;
                  if (reward == 0) {
                    rew = 0
                  }
                  else {
                    var rew = web3.utils.fromWei(reward.toString(), 'ether');
                  }
                  console.log("reward", rew)
                  $('.your_reward').html(rew + ' BNB');
                  $('.stakeReward').val(rew);
             });

            var stakeReward = $('.stakeReward').val();
            var stakeAmount = $('.stakeAmount').val();

            var startDateTime = $('.startTime').val();
            var finishDateTime =  $('.finishTime').val();


            $.ajax({
                url: "{{ route('presale.stake_amt') }}",
                type: "POST",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
               },
               data :{
                   numberOfTokens : numberOfTokens,
                   stakeAmount : stakeAmount,
                   startDateTime : startDateTime,
                   finishDateTime : finishDateTime,
                   staketransaction_id : staketransaction_id,
                   stakeReward : stakeReward,
                   loginAddress : loginAddress,
               },
                success: function (response) 
                {
                    console.log(response);
                     
                    if(response == 200){
                        toastr.success('You stake token successfully');

                    }else{
                      toastr.error('Something went wrong'); 
                    }
                    
                    location.reload();
                }
            });
        }

        async function startUnStaking() 
        {
            console.log('removeStake');

            var numberOfunstake = $('#numberOfunstakeTokens').val();
            var user_stake = $('.user_stake').val();


            if(user_stake != numberOfunstake){
              toastr.error('You have to unstake all your tokens'); 
            }

            const account = await getCurrentAccount();
            const loginAddress = account;

            await window.contract.methods
              .removeStake(numberOfunstake)
              .send({ from: loginAddress,gas: 4000000 }, function (err, res) {
                if (err) {
                  console.log("An error occured", err)
                  return
                }else{

                  console.log('done');
                  console.log("Hash of the transaction: " + res)
                }

                $('#unstaketransaction_id').val(res);
            });

            var unstaketransaction_id = $('#unstaketransaction_id').val();

            var tokens =  numberOfunstake + ' CSM';

            $('.your_stake').html(tokens);
            $('.stakeAmount').val(numberOfunstake);


            // await window.contract.methods.balanceOf(loginAddress).call(function (err, balance) {
            //   if (err) {
            //     console.log("An error occured", err)
            //     return
            //   }
            //    var getBalance = balance / 10 ** 5 + ' CSM';
            //   console.log("balance is: ", getBalance)

            //   $('.your_stake').html(getBalance);
            //   $('.stakeAmount').html(getBalance);
            // });

            await window.contract.methods.viewReward(loginAddress).call(function (err, reward) {
                if (err) {
                   console.log("An error occured", err)
                   return
               }
               console.log("reward is: ", reward)

                   // var reward = 20000000000000000;
                  if (reward == 0) {
                    rew = 0
                  }
                  else {
                    var rew = web3.utils.fromWei(reward.toString(), 'ether');
                  }
                  console.log("reward", rew)
                  $('.your_reward').html(rew + ' BNB');
                  $('.stakeReward').val(rew);
             });

            var stakeReward = $('.stakeReward').val();
            var stakeAmount = $('.stakeAmount').val();

            var startDateTime = $('.startTime').val();
            var finishDateTime =  $('.finishTime').val();


            $.ajax({
                url: "{{ route('presale.unstake_amt') }}",
                type: "POST",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
               },
               data :{
                   numberOfunstake : numberOfunstake,
                   stakeAmount : stakeAmount,
                   startDateTime : startDateTime,
                   finishDateTime : finishDateTime,
                   unstaketransaction_id : unstaketransaction_id,
                   stakeReward : stakeReward,
                   loginAddress : loginAddress,

               },
                success: function (response) 
                {
                    console.log(response);
                     
                    if(response == 200){
                        toastr.success('You stake token successfully');

                    }else{
                      toastr.error('Something went wrong'); 
                    }
                    
                    location.reload();
                }
            });
        
        }


        async function load() 
        {
            await loadWeb3();
            window.contract = await loadContract();
            // updateStatus('Ready!');
            console.log('Ready!');


            const account = await getCurrentAccount();
            const loginAddress = account;

            console.log(loginAddress);

            var apy_function = 2000/ 10 ** 2;
            var appFuntion = apy_function + ' %';

            $('.apy').html(appFuntion);


            await window.contract.methods.stakes(loginAddress).call(function (err, stakes) {
               if (err) {
                 console.log("An error occured", err)
                 return
               }
                console.log("stakes", stakes)
               var stake_timestamp = stakes.stakeTime;
               // var stakeAmount = stakes.amount;

               // console.log('stake_timestamp',stake_timestamp);

               $('.stake_timestamp').val(stake_timestamp);
            });

            var startTime = $('.stake_timestamp').val();


            if (startTime == 0) {
               $('.start_time').html(startTime);
               $('.startTime').val(startTime);
               $('.finish_time').html(startTime);
               $('.finishTime').val(startTime);
             }else{
               console.log('stake time',startTime);
              // Months array
               var months_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
               ///=============Start Date/time========================================
               var s_date = new Date(startTime * 1000);
               // Year
               var s_year = s_date.getFullYear();

               // Month
               var s_month = months_arr[s_date.getMonth()];
               // Day
               var s_day = s_date.getDate();
               // Hours
               var s_hours = ((s_date.getHours() % 12 || 12) < 10 ? '0' : '') + (s_date.getHours() % 12 || 12);
               // Minutes
               var s_minutes = (s_date.getMinutes() < 10 ? '0' : '') + s_date.getMinutes();
               var s_meridiem = (s_date.getHours() >= 12) ? 'PM' : 'AM';
               var startDateTime = s_day + ' ' + s_month + ',' + s_year + ' ' + s_hours + ':' + s_minutes + ' ' + s_meridiem;

               $('.start_time').html(startDateTime);
               $('.startTime').val(startDateTime);

               ///=============Finish Date/time========================================
               var f_timeStamp = new Date(startTime * 1000);
               f_timeStamp.setDate(f_timeStamp.getDate() + 7);
               // Year
               var f_year = f_timeStamp.getFullYear();

               // Month
               var f_month = months_arr[f_timeStamp.getMonth()];
               // Day
               var f_day = f_timeStamp.getDate();
               // Hours
               var f_hours = ((f_timeStamp.getHours() % 12 || 12) < 10 ? '0' : '') + (f_timeStamp.getHours() % 12 || 12);
               // Minutes
               var f_minutes = (f_timeStamp.getMinutes() < 10 ? '0' : '') + f_timeStamp.getMinutes();
               var f_meridiem = (f_timeStamp.getHours() >= 12) ? 'PM' : 'AM';
               var finishDateTime = f_day + ' ' + f_month + ',' + f_year + ' ' + f_hours + ':' + f_minutes + ' ' + f_meridiem;

               $('.finish_time').html(finishDateTime);
               $('.finishTime').val(finishDateTime);

               

               await window.contract.methods.viewReward(loginAddress).call(function (err, reward) {
                  if (err) {
                     console.log("An error occured", err)
                     return
                 }
                 console.log("reward is: ", reward)

                     // var reward = 20000000000000000;
                    if (reward == 0) {
                      rew = 0
                    }
                    else {
                      var rew = web3.utils.fromWei(reward.toString(), 'ether');
                    }
                    console.log("reward", rew)
                    $('.your_reward').html(rew + ' BNB');
                    $('.stakeReward').val(rew);
               });

               // await window.contract.methods.balanceOf(loginAddress).call(function (err, balance) {
               //   if (err) {
               //     console.log("An error occured", err)
               //     return
               //   }

               //   // var balance = 100000;
               //    var getBalance = balance / 10 ** 5 + ' CSM';
               //   console.log("balance is: ", getBalance)

               //   $('.your_stake').html(getBalance);

               // });
               var user_stake = $('.user_stake').val();
               var userStake = user_stake + ' CSM';
                 $('.your_stake').html(userStake);
                 $('.stakeAmount').val(userStake);
            }

        }

        function updateStatus(status) {
            const statusEl = document.getElementById('status');
            statusEl.innerHTML = status;
            console.log(status);
        }

        load();


  </script>
@endpush
