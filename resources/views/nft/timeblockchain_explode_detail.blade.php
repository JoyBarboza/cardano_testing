<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
        <link rel="shortcut icon" type="image/png" href="{{ asset('/time/images/favicon.ico?fhc') }}">
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> -->

    <link rel="stylesheet" href="{{ asset('assets/global/cardano/css/bootstrap5.0.1.css') }}/">
    <link rel="stylesheet" href="{{ asset('assets/global/cardano/css/data-tables-bootstrap5-min.csss') }}">

    <title>TIME BLOCKCHAIN EXPLORER</title>
    <style>
        * {
            margin: 0%;
            padding: 0%;
            box-sizing: border-box;
        }

        body {
            background-color: #1f1f32;
        }

        .main_page {
            padding: 0px 100px;
        }

        .top_sec_tile {
            color: #fff;
            font-size: 18px;
        }

        .main_txt {
            font-weight: bold;
            color: #fff;
            font-size: 18px;
        }

        .top_section {
            text-align: center;
            padding: 70px;
        }

        .Header_logo__3Q2fX {
            width: 100px;
            height: auto;
        }

        .search_div {
            background-color: #1f1f32;
            padding: 30px;
        }

        .search_txt {
            color: #fff;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .form-control {
            background-color: #1f1f32;
            border: none;
            border-radius: 0px;
            border-bottom: 1px solid cyan;
        }

        .btn-outline-success {
            color: cyan;
            border-color: cyan;
        }

        .btn-outline-success:hover {
            background-color: cyan;
            color: black;
        }


        /* ----------------  */

        .isthead_div {
            display: flex;
            justify-content: space-between;
            color: cornflowerblue;
            font-size: 12px;
        }

        .list_itemdiv {
            color: grey;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .lst_btm {
            display: flex;
            justify-content: flex-end;
        }

        .lst_btm button {
            background-color: rgb(4, 214, 214);
            padding: 3px 15px;
            color: black;
            font-weight: bold;
            font-size: 12px;
            outline: none;
            border: none;
            border-radius: 3px;
            margin: 10px;
        }

        .list_head_name {
            color: #fff;
            text-align: center;
            margin: 10px;
        }

        /* ======================== New tables ======================= */

        .custom-clr {
            color: #fff;
        }

        .dataTables_wrapper.dt-bootstrap5 {
            color: #fff;
        }

        .odd {
            color: #fff !important;
        }

        .page-link {
            background-color: #1f1f32 !important;
            color: #fff !important;
        }

        .form-select {
            background-color: #1f1f32 !important;
            color: #fff !important;
        }

        .cardno_datatable .row:first-child {
            display: flex;
            flex-flow: column-reverse;
            width: 100%;
        }

        .cardno_datatable .row:first-child .col-md-6 {
            width: 100% !important;
            margin: 5px auto;
            display: inline-block;
        }

        .cardno_datatable .dataTables_filter {
            text-align: left !important;
            width: 100% !important;
            display: inline-block !important;
        }

        .cardno_datatable .dataTables_filter label {
            width: 100%;
            margin-bottom: 15px;
            display: flex;
            flex-flow: column;
            text-transform: uppercase;
            font-size: 16px;
            font-weight: bold !important;
            letter-spacing: 1.5px !important;
        }

        .cardno_datatable .dataTables_filter input {
            width: 100% !important;
            letter-spacing: 1px;
            color: #fff !important;
        }

        .cardno_datatable .dataTables_filter input.form-control:focus {
            background-color: transparent !important;
            color: #fff;
            border-bottom: 1px solid cyan !important;
            box-shadow: none !important;
        }

        .cardno_datatable .dataTables_length {
            text-align: right !important;
            margin-bottom: 15px;
            display: none;
        }

        .EpochSummary_infoPanel{
            color: #fff;
            margin-left: 60px;
        }

        .EpochSummary_infoRow {
            align-items: center;
            display: flex;
            font-size: 12px;
            letter-spacing: .6px;
            line-height: 1.33;
            margin-bottom: 10px;
        }

        .EpochSummary_infoLabel{
            width: 130px;
            font-weight: 600;
        }

        .Epoch_Summary_container{
            display: flex;
        }

        .lft_EpochDetails{
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .num_box{
            width: 120px;
            height: 120px;
            border: 1px solid cyan;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .epoch_txt{
            font-size: 14px;
            color: darkgrey;
        }

        .epoch_num{
            font-size: 30px;
            color: #fff;
        }
        .cardo_logo{
            width: 150px;
            filter: grayscale(1)invert(1);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 main_page">
                <div class="top_section">
                    <div class="svg_logo_div">
                        <!-- <svg class="Header_logo__3Q2fX" xmlns="http://www.w3.org/2000/svg" width="244" height="224"
                            viewBox="0 0 244 224">
                            <path fill="#FFF" fill-rule="evenodd"
                                d="M128.517 7.096c-.213 3.707-3.408 6.536-7.134 6.328-3.73-.211-6.579-3.386-6.369-7.088.212-3.704 3.408-6.536 7.136-6.325 3.729.208 6.577 3.383 6.367 7.085zm88.179 58.06c-3.337 1.667-7.4.335-9.08-2.977-1.683-3.312-.34-7.351 2.995-9.02 3.333-1.668 7.398-.338 9.079 2.974 1.68 3.315.336 7.354-2.994 9.023zm-6.516 104.902c-3.124-2.035-3.996-6.202-1.946-9.303 2.043-3.098 6.235-3.967 9.358-1.933a6.695 6.695 0 0 1 1.949 9.3c-2.053 3.104-6.243 3.968-9.361 1.936zm-95.392 46.84c.212-3.703 3.408-6.536 7.133-6.324 3.729.208 6.577 3.386 6.367 7.087-.21 3.707-3.408 6.537-7.134 6.328-3.73-.21-6.579-3.383-6.366-7.09zm-87.486-58.054c3.336-1.67 7.401-.337 9.079 2.972 1.68 3.315.34 7.354-2.994 9.023-3.331 1.67-7.399.338-9.077-2.975-1.68-3.312-.342-7.35 2.992-9.02zM33.82 53.942c3.121 2.035 3.993 6.197 1.946 9.298-2.048 3.104-6.237 3.967-9.361 1.933-3.121-2.032-3.993-6.197-1.946-9.298 2.048-3.1 6.237-3.967 9.361-1.933zm97.677-7.298c-.303 5.291-4.868 9.338-10.191 9.037-5.326-.302-9.4-4.837-9.096-10.126.304-5.294 4.865-9.336 10.189-9.037 5.329.3 9.4 4.837 9.098 10.126zm52.218 40.85c-4.766 2.383-10.57.482-12.97-4.253-2.401-4.732-.486-10.5 4.277-12.883 4.763-2.386 10.57-.483 12.973 4.25 2.398 4.729.48 10.5-4.28 12.886zm-9.499 65.354c-4.456-2.907-5.704-8.856-2.779-13.287 2.923-4.428 8.914-5.665 13.37-2.764 4.463 2.91 5.708 8.859 2.783 13.287-2.928 4.433-8.911 5.667-13.374 2.764zm-62.409 24.503c.304-5.292 4.868-9.333 10.192-9.034 5.326.301 9.399 4.836 9.093 10.128-.301 5.289-4.863 9.336-10.192 9.032-5.326-.3-9.394-4.834-9.093-10.126zM60.285 136.51c4.763-2.388 10.57-.482 12.97 4.247 2.401 4.733.483 10.504-4.28 12.89-4.763 2.382-10.567.476-12.97-4.253-2.398-4.735-.48-10.501 4.28-12.884zm9.496-65.354c4.46 2.901 5.704 8.851 2.776 13.282-2.92 4.433-8.908 5.67-13.368 2.76-4.46-2.903-5.707-8.85-2.779-13.283 2.923-4.431 8.908-5.668 13.37-2.759zm114.781-56.79c-1.609 2.437-4.904 3.117-7.354 1.518a5.261 5.261 0 0 1-1.529-7.31 5.332 5.332 0 0 1 7.354-1.515 5.261 5.261 0 0 1 1.53 7.306zm53.824 102.647c-2.93-.162-5.171-2.657-5.003-5.568.168-2.91 2.677-5.133 5.608-4.971 2.93.164 5.168 2.66 5 5.571-.168 2.91-2.677 5.135-5.605 4.968zm-62.563 97.639a5.262 5.262 0 0 1 2.35-7.088c2.622-1.313 5.815-.266 7.137 2.336 1.32 2.602.265 5.774-2.354 7.085-2.621 1.313-5.814.266-7.133-2.333zm-116.385-5.015c1.609-2.438 4.9-3.118 7.354-1.52a5.254 5.254 0 0 1 1.523 7.308c-1.606 2.435-4.898 3.12-7.351 1.519a5.258 5.258 0 0 1-1.526-7.307zM5.614 106.986c2.928.167 5.166 2.656 5 5.568-.165 2.909-2.68 5.135-5.607 4.97-2.928-.166-5.166-2.661-4.998-5.568.165-2.912 2.677-5.135 5.605-4.97zM68.177 9.35c1.32 2.602.263 5.777-2.354 7.087-2.621 1.31-5.811.266-7.133-2.339a5.259 5.259 0 0 1 2.351-7.084c2.622-1.314 5.812-.266 7.136 2.336zm103.556 32.967c-2.484 3.767-7.573 4.82-11.364 2.353-3.79-2.474-4.85-7.53-2.363-11.297 2.487-3.77 7.578-4.817 11.367-2.347 3.792 2.47 4.846 7.527 2.36 11.291zm35.872 77.637c-4.531-.255-7.989-4.11-7.732-8.604.26-4.502 4.136-7.94 8.662-7.685 4.529.258 7.992 4.113 7.733 8.612-.257 4.491-4.137 7.935-8.663 7.677zm-49.737 69.68c-2.042-4.025-.41-8.924 3.635-10.953 4.054-2.03 8.988-.411 11.027 3.614 2.037 4.022.414 8.927-3.637 10.95-4.048 2.027-8.985.412-11.025-3.61zm-85.604-7.956c2.487-3.765 7.573-4.818 11.365-2.345 3.789 2.468 4.851 7.524 2.365 11.291-2.487 3.767-7.576 4.818-11.367 2.347-3.792-2.47-4.849-7.526-2.363-11.293zm-35.872-77.632c4.529.255 7.99 4.107 7.732 8.607-.256 4.496-4.136 7.934-8.665 7.68-4.523-.261-7.986-4.11-7.73-8.607.26-4.5 4.137-7.938 8.663-7.68zm49.737-69.68c2.042 4.022.414 8.927-3.637 10.95-4.049 2.03-8.983.41-11.022-3.61-2.042-4.023-.411-8.928 3.634-10.957 4.049-2.023 8.986-.405 11.025 3.617zm55.146 60.597a16.46 16.46 0 0 1-9-2.676c-7.575-4.938-9.694-15.075-4.727-22.604 3.05-4.617 8.188-7.375 13.754-7.375 3.201 0 6.312.926 8.997 2.678 7.575 4.93 9.697 15.075 4.73 22.604-3.05 4.614-8.188 7.373-13.754 7.373zm19.463 33.277c-.314 0-.632-.011-.946-.028-9.046-.51-15.984-8.239-15.47-17.226.51-8.944 8.24-15.895 17.338-15.368a16.326 16.326 0 0 1 11.323 5.429 16.141 16.141 0 0 1 4.145 11.798c-.494 8.63-7.694 15.395-16.39 15.395zm-19.295 33.365c-6.242 0-11.87-3.441-14.678-8.98a16.095 16.095 0 0 1-.93-12.458c1.374-4.146 4.288-7.507 8.207-9.47a16.556 16.556 0 0 1 7.384-1.747c6.246 0 11.872 3.44 14.684 8.982 4.076 8.04.812 17.877-7.28 21.924a16.57 16.57 0 0 1-7.387 1.749zm-38.745.082a16.44 16.44 0 0 1-8.997-2.673c-3.673-2.391-6.187-6.06-7.078-10.329a16.12 16.12 0 0 1 2.346-12.272c3.046-4.623 8.19-7.378 13.75-7.378 3.202 0 6.315.927 9.003 2.679a16.217 16.217 0 0 1 7.075 10.325c.897 4.27.061 8.629-2.345 12.275-3.05 4.618-8.188 7.373-13.754 7.373zm-19.414-33.274c-.312 0-.627-.011-.947-.028-9.04-.515-15.984-8.242-15.47-17.227.516-8.949 8.237-15.9 17.338-15.373 9.05.513 15.987 8.24 15.474 17.224-.497 8.64-7.697 15.404-16.395 15.404zm19.29-33.363c-6.251 0-11.875-3.443-14.684-8.982-4.076-8.042-.812-17.876 7.28-21.929a16.627 16.627 0 0 1 7.381-1.746c6.248 0 11.872 3.438 14.684 8.982 4.076 8.036.812 17.874-7.28 21.926a16.593 16.593 0 0 1-7.381 1.75z">
                            </path>
                        </svg> -->
                       <img src="{{ url('/')}}/LogoTime Blockchain.png" class="img-fluid cardo_logo">
                    </div>
                    <div class="top_sec_tile my-4">
                        TIME <span class="main_txt">BLOCKCHAIN EXPLORER</span>
                    </div>
                </div>
                <!-- -------- -->
               <!--  <div class="search_div">
                    <div class="search_txt">Search</div>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search"
                            placeholder="Search for epochs, blocks, addresses and transactions" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit"><i
                                class="fas fa-caret-right"></i></button>
                    </form>
                </div> -->

                <!-- ------------------ -->

                <div class="list_div my-4">
                    <div class="line"></div>
                    <div class="list_head_name">Epoch Summary</div>

                    <div class="Epoch_Summary_container">
                        <div class="lft_EpochDetails">
                            <div class="num_box">
                                <span class="epoch_txt">Epochs</span>
                                <span class="epoch_num">{{$explore_detail->id}}</span>
                            </div>
                        </div>
                        <div class="right_EpochDetails">
                            <div class="EpochSummary_infoPanel">
                                <div class="EpochSummary_infoRow">
                                    <div class="EpochSummary_infoLabel"># of blocks</div>
                                    <div class="EpochSummary_infoVal">{{$block}}</div>
                                </div>
                                <div class="EpochSummary_infoRow">
                                    <div class="EpochSummary_infoLabel"># of slots</div>
                                    <div class="EpochSummary_infoVal">{{$block}}</div>
                                </div>
                                <div class="EpochSummary_infoRow">
                                    <div class="EpochSummary_infoLabel">Started at</div>
                                    <div class="EpochSummary_infoVal">{{$explore_detail->created_at}}</div>
                                </div>
                                <div class="EpochSummary_infoRow">
                                    <div class="EpochSummary_infoLabel">Last Block at</div>
                                    <div class="EpochSummary_infoVal">{{date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($explore_detail->created_at)) . " + 5day"))}}</div>
                                </div>
                                <div class="EpochSummary_infoRow">
                                    <div class="EpochSummary_infoLabel">Transactions</div>
                                    <div class="EpochSummary_infoVal">{{$transaction}}</div>
                                </div>
                                <div class="EpochSummary_infoRow">

                                    <div class="EpochSummary_infoLabel">IPFS</div>
                                    
                                    <div class="EpochSummary_infoVal">
                                        <?php
                                            if($explore_detail->type == 'ipfs' || $explore_detail->type == 'ft_ipfs'){
                                                $ipfs = explode('https://ipfs.io/',$explore_detail->csm_amount);

                                                if(!empty($ipfs[1])){ ?>
                                                    
                                                    <a href="<?php echo 'https://ipfs.io/'.$ipfs[1]; ?>" target="_blank"><?php echo $ipfs[1]; ?></a>
                                             <?php   }else{
                                                    echo '-';
                                                }
                                            }elseif($explore_detail->type == 'nft'){
                                                echo $explore_detail->csm_amount.' CSM';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                 <div class="list_div my-4">
                    <div class="line"></div>
                    <div class="list_head_name">Transactions</div>

                    <div class="Epoch_Summary_container">
                       <?php
                        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                            // Output: 54esmdr0qf
                       ?>

                       <?php
                            if($explore_detail->user_id == auth()->user()->id)
                            {
                                if(!empty(auth()->user()->daedalus_wallet)){
                                    $from_address = auth()->user()->daedalus_wallet;
                                }else{
                                    $from_address = '-';
                                }
                            }else{
                                $from_id = \App\User::where(['id' => $explore_detail->user_id])->first();

                                if(!empty($from_id->daedalus_wallet)){
                                    $from_address = $from_id->daedalus_wallet;
                                }else{
                                    $from_address = '-';
                                }
                            }

                            $to_id = \App\User::where(['id' => $explore_detail->to_id])->first();
                            if(!empty($to_id->daedalus_wallet)){
                                $to_address = $to_id->daedalus_wallet;
                            }else{
                                $to_address = '-';
                            }

                            if(!empty($explore_detail->transaction_id)){
                                $transaction_id = $explore_detail->transaction_id;
                            }else{
                                $transaction_id = '-';
                            }
                        ?>
                        <div class="right_EpochDetails">
                            <div class="EpochSummary_infoPanel">
                                <div class="EpochSummary_infoRow">
                                    <div class="EpochSummary_infoLabel">Received Time</div>
                                    <div class="EpochSummary_infoVal">
                                       {{ Carbon\Carbon::parse($explore_detail->created_at)->diffForHumans()}}
                                       ({{$explore_detail->created_at}} UTC) 
                                    </div>
                                </div>
                                <div class="EpochSummary_infoRow">
                                    <div class="EpochSummary_infoLabel">Transaction ID</div>
                                    <div class="EpochSummary_infoVal">{{$transaction_id}}</div>
                                </div>
                                <div class="EpochSummary_infoRow">
                                    <div class="EpochSummary_infoLabel">From addresses</div>
                                    <div class="EpochSummary_infoVal">{{$from_address}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          <!-- <?php

                                                if($explore_detail->type != 'ipfs' || $explore_detail->type != 'ft_ipfs'){
                                                    echo $explore_detail->csm_amount.' CSM';
                                                }
                                            ?> -->
                                        <?php
                                            if($explore_detail->type == 'ipfs' || $explore_detail->type == 'ft_ipfs'){
                                                $ipfs = explode('https://ipfs.io/',$explore_detail->csm_amount);

                                                if(!empty($ipfs[1])){
                                                    echo $ipfs[1];
                                                }else{
                                                    echo '-';
                                                }
                                            }elseif($explore_detail->type == 'nft'){
                                                echo $explore_detail->csm_amount.' CSM';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="EpochSummary_infoRow">
                                    <div class="EpochSummary_infoLabel">To addresses</div>
                                    <div class="EpochSummary_infoVal">
                                        {{$to_address}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/global/cardano/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('assets/global/cardano/js/jquery-data-table-min.js') }}"></script>
    <script src="{{ asset('assets/global/cardano/js/data-table-bootstrap5-min.js') }}"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
        crossorigin="anonymous"></script> -->
    <script src="{{ asset('assets/global/cardano/js/jquery-3.5.1.js') }} /assets/js/bootstrap-bundle.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
</body>

</html>