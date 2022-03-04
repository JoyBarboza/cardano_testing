<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getPhoto($filename, $user=null)
    {
		if($user!=null){
			$username = $user;
		}else{
			$username = auth()->user()->id;
		} 
 
        //~ $filePath = storage_path('app').
            //~ DIRECTORY_SEPARATOR.'public'.
            //~ DIRECTORY_SEPARATOR.$username.
            //~ DIRECTORY_SEPARATOR.$filename;
            
         $filePath = storage_path('app').
            DIRECTORY_SEPARATOR.'public'.           
            DIRECTORY_SEPARATOR.$filename; 

        if(!file_exists($filePath)){
            $file = storage_path('app').DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'no-image.png';
        } else {
            $file = $filePath;
        }

        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if($ext == 'png' || $ext =='PNG'){
            $headers = array(
                'Content-Type' => 'image/png',
            );
        }elseif($ext == 'jpg' || $ext =='jpeg' || $ext =='JPEG' || $ext =='JPG'){
            $headers = array(
                'Content-Type' => 'image/jpeg',
            );
        }

        $response = response()->download($file,null, $headers);
        // ob_end_clean();
        return $response;
    }
}
