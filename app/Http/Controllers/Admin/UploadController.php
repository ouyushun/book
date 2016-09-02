<?php

namespace App\Http\Controllers\Admin;

use App\Models\M3Result;
use App\Tool\UUID;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function uploadFile(Request $request,$type)
    {
        $file = $request->file("file");
        
        $m3_result = new M3Result();
        if($_FILES["file"]["error"]>0){
            $m3_result->status = 2;
            $m3_result->message = "未知错误，错误码：". $_FILES['file']["error"];
            return $m3_result->toJson();
        }
        
        if($_FILES["file"]["size"] > 1024*1024*10){
            $m3_result->status = 2;
            $m3_result->message = "图片大小不能超过10M";
            return $m3_result->toJson();
        }
        
        $public_dir = sprintf('upload/%s/%s',$type,date("Y-m-d"));
        
        if(!file_exists($public_dir)){
            mkdir($public_dir,0777,true);
        }
        
        if($file->isValid()){
            $entension = $file->getClientOriginalExtension(); //上传文件的后缀.
            $upload_filename = UUID::create().'.'.$entension;
            $file->move($public_dir, $upload_filename);
            $upload_path = '/'.$public_dir.'/'.$upload_filename;
            $m3_result->status = 0;
            $m3_result->message = "上传成功";
            $m3_result->url = $upload_path;
            return $m3_result->toJson();
        }else{
            $m3_result->status = 2;
            $m3_result->message = $file->getErrorMessage();
            return $m3_result->toJson();
        }
        
         
        
    }
}
