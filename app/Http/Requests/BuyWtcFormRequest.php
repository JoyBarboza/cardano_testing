<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyWtcFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'buy_to' => 'required|in:wallet,address',
            'wtc_address' => 'required_if:buy_to,address|nullable|min:26,verify_btc_address',
            'amountWTC' => 'required|numeric|check_limit:WTC,BUY',
            'payment_type' => 'required|in:inrwallet,bankdeposit',
            'fee' => 'required|numeric',
            'tax' => 'required|numeric',
            'total' => 'required|numeric',
        ];

        if($this->input('payment_type') == 'paymentgetwaycharge') {
            $rules['amountINR'] = 'required|numeric';
        } else {
            $rules['amountINR'] = 'required|numeric|check_fund:inr';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'amountINR.check_fund' => 'Your Wallet doesn\'t have sufficient fund',
            'payment_type.required' => 'Payment source must be selected',
            'amountWTC.check_limit' => 'Your limit has been exceeded'
        ];
    }
}
