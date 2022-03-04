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
</head>

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
            <div class="c-header-icon ms-auto">
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
            </div>
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
                    <li class="bottom_add_wallet">
                        <a href="#addWalletModalToggle" data-bs-toggle="modal">
                            <i class="fas fa-plus font_icon"></i> Add Wallet</a>
                    </li>
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
                    <a href="https://anandisha.com/alpha_game_code/public/en/csm_wallet" class="nav-link">
                      <i class="fas fa-chart-pie font_icon"></i>
                      Summary
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="https://anandisha.com/alpha_game_code/public/en/csm_wallet" class="nav-link">
                      <i class="fas fa-arrow-up font_icon"></i>              
                      Send
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="https://anandisha.com/alpha_game_code/public/en/csm_wallet" class="nav-link">
                      <i class="fas fa-arrow-down font_icon"></i>
                      Receive
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <!-- <button class="nav-link" id="pills-transactions-tab" data-bs-toggle="pill" data-bs-target="#pills-transactions" type="button" role="tab" aria-controls="pills-transactions" aria-selected="false">
                      <i class="fas fa-receipt font_icon"></i>
                      Transactions
                    </button> -->
                    <a href="{{ route('csm_wallet_transaction') }}" class="nav-link active" id="pills-transactions-tab" data-bs-toggle="pill" data-bs-target="#pills-transactions" type="button" role="tab" aria-controls="pills-transactions" aria-selected="false">
                        <i class="fas fa-receipt font_icon"></i>
                        Transactions
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="https://anandisha.com/alpha_game_code/public/en/csm_wallet" class="nav-link">
                      <i class="fas fa-cog font_icon"></i>
                      More
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">                
                <div class="tab-pane fade show active" id="pills-transactions" role="tabpanel" aria-labelledby="pills-transactions-tab">
                    <div class="transactions_section pills_tab_content">
                        <div class="trans_histy_data">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h5>Transactions (<span>{{$transaction_count}}</span>)</h5>
                                </li>
                                <!-- <li class="list-inline-item ms-auto">
                                    <button type="button" class="btn csv_export">Export CSV <i class="fas fa-download font_icon"></i></button>
                                    <button type="button" class="btn filter_btn">Filter <i class="fas fa-filter font_icon"></i></button>
                                </li> -->
                            </ul>
                        </div>
                        <div class="csm_summy_databox">
                            <!-- <span class="csm_current_date">20/10/2021</span> -->
                            <div class="csm_data_box">
                                <div class="accordion" id="accordionExample">
                                    @if(count($transaction) != 0)
                                        @foreach($transaction as $r)
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
                                                        $from_address ='-';
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

                                                    if($r->coversion == 'stake_amount'){
                                                        $address = auth()->user()->daedalus_wallet;
                                                    }elseif($r->coversion == 'unstake_amount'){
                                                        $address = auth()->user()->daedalus_wallet;
                                                    }
                                                ?>
                                               
                                                <div id="collapse{{$r->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$r->id}}" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body trans_content_box">
                                                        <?php if($r->coversion == 'stake_amount' || $r->coversion == 'unstake_amount'){ ?>
                                                            <div class="row">
                                                                <div class="col-lg-12 col-12">
                                                                    <h5>From addresses</h5>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <p>{{$address}}</p>
                                                                </div>
                                                            </div>
                                                        <?php }else{ ?>
                                                            <div class="row">
                                                                <div class="col-lg-12 col-12">
                                                                    <h5>From addresses</h5>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <p>{{$from_address}}</p>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 col-12">
                                                                    <h5>To addresses</h5>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <p>{{$to_address}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 col-12">
                                                                    <h5>Transaction ID</h5>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <p>{{$transaction_id}}</p>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{$transaction->links() }}
                                    @endif

                                </div>
                            </div>
                        </div>
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


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('csm_wallet/js/jquery-3.2.1.slim.min.js') }} "></script>
<script src="{{ asset('csm_wallet/js/bootstrap.bundle.min.js') }}"></script>
<!-- fontAwesome js -->
<script src="{{ asset('csm_wallet/js/all.js') }}"></script>
<!-- Custom script js -->
<script src="{{ asset('csm_wallet/js/script.js') }}"></script>
</body>

</html>