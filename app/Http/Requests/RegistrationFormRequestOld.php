<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationFormRequest extends FormRequest
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
				
				
                $rules = [
                    'referral_code' => 'required|exists:users,referral',
                    'first_name' => 'required|max:255',
                    'phone' => 'required|numeric|unique:users,phone_no',
                    'account_type' => 'required',                  
                    //'username' => 'required|alpha_dash|max:255|unique:users,username',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:8|confirmed',
			        'captcha' => 'required|passed',
			        'one_time_password' => 'required'                  
                ];
                return $rules;
            case 'PUT':
            case 'PATCH':
                $id = $this->segment(4);//|unique:news,slug,'.$news.',slug',
                $rules = [
                    'name' => 'required|max:255',
                    'account_type' => 'required',
                    //'username' => 'required|alpha_dash|max:255|unique:users,username,'.$id.'id',
                    'email' => 'required|email|unique:users,email,'.$id.'id',
                    //'password' => 'nullable|min:8',
                    'phone' => 'required|max:12|min:10',
                ];
                return $rules;
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'username.required' => 'Tax id field is required',
            'username.unique' => 'Tax id field is unique',
            'referral_code.exists' => 'This is not a valid referral code',
            'tnc.accepted' => 'Term and condition field must be accepted',
            'captcha.passed' => 'Captcha is invalid',
            'name.required' => 'Name is required',
            'one_time_password.required' => 'Please enter otp , Email verify is required',
           
        ];
    }

}
