<?php

namespace App\Http\Controllers\Admin;

use App\RoiPlan;
use App\RoiInvestment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CloudMiningController extends Controller
{
    
    public function subscription()
    {
		$query = new RoiInvestment;
		
		if(request()->has('email')){
			//$query->where
		}
		
        $roiInvestments = $query->latest()->paginate(10);

        return view('roi-plans.roiInvestments', compact('roiInvestments'));
    }
    
    public function index()
    {
        $plans = RoiPlan::latest()->get();

        return view('roi-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('roi-plans.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|min:3',
            //'percentage' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:7',
            'min_coin' => 'required|numeric|min:1',
            'max_coin' => 'required|numeric|min:1',
            'token_price' => 'required|numeric|min:1',
            'payin_coin' => 'required|in:USD,CSM',
            'payout_coin' => 'required|in:USD,CSM',
            'status' => 'required'
        ]);
        
        //~ if($request->input('payin_coin')!=$request->input('payout_coin')){
			//~ if($request->input('token_price') <= 0){
				//~ flash()->error('CSM Price must be greater than 0');
				//~ return redirect()->back()->withInput($request->input());
			//~ }
		//~ }

        try {

            RoiPlan::create([
                'name' => $request->input('name'),
                'percentage' => 0,
                'duration' => $request->input('duration'),
                'token_price' => $request->input('token_price'),
                'payin_coin' => $request->input('payin_coin'),
                'payout_coin' => $request->input('payout_coin'),
                'min_coin' => $request->input('min_coin'),
                'max_coin' => $request->input('max_coin'),
                'status' => $request->input('status')
            ]);

            flash()->success('New plan has been successfully created');

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            flash()->error('some error occoured');
        }

        return redirect()->back();
    }

    public function edit($id)
    {
        $plan = RoiPlan::findOrFail($id);

        return view('roi-plans.edit', compact('plan'));

    }

    public function update(Request $request, $id)
    {
		$this->validate($request, [
            'name' => 'required|min:3',
            //'percentage' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:7',
            'token_price' => 'required|numeric|min:1',
            'payin_coin' => 'required|in:USD,CSM',
            'payout_coin' => 'required|in:USD,CSM',
            'min_coin' => 'required|numeric|min:1',
            'max_coin' => 'required|numeric|min:1',
            'status' => 'required'
        ]);
        
        //~ if($request->input('payin_coin')!=$request->input('payout_coin')){
			//~ if($request->input('token_price') <= 0){
				//~ flash()->error('CSM Price must be greater than 0');
				//~ return redirect()->back()->withInput($request->input());
			//~ }
		//~ }
		
        $roiPlan = RoiPlan::findOrFail($id);

        $roiPlan->name = $request->input('name');
        $roiPlan->percentage = 0;
        $roiPlan->duration = $request->input('duration');
        $roiPlan->status = $request->input('status');
        $roiPlan->token_price = $request->input('token_price');
        $roiPlan->payin_coin = $request->input('payin_coin');
        $roiPlan->payout_coin = $request->input('payout_coin');
        $roiPlan->min_coin = $request->input('min_coin');
        $roiPlan->max_coin = $request->input('max_coin');

        try {
            $roiPlan->save();

            flash()->success('Core Mining plan has been successfully updated');
        } catch (QueryException $exception) {

            Log::error($exception->getMessage());
            flash()->error('some error occoured');

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());
            flash()->error('some error occoured');
        }

        return redirect()->back();
    }
}
