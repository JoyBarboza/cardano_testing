@php $url = (auth()->check()) ? url(DIRECTORY_SEPARATOR.app()->getLocale().DIRECTORY_SEPARATOR.'home') :  url(DIRECTORY_SEPARATOR.app()->getLocale()); @endphp


{{--<header class="header-area">
    <div class="header-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navigation">
                        <nav class="navbar navbar-expand-lg navbar-light ">
                            <a class="navbar-brand" href="{{ route('home') }}">
                                <img class="logo" src="{{ asset('/time/images/logo.png?dfgxf') }}" alt="">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button> 
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul class="navbar-nav m-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#about">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Token Sale</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Roadmap</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Team</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#faq">Faqs</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="navbar-btn d-none d-sm-flex">
                                <a class="main-btn" href="{{ route('login') }}">{{trans('layouts/partial/user/header.signin')}}</a>
                            </div>
                        </nav>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</header>--}}



<!-- Loader -->
<div class="loader" style="display:none">
    <div class="inner one"></div>
    <div class="inner two"></div>
    <div class="inner three"></div>
</div>


<header id="header" class="header fixed">
    <div class="navbar-top">
        <div class="curren-menu info-left">
            <div class="logo">
                <a href="{{ route('page.welcome') }}">
                    <img src="{{ asset('images/logo.png?ftgs') }}" alt="One Admin">
                </a>
            </div>
            <div class="top-button">
                <span></span>
            </div>
            
        </div>
     

        <ul class="info-right">
            <!--  <?php
                    $wallet = auth()->user()->daedalus_wallet;
                    if(empty( $wallet)){
                ?>
            <li>
                <button class="enableEthereumButton" style="color: white;" onClick="checkMetamask()">Your Wallet</button>
            </li>
            <?php }?> -->
            <li class="setting">
                

              <!--   <?php
                    $wallet = auth()->user()->daedalus_wallet;
                    if(!empty( $wallet)){
                ?> -->
                    <!-- <button class="enableEthereumButton" style="color: white;" onClick="checkMetamask()">Your Wallet</button> -->
                    <!-- <a href="{{ route('csm_wallet') }}" target="_blank">Your Wallet</a> -->
               <!-- <?php }else{?>
                    <a href="https://testnets.cardano.org/en/testnets/cardano/get-started/wallet/" target="_blank">Create Wallet</a>
                <?php }?>
                -->
                <!-- <h2>Account: <span class="showAccount"></span></h2> -->

                <!-- <a href="{{ route('account.password') }}" class="waves-effect waves-teal" title="">
                    <img src="{{ url('/') }}/masonicoin/img/setting.png" alt="">
                </a> -->
            </li>

            <li>
                <form>
                    <div class="flag_right">
                        <div class="flagstrap" id="select_country" data-input-name="NewBuyer_country" data-selected-country=""></div>
                    </div>
                </form>
            </li>


        @if(auth()->check())
            <li class="setting">
                <a href="{{ route('account.password') }}" class="waves-effect waves-teal" title="">
                    <img src="{{ url('/') }}/masonicoin/img/setting.png" alt="">
                </a>
            </li>
        @endif    
            <li class="user">
            @if(auth()->check())
            @php $image = auth()->user()->document()->where('name','PHOTO')->first();
            $basepath = 'public'.DIRECTORY_SEPARATOR.auth()->user()->username @endphp
                <div class="avatar">
                    @if((auth()->user()->document()->where('name','PHOTO')->exists()))
                    <img src="{{route('photo.get',[$image['location'],auth()->user()->username])}}" alt="">
                    @else
                    <img src="{{ asset('images/user.jpg') }}" alt="">
                    @endif
                   
                </div>
                <div class="info">
                    <p class="name">{{trans('layouts/partial/user/header.my_account')}}</p>
                    <p class="address">Referral Code : <span class="text-info">{{ auth()->user()->referral}}</span></p>
                </div>
                @else
                <div class="info">
                    <p class="name">{{trans('layouts/partial/user/header.my_account')}}</p>
                </div>
                @endif
                <div class="arrow-down">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                    <i class="fa fa-angle-up" aria-hidden="true"></i>
                </div>
            
                @guest
                <div class="dropdown-menu">
                    <ul>
                        <li><a class="waves-effect" href="{{ route('login') }}">{{trans('layouts/partial/user/header.signin')}}</a></li>
                        <li><a class="waves-effect" href="{{ route('register') }}">{{trans('layouts/partial/user/header.signup')}}</a></li>
                    </ul>
                </div>
                @endguest
                @if(auth()->check())
                <div class="dropdown-menu">
                    <ul>
                        
                        <li><a class="waves-effect" href="{{ route('home') }}">{{trans('layouts/partial/user/sidebar.home')}}</a></li>
                        <li><a class="waves-effect" href="{{ route('account.profile') }}">{{trans('layouts/partial/user/sidebar.profile')}}</a></li>
                        <li><a class="waves-effect" href="{{ route('account.password') }}">{{trans('layouts/partial/user/sidebar.change_password')}}</a></li>
                        <li><a class="waves-effect" href="{{ route('account.2fa') }}">{{trans('layouts/partial/user/sidebar.security')}}</a></li>
                        <li><a class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{trans('layouts/front.logout')}}</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{csrf_field()}}
                    </form>
                </div>
                @endif
                <div class="clearfix"></div>
            </li>
            @if(auth()->check())
            <li class="button-menu-right active">
                <img src="{{ url('/') }}/masonicoin/img/menu-right.png" alt="">
            </li>
            @endif
        </ul>
        <div class="clearfix"></div>
    </div>
</header>

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
h5.modal-title{
margin: auto;
}

.modal-body p{
    margin-bottom: 5px;
}
.modal-content{
    height: 550px;
    overflow: scroll;
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
                        <p class="m-4"> <b>Note :</b> You need CSM wallet to deposite ADA and buy CZM </p>
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


 <div id="checkMetamask" class="modal create_wallet_modal fade" tabindex="-1">
        <!-- <form method="POST" action="{{ route('presale.account') }}" enctype="multipart/form-data" data-parsley-validate> -->
            <!-- {{ csrf_field() }} -->
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:white;">How to Install and Use Metamask</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <p class="mx-4" style="color: black;"> <b>Step 1:</b> Go to Chrome Web Store Extensions Section.</p>
                        <p class="mx-4" style="color: black;"> <b>Step 2:</b> Search MetaMask.</p>
                        <p class="mx-4" style="color: black;"> <b>Step 3:</b> Check the number of downloads to make sure that the legitimate MetaMask is being installed, as hackers might try to make clones of it.</p>
                        <p class="mx-4" style="color: black;"> <b>Step 4:</b> Click the Add to Chrome button.</p>
                        <p class="mx-4" style="color: black;"> <b>Step 5:</b> Once installation is complete this page will be displayed. Click on the Get Started button.</p>
                        <p class="mx-4" style="color: black;"> <b>Step 6:</b> This is the first time creating a wallet, so click the Create a Wallet button. If there is already a wallet then import the already created using the Import Wallet button.</p>
                        <p class="mx-4" style="color: black;"> <b>Step 7:</b> Click I Agree button to allow data to be collected to help improve MetaMask or else click the No Thanks button. The wallet can still be created even if the user will click on the No Thanks button.</p>
                        <p class="mx-4" style="color: black;"> <b>Step 8:</b> Create a password for your wallet. This password is to be entered every time the browser is launched and wants to use MetaMask. A new password needs to be created if chrome is uninstalled or if there is a switching of browsers. In that case, go through the Import Wallet button. This is because MetaMask stores the keys in the browser. Agree to Terms of Use.</p>
                        <p class="mx-4" style="color: black;"> <b>Step 9:</b> Click on the dark area which says Click here to reveal secret words to get your secret phrase. </p>
                        <p class="mx-4" style="color: black;"> <b>Step 10:</b> This is the most important step. Back up your secret phrase properly. Do not store your secret phrase on your computer. Please read everything on this screen until you understand it completely before proceeding. The secret phrase is the only way to access your wallet if you forget your password. Once done click the Next button. </p>
                        <p class="mx-4" style="color: black;"> <b>Step 11:</b> Click the buttons respective to the order of the words in your seed phrase. In other words, type the seed phrase using the button on the screen. If done correctly the Confirm button should turn blue.</p>
                        <p class="mx-4" style="color: black;"> <b>Step 12:</b> Click the Confirm button. Please follow the tips mentioned.</p>
                        <p class="mx-4" style="color: black;"> <b>Step 13:</b> One can see the balance and copy the address of the account by clicking on the Account 1 area.</p>
                        <p class="mx-4" style="color: black;"> <b>Step 14:</b> One can access MetaMask in the browser by clicking the Foxface icon on the top right. If the Foxface icon is not visible, then click on the puzzle piece icon right next to it.</p>

                    </div>

                    <div class="modal-footer">
                        <!-- <button type="submit" class="btn mint_submit btn-block btn-primary">{{trans('nft.submit')}}</button> -->

                        <!-- <button class="btn btn-info submitButton">Submit</button> -->

                        <button type="button" class="btn btn-secondary cancle_btn" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        <!-- </form> -->
    </div>
@push('js')


 <script src="https://unpkg.com/vue@2.5.17/dist/vue.min.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js" integrity="sha256-nWBTbvxhJgjslRyuAKJHK+XcZPlCnmIAAMixz6EefVk=" crossorigin="anonymous"></script>

<!-- <script>
    window.addEventListener('load', function() {

  // Check if Web3 has been injected by the browser (Mist/MetaMask).
  if (typeof web3 !== 'undefined') {
    // Use Mist/MetaMask's provider.
    web3js = new Web3(web3.currentProvider);
  } else {
    // Handle the case where the user doesn't have web3. Probably 
    // show them a message telling them to install Metamask in 
    // order to use the app.
  }

});


    const ethereumButton = document.querySelector('.enableEthereumButton');

    ethereumButton.addEventListener('click', () => {
      //Will Start the metamask extension
      ethereum.request({ method: 'eth_requestAccounts' });
    });
</script> -->

<!-- <script src="https://unpkg.com/vue@2.5.17/dist/vue.min.js"></script> -->
  <!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->

<!-- <script type="text/javascript" src="D:\TestEth\capestoneEthILP\html\js\web3.js"></script> -->
<script type="text/javascript">

    const { ethereum } = window;

    function checkMetamask(){

        // $("#checkModal").modal('show');
        
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

