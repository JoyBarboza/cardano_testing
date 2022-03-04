@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => {{trans('emails/forget_password.Forget_password',[],$locale)}},
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

        <p> {{trans('emails/forget_password.Hello',[],$locale)}} <br />
        ----------------------------------------------------------------------------------------------------------
        {{trans('emails/forget_password.received_password_reset_request',[],$locale)}}!!
        </p><br />

        
    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
        	'title' => {{trans('emails/forget_password.Reset_password',[],$locale)}},
        	'link' => url(encrypt($token))
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>{{trans('emails/forget_password.forget_password',[],$locale)}}</p>
     <br />

    {{trans('emails/forget_password.Regards',[],$locale)}},<br />
    {{trans('emails/forget_password.JPcoinTeam',[],$locale)}}<br />
    @include('beautymail::templates.sunny.contentEnd')

@stop
