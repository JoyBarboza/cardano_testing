@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => '{{config("app.name")}}',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p> {{trans('emails/coin-bought.Hi',[],$locale)}} {{ $user->first_name }},</p>

    <p> {{trans('emails/coin-bought.Successful_Purchase_of_JPCCoins',[],$locale)}}</p>

    <p><strong>{{trans('emails/coin-bought.Details',[],$locale)}}</strong></p>
    <hr>

    @isset($data['buyVolume'])
        {{trans('emails/coin-bought.Buy_Volume',[],$locale)}}: <strong style="float: right;">{{ number_format($data['buyVolume'], 8) }} Time</strong>
    @endisset
    @isset($data['bonusVolume'])
    <hr>
	{{trans('emails/coin-bought.Bonus_Volume',[],$locale)}}: <strong style="float: right;">{{ number_format($data['bonusVolume'], 8) }} Time</strong>
    @endisset
    @isset($data['totalPrice'])
    <hr>
        {{trans('emails/coin-bought.Total_Price',[],$locale)}}: <strong style="float: right;">{{ number_format($data['totalPrice'], 2) }} USD</strong>
    @endisset
    @isset($data['discount'])
    <hr>
        {{trans('emails/coin-bought.Discount',[],$locale)}} : <strong style="float: right;">{{ number_format($data['discount'], 2) }} USD</strong>
    @endisset
    @isset($data['netAmount'])
    <hr>
       {{trans('emails/coin-bought.NetAmount',[],$locale)}}: <strong style="float: right;">{{ number_format($data['netAmount'], 2) }} USD</strong>
    @endisset

    <hr>
    <p>  {{trans('emails/coin-bought.If_you_have_any_questions',[],$locale)}}, {{trans('emails/coin-bought.contact_us_anytime_at',[],$locale)}}  </p><br />

     {{trans('emails/coin-bought.Best_regards',[],$locale)}},<br />
    {{trans('emails/coin-bought.JPcoinTeam',[],$locale)}}<br />
    @include('beautymail::templates.sunny.contentEnd')

@stop

