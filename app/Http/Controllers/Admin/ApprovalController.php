<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Currency;
use App\Withdraw;
//use App\Operation;
use App\Transaction;
use App\BankDeposit;
use App\Payment;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Snowfire\Beautymail\Beautymail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

use Illuminate\Pagination\LengthAwarePaginator;

class ApprovalController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->whereHas('document')->get();
        return view('approve.index', compact('users'));
    }

    public function getDocApprove()
    {
        $users = $this->user->whereHas('document',function ($query) {
            $query->where('documents.status',1);
        })->get();

        return view('approve.document', compact('users'));
    }

    public function approve($user, $document)
    {
        $user = $this->user->find($user);

        try {
            $user->document()->find($document)->update(['status' => 2]);
            return json_encode(['status' => true, 'message' => trans('auth/controller_msg.Success_Document_approved')]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return json_encode(['status' => false, 'message' => trans('auth/controller_msg.Success_Document_rejeced')]);
        }
    }

    public function reject($user, $document)
    {
        $user = $this->user->find($user);

        try {
            $user->document()->find($document)->update(['status' => 0]);
            return json_encode(['status' => true, 'message' => trans('auth/controller_msg.Success_Document_approved')]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return json_encode(['status' => false, 'message' => trans('auth/controller_msg.Success_Document_rejeced')]);
        }
    }

    public function getDepositApprove(BankDeposit $transaction)
    {
        $request = request();
        $query = $transaction->orderBy('BankDeposits.created_at','DESC');
        if($request->has('transaction_id') && ($request->transaction_id!="")){
            $refenceNo = $request->transaction_id;
            $query->where('reference_no',$refenceNo);
        }
        if(strcasecmp($request->get('search'), 'true')==0)
        {
            if($request->has('from_date') && ($request->from_date!="") && $request->has('to_date') && ($request->to_date!="")) {

                $dates = [
                    Carbon::parse($request->from_date)->toDateString(),
                    Carbon::parse($request->to_date)->toDateString()
                ];

                $query->whereBetween('BankDeposits.created_at', $dates);
        }

            if($request->has('user_info') && ($request->user_info!="")) {
                $all_users= User::orwhere('users.first_name', 'like', "%".$request->user_info."%")
                    ->orwhere('users.username', 'like', "%".$request->user_info."%")
                    ->orWhere('users.email', 'like', "%".$request->user_info."%")->pluck('id')->toArray();
               
                 $query->whereIn('uid',$all_users);
   
            }
            //$query->select(['users.email']);
            $query = $query->select(['BankDeposits.*']);
        }
       
        $transactions = $query->paginate(20)->appends(request()->query());

        return view('approve.deposit', compact('transactions'));
    }

    public function approveDeposit(Request $request,$transaction)
    {
		$validator = Validator::make($request->all(), [
            'approved_amount' => 'required|numeric',
            
        ]);
  
        if ($validator->fails()) {
			$output = ['status' => true, 'message' => $validator->errors()];
			return json_encode($output);
			//return response()->json(['status' => false, 'errors' => $validator->errors(), 'success'=>0]);
        }
		$approved_amount=$request->approved_amount;
        $BankDeposit = BankDeposit::where('id',$transaction)->where('status','pending');
	
        try{
            if($BankDeposit->update(['status' => 'approved'])){

                $BankDeposit = BankDeposit::find($transaction);
                
                $BankDeposit->approved_amount=$approved_amount;
                $BankDeposit->save();
                
                $transaction = Transaction::create([
                    'user_id' => $BankDeposit->uid,
                    'currency_id' => $BankDeposit->currency_id,
                    'reference_no' => uniqid('TXN'.time()),
                    'type' => 'Credit',
					'source' => 'Bankdeposit',
                    'amount' => $approved_amount,
                    'status'=>1
                ]);


                $beautymail = app()->make(BeautyMail::class);
                $beautymail->send(
                    'emails.bank-deposit-done',
                    ['transaction' => $transaction,'locale' => app()->getLocale()],
                    function($message) use ($transaction)
                    {
                        $message
                            ->to($transaction->user->email, $transaction->user->fullName)
                            ->subject('Bank Deposit added successfully');
                    });


            }
            $output = ['status' => true, 'message' => trans('auth/controller_msg.Transaction_payment_status_approved')];
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $output = ['status' => true, 'message' => trans('auth/controller_msg.payment_status_approval_failed')];
        }
        return json_encode($output);
    }

    public function rejectDeposit($transaction)
    {
        $BankDeposit = BankDeposit::where('id',$transaction)->where('status','pending');

        try {
            if($BankDeposit->update(['status' => 'rejected'])){
                $BankDeposit = BankDeposit::find($transaction);
                $beautymail = app()->make(BeautyMail::class);
                $beautymail->send(
                    'emails.bank-deposit-reject',
                    ['transaction' => $BankDeposit,'locale' => app()->getLocale()],
                    function($message) use ($BankDeposit)
                    {
                        $message
                            ->to($BankDeposit->user->email, $BankDeposit->user->fullName)
                            ->subject($BankDeposit->reference_no.' Rejected.');
                    });
            }
            $output = ['status' => true, 'message' => trans('auth/controller_msg.payment_status_rejected')];
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $output = ['status' => true, 'message' => trans('auth/controller_msg.payment_status_rejection_failed')];
        }
        return json_encode($output);
    }

    public function getWithdrawApprove(Withdraw $withdraw)
    {
        $request = request();

        $searchField = [null, null, null, null, null, null, null, null, null, null, null];

        $result = $this->searchValues($request, $searchField, $withdraw);
        
        if($request->has('export')) {
            $array = json_decode(json_encode($result), true);
            $resultSet = array_map(function($record){
				
                return [                   
                   
                    'Created At' => $record['created_at'],                  
                    'User Email' => $record['email'],
                    'Amount' => $record['amount'],
                    'Fees' => $record['fees'],
                    'Net amount' => $record['net_amount'],
                    'Currency' => $record['coin_description'],
                    'address' => $record['address'],
                    'T_hash' => $record['t_hash'],
                    'status' => $record['status'],
               
                ];
            }, $array);

            Excel::create('Withdraw-Request-List', function($excel) use($resultSet) {

                $excel->sheet('Date - '.date('Y-m-d'), function($sheet) use ($resultSet) {

                    $sheet->setAutoSize(true);

                    $sheet->fromArray($resultSet);

                    $sheet->freezeFirstRow();
                    $sheet->cells('A1:I1', function($cells) {
                        $cells->setBackground('#000000');
                        $cells->setFontColor('#ffffff');
                        $cells->setFontFamily('Calibri');
                        $cells->setFontSize(14);
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                    });


                });

            })->download('xlsx');

        }
		
		$page = $request->get('page',1);

        $withdraws = new LengthAwarePaginator(
            $result->forPage($page, 20), $result->count(), 20, $page
        );

        $withdraws->appends($request->query())->setPath(url('approval/withdraw-approve'));
        
        $currencies = Currency::all()->where('status',1);

        return view('approve.withdrawRequest', compact('withdraws','currencies'));
    }

    public function approveWithdrawl(Request $request)
    {
        $this->validate($request, [
            'transactionHash' => 'required',
            'code' => 'required',
        ]);

        $withdrawRequest = Withdraw::where('transaction_id',$request->code)->first(); 

        if($withdrawRequest) {

            $withdrawRequest->t_hash = $request->transactionHash;
            $withdrawRequest->status = 1;
           

            DB::transaction(function() use ($withdrawRequest) {
                $withdrawRequest->save();
               
            });
            
            
            return json_encode([
                'status' => true, 'message' => 'Status of withdraw has been set to approved'
            ]);
        }
        return json_encode([
            'status' => false, 'message' => 'Unable to find withdraw request with this code'
        ]);
    }

    public function rejectWithdrawl(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'reason' => 'required'
        ]);
        
        $tran_id=$request->code; 

        $withdrawRequest = Withdraw::where('transaction_id',$tran_id)->first();

        if($withdrawRequest) {

            $withdrawRequest->decline_reason = $request->reason;
            $withdrawRequest->status = 2;
           

            $amount = $withdrawRequest->amount;

			
			
            DB::transaction(function() use ($withdrawRequest,$tran_id ) {
                
                $withdrawRequest->save();

                Transaction::where('id',$tran_id)->update(array('status'=>2,'description'=>'Declined withdrawal request by admin'));
                

            });
        
            return json_encode([
                'status' => true, 'message' => 'Status of withdraw has been set to rejected'
            ]);
        }

        return json_encode([
            'status' => false, 'message' => 'Unable to find withdraw request with this code'
        ]);
    }
    
    protected function searchValues($request, array $searchField, Withdraw $withdraw)
    {
        $user = auth()->user();

        if($request->has('user') && ($request->user!="")) {
            $searchField[0] = $request->user;
        }

        if($request->has('from_date') && ($request->from_date!="")) {
			if($request->from_date!=null){
				$searchField[1] = date('Y-m-d',strtotime($request->from_date));
			}          
        }
        if($request->has('to_date') && ($request->to_date!="")) {
			if($request->to_date!=null){
				$searchField[2] = date('Y-m-d',strtotime($request->to_date));
			}               
        }
        if($request->has('from_approve_date') && ($request->from_approve_date!="")) {
			if($request->from_approve_date!=null){
				$searchField[3] = date('Y-m-d',strtotime($request->from_approve_date));
			}              
        }
        if($request->has('to_approve_date') && ($request->to_approve_date!="")) {
			if($request->to_approve_date!=null){
				$searchField[4] = date('Y-m-d',strtotime($request->to_approve_date));
			}            
        }
        if($request->has('status') && ($request->status!="")) {
            $searchField[5] = $request->status;
        }	
        if($request->has('currency') && ($request->currency!="")) {
            $searchField[6] = $request->currency;
        }		
		//dd($searchField);

        return collect($withdraw->searchWithdraw($searchField));
    }

}
