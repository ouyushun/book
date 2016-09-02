<?php

namespace App\Http\Controllers\Admin;
use App\Entity\Manager;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;

class ManagerController extends Controller
{
    public function toAdminLogin()
    {
        return view('admin.login');
    }
    
    
    
    
    
    
    
    /***********Service************/

    public function adminLogin(Request $request)
    {
        $username = $request->input('username','');
        $password = $request->input('password','');
        $validate_code = strtolower($request->input('validate_code', ''));
        $m3_result = new M3Result;

        if($username == '') {
            $m3_result->status = 1;
            $m3_result->message = '手机号或邮箱不能为空';
            return $m3_result->toJson();
        }


        $validate_code_session = $request->session()->get('validate_code');
        if($validate_code != $validate_code_session){
            $m3_result->status = 1;
            $m3_result->message = '验证码不正确';
            return $m3_result->toJson();
        }
        
        $member = Manager::where('name',$username)->first();
        if($member == null){
            $m3_result->status = 2;
            $m3_result->message = '用户不存在';
            return $m3_result->toJson();
        }
        if($member->password != $password){
            $m3_result->status = 3;
            $m3_result->message = '用户名或密码错误';
            return $m3_result->toJson();
        }

        $request->session()->put('admin',$member);

        $m3_result->status = 0;
        $m3_result->message = '登录成功';
        return $m3_result->toJson();
    }

    public function toExit(Request $request)
    {
        session(['admin'=>null]);
        return redirect('/admin/login');
    }
    
    
    
}
