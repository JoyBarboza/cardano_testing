@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => '{{config("app.name")}}',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>{{trans('emails/deposit-done.Hi',[],$locale)}} {{ $payment->user->first_name }},</p>

    <p>{{trans('emails/deposit-done.Your_deposit_has_been_successfully_processed',[],$locale)}}.</p>

    <p><strong>{{trans('emails/deposit-done.Details',[],$locale)}}</strong></p>
    <hr>
       {{trans('emails/deposit-done.TXNID',[],$locale)}}: <strong style="float: right;">{{ $payment->reference_no }} </strong>
    <hr>
        {{trans('emails/deposit-done.Amount',[],$locale)}}: <strong style="float: right;">{{ number_format($payment->transaction->amount, 8) }} {{ $payment->transaction->currency->name }}</strong>
    

    <hr>
    <p>{{trans('emails/deposit-done.If_you_have_any_questions',[],$locale)}},</p>
    <br /> {{trans('emails/deposit-done.contact_us_anytime_at',[],$locale)}}<br />

    {{trans('emails/deposit-done.Best_regards',[],$locale)}},<br />
   {{trans('emails/deposit-done.JPcoinTeam',[],$locale)}}<br />
    @include('beautymail::templates.sunny.contentEnd')

@stop

