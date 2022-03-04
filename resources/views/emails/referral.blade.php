@component('mail::message')

{{ __('Greetings') }}!
{{ __('Your Joining Code') }}


@component('mail::button', ['url' => url(Config::get('app.locale').'/register?referral-code=').$wing])
{{ __('Click to Join') }}

@endcomponent

{{ __('Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
