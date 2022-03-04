<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellBtcFormRequest extends FormRequest
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
        return [
            'amountBTC' => 'required|numeric|check_fund:btc|check_limit:BTC,SELL',
            'amountINR' => 'required|numeric',
            'pay_to' => 'required|in:bankaccount,inrwallet',
            'fee' => 'required|numeric',
            'tax' => 'required|numeric',
            'total' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'amountBTC.check_fund' => 'Your Wallet doesn\'t have sufficient fund',
            'pay_to.required' => 'Payment Destination must be selected',
            'pay_to.in' => 'Payment can be done only on Bignion wallet or Bank Account',
            'amountBTC.check_limit' => 'Your buying limit exceeded',
        ];
    }
}
