@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => '{{config("app.name")}}',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>{{trans('emails/bank-deposit-done.hi',[],$locale)}} {{ $transaction->user->first_name }},</p>

    <p>{{trans('emails/bank-deposit-done.Your_deposit_has_been_successfully_processed',[],$locale)}}</p>

    <p><strong>{{trans('emails/bank-deposit-done.Details',[],$locale)}}</strong></p>
    <hr>
        {{trans('emails/bank-deposit-done.TXNID',[],$locale)}}: <strong style="float: right;">{{ $transaction->reference_no }} </strong>
    <hr>
        {{trans('emails/bank-deposit-done.Amount',[],$locale)}}: <strong style="float: right;">{{ number_format($transaction->amount, 8) }} {{ $transaction->currency->name }}</strong>
    

    <hr>
    <p>{{trans('emails/bank-deposit-done.If_you_have_any_questions',[],$locale)}},</p>
    <br /> {{trans('emails/bank-deposit-done.contact_us_anytime_at',[],$locale)}}  <br />

   {{trans('emails/bank-deposit-done.Best_regards',[],$locale)}},<br />
    {{trans('emails/bank-deposit-done.JPcoinTeam',[],$locale)}}<br />
    @include('beautymail::templates.sunny.contentEnd')

@stop

