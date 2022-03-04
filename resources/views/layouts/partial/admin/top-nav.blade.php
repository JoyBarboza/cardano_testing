<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{ route('page.welcome') }}">
                <img src="{{ asset('images/logo.png?dvj') }}" alt="logo" class="img-responsive" style="width: 123px; margin-top: 6px;" /> </a> 
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <!-- <li class="setting"> -->
                
                    <!-- <?php
                        $wallet = auth()->user()->daedalus_wallet;
                        if(!empty( $wallet)){
                    ?>
                         <a href="{{ route('csm_wallet') }}" target="_blank">Your Wallet</a>
                   <?php }else{?>
                        <a href="https://testnets.cardano.org/en/testnets/cardano/get-started/wallet/" target="_blank">Create Wallet</a>
                    <?php }?> -->
                   
                    <!-- <h2>Account: <span class="showAccount"></span></h2> -->

                    <!-- <a href="{{ route('account.password') }}" class="waves-effect waves-teal" title="">
                        <img src="{{ url('/') }}/masonicoin/img/setting.png" alt="">
                    </a> -->
                <!-- </li> -->
				<li class="dropdown dropdown-user">
                     <form>
						<div class="flag_right">
							<div class="flagstrap" id="select_country" data-input-name="NewBuyer_country"></div>
						</div>
					</form>
                 </li>

                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <span class="username username-hide-on-mobile"> {{ auth()->user()->full_name }} </span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="{{ route('admin.user.profile') }}">
                                <i class="icon-user"></i>{{trans('layouts/partial/admin/top_nav.my_profile')}} </a>
                        </li>

                        <li>                            
                            <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                             <i class="icon-key"></i>
                                  {{trans('layouts/partial/admin/top_nav.logout')}}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
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
                       <textarea type='text' name="daedalus_wallet" id="daedalus_wallet" required data-parsley-required data-parsley-required-message="Enter account">{{ auth()->user()->daedalus_wallet }}</textarea>
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

<!-- <script type="text/javascript" src="D:\TestEth\capestoneEthILP\html\js\web3.js"></script> -->
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
