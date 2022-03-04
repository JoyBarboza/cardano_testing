@extends('layouts.master')
@section('page-content')
<style>
    /*.alpha_card_game {
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
    }*/
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
<main>
  <section>
    <div class="rows">

        
            <h1 class="main_heading">Market Place</h1>
            <label style="color: black;">Note : 1 CSM = {{$bnb_csm->bnb}} BNB</label>
            <!-- <hr>
                <div  style="display: flex;">
                    <h3 style="margin:10px;" class="main_heading">Market Place</h3>
                    <div class="" style="margin-left: auto;">
                        
                        <a href="{{ route('nft.nft_delete') }}" class="nav-link" style="float: right; color: red; margin-left: 25px; border:1px solid red; border-radius:25px !important; padding:2px 15px;">Delete All</a>
                    </div>
                </div>
                    
            <hr> -->
            <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                <div class="card-widget white">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card-widget white mint_form">
                                <div class="row margin-top-20">
                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;color: black;" id="left-code">{{trans('nft.mint_name')}}</h6>
                                        <label style="display: inline-block;color: black;">{{$nft_detail->name}}</label>
                                    </div>         

                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;color: black;" id="left-code">{{trans('nft.mint_price')}}</h6>
                                        <label style="display: inline-block;color: black;">{{$nft_detail->price}} CSM</label>
                                    </div>   

                                    <!-- <div class="col-md-12">
                                        <h6 style="display: inline-block;color: black;" id="left-code">Royality Price</h6>
                                        <label style="display: inline-block;color: black;">{{$nft_detail->royalty}} CSM</label>
                                    </div>  -->

                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;color: black;" id="left-code">{{trans('nft.mint_descripition')}}</h6>

                                        <label style="display: inline-block;color: black;">{{$nft_detail->descripition}}</label>
                                    </div>   

                                    <!-- <div class="col-md-12">
                                        <h6 style="display: inline-block;color: black;" id="left-code">{{trans('nft.ipfs_url')}}</h6>
                                        <label style="display: inline-block;color: black;">{{$nft_detail->ipfs_url}}</label>
                                    </div>  -->

                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;color: black;" id="left-code">Image</h6>
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
                                 <div class="col-md-12">
                                    <!-- <button type="submit" class="btn mint_submit btn-block btn-primary">{{trans('nft.submit')}}</button> -->
                                    <!-- <button type="submit" class="btn mint_submit btn-block btn-primary" onclick="resellNft();">Resell NFT</button> -->
                                </div>
                                                
                                <input type="hidden" name="token_id" value="{{$nft_detail->token_id}}" id="token_id">
                                <input type="hidden" name="type" value="{{$nft_detail->type}}" id="type">
                                <input type="hidden" name="nft_id" value="{{$nft_detail->id}}" id="nft_id">

                                <a href="{{ route('presale.user_nft') }}" class="nav-link" style="float: right; color: red; margin-left: 25px; border:1px solid red; border-radius:25px !important; padding:2px 15px;">Back</a>
                            </div>
                        </div>

                    </div>
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

            var nft_id= $('#nft_id').val();
            console.log('nft_id',nft_id);

            var token_id= $('#token_id').val();
            console.log('token_id',token_id);

            var name= $('#name').val();
            console.log('name',name);

            var price= $('#price').val();
            console.log('price',price);

            var type= $('#type').val();
            console.log('type',type);

            var nft_id= $('#nft_id').val();
            console.log('nft_id',nft_id);
            
            var transactionHash = 'fdgfdgdfgfd';

            // $.ajax({
            //     url: "{{ route('presale.resell_nft.post') }}",
            //     type: "POST",
            //     headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            //    },
            //    data :{
            //        name : name,
            //        type : type,
            //        price : price,
            //        transaction_id : transactionHash,
            //        tokenId : token_id,
            //    },
            //     success: function (response) 
            //     {
            //         console.log(response);
                     
            //         // if(response == 200){
            //         //     toastr.success('You mint nft successfully');
            //         //     // var url = "https://anandisha.com/alpha_game_code/public/en/nft/nft_collection";
            //         //     // // $(location).attr('href', url); // Using this
            //         //     // // window.location.replace(url);
            //         //     // window.location = "https://anandisha.com/alpha_game_code/public/en/nft/nft_collection";
            //         //     // window.location.href = 'https://anandisha.com/alpha_game_code/public/en/nft/nft_collection';
            //         //     // window.location.href = "https://www.geeksforgeeks.org/";

            //         //     $(location).prop('href', 'http://stackoverflow.com')
            //         //     // setTimeout(function(){
            //         //     //     window.location = "https://anandisha.com/alpha_game_code/public/en/nft/nft_collection";
            //         //     // },1000)

            //         // }else{
            //         //   toastr.error('Something went wrong'); 
            //         //     // location.reload();
            //         // }
            //     }
            // });
            
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
