<?php

namespace App\Http\Controllers\Admin;

// use App\Setting;
// use App\Charge;
// use App\Events\CoinPurchased;
// use App\Presale;
// use App\Transaction;
// use App\Repository\Currency\JPCoin;
// use App\Currency;
// use Carbon\Carbon;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;
// use App\Http\Controllers\Controller;
// use Illuminate\Database\QueryException;
// use App\ConvertCurrency;
// use App\User;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\Presale;
use App\User;
use App\NftItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\ConvertCurrency;
use App\UserBuyPack;
use App\BnbCsmCoveter;

class MarketPlaceController extends Controller
{
    // protected $presale;

    // public function __construct(Presale $presale) {
    //     $this->presale = $presale;
    // }

    public function user_nft()
    {
        $bnb_csm = BnbCsmCoveter::where('id','1')->first();

    	$nft = NftItem::where('type','1')->where('user_id','!=',auth()->user()->id)->orderBy('id', 'DESC')->paginate('8');

        return view('market_place.user_nft',compact('nft','bnb_csm'));
    }

     public function nft_detail($id)
    {
        $id = decrypt($id);

        $nft_detail = NftItem::where('id',$id)->first();
        $bnb_csm = BnbCsmCoveter::where('id','1')->first();

        return view('market_place.nft_detail',compact('nft_detail','bnb_csm'));
    }
    
    public function buy_nft(Request $request)
    {
    	// return $request->all();

    	$getNftDetail = NftItem::where('id',$request->input('nft_id'))->first();
        $getNftDetail->type =  4; 
        $getNftDetail->save();


        $data                =  new NftItem();
        $data->name          =  $getNftDetail->name; 
        $data->descripition  =  $getNftDetail->descripition; 
        $data->price         =  $getNftDetail->price; 
        $data->bnb_price     =  $getNftDetail->bnb_price; 
        $data->csm_price     =  $getNftDetail->csm_price; 
        $data->royalty       =  $getNftDetail->royalty; 
        $data->user_id       =  auth()->user()->id; 
        $data->nft_img       =  $getNftDetail->nft_img; 
        $data->ipfs_url      =  $getNftDetail->ipfs_url; 
        $data->token_id      =  $request->input('token_id'); 
        $data->hash          =  $request->input('get_transaction_id'); 
        $data->type          =  3; 

        

        if($data->save())
        {
            $NftItem_id = $data->id;

            
            $UserBuyPackData                   =  new UserBuyPack();
            $UserBuyPackData->type             =  1; 
            $UserBuyPackData->user_id          =  auth()->user()->id; 
            $UserBuyPackData->pack_id          =  $NftItem_id;
            $UserBuyPackData->account_number   =  $getNftDetail->receiverAddress; 
        
            if($UserBuyPackData->save())
            {
                $convertCurrency = ConvertCurrency::create([
                    'type' => 'buy_nft',
                    'coversion' => 'buy_nft',
                    'user_id' => $getNftDetail->user_id,
                    'to_id' => auth()->user()->id,
                    'usd_amt' => $getNftDetail->price,
                    'eth_amount' => $request->input('token_id'),
                    'transaction_id' => $request->input('transaction_id'),
                    'csm_amount' => $getNftDetail->ipfs_url,
                ]);
                 $status = 200;
                echo json_encode($status);
            }else{
                $status = 400;
                echo json_encode($status);
            }
        }else{
            $status = 400;
            echo json_encode($status);
        }
    }

    public function mynfT()
    {
        $bnb_csm = BnbCsmCoveter::where('id','1')->first();

        $my_nft = UserBuyPack::where('user_buy_packs.type','1')->where('user_buy_packs.user_id', auth()->user()->id)
        ->leftJoin('nft_items', 'user_buy_packs.pack_id', '=', 'nft_items.id')
        ->select( 'user_buy_packs.id',
            'user_buy_packs.type',
            'user_buy_packs.user_id',
            'user_buy_packs.pack_id',
            'nft_items.id as nft_items_id',
            'nft_items.token_id',
            'nft_items.user_id',
            'nft_items.type',
            'nft_items.name',
            'nft_items.nft_img',
            'nft_items.descripition',
            'nft_items.csm_price',
            'nft_items.price',
            'nft_items.royalty',
            'nft_items.ipfs_url')
        ->orderBy('user_buy_packs.id','desc')
        ->paginate('8');

        return view('market_place.my_nft',compact('my_nft','bnb_csm'));
    }

    
    public function mynfT_detail($id)
    {
        $id = decrypt($id);

        $bnb_csm = BnbCsmCoveter::where('id','1')->first();

        $nft_detail = NftItem::where('id',$id)->first();

        return view('market_place.mynfT_detail',compact('nft_detail','bnb_csm'));
    }

    public function resell_nft(Request $request)
    {
        // return $request->all();

        $royalty = $request->input('royalty') / 100;

        $price = $request->input('price') * $royalty;

        $price_royality = $request->input('price') + $price;

        $getNftDetail = NftItem::where('id',$request->input('nft_id'))->first();
        $getNftDetail->type =  1; 
        $getNftDetail->name =  $request->input('name'); 
        $getNftDetail->user_id =  auth()->user()->id; 
        $getNftDetail->price =  $price_royality; 

        if($getNftDetail->save()){
            $convertCurrency = ConvertCurrency::create([
                'type' => 'resell_nft',
                'coversion' => 'resell_nft',
                'user_id' => $getNftDetail->user_id,
                'to_id' => auth()->user()->id,
                'usd_amt' => $price_royality,
                'eth_amount' => $request->input('tokenId'),
                'transaction_id' => $request->input('transaction_id'),
                'csm_amount' => $getNftDetail->ipfs_url,
            ]);
            
            $status = 200;
            echo json_encode($status);
            
        }else{
            $status = 400;
            echo json_encode($status);
        }
    }
}
