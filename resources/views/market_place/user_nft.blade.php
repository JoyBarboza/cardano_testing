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
</style>
<main>
  <section>
    <div class="rows">
        
            <h1 class="main_heading">Market Place</h1>

            <div class="col-md-12 col-sm-12">
                <label style="color: black;">Note : 1 CSM = {{$bnb_csm->bnb}} BNB</label>
                <div class="row">
                    <div class="alp_games_cards">
                        @foreach($nft as $v)
                            <div class="col-md-3">
                                <div class="alpha_card_game">    
                                    <div class="alpha_card_game_hdng">
                                        <a href="{{ route('presale.mynfT_detail', encrypt($v['id'])) }}" class="alpa-name_gm">
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
                                                <div style="padding: 5px">
                                                    <button style="background-color: dodgerblue; color: #fff;padding: 5px 10px;border-radius: 12px;" onclick="buyNft(<?php echo $v['id']; ?>);">Buy</button>
                                                </div>

                                                <?php
                                                    $csm_price = $v['csm_price'];
                                                    $bnb_price = $bnb_csm->bnb;

                                                    $final_bnb = $bnb_price * $csm_price;
                                                ?>
                                                
                                                <input type="hidden" name="nft_id" value="{{$v['id']}}" id="nft_id_{{$v['id']}}">
                                                <input type="hidden" name="token_id" value="{{$v['token_id']}}" id="token_id_{{$v['id']}}">
                                                <input type="hidden" name="type" value="{{$v['type']}}" id="type_{{$v['id']}}">
                                                <!-- <input type="hidden" name="price" value="{{$v['price']}}" id="price_{{$v['id']}}"> -->
                                                <input type="hidden" name="price" value="{{$final_bnb}}" id="price_{{$v['id']}}">
                                                <input type="hidden" name="royalty" value="{{$v['royalty']}}" id="royalty_{{$v['id']}}">
                                                <input type="hidden" name="owner_address" value="" id="owner_address_{{$v['id']}}">
                                                <input type="hidden" name="transaction_id" value="" id="transaction_id_{{$v['id']}}">
                                            </li>
                                        </ul>
                                    </div>
                                </div>   
                            </div>
                        @endforeach    
                    </div>
                </div>
                 {{ $nft->links() }}
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

      bnb_amount = 0.00003 * csm_amount;
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

             // return await new window.web3.eth.Contract([ { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "approved", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Approval", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "operator", "type": "address" }, { "indexed": false, "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "ApprovalForAll", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "approve", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "add", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "approvethis", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_bidAmount", "type": "uint256" } ], "name": "bid", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "indexed": false, "internalType": "address", "name": "_buyer", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BoughtNFT", "type": "event" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "BuyBidNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_owner", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BuyNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "mintAuctionLength", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "MintFixedNFT", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "nftSold", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" } ], "name": "resellAuctionNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" } ], "name": "resellNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" }, { "internalType": "bytes", "name": "_data", "type": "bytes" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "operator", "type": "address" }, { "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "setApprovalForAll", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "from", "type": "address" }, { "indexed": true, "internalType": "address", "name": "to", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Transfer", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "transferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "_tokenApprovals", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" } ], "name": "balanceOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "getApproved", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "HighestBiderAddress", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "imageData", "outputs": [ { "internalType": "string", "name": "Artwork_name", "type": "string" }, { "internalType": "string", "name": "Artwork_type", "type": "string" }, { "internalType": "address", "name": "Author", "type": "address" }, { "internalType": "string", "name": "Artwork_description", "type": "string" }, { "internalType": "string", "name": "Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "Royalty", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "images", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "operator", "type": "address" } ], "name": "isApprovedForAll", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "name", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "ownerOf", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "bytes4", "name": "interfaceId", "type": "bytes4" } ], "name": "supportsInterface", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "symbol", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenOfOwnerByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "tokenURI", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalSupply", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" } ], '0xb079120b0eb13f204752887a50f7327d51c15d5f');

             return await new window.web3.eth.Contract([ { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "approved", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Approval", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "operator", "type": "address" }, { "indexed": false, "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "ApprovalForAll", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "approve", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "add", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "approvethis", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_bidAmount", "type": "uint256" } ], "name": "bid", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "indexed": false, "internalType": "address", "name": "_buyer", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BoughtNFT", "type": "event" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "BuyBidNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_owner", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BuyNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "mintAuctionLength", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "MintFixedNFT", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "nftSold", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" } ], "name": "resellAuctionNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" } ], "name": "resellNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" }, { "internalType": "bytes", "name": "_data", "type": "bytes" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "operator", "type": "address" }, { "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "setApprovalForAll", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "from", "type": "address" }, { "indexed": true, "internalType": "address", "name": "to", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Transfer", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "transferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "_tokenApprovals", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" } ], "name": "balanceOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "getApproved", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "HighestBiderAddress", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "imageData", "outputs": [ { "internalType": "string", "name": "Artwork_name", "type": "string" }, { "internalType": "string", "name": "Artwork_type", "type": "string" }, { "internalType": "address", "name": "Author", "type": "address" }, { "internalType": "string", "name": "Artwork_description", "type": "string" }, { "internalType": "string", "name": "Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "Royalty", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "images", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "operator", "type": "address" } ], "name": "isApprovedForAll", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "name", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "ownerOf", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "bytes4", "name": "interfaceId", "type": "bytes4" } ], "name": "supportsInterface", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "symbol", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenOfOwnerByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "tokenURI", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalSupply", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" } ], '0xb1355baA92f0b01Fc1f968cb12c6D24c5457d801');
        }

        async function getCurrentAccount() {
            const accounts = await window.web3.eth.getAccounts();
            return accounts[0];r
        }


        async function buyNft(i) 
        {
            console.log(i);

            if (ethereum && ethereum.isMetaMask) {
                console.log('Ethereum successfully detected!');
            } else {
                $("#checkMetamask").modal('show');
            }
            
            console.log('buyNft');

            var nft_id= $('#nft_id_'+i).val();
            console.log('nft_id',nft_id);

            var token_id= $('#token_id_'+i).val();
            console.log('token_id',token_id);

            var nft_type= $('#type_'+i).val();
            console.log('nft_type',nft_type);

            var royalty= $('#royalty_'+i).val();
            console.log('royalty',royalty);
            
            //get owner if token id
            await window.contract.methods.ownerOf(token_id).call(function (err, owner_address) {
                if (err) {
                  console.log("An error occured", err)
                  return
                }
                console.log("The ownerOf is: ", owner_address);

                $('#owner_address_'+i).val(owner_address);
            });


            var owner_address = $('#owner_address_'+i).val();

            var price = $('#price_'+i).val();
            console.log('price',price);


            var tokens = web3.utils.toWei(price.toString(),'ether')

            var weiValue = web3.utils.toBN(tokens)


            console.log('dd',price.toString());
            console.log('dd',tokens);
            console.log('price_bnb',weiValue);



            const account = await getCurrentAccount();
            const receiverAddress = account;
            console.log(receiverAddress);



            contract.methods.BuyNFT(owner_address, token_id,weiValue)
                .send({
                  from: receiverAddress,
                  value: weiValue,
                  gas:500000,
                }).on('error', function(error){
                    console.log('error');
                    toastr.error('Something went wrong');
                    // location.reload();
                }).then( function( info ) {
                    console.log('success ',info);
                    var transactionHash = info.transactionHash;

                    $.ajax({
                        url: "{{ route('presale.buy_nft.post') }}",
                        type: "POST",
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                       },
                       data :{
                           get_transaction_id : transactionHash,
                           nft_id : nft_id,
                           token_id : token_id,
                           owner_address : owner_address,
                           receiverAddress : receiverAddress,
                           
                       },
                        success: function (response) 
                        {
                            console.log(response);
                             
                            if(response == 200){
                                toastr.success('You buy nft successfully');

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
