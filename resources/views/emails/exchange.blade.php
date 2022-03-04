@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => {{trans('emails/exchange.Exchange_Details',[],$locale)}},
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>{{trans('emails/exchange.Currency_Exchange_Details',[],$locale)}} - {{$oparetion->txnid}}<br />
    ------------------------------------------------------------------------------------------------------
    {{trans('emails/exchange.Exchange',[],$locale)}} {{$paycoin}} {{trans('emails/exchange.to',[],$locale)}} {{ $receivecoin }} {{trans('emails/exchange.on',[],$locale)}} {{$oparetion->created_at}}
    </p><br />
    {{$paycoin}} {{trans('emails/exchange.amount',[],$locale)}}:  {{$oparetion->source_amount}} {{$paycoin}}<br />
    @if($receivecoin !='INR')
    {{ $receivecoin }} {{trans('emails/exchange.Convert_Amount',[],$locale)}} : {{ round($oparetion->destination_amount + $oparetion->fees + $oparetion->tax,8) }}<br />
    @else
    {{ $receivecoin }} {{trans('emails/exchange.Convert_Amount',[],$locale)}} : {{ round($oparetion->destination_amount + $oparetion->fees + $oparetion->tax,2) }}<br />
    @endif

    {{trans('emails/exchange.Fee',[],$locale)}} : -{{$oparetion->fees}} {{ $receivecoin }}<br />
    {{trans('emails/exchange.Tax',[],$locale)}} : -{{$oparetion->tax}} {{ $receivecoin }}<br />
    {{trans('emails/exchange.contact_us_anytime_at',[],$locale)}} - {{$oparetion->destination_amount}} {{ $receivecoin }}

    @include('beautymail::templates.sunny.contentEnd')


    @include('beautymail::templates.sunny.contentStart')

    <p>{{trans('emails/exchange.If_you_have_any_questions',[],$locale)}},</p>
    <br /> {{trans('emails/exchange.contact_us_anytime_at',[],$locale)}}  <br />

   {{trans('emails/exchange.Best_regards',[],$locale)}},<br />
    {{trans('emails/exchange.JPcoinTeam',[],$locale)}}<br />
    @include('beautymail::templates.sunny.contentEnd')

@stop

