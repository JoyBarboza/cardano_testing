<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Session;

class LanguageController extends Controller
{
    public function index()
	{
		$path=resource_path('lang/en');
		$files = $this->listFolderFiles($path); 
		$r_trim_file= rtrim($files,"<br>");
		$file_list_path= explode("<br>",$r_trim_file);	
		$data['file_list_path']=$file_list_path;
	
		return view('language.index',$data);
		
	}
	
	public function getFiles(Request $request)
	{
		$this->validate($request, [
			'language' => 'required',
			'file' => 'required',
		]);

		$path=resource_path('lang');
		$files = $this->listFolderFiles($path.'/en');
		$r_trim_file= rtrim($files,"<br>");
		$file_list_path= explode("<br>",$r_trim_file);
		$data['file_list_path']=$file_list_path;
		$data['request']=$request;

		try {

			$file_path=$path.'/'.$request->language.'/'.$request->file;
			$request->session()->put('file_path', $file_path);

			if(is_readable($file_path)){
				$myfile = fopen($file_path, "r") or die("Unable to open file!");
				$contentLang = fread($myfile,filesize($file_path));
			}
			$replace = str_replace("<?php","","$contentLang");
			$contentLanguage = str_replace("?>","","$replace");

			if($request->language=='en'){ $data['language']='English'; }
			if($request->language=='fr'){ $data['language']='French'; }
			if($request->language=='ja'){ $data['language']='Japanesse'; }
			if($request->language=='pt'){ $data['language']='Portugues'; }
			if($request->language=='es'){ $data['language']='Spanish'; }
			if($request->language=='ko'){ $data['language']='Korean'; }
			if($request->language=='zh'){ $data['language']='Chinese'; }
			if($request->language=='ru'){ $data['language']='Russian'; }

			$data['contentLang']=eval($contentLanguage.';');


		} catch (\Exception $exception) {
			Log::error($exception->getMessage());
			flash()->error(trans('auth/controller_msg.Error_error_saving_language'));
		}
		

		return view('language.index',$data);
	}
	
	public function exportToFile(Request $request)
	{
		try {
			$key_result_lang=$request->input('key_name');
			$val_result_lang=$request->input('key_val');

			$com_lang = (array_combine($key_result_lang,$val_result_lang));

			$file_path = Session::get('file_path');

			file_put_contents($file_path, '<?php'.PHP_EOL.'return '.var_export($com_lang, true).PHP_EOL.'?>');

			flash()->success('Successfully updated');
		} catch (\Exception $exception) {
			Log::error('Exception from export to file '. $exception->getMessage());
			flash()->error(trans('auth/controller_msg.Language_file_update_failed')); 
		}

		return redirect()->route('admin.language.index');
	}
	
	function listFolderFiles($dir){
		$str = '';
		$list = array();
		$ffs = scandir($dir); 
		foreach($ffs as $ff){
			if ( $ff != '.' && $ff != '..' ){
				if ( strlen($ff)>=5 ) {
					if ( substr($ff, -4) == '.php' ) {
						$list[] = $ff;                                     
						$str .= $dir."/".$ff."<br>"; 
					}    
				}       
				if( is_dir($dir.'/'.$ff) ){
						$a = $this->listFolderFiles($dir.'/'.$ff);
						$str .= $a."<br>"; 
					}
			}
		}
		return $str;
		
	}
}
