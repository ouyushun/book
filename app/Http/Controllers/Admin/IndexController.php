<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M3Result;
use App\Entity\Admin;

class IndexController extends Controller
{
    public function login(Request $request)
  {
    $username = $request->input('username', '');
    $password = $request->input('password', '');

    $m3_result = new M3Result;

    if($username == '' || $password == '') {
      $m3_result->status = 1;
      $m3_result->message = "帐号或密码不能为空!";
      return $m3_result->toJson();
    }
   
    $admin = Manager::where('name', $username)->where('password', $password)->first();
    if(!$admin) {
      $m3_result->status = 2;
      $m3_result->message = "帐号或密码错误!";
    } else {
        $request->session()->put('admin', $admin);
        $m3_result->status = 0;
        $m3_result->message = "登录成功!";
        
    }

    return $m3_result->toJson();
  }

  public function toLogin()
  {
    return view('admin.login');
  }

  public function toExit(Request $request)
  {
    $request->session()->forget('admin');
    return view('admin.login');
  }

  public function toIndex(Request $request)
  {
    return view('admin.index');
  }

    public function toInfo()
    {
        return view('admin/info');
  }

}
