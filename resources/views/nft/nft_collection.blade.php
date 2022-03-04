@extends('layouts.nft')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('nft.nft_collection')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE TITLE-->
@endsection
<style>
    .alpha_card_game {
        display: inline-block;
        width: 100%;
        padding: 5px 20px;
        margin: 15px 0;
        background: #fff;
        box-shadow: 0 0 10px 0 rgb(0 0 0 / 20%);
        border-radius: 5px !important;
        overflow: hidden;
    }
    .alpha_card_game_hdng h4 {
        font-size: 18px;
        font-weight: 600;
        color: #33bee7;
    }
    .alpha_card_game_img {
        overflow: hidden;
        margin-bottom: 10px;
        border: 1px solid #ddd;
    }
    .alpha_card_game_img img {
        margin: auto;
        display: block;
        height: 180px;
        width: auto;
    }
    .alpha_card_game_bottom {
        margin: 10px auto;
    }
    .price_alp_gm {
        width: 100%;
        font-size: 16px;
        color: #2b3643;
        background: #fff;    
        font-weight: 600;
        border: 1px solid #2b3643;
        border-radius: 25px !important;
        text-align: center;
        padding: 2px;
        display: inline-block;
        font-weight: 600;
    }
    .alpha_card_game_hdng {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .delete_btn_gm {
        margin-left: auto;
        text-decoration: none !important;
        color: #fff !important;
        border: 1px solid #f11515;
        background: #f11515;
        padding: 2px 20px;
        border-radius: 25px !important;
        margin-bottom: 20px;
    }
</style>
@section('contents')
    <div class="row">
        <!-- 
        <div class="col-md-12 col-sm-12">
            <h3>{{trans('nft.nft_collection')}}</h3><hr>

            <form method="POST" action="{{ route('nft.add_nft') }}" data-parsley-validate enctype="multipart/form-data"/>
                {{ csrf_field() }}

                <div class="card-widget white">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card-widget white">
                                @php $user=auth()->user(); @endphp

                                <div class="row margin-top-20">
                                    <div class="col-md-6">
                                        <h6 style="display: inline-block;" id="left-code">{{trans('nft.select_img')}}</h6>

                                         <img width="100" id="img_add" name="nft_img">

                                        <input type='file' name="nft_img" id="imgadd" class="upload" required data-parsley-required data-parsley-required-message="@lang('message.select img')"/>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-block btn-primary">{{trans('nft.submit')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div> -->
	   				
	
        <div class="col-md-12 col-sm-12">

           

            <hr>
                <div  style="display: flex;">
                    <h3 style="margin:10px;">{{trans('nft.nft_list')}}</h3>
                    <div class="" style="margin-left: auto;">
                        <a href="{{ route('nft.mint') }}" class="nav-link" style="margin-left: 25px; border:1px solid blue; border-radius:25px !important; padding:2px 15px;">Add NFT</a>
                        
                        <a href="{{ route('nft.nft_delete') }}" class="nav-link" style="float: right; color: red; margin-left: 25px; border:1px solid red; border-radius:25px !important; padding:2px 15px;">Delete All</a>
                    </div>
                </div>
        

            <hr>

            <div class="row">
                
                <label>Note : 1 CSM = {{$bnb_csm->bnb}} BNB</label>

                <div class="alp_games_cards">
                    @foreach($nft as $v)
                        <div class="col-md-3">
                            <div class="alpha_card_game">    
                                <div class="alpha_card_game_hdng">
                                    <a href="{{ route('nft.nft_detail', encrypt($v['id'])) }}" class="alpa-name_gm">
                                        <h4>{{$v['name']}}</h4>
                                    </a>
                                    @php 
                                        $check_user_item = \App\UserBuyPack::where(['pack_id' => $v['id']])->first();
                                    @endphp
                                    @if($v['user_id'] == auth()->user()->id || empty($check_user_item))
                                        <a href="{{ route('nft.delete', encrypt($v['id'])) }}" class="delete_btn_gm" style="color:#fff !important;">
                                            <h4>Delete</h4>
                                        </a>
                                    @endif
                                </div>    
                                <div class="alpha_card_game_img">
                                    <?php
                                        $img = explode('/home/anandisha/public_html/alpha_game_code/public/nft_item/',$v['nft_img']);

                                        if(!empty($img[1])){
                                            $img = $img[1];
                                        }else{
                                            $img = $img[0];
                                        }
                                    ?>
                                    <img width="100" name="nft_img img-responsive" src="{{ url('/')}}/nft_item/{{$img}}">

                                </div>    
                                <div class="alpha_card_game_bottom">
                                    <ul class="list-inline">
                                        <li class="price_alp_gm"> 
                                            <!-- <img width="20" name="nft_img img-responsive" src="{{ url('/')}}/nft_item/add_symbol.png">  -->
                                             <!-- {{$v['price']}} CSM -->
                                             {{$v['csm_price']}} CSM
                                        </li>

                                        <?php
                                            $csm_price = $v['csm_price'];
                                            $bnb_price = $bnb_csm->bnb;

                                            $final_bnb = $bnb_price * $csm_price;
                                        ?>
                                        <input type="hidden" name="bnb_price" value="{{$final_bnb}}">
                                    </ul>
                                </div>
                            </div>   
                        </div>
                    @endforeach    
                </div>
            </div>
             {{ $nft->links() }}
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

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script type="text/javascript">
	$('#leftLink').click(function(){
		addthis.update('share', 'url', "{{ url(Config::get('app.locale').'/register?referral-code=').$user->referral }}");
		addthis.url = "{{ url(Config::get('app.locale').'/register?referral-code=').$user->referral }}";   
		$(this).hide();
		$('#leftShare').show();     
		          
	});						
</script>
@endpush
