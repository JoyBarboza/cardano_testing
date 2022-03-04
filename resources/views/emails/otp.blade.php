@component('mail::message')

<p><strong>{{ __('Greetings') }}!</strong></p>
            

<p>{{ __('Your One Time Password is :') }}{{ $otp }}<br></p>


{{ __('Thanks & Regard') }},<br>
{{ config('app.name') }} {{ __('Team') }}

<p style="color:blue">** {{ __('This is an auto-generated email. Please do not reply to this email') }}.</p>


@endcomponent



