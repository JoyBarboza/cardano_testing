@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => '{{config("app.name")}}',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>{{trans('emails/bank-deposit-reject.Hi',[],$locale)}} {{ $transaction->user->first_name }},</p>

    <p>{{trans('emails/bank-deposit-reject.Your_deposit_has_been_rejected',[],$locale)}}.</p>
    <p>{{trans('emails/bank-deposit-reject.Reference_no',[],$locale)}} : {{$transaction->reference_no}}</p>

   
    

    <hr>
    <p>{{trans('emails/bank-deposit-reject.If_you_have_any_questions',[],$locale)}},</p>
    <br /> {{trans('emails/bank-deposit-reject.contact_us_anytime_at',[],$locale)}}  <br />

    {{trans('emails/bank-deposit-reject.Best_regards',[],$locale)}},<br />
    {{trans('emails/bank-deposit-reject.JPcoinTeam',[],$locale)}}<br />
    @include('beautymail::templates.sunny.contentEnd')

@stop

