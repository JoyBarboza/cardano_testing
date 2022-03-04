@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => trans('emails/welcome.Welcome_To_JPCoin',[],$locale),
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

        {{trans('emails/welcome.Congratulations_coming_onboard',[],$locale)}}!!
        </p><br />

        {{trans('emails/welcome.To_Activate_account',[],$locale)}}
    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
        	'title' => trans('emails/welcome.Click_To_Verify_Your_Mail',[],$locale),
        	'link' => url($locale.'/account/verification/'.encrypt($token))
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>{{trans('emails/welcome.For_protection',[],$locale)}}</p>
    <br /> {{trans('emails/welcome.contact_us_anytime',[],$locale)}}  <br />

    {{trans('emails/welcome.Best_regards',[],$locale)}},<br />
    {{trans('emails/welcome.JPcoinTeam',[],$locale)}}<br />
    @include('beautymail::templates.sunny.contentEnd')

@stop
