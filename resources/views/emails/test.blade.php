@extends('beautymail::templates.widgets')

@section('content')
	 
    
	@include('beautymail::templates.widgets.articleStart')
	<h3>Welcome to Time</h3>
	<p>Hi,</p>
	<p>Your email is successfully verified.</p> 

	<p>Please complete your profile to get access to exclusive features of Time. </p>
	<p>We take this opportunity to thank you and extend our warm welcome for choosing Time.</p>
	
	<p>contact us anytime at  <strong>info@time.com</strong> </p>

	<p>Best regards,</p>
	<p>Time Team</p>

	@include('beautymail::templates.widgets.articleEnd')


	

@stop
