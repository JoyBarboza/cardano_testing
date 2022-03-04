<?php
namespace App\Http\Controllers\Nft;

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

class NftController extends Controller
{

    public function nft_collection()
    {
    	$user = auth()->user();

    	$nft = NftItem::where('type','1')->where('user_id',$user->id)->orderBy('id', 'DESC')->paginate('8');

        $bnb_csm = BnbCsmCoveter::where('id','1')->first();

        return view('nft.nft_collection',compact('nft','bnb_csm'));
    }
    
    public function ft_collection()
    {
    	$user = auth()->user();

    	$ft = NftItem::where('type','2')->where('user_id',$user->id)->orderBy('id', 'DESC')->paginate('8');

        return view('nft.ft_collection',compact('ft'));
    }
    
    
    public function ft()
    {
        return view('nft.add_ft');
    }

    public function add_ft(Request $request)
    {
        
        $img = $request->input('img');
        
        $folderPath = public_path('/nft_item/');
        // $folderPath = 'https://anandisha.com/alpha_game_code/public/nft_item/';
        
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() .'.'.$image_type;
        
        // $file_name = uniqid().'.'.$image_type;
        // $file_name = $file.','.$image_base64;
        
        file_put_contents($file, $image_base64);

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $transaction_id = substr(str_shuffle($permitted_chars), 0, 50);

        $data 			     =  new NftItem();
        $data->name          =  $request->input('name'); 
        $data->type          =  2; 
        $data->descripition  =  $request->input('descripition'); 
        $data->price         =  $request->input('price'); 
        $data->user_id       =  auth()->user()->id; 
        // $data->nft_img         =  $request->input('nft_img'); 
        // $data->nft_img       =  uniqid() .'.'.$image_type; 
        $data->nft_img       =  $file; 
        $data->ipfs_url      =  $request->input('ipfs_url'); 
        $data->hash          =  $request->input('ipfs_url'); 
        
        // $data->save();
        //  return $data;
		if($data->save()){
			$convertCurrency = ConvertCurrency::create([
	            'type' => 'ft_ipfs',
	            'coversion' => 'ft ipfs',
	            'user_id' => auth()->user()->id,
	            'usd_amt' => 0,
	            'eth_amount' => 0,
                'transaction_id' => $transaction_id,
	            'csm_amount' => $request->input('ipfs_url'),
	        ]);
// 			$data->save();
        // 	flash()->success(trans('nft.mint_update_successfully'));
            return 1;
        }else{
        // 	flash()->error(trans('nft.mint_not_update_successfully'));
            return 0;
        }

        // return redirect()->back();
    }

    public function nft_detail($id)
    {
        $id = decrypt($id);

        $nft_detail = NftItem::where('id',$id)->first();

        return view('nft.nft_detail',compact('nft_detail'));
    }
    
     public function ft_detail($id)
    {
        $id = decrypt($id);

        $nft_detail = NftItem::where('id',$id)->first();

        return view('nft.nft_detail',compact('nft_detail'));
    }
    
    
     public function delete($id)
    {
        $id = decrypt($id);
        // print_r($id);die;
        $explore_detail = UserBuyPack::where('pack_id',$id)->get();
        
        $nft_delete = NftItem::where('id',$id)->delete();
        
        if($nft_delete){
            if(!empty($explore_detail)){
                foreach($explore_detail as $v){
                    $explore_delete = UserBuyPack::where('id',$v['id'])->delete();
                }
            }
            flash()->success('Delete Successfully');
        }else{
            flash()->error('Delete not successfully');
        }
        
         return redirect()->back();
    }
    
    public function nft_delete()
    {
        $list= NftItem::where('type',1)->get();
        
        if(!empty($list)){
            foreach($list as $v){
                $nft_delete = NftItem::where('id',$v['id'])->delete();
                
                $explore = UserBuyPack::where('pack_id',$v['id'])->first();
                if(!empty($explore)){
                    $explore_detail = UserBuyPack::where('pack_id',$v['id'])->delete();  
                }
                
            }
        }
        
        flash()->success('Delete Successfully');
        return redirect()->back();
    }
    
    public function ft_delete()
    {
        
         $list= NftItem::where('type',2)->get();
        
        if(!empty($list)){
            foreach($list as $v){
                $nft_delete = NftItem::where('id',$v['id'])->delete();
                
                $explore = UserBuyPack::where('pack_id',$v['id'])->first();
                if(!empty($explore)){
                    $explore_detail = UserBuyPack::where('pack_id',$v['id'])->delete();  
                }
                
            }
        }
        
        flash()->success('Delete Successfully');
        return redirect()->back();
    }
    
    public function add_nft(Request $request)
    {
    	// return 1;
    	$file = $request->file('nft_img');

    	$file_name = time().'.'.$file->getClientOriginalExtension();
        // $destinationPath = public_path('/web/img/');
        $destinationPath = public_path('/nft_item/');
        $file->move($destinationPath, $file_name);

        $data 			= new NftItem();
        $data->nft_img  =  $file_name; 
        // $data->save();
         
		// return redirect()->back()->with('status',trans('nft.image_update_successfully')); 
		if($data->save()){
			$data->save();
        	// flash()->success(trans('nft.image_update_successfully'));
        	flash()->success('Image Update succesfully');
        }else{
        	flash()->error(trans('nft.image_not_update_successfully'));
        }

        return redirect()->back();
    }

     public function wallet()
    {
        return view('nft.wallet');
    }

    public function setting()
    {
        // return 1;
        return view('nft.setting');
    }

     public function change_setting(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6',
            // 'confirm_password' => 'required|confirmed|min:6',
            'old_password' => 'required|match_old:'.auth()->user()->password
        ],['old_password.match_old'=> 'Wrong Password!']);

        $user = auth()->user();
        $user->password = bcrypt($request->input('password'));

        if($user->save()){
            flash()->success(trans('nft.success_your_password_has_been_updated'))->important();
        }
        return redirect()->back();
    }

    public function mint()
    {
        $bnb_csm = BnbCsmCoveter::where('id','1')->first();

        return view('nft.mint',compact('bnb_csm'));
    }

     public function add_mintOld(Request $request)
    {
        
        $img = $request->input('img');
        
        $folderPath = public_path('/nft_item/');
        // $folderPath = 'https://anandisha.com/alpha_game_code/public/nft_item/';
        
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() .'.'.$image_type;
        
        // $file_name = uniqid().'.'.$image_type;
        // $file_name = $file.','.$image_base64;
        
        file_put_contents($file, $image_base64);


        $data 			     =  new NftItem();
        $data->name          =  $request->input('name'); 
        $data->descripition  =  $request->input('descripition'); 
        $data->price         =  $request->input('price'); 
        $data->user_id       =  auth()->user()->id; 
        // $data->nft_img         =  $request->input('nft_img'); 
        // $data->nft_img       =  uniqid() .'.'.$image_type; 
        $data->nft_img       =  $file; 
        $data->ipfs_url      =  $request->input('ipfs_url'); 
        $data->hash          =  $request->input('ipfs_url'); 
        
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $transaction_id = substr(str_shuffle($permitted_chars), 0, 50);
        // $data->save();
        //  return $data;
		if($data->save()){
			$convertCurrency = ConvertCurrency::create([
	            'type' => 'ipfs',
	            'coversion' => 'ipfs',
	            'user_id' => auth()->user()->id,
	            'usd_amt' => 0,
	            'eth_amount' => 0,
                'transaction_id' => $transaction_id,
	            'csm_amount' => $request->input('ipfs_url'),
	        ]);
// 			$data->save();
        // 	flash()->success(trans('nft.mint_update_successfully'));
            return 1;
        }else{
        // 	flash()->error(trans('nft.mint_not_update_successfully'));
            return 0;
        }
    }

    public function add_mint(Request $request)
    {
        // return 1;die;
        // return $request->all();

        $img = $request->input('img');
        
        $folderPath = public_path('/nft_item/');
        // $folderPath = 'https://anandisha.com/alpha_game_code/public/nft_item/';
        
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() .'.'.$image_type;
        file_put_contents($file, $image_base64);



        $data                =  new NftItem();
        $data->name          =  $request->input('name'); 
        $data->descripition  =  $request->input('descripition'); 

        $data->price         =  $request->input('price'); 
        $data->bnb_price     =  $request->input('bnb_price'); 
        $data->csm_price     =  $request->input('csm_price'); 

        $data->royalty       =  $request->input('royalty'); 
        $data->token_id      =  $request->input('tokenId'); 
        $data->user_id       =  auth()->user()->id; 
        $data->nft_img       =  $file; 
        $data->ipfs_url      =  $request->input('ipfs_url'); 
        $data->hash          =  $request->input('transaction_id'); 
        
        // $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        // $transaction_id = substr(str_shuffle($permitted_chars), 0, 50);
        // $data->save();
        //  return $data;
        if($data->save()){
            $convertCurrency = ConvertCurrency::create([
                'type' => 'nft',
                'coversion' => 'nft',
                'user_id' => auth()->user()->id,
                'to_id' => '0x79319A973Be6C6F0cbad2206ea4F6573A9ecF223',
                'usd_amt' => $request->input('price'),
                'eth_amount' => $request->input('tokenId'),
                'transaction_id' => $request->input('transaction_id'),
                'csm_amount' => $request->input('ipfs_url'),
            ]);
//          $data->save();
        //  flash()->success(trans('nft.mint_update_successfully'));
            // return 1;
             $status = 200;
            echo json_encode($status);
        }else{
        //  flash()->error(trans('nft.mint_not_update_successfully'));
            // return 0;
            $status = 400;
            echo json_encode($status);
        }
    }

    public function hash()
    {
       // return $mint = NftItem::where('type','nft')->orderBy('id', 'DESC')->paginate('10');
        $mint = ConvertCurrency::Where('type','nft')->orderBy('id', 'DESC')->paginate('10');

        return view('nft.hash',compact('mint'));
    }


    public function timeblockchain_explore()
    {
        // return 1;die;
        
        // $mint_explore = NftItem::orderBy('id', 'DESC')->paginate('10');

        $mint_explore = ConvertCurrency::Where('type','nft')->orWhere('type','ft')->orWhere('type','ft_ipfs')->orWhere('type','ipfs')->orWhere('type','buy_trade')->orWhere('type','trading')->orderBy('id', 'DESC')->get();

        return view('nft.timeblockchain',compact('mint_explore'));
    }

      public function timeBlockchain_detail($id,$block,$transaction)
    {
        $id = decrypt($id);
        $block = $block;
        $transaction = $transaction;
        
        $explore_detail = NftItem::where('id',$id)->first();

       $explore_detail = ConvertCurrency::where('id',$id)->first();

       $toUser_Detail = User::where('id',$explore_detail->to_id)->first();

       if(!empty($explore_detail->to_id)){
            $to_address = $toUser_Detail->daedalus_wallet;
       }else{
            $to_address = '-';
       }

        return view('nft.timeblockchain_explode_detail',compact('explore_detail','block','transaction','to_address'));
    }
}
