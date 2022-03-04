@php $user = auth()->user(); @endphp  
@extends('layouts.master')


@section('page-content')
    <div class="col-md-9 col-sm-8">
        <div class="profile_section">
            <div class="send_request_background">
                <h1 class="main_heading">{{trans('account/bank_account.account_settings')}}</h1>
                
                <div class="row">
                    
                    <div class="col-md-12 col-sm-12">
                        <strong>{{trans('account/bank_account.bank_instructions')}}</strong>
                        <hr>
                            <p>{{trans('account/bank_account.enter_bank_details_1')}} {{ env('APP_NAME') }} {{trans('account/bank_account.enter_bank_details_2')}} </p>
                        <br>
                        <strong>{{trans('account/bank_account.account_details')}}</strong>
                        <hr>
                        @if(!($user->profile->bank_account_no and $user->profile->ifsc_code))
                            <p>{{trans('account/bank_account.add_account_details')}}</p>
                        @else
                            <table>
                                <tbody>
                                    <tr><th width="250">{{trans('account/bank_account.bank_ifsc')}}: </th><td>{{ $user->profile->ifsc_code }}</td></tr>
                                    <tr><th>{{trans('account/bank_account.account_no')}}: </th><td>{{ $user->profile->bank_account_no }}</td></tr>
                                </tbody>
                            </table>
                        @endif
                        @if($user->isNotVerified())
                            <button class="btn-primary" onclick="location.href='{{ route('account.verify') }}';" style="width:210px">{{trans('account/bank_account.verify_account')}}</button>
                        @else

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
