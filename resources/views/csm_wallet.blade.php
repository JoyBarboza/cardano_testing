<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="{{ asset('/time/images/favicon.ico?fhc') }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('csm_wallet/css/bootstrap.min.css') }} ">
    <!-- fontawesome css -->
    <link rel="stylesheet" href="{{ asset('csm_wallet/css/all.css') }}">
    <!-- custom style css -->
    <link rel="stylesheet" href="{{ asset('csm_wallet/css/style.css') }}">
    <title>CSM Wallet</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    


    <script type="text/javascript" src="{{ asset('parsley.min.js') }}"></script>

    <script src="{{ asset('toastr.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('toastr.min.css') }}">

    <style type="text/css">
    .parsley-errors-list{
        color: red;
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
  </style>
</head>


<input type="text" name="daedalus_wallet_address" value="{{auth()->user()->daedalus_wallet}}" id="daedalus_wallet_address">
<input type="text" name="seed_pharse" value="{{auth()->user()->seed_pharse}}" id="seed_pharse">
<input type="text" name="wallet_password" value="{{auth()->user()->wallet_password}}" id="wallet_password">

<body class="sidebar-is-reduced">
    <header class="l-header">
        <div class="l-header__inner clearfix">
            <div class="c-header-icon js-hamburger">
                <div class="hamburger-toggle">
                    <span class="bar-top"></span>
                    <span class="bar-mid"></span>
                    <span class="bar-bot"></span>
                </div>
            </div>
            <!-- <div class="c-header-icon ms-auto">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a href="javascript:;" class="right_menu_icon">
                            <i class="fas fa-sync-alt font_icon"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:;" class="right_menu_icon">
                            <i class="fa fa-bell font_icon"></i>
                        </a>
                    </li>
                </ul>
            </div> -->
        </div>
    </header>
    <div class="l-sidebar">
        <div class="logo">
            <div class="logo__txt">
                <img src="{{ asset('csm_wallet/images/logo.png') }}" alt="" class="img-fluid">
                <h5 class="mb-0">CSM Wallet</h5>
            </div>
        </div>
        <div class="l-sidebar__content">
            <nav class="c-menu js-menu side_menu">
                <ul class="u-list">
                    <li class="c-menu__item is-active">
                        <a href="{{ route('csm_wallet') }}" class="c-menu__item__inner">
                            <i class="fas fa-wallet font_icon"></i>
                        </a>
                    </li>
                    <!-- <li class="c-menu__item">
                        <a href="javascript:;" class="c-menu__item__inner">
                            <i class="fas fa-sliders-h font_icon"></i>
                        </a>
                    </li>
                    <li class="c-menu__item">
                        <a href="javascript:;" class="c-menu__item__inner">
                            <i class="far fa-chart-bar font_icon"></i>
                        </a>
                    </li> -->
                </ul>
                <ul class="u_leftlist list-unstyled">
                    <li class="c-menu__item">
                        <a href="javascript:;" class="c-menu__item__inner menu_text">
                            CSM Wallet
                        </a>
                    </li>
                   <!--  <li class="c-menu__item">
                        <a href="javascript:;" class="c-menu__item__inner menu_text">
                            test1
                        </a>
                    </li> -->
                    <!-- <li class="bottom_add_wallet">
                        <a href="#addWalletModalToggle" data-bs-toggle="modal">
                            <i class="fas fa-plus font_icon"></i> Add Wallet</a>
                    </li> -->
                </ul>
            </nav>
        </div>
    </div>
</body>
<main class="l-main">
    <div class="content-wrapper content-wrapper--with-bg">
        @include('flash::message')
        <!-- main section content start here -->
        <div class="top_note">
            <?php
                $wallet = auth()->user()->daedalus_wallet;
            ?>
            <p>Wallet Address : <b>{{$wallet}}</b></p>
        </div>
        <div class="tab_menu_section">
            <ul class="nav nav-pills mb-0 piils_menu nav-justified" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-summary-tab" data-bs-toggle="pill" data-bs-target="#pills-summary" type="button" role="tab" aria-controls="pills-summary" aria-selected="true">
                      <i class="fas fa-chart-pie font_icon"></i>
                      Summary
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-send-tab" data-bs-toggle="pill" data-bs-target="#pills-send" type="button" role="tab" aria-controls="pills-send" aria-selected="false">
                      <i class="fas fa-arrow-up font_icon"></i>              
                      Send
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-receive-tab" data-bs-toggle="pill" data-bs-target="#pills-receive" type="button" role="tab" aria-controls="pills-receive" aria-selected="false">
                      <i class="fas fa-arrow-down font_icon"></i>
                      Receive
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <!-- <button class="nav-link" id="pills-transactions-tab" data-bs-toggle="pill" data-bs-target="#pills-transactions" type="button" role="tab" aria-controls="pills-transactions" aria-selected="false">
                      <i class="fas fa-receipt font_icon"></i>
                      Transactions
                    </button> -->
                    <a href="{{ route('csm_wallet_transaction') }}" class="nav-link">
                        <i class="fas fa-receipt font_icon"></i>
                        Transactions
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-more-tab" data-bs-toggle="pill" data-bs-target="#pills-more" type="button" role="tab" aria-controls="pills-more" aria-selected="false">
                      <i class="fas fa-cog font_icon"></i>
                      More
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-summary" role="tabpanel" aria-labelledby="pills-summary-tab">
                    <div class="summary_section pills_tab_content">
                        <div class="blck_trans_box">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-12">
                                    <ul class="list-unstyled blck_trans_left">
                                        <li>
                                            <h4>CSM Wallet</h4>
                                        </li>
                                        <li>
                                            <h5> {{auth()->user()->cjm_wallet}} CSM</h5>
                                        </li>
                                        <li>
                                            <p>Number of pending transactions:</p>
                                            <span>0</span>
                                        </li>
                                        <li>
                                            <p>Number of transactions:</p>
                                            <span>{{$transaction_count}}</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- <div class="col-md-6 col-sm-6 col-12">
                                    <ul class="list-unstyled blck_trans_right">
                                        <li>
                                            <h6>Converts as</h6>
                                        </li>
                                        <li>
                                            <p>- USD</p>
                                        </li>
                                        <li>
                                            <p>1 CSM = 2.1 USD</p>
                                        </li>
                                        <li>
                                            <b>converted a few seconds ago <i class="fas fa-cog font_icon"></i></b>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>
                        @if(count($summy_transaction) != 0)
                            <div class="loader_box">
                                <p>Your transaction history of this wallet is begin synced with the blockchain.</p>
                            </div>
                            <div class="csm_summy_databox">
                                <div class="csm_data_box">
                                    <div class="accordion" id="accordionExample">
                                        @if(count($summy_transaction) != 0)
                                            @foreach($summy_transaction as $r)
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="heading{{$r->id}}">
                                                        <ul class="list-inline" data-bs-toggle="collapse" data-bs-target="#collapse{{$r->id}}" aria-expanded="false" aria-controls="collapse{{$r->id}}">
                                                           <li class="list-inline-item">
                                                                @if($r->user_id == auth()->user()->id)
                                                                    <div class="csm_data_icon csm_recive_data">
                                                                        <i class="fas fa-arrow-up font_icon"></i>
                                                                    </div>
                                                                 @else
                                                                    <div class="csm_data_icon csm_send_data">
                                                                        <i class="fas fa-arrow-down font_icon"></i>
                                                                    </div>
                                                                @endif
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <div class="csm_data_name">
                                                                    @if($r->coversion == 'csm_wallet_received')
                                                                        @if($r->user_id == auth()->user()->id)
                                                                            <p>CSM Send</p>
                                                                        @else
                                                                            <p>CSM Received</p>
                                                                        @endif
                                                                    @elseif($r->coversion == 'mint nft')
                                                                        @if($r->user_id == auth()->user()->id)
                                                                            <p>Mint NFT</p>
                                                                        @else
                                                                            <p>Mint NFT</p>
                                                                        @endif
                                                                    @elseif($r->coversion == 'mint ft')
                                                                        @if($r->user_id == auth()->user()->id)
                                                                            <p>Mint FT</p>
                                                                        @else
                                                                            <p>Mint FT</p>
                                                                        @endif
                                                                    @elseif($r->coversion == 'ada to csm')
                                                                        @if($r->user_id == auth()->user()->id)
                                                                            <p>ADA to CSM</p>
                                                                        @else
                                                                            <p>ADA to CSM</p>
                                                                        @endif
                                                                    @elseif($r->coversion == 'buy trade')
                                                                        @if($r->user_id == auth()->user()->id)
                                                                            <p>Buy Trade</p>
                                                                        @else
                                                                            <p>Buy Trade</p>
                                                                        @endif
                                                                    @elseif($r->coversion == 'user trading')
                                                                        @if($r->user_id == auth()->user()->id)
                                                                            <p>User Trading</p>
                                                                        @else
                                                                             <p>User Trading</p>
                                                                        @endif
                                                                    @elseif($r->coversion == 'stake_amount')
                                                                        @if($r->user_id == auth()->user()->id)
                                                                            <p>Stake Amount</p>
                                                                        @endif
                                                                     @elseif($r->coversion == 'unstake_amount')
                                                                        @if($r->to_id == auth()->user()->id)
                                                                            <p>Unstake Amount</p>
                                                                        @endif
                                                                    @endif

                                                                    <span>Confirmed transaction, {{date("H:i:s A", strtotime($r->created_at))}} </span>
                                                                </div>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <div class="csm_data_value">
                                                                    
                                                                    @if($r->user_id == auth()->user()->id)
                                                                        <span>- {{$r->csm_amount}} CSM</span>
                                                                    @else
                                                                        <span>{{$r->csm_amount}} CSM</span>
                                                                    @endif

                                                                    <b class="csm_tran_status">
                                                                      Transactions Confirmed
                                                                    </b>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <?php
                                                        if($r->user_id == auth()->user()->id){
                                                            $from_address = auth()->user()->daedalus_wallet;
                                                        }else{
                                                            $from_address = auth()->user()->daedalus_wallet;
                                                        }

                                                        $to_id = \App\User::where(['id' => $r['to_id']])->first();
                                                        if(!empty($to_id->daedalus_wallet)){
                                                            $to_address = $to_id->daedalus_wallet;
                                                        }else{
                                                            $to_address = '-';
                                                        }

                                                        if(!empty($r->transaction_id)){
                                                            $transaction_id = $r->transaction_id;
                                                        }else{
                                                            $transaction_id = '-';
                                                        }
                                                    ?>
                                                   
                                                    <div id="collapse{{$r->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$r->id}}" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body trans_content_box">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-12">
                                                                    <h5>From addresses</h5>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <p>Show address text {{$from_address}}</p>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 col-12">
                                                                    <h5>To addresses</h5>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <p>Show address text {{$to_address}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 col-12">
                                                                    <h5>Transaction ID</h5>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <p>Show address text {{$transaction_id}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-send" role="tabpanel" aria-labelledby="pills-send-tab">
                    <div class="send_section pills_tab_content">
                        <form method="POST" action="{{ route('send_amount') }}" enctype="multipart/form-data" data-parsley-validate>
                            {{ csrf_field() }}
                            <div class="mb-3">
                                <label for="exampleInputAddress" class="form-label">Receiver</label>
                                <input type="text" class="form-control" name="daedalus_wallet" id="exampleInputAddress" placeholder="Wallet Address">
                            </div>
                            <div class="mb-3 amount_field">
                                <label for="exampleInputAmount" class="form-label">Amount</label>
                                <input type="number" class="form-control" name="csm_amount" id="exampleInputAmount" placeholder="0.0000">
                                <span>CSM</span>
                            </div>
                            <button type="submit" class="btn frm_send_btn">Submit</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-receive" role="tabpanel" aria-labelledby="pills-receive-tab">
                    <div class="receive_section pills_tab_content">
                        <h2>Available wallet addresses</h2>
                        <!-- <h6>Share any of these wallet address to receive payments in csm or a native cardano token.</h6>
                        <p>Privacy warning: Please note that all of your receiving addresses include your stake key. When you share a receiving address, the recipient can search the blockchain using your stake key to locate all addresses associated with
                            your wallet, and also discover your wallet balance and transaction history.</p>
                        <hr> -->
                        <ul class="list-inline csm_table_head">
                            <li class="list-inline-item">
                                Receiving Addresses
                            </li>
                            <!-- <li class="list-inline-item ms-auto">
                                Show used
                                <label class="switch">
                                  <input type="checkbox">
                                  <span class="slider"></span>
                                </label>
                            </li> -->
                        </ul>
                        <ul class="list-unstyled table_receive_data">
                            @if(count($received) != 0)
                                @foreach($received as $r)
                                    @php 
                                        $check_user = \App\User::where(['id' => $r->user_id])->first();
                                    @endphp
                                    <li>
                                        @if(!empty($check_user))
                                            <p>{{$check_user->daedalus_wallet}}</p>
                                        @else
                                            <p>-</p>
                                        @endif
                                        <span>CSM {{$r->csm_amount}}</span>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <p>No received yet</p>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-more" role="tabpanel" aria-labelledby="pills-more-tab">
                    <div class="more_section pills_tab_content">
                        <div class="more_top_box">
                            <form>
                                <div class="mb-3">
                                    <label for="exampleInputName" class="form-label">Name</label>
                                    <div class="input-group mb-3 form_input_grp">
                                        <input type="text" class="form-control" id="exampleInputName" value="{{auth()->user()->daedalus_wallet}}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword" class="form-label">Password</label>
                                    <div class="input-group mb-3 form_input_grp">
                                        <input type="password" class="form-control" id="exampleInputPassword" value="{{auth()->user()->wallet_password}}">
                                        <a href="javascript:;" class="pass_chng" data-bs-toggle="modal" data-bs-target="#change_password">Change</a>
                                    </div>
                                </div>
                            </form>
                            <!-- <h4>Do you have your wallet recovery phrase?</h4>
                            <p>Funds in this wallet can only be recovered using the correct wallet recovery phrase, which is a unique 12-word string you were shown and asked to write down when creating this wallet. You can re-enter your wallet recovery phrase
                                to verify that you have the correct recovery phrase for this wallet.
                            </p>
                            <div class="wlt_vrfy">
                                <i class="fas fa-check-circle font_icon"></i>
                                <p>We recommend that your verify your wallet recovery phrase in <b>5 months</b>.</p>
                                <button type="button" class="btn verify_wlt_btn">Verify wallet recovery phrase</button>
                            </div> -->
                        </div>

                        <div class="more_top_box">
                            <form>
                                <div class="mb-3">
                                    <label for="exampleInputPassword" class="form-label">Wallet Public Key</label>
                                    <div class="input-group mb-3 form_input_grp">
                                        <input type="password" class="form-control" id="pass_log_id" value="{{auth()->user()->daedalus_wallet}}">
                                        <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                                    </div>
                                </div>
                            </form>
                        </div>

                       <!--  <div class="more_btm_box">
                            <div class="more_btm_lftbox">
                                <h5>Delete Wallet</h5>
                                <p>Once you delete this wallet it will be removed from tha CSM interface and you will lose access to any remaining funds in the wallet. The only way to regain access after deletion is by restoring it using your wallet recovery
                                    phrase.
                                </p>
                                <p>You may wish to verify your recovery phrase before deletion to ensure that you can restore this wallet in the future, if desired.</p>
                            </div>
                            <div class="more_btm_rgtbox">
                                <button type="button" class="btn dlt_wlt_btn">Delete wallet</button>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- main section content close here -->
    </div>
</main>
<!-- partial -->



<!-- add wallet popup start here -->
<section class="addwallet_popup">
    <div class="modal fade" id="addWalletModalToggle" aria-hidden="true" aria-labelledby="addWalletModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="addWalletModalToggleLabel">Add Wallet</h5> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-ms-7 col-sm-8 col-12">
                        <div class="row">
                            <div class="col-lg-6 col-ms-6 col-sm-6 col-12">
                                <a href="javascript:;" class="add_wlt_box">
                                    <i class="fas fa-plus font_icon"></i>
                                    <h4>Create</h4>
                                    <p>Create a new wallet</p>
                                </a>
                            </div>
                            <div class="col-lg-6 col-ms-6 col-sm-6 col-12">
                                <a href="javascript:;" class="add_wlt_box">
                                    <i class="fas fa-users font_icon"></i>
                                    <h4>Join</h4>
                                    <p>Create a new wallet</p>
                                </a>
                            </div>
                            <div class="col-lg-6 col-ms-6 col-sm-6 col-12">
                                <a href="javascript:;" class="add_wlt_box">
                                    <i class="fas fa-sync-alt font_icon"></i>
                                    <h4>Restore</h4>
                                    <p>Create a new wallet</p>
                                </a>
                            </div>
                            <div class="col-lg-6 col-ms-6 col-sm-6 col-12">
                                <a href="javascript:;" class="add_wlt_box">
                                    <i class="fas fa-cloud-download-alt font_icon"></i>
                                    <h4>Import</h4>
                                    <p>Create a new wallet</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- add wallet popup start here -->


<!-- change password modal start here -->
<div class="changepass_modal">
    <!-- Modal -->
    <div class="modal fade" id="change_password" tabindex="-1" aria-labelledby="change_passwordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="change_passwordLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="change_pass_form">
                    <form method="POST" action="{{ route('wallet_password') }}" enctype="multipart/form-data" data-parsley-validate>
                            {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="user_id" value="{{auth()->user()->id}}">
                        <input type="hidden" class="form-control" name="type_password" value="2">
                         <div class="mb-3">
                            <label for="newPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Current Password" required data-parsley-required data-parsley-required-message="Enter Current Password">
                        </div>

                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" required data-parsley-required data-parsley-required-message="Enter New Password">
                        </div>
                        <div class="mb-3">
                            <label for="repeatPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Repeat New Password" required data-parsley-required data-parsley-required-message="Enter confirm password" class="form-control text-center" data-parsley-equalto="#newPassword" data-parsley-equalto-message="Confirm and new password should be same">
                        </div>

                        <!-- <p>The password needs to be <b>at least 10 characters</b> and <b>at most 255 characters</b> long.</p> -->
                        <button type="submit" class="btn chng_pass_save create_password" id="create_password">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- change password modal close here -->


<!-- Wallet modal start here -->
    <?php 
        //generate pharse
        // function getRandomWord($len = 5) {
        //     $word = array_merge(range('a', 'z'), range('A', 'Z'));
        //     shuffle($word);
        //     return substr(implode($word), 0, $len);
        // }

        // $pharse = array();
        // for ($i = 0; $i < 24; $i++) {            
        //     $pharse[] = getRandomWord()." ";
        // }
        // echo  "\n";

        if(!function_exists("curl_init")) die("cURL extension is not installed");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://random-word-api.herokuapp.com/word?number=24");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        // echo $result;
        // echo '<br>';
        $arr = json_decode($result);


        $seed_pharse =  implode(" ",$arr);


        // $seed_pharse = implode('',$pharse);

        //generate daedalus wallet address
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $daedalus_wallet = 'acct_'.substr(str_shuffle($permitted_chars), 0, 100);

    ?>
<div class="changepass_modal">
    <!-- Modal -->
    <div class="modal fade" id="pharse" tabindex="-1" aria-labelledby="pharse" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="change_passwordLabel">Recovery Pharse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="change_pass_form">
                    <form method="POST" action="{{ route('add_wallet_detail') }}" enctype="multipart/form-data" data-parsley-validate>
                            {{ csrf_field() }}
                        <div class="mb-3">
                            <!-- <label for="currentPassword" class="form-label">Pharse</label> -->
                            <p>
                                <b>{{$seed_pharse}}</b>
                            </p>
                            <input type="hidden" class="form-control" id="user_id" name="user_id" placeholder="User Id" value="{{auth()->user()->id}}">
                            <input type="hidden" class="form-control" id="seed_pharse" name="seed_pharse" placeholder="Seed Pharse" value="{{$seed_pharse}}">
                            <input type="hidden" class="form-control" id="daedalus_wallet" name="daedalus_wallet" placeholder="Seed Pharse" value="{{$daedalus_wallet}}">
                        </div>

                        <div class="mb-3">
                            <input class="form-check-input wallet_chk" type="checkbox" name="2[]" value="1"> I undersand that the simplest way to keep my wallet recovery pharse secure is to never store it digitally or online. If I decide to use an online service, such as a password manager with an encrypted database,it is my responsibility to make sure that I use it correctly
                        </div>

                       <!--  <div class="mb-3">
                            <input class="form-check-input tab1_chk" type="checkbox" name="2[]" value="1"> I understand that the only way to recover my wallet if my computer
                        </div> -->

                        <button type="submit" class="btn chng_pass_save wallet_detail" id="confirm_wallet_detail">Confirm</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Wallet modal close here -->

<!-- change password modal start here -->
<div class="changepass_modal">
    <!-- Modal -->
    <div class="modal fade" id="create_new_password" tabindex="-1" aria-labelledby="change_passwordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="change_passwordLabel">Create Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="change_pass_form">
                    <form method="POST" action="{{ route('wallet_password') }}" enctype="multipart/form-data" data-parsley-validate>
                            {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="user_id" value="{{auth()->user()->id}}">
                        <input type="hidden" class="form-control" name="type_password" value="1">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="npassword" name="newPassword" placeholder="Type New Password" required data-parsley-required data-parsley-required-message="Enter Password">
                        </div>
                        <div class="mb-3">
                            <label for="repeatPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Repeat New Password" required data-parsley-required data-parsley-required-message="Enter confirm password" class="form-control text-center" data-parsley-equalto="#npassword" data-parsley-equalto-message="Confirm and new password should be same">
                        </div>

                        <!-- <p>The password needs to be <b>at least 10 characters</b> and <b>at most 255 characters</b> long.</p> -->
                        <button type="submit" class="btn chng_pass_save create_password" id="create_password">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- change password modal close here -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('csm_wallet/js/jquery-3.2.1.slim.min.js') }} "></script>
<script src="{{ asset('csm_wallet/js/bootstrap.bundle.min.js') }}"></script>
<!-- fontAwesome js -->
<script src="{{ asset('csm_wallet/js/all.js') }}"></script>
<!-- Custom script js -->
<script src="{{ asset('csm_wallet/js/script.js') }}"></script>

<script type="text/javascript">
    $( document ).ready(function() {

        //create wallet
        var seed_pharse = $('#seed_pharse').val();
        var wallet_password = $('#wallet_password').val();

        if(seed_pharse != ''){
            console.log(1);
           $('#pharse').modal('hide');
           // $('#create_new_password').modal('show');

            if(wallet_password == ''){
                console.log(3);
                $('#create_new_password').modal('show');
            }else{
                $('#create_new_password').modal('hide');
            }
        }else{
            console.log(2);
           $('#pharse').modal('show');
           $('#create_new_password').modal('hide');
        }


        $('.wallet_detail').prop('disabled', !$('.wallet_chk:checked').length);

        $('input[type=checkbox]').click(function() {
            if ($('.wallet_chk:checkbox:checked').length == 1) {
                console.log(1);
                $('.wallet_detail').prop('disabled', false);
            } else {
                console.log(2);
                $('.wallet_detail').prop('disabled', true);
           }
        });
    });

    $(document).on('click', '.toggle-password', function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        
        var input = $("#pass_log_id");
        input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
    });


</script>
</body>

</html>