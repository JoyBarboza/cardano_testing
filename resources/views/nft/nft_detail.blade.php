@extends('layouts.nft')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>
                <?php 
                    if(Request::segment(3) == 'ft_detail'){
                        echo 'FT Detail';
                    }else{
                        echo 'NFT Detail';
                    }
                ?>
            </span>
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
        margin-left: auto;
        border: 1px solid #ddd;
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
            <h3>
                <?php 
                    if(Request::segment(3) == 'ft_detail'){
                        echo 'FT Detail';
                    }else{
                        echo 'NFT Detail';
                    }
                ?>
            </h3><hr>

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
                
            <form method="POST" action="{{ route('nft.change_setting') }}" enctype="multipart/form-data" data-parsley-validate>
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                <div class="card-widget white">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card-widget white mint_form">
                                <div class="row margin-top-20">
                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">{{trans('nft.mint_name')}}</h6>

                                        <!-- <input type='text' name="name" id="name" value="{{$nft_detail->name}}" readonly/> -->
                                        <label>{{$nft_detail->name}}</label>
                                    </div>         

                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">{{trans('nft.mint_price')}}</h6>

                                        <!-- <input type='text' name="price" id="price" value="{{$nft_detail->price}}" readonly/> -->
                                        <label>{{$nft_detail->price}} CSM</label>
                                    </div>   

                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">Royality Price</h6>

                                        <!-- <input type='text' name="price" id="price" value="{{$nft_detail->price}}" readonly/> -->
                                        <label>{{$nft_detail->royalty}} CSM</label>
                                    </div> 

                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">{{trans('nft.mint_descripition')}}</h6>

                                        <!-- <textarea readonly>{{$nft_detail->descripition}}</textarea> -->
                                        <label>{{$nft_detail->descripition}}</label>
                                    </div>   

                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">{{trans('nft.ipfs_url')}}</h6>

                                        <!-- <input type='text' name="ipfs_url" id="ipfs_url" value="{{$nft_detail->ipfs_url}}" readonly /> -->
                                        <label>{{$nft_detail->ipfs_url}}</label>
                                        <!-- <button type="button" id="hash" name="hash" onclick="download()">Download</button> -->
                                    </div> 

                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">Image</h6>
                                        <?php
                                            $img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$nft_detail->nft_img);

                                            if(!empty($img[1])){
                                                $img = $img[1];
                                            }else{
                                                $img = $img[0];
                                            }
                                        ?>
                                        <img width="100" name="nft_img img-responsive" src="{{ url('/')}}/nft_item/{{$img}}">
                                    </div>                          
                                </div>
                                 <!-- <div class="col-md-12">
                                    <button type="submit" class="btn mint_submit btn-block btn-primary">{{trans('nft.submit')}}</button>
                                </div> -->

                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
                
    </div>
@endsection
@push('css')
<link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
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
