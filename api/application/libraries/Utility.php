<?php

class Utility
{

	private $CI;

	function __construcyt ()
	{

	}

	public function email ( $data )
	{
		$this->CI = & get_instance();
		$config = Array(
			'protocol'  => 'smtp',
			'smtp_host' => 'smtp.sendgrid.net',
			'smtp_port' => 587,
			'smtp_user' => 'apikey',
			'smtp_pass' => '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',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);
		$this->CI->load->library('email', $config);
		$this->CI->email->from(EMAIL_FROM, EMAIL_FROM_NAME);
		$this->CI->email->to( $data['to'] );
		$this->CI->email->subject( $data['subject'] );
		$this->CI->email->message( $data['message'] );
		$result = $this->CI->email->send();
		return $result;
	}

	public function token( $length = 32, $type = 'alnum' )
	{
		$this->CI = & get_instance();
		$this->CI->load->helper('string');
		return uniqid( date('YmdHisu') ) . random_string( $type, $length );
	}

	public function otp( $length = 6, $type = 'numeric' )
	{
		$this->CI = & get_instance();
		$this->CI->load->helper('string');
		return random_string( $type, $length );
	}

	public function googleCaptchaVerification($response)
	{
		$post = array(
			'secret'    => GOOGLE_CATPCHA_SECRET,
			'response'  => $response,
			'remoteip'  => $_SERVER['REMOTE_ADDR']
		);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		$result = curl_exec($curl);
		curl_close($curl);
		$captcha = json_decode( $result );
		return $captcha->success;
	}

}
