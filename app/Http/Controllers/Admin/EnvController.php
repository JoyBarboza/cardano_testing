<?php

namespace App\Http\Controllers\Admin;
use App\Env;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class EnvController extends Controller
{
	protected $env;

    public function __construct(Env $env)
    {
        $this->env = $env;
    }

    public function getEnvSetting()
    {
        //$encrypter = app('Illuminate\Contracts\Encryption\DecryptException ');
        $env_data = $this->env->where('status',1)->get();
		$data = array();
		if(!empty($env_data)){
			foreach($env_data as $env){
				
				$key_data = $env['key'];//Crypt::decryptString($env['key']);
				$value_data = Crypt::decryptString($env['value']);
				$data[$key_data] = $value_data;

			}
		}
		$file_permission = substr(sprintf("%o", fileperms(base_path('.env'))),-4);
		$data['file_permission'] = ($file_permission == '0777' || $file_permission =='777')?'Writable':'Non-writable';//dd($data);
		
    	return view('env.index',compact('data'));
	}

	public function setEnvSetting(Request $request)
	{//dd($request->all());
		// $this->validate($request, [
		// 	'app_name' => 'required',
		// 	'app_env' => 'required',
		// 	'app_debug' => 'required',
		// 	'queue_driver' => 'required',
		// 	'app_url' => 'required',
		// 	'database_live' => 'required',
		// 	'database_username_live' => 'required',
		// 	'database_password_live' => 'required',
		// 	'database_demo' => 'required',
		// 	'database_username_demo' => 'required',
		// 	'database_password_demo' => 'required',
		// 	'mail_driver' => 'required',
		// 	'mail_host' => 'required',
		// 	'mail_port' => 'required',
		// 	'mail_username' => 'required',
		// 	'mail_password' => 'required',
		// 	'mail_encryption' => 'required',
		// 	'coinpayments_db_prefix' => 'required',
		// 	'coinpayments_merchant_id' => 'required',
		// 	'coinpayments_public_key' => 'required',
		// 	'coinpayments_private_key' => 'required',
		// 	'coinpayments_ipn_secret' => 'required',
		// 	'coinpayments_ipn_url' => 'required',
		// 	'coinpayments_api_format' => 'required',
		// 	'aws_access_key_id' => 'required',
		// 	'aws_secret_access_key' => 'required',
		// 	'aws_region' => 'required',
		// 	'captcha_sitekey' => 'required',
		// 	'captcha_secret' => 'required',
		// ]);

		try {
			
			foreach ($request->except('_token') as $key => $value) {
				$query = Env::where('key', $key);
				if($query->exists()) {
					$query->update([
						'status' => 0
					]);
				}
				Env::create(['key' => $key, 'value' => Crypt::encryptString($value)]);
				
			}
			$this->setEnvironmentValue($request->except('_token'));
			//$this->env->createOrUpdate($request->except('_token'));
			flash()->message('Env settings updated successfully !!');
		} catch (\Exception $exception) {
			Log::error($exception);
			flash()->error('Error! There is an error saving settings'.$exception->getMessage());
		}

		return redirect()->back();
	}

    function setEnvironmentValue($data)
	{//echo $name.'--'.$value.'--'.env($name);die;
		$path = base_path('.env.example');
		$envPath = base_path('.env');
		//chmod($envPath,0755);
		file_put_contents($envPath, file_get_contents($path));
		foreach($data as $name=>$value)
		{
			if (file_exists($path)) {
				$prevData = '__'.strtoupper($name);
				$currData = $value;//echo $prevData.'--'.$currData;die;
				
				file_put_contents($envPath, str_replace($prevData ,$currData , file_get_contents($envPath)));//echo $envData;die;
				
			}
		}
		return true;
	}

	// function setEnvironmentValue($name, $value)
	// {//echo $name.'--'.$value.'--'.env($name);die;
	// 	$path = base_path('.env.example');
	// 	if (file_exists($path)) {
	// 		echo $prevData = '__'.$name;
	// 		echo $currData = $value;

	// 		//$envfile = fopen(".env", "w");
	// 		file_put_contents($path, str_replace(
	// 			$prevData ,$currData , file_get_contents(base_path('.env'))
	// 		));
	// 	}
	// }

}
