@extends('layouts.master')
@section('page-content')
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
    .mint_submit {
        margin: 15px auto;
        display: block;
        width: 250px !important;
        font-size: 17px !important;
    }
    .modal.fade .modal-dialog {
    margin-top: 12%;
}
.modal-title{
    color:#111;
}
h6{
    width:25%;
}
</style>
<main>
  <section>
    <div class="rows ">
        
            <div class="col-md-12">
                <h3 class="main_heading">My NFT</h3>
            </div>

            <div class="">

                <div class="row">
                   <div class="col-md-12">
                    <label style="color: black;">Note : 1 CSM = {{$bnb_csm->bnb}} BNB</label>
                        <div class="alp_games_cards ">
                           <!--  <div class="col-md-3"> -->
                            
                        @foreach($my_nft as $v)
                        <div class="col-md-3 ">
                                <div class="alpha_card_game ">    
                                    <div class="alpha_card_game_hdng">
                                        <a href="{{ route('presale.mynfT_detail', encrypt($v['pack_id'])) }}" class="alpa-name_gm">
                                            <h4>{{$v['name']}}</h4>
                                        </a>
                                        @php 
                                            $check_user_item = \App\UserBuyPack::where(['pack_id' => $v['id']])->first();
                                        @endphp
                                        
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
                                            <li class="price_alp_gm" style="display: flex;justify-content: space-between;align-items: center">
                                                <div style="padding: 5px; word-break: break-all;">
                                                             <!-- {{$v['price']}} CSM -->
                                                             {{$v['csm_price']}} CSM
                                                </div> 
                                                <!-- {{$v['type']}} -->


                                                @if($v['type'] == 3)
                                                    <?php
                                                        $csm_price = $v['csm_price'];
                                                        $bnb_price = $bnb_csm->bnb;

                                                        $final_bnb = $bnb_price * $csm_price;
                                                    ?>

                                                    <div style="padding: 5px">
                                                        <a style="background-color: dodgerblue; color: #fff;padding: 5px 10px;border-radius: 12px;" class="btn btn-primary edit_category" title="edit" href="javascript:void(0);" data-id="{{$v['pack_id']}}" data-token_id="{{$v['token_id']}}" data-nft_img="{{$img}}" data-name="{{$v['name']}}" data-descripition="{{$v['descripition']}}" data-price="{{$final_bnb}}" data-final_bnb="{{$v['csm_price']}}" data-ipfs_url="{{$v['ipfs_url']}}" data-royalty="{{$v['royalty']}}" data-type="{{$v['type']}}">Resell</a>
                                                    </div>
                                                @endif
                                                <input type="hidden" name="transaction_id" value="" id="transaction_id">
                                            </li>
                                        </ul>
                                    </div>
                                </div>  
                            </div> 
                        @endforeach  
                           

                         </div>   
                    </div>
                </div>
                 {{ $my_nft->links() }}
            </div>



  </section>

  <div id="resellNftModel" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Title</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                  <div class="card-widget white mint_form">
                    <div class="container">
                    <div class="row margin-top-20">
                        <div class="col-md-12 my-2">
                            <div class="d-flex">
                                    <h6 style="display: inline-block;color: black;" id="left-code">{{trans('nft.mint_name')}}</h6>

                            <input type='text' class="form-control ml-2" name="name" id="name" value="" readonly="" />
                            </div>
                        </div>         

                        <div class="col-md-12 my-2">
                            <div class="d-flex">
                                <h6 style="display: inline-block;color: black;" id="left-code">{{trans('nft.mint_price')}} CSM</h6>

                            <input type='hidden' class="form-control ml-2" name="price" id="price" value=""/>
                            <input type='text' class="form-control ml-2" name="final_bnb" id="final_bnb" value=""/>
                            </div>
                        </div>   

                        <!-- <div class="col-md-12 my-2"> -->
                            <!-- <div class="d-flex"> -->
                                  <!-- <h6 style="display: inline-block;color: black;" id="left-code">Royality Price</h6> -->
                            <!-- <label style="display: inline-block;color: black;"></label> -->
                            <input type='hidden' class="form-control ml-2" name="royalty" id="royalty" value="" readonly />
                            <!-- </div> -->
                        <!-- </div>  -->

                        <div class="col-md-12 my-2">
                            <div class="d-flex">
                                <h6 style="display: inline-block;color: black;" id="left-code">{{trans('nft.mint_descripition')}}</h6>

                            <textarea name="descripition" class="form-control ml-2" id="descripition" readonly></textarea>
                            </div>
                        </div>   

                        <!-- <div class="col-md-12 my-2">
                          <div class="d-flex">
                                <h6 style="display: inline-block;color: black;" id="left-code">{{trans('nft.ipfs_url')}}</h6>

                            <input type='text' class="form-control ml-2" name="ipfs_url" id="ipfs_url" value="" readonly />
                          </div>
                        </div>  -->

                        <div class="col-md-12 my-2">
                            <h6 style="display: inline-block;color: black;" id="left-code">Image</h6>
                            <!-- <img width="100" name="nft_img img-responsive" src=""> -->
                            <img width="100" id="img_tag" name="img">
                        </div>                          
                    </div>
                </div>

                    <input type="hidden" name="token_id" value="" id="token_id">
                    <input type="hidden" name="type" value="" id="type">
                    <input type="hidden" name="nft_id" value="" id="nft_id">
                </div>
                       
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="resellNft();">Resell NFT</button>
                </div>
            </div>
        </div>
    </div>
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

    $(document).on('click','.edit_category', function() { 
        var id = $(this).data('id'); 
        var token_id = $(this).data('token_id'); 
        var name = $(this).data('name'); 
        var price = $(this).data('price'); 
        var final_bnb = $(this).data('final_bnb'); 
        var ipfs_url = $(this).data('ipfs_url'); 
        var nft_img = $(this).data('nft_img'); 
        var royalty = $(this).data('royalty'); 
        var descripition = $(this).data('descripition'); 
        var type = $(this).data('type'); 
        

        console.log(nft_img)
        var base_url = "<?php echo url('/').'/nft_item/';?>";

        var nftImg = base_url + nft_img;
         
        $('#nft_id').val(id);
        $('#name').val(name);
        $('#price').val(price);
        $('#final_bnb').val(final_bnb);
        $('#royalty').val(royalty);
        $('#type').val(type);
        $('#descripition').val(descripition);
        $('#ipfs_url').val(ipfs_url);
        $('#token_id').val(token_id);
        $('#img_tag').prop('src',nftImg);


        $('#resellNftModel').modal('show');

    });

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

             // return await new window.web3.eth.Contract([ { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "approved", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Approval", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "operator", "type": "address" }, { "indexed": false, "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "ApprovalForAll", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "approve", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "add", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "approvethis", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_bidAmount", "type": "uint256" } ], "name": "bid", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "indexed": false, "internalType": "address", "name": "_buyer", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BoughtNFT", "type": "event" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "BuyBidNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_owner", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BuyNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "mintAuctionLength", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "MintFixedNFT", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "nftSold", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" } ], "name": "resellAuctionNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" } ], "name": "resellNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" }, { "internalType": "bytes", "name": "_data", "type": "bytes" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "operator", "type": "address" }, { "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "setApprovalForAll", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "from", "type": "address" }, { "indexed": true, "internalType": "address", "name": "to", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Transfer", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "transferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "_tokenApprovals", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" } ], "name": "balanceOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "getApproved", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "HighestBiderAddress", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "imageData", "outputs": [ { "internalType": "string", "name": "Artwork_name", "type": "string" }, { "internalType": "string", "name": "Artwork_type", "type": "string" }, { "internalType": "address", "name": "Author", "type": "address" }, { "internalType": "string", "name": "Artwork_description", "type": "string" }, { "internalType": "string", "name": "Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "Royalty", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "images", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "operator", "type": "address" } ], "name": "isApprovedForAll", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "name", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "ownerOf", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "bytes4", "name": "interfaceId", "type": "bytes4" } ], "name": "supportsInterface", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "symbol", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenOfOwnerByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "tokenURI", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalSupply", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" } ], '0xb079120b0eb13f204752887a50f7327d51c15d5f');

             return await new window.web3.eth.Contract([ { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "approved", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Approval", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "operator", "type": "address" }, { "indexed": false, "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "ApprovalForAll", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "approve", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "add", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "approvethis", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_bidAmount", "type": "uint256" } ], "name": "bid", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "indexed": false, "internalType": "address", "name": "_buyer", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BoughtNFT", "type": "event" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "BuyBidNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_owner", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BuyNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "mintAuctionLength", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "MintFixedNFT", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "nftSold", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" } ], "name": "resellAuctionNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" } ], "name": "resellNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" }, { "internalType": "bytes", "name": "_data", "type": "bytes" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "operator", "type": "address" }, { "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "setApprovalForAll", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "from", "type": "address" }, { "indexed": true, "internalType": "address", "name": "to", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Transfer", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "transferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "_tokenApprovals", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" } ], "name": "balanceOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "getApproved", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "HighestBiderAddress", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "imageData", "outputs": [ { "internalType": "string", "name": "Artwork_name", "type": "string" }, { "internalType": "string", "name": "Artwork_type", "type": "string" }, { "internalType": "address", "name": "Author", "type": "address" }, { "internalType": "string", "name": "Artwork_description", "type": "string" }, { "internalType": "string", "name": "Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "Royalty", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "images", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "operator", "type": "address" } ], "name": "isApprovedForAll", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "name", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "ownerOf", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "bytes4", "name": "interfaceId", "type": "bytes4" } ], "name": "supportsInterface", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "symbol", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenOfOwnerByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "tokenURI", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalSupply", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" } ], '0xb1355baA92f0b01Fc1f968cb12c6D24c5457d801');
        }

        async function getCurrentAccount() {
            const accounts = await window.web3.eth.getAccounts();
            return accounts[0];r
        }


        async function resellNft() 
        {
            console.log('resellNft');

            if (ethereum && ethereum.isMetaMask) {
                console.log('Ethereum successfully detected!');
            } else {
                $("#checkMetamask").modal('show');
            }
            
            const account = await getCurrentAccount();
            const receiverAddress = account;

            console.log(receiverAddress);

            var nft_id= $('#nft_id').val();
            console.log('nft_id',nft_id);

            var token_id= $('#token_id').val();
            console.log('token_id',token_id);

            var name= $('#name').val();
            console.log('name',name);

            var price= $('#price').val();
            console.log('price',price);

            var royalty= $('#royalty').val();

            var tokens = web3.utils.toWei(price.toString(), 'ether')

            var weiValue = web3.utils.toBN(tokens)


            var type= $('#type').val();
            console.log('type',type);

            contract.methods.resellNFT(token_id,weiValue,name,type)
                .send({
                  from: receiverAddress,
                  // gas:500000,
                  // value: 5
                  //gasPrice: '210000000'
                }).on('error', function(error){
                    console.log('error');
                    toastr.error('Something went wrong');
                    // location.reload();
                }).then( function( info ) {
                    console.log('success ',info);
                    var transactionHash = info.transactionHash;
                    // var transactionHash = 'fdgdfg';

                    $.ajax({
                        url: "{{ route('presale.resell_nft.post') }}",
                        type: "POST",
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                       },
                       data :{
                           name : name,
                           type : type,
                           price : price,
                           transaction_id : transactionHash,
                           tokenId : token_id,
                           nft_id : nft_id,
                           royalty : royalty,
                       },
                        success: function (response) 
                        {
                            console.log(response);
                             
                            if(response == 200){
                                toastr.success('You resell nft successfully');

                            }else{
                              toastr.error('Something went wrong'); 
                            }
                            location.reload();
                        }
                    });

                    
        
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
