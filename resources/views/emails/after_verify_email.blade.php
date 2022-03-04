@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Email Verified',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

        	<p>Hi,</p>
			<p>Your email is successfully verified.</p> 

			<p>Please complete your profile to get access to exclusive features of {{config("app.name")}}. </p>
			<p>We take this opportunity to thank you and extend our warm welcome for choosing {{config("app.name")}}.</p>
			
			<p>Best regards,</p>
	<p>{{config("app.name")}} Team</p>

    @include('beautymail::templates.sunny.contentEnd')

   

@stop
