<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use App\Entity\TemPhone;
use App\Entity\TempEmail;
use App\Entity\Member;
use App\Tool\UUID;
use App\Models\M3Email;
use Mail;
use Illuminate\Support\Facades\Crypt;
class MemberController extends Controller
{
    public function register(Request $request)
    {
        $email = $request->input('email', '');
        $phone = $request->input('phone', '');
        $password = $request->input('password', '');
        $confirm = $request->input('confirm', '');
        $phone_code = $request->input('phone_code', '');
        $validate_code = strtolower($request->input('validate_code', ''));

        $m3_result = new M3Result;

        if($email == '' && $phone == '') {
            $m3_result->status = 1;
            $m3_result->message = '手机号或邮箱不能为空';
            return $m3_result->toJson();
        }
        if($password == '' || strlen($password) < 6) {
            $m3_result->status = 2;
            $m3_result->message = '密码不少于6位';
            return $m3_result->toJson();
        }
        if($confirm == '' || strlen($confirm) < 6) {
            $m3_result->status = 3;
            $m3_result->message = '确认密码不少于6位';
            return $m3_result->toJson();
        }
        if($password != $confirm) {
            $m3_result->status = 4;
            $m3_result->message = '两次密码不相同';
            return $m3_result->toJson();
        }

        // 手机号注册
        if($phone != '') {
            if($phone_code == '' || strlen($phone_code) != 6) {
                $m3_result->status = 5;
                $m3_result->message = '手机验证码为6位';
                return $m3_result->toJson();
            }

            $temPhone = TemPhone::where('phone', $phone)->first();
            
            $member = Member::where('phone', $phone)->first();
            if($member != null){
                $m3_result->status = 9;
                $m3_result->message = '此号码已经被注册！';
                return $m3_result->toJson();
            }
            
            if($temPhone->code == $phone_code) {
                if(time() > $temPhone->deadline) {
                    $m3_result->status = 7;
                    $m3_result->message = '手机验证码不正确';
                    return $m3_result->toJson();
                }

                $member = new Member;
                $member->phone = $phone;
                $member->password = Crypt::encrypt($password);
                $member->created_at = time();
                $member->save();

                $m3_result->status = 0;
                $m3_result->message = '注册成功';
                return $m3_result->toJson();
            } else {
                $m3_result->status = 7;
                $m3_result->message = '手机验证码不正确';
                return $m3_result->toJson();
            }

            // 邮箱注册
        } else {

            $member = Member::where('email', $email)->first();
            
            if($member != null){
                if($member->active == 1){
                    $m3_result->status = 9;
                    $m3_result->message = '此邮箱已经被注册！';
                    return $m3_result->toJson();
                }
            }
            
            if($validate_code == '' || strlen($validate_code) != 4) {
                $m3_result->status = 6;
                $m3_result->message = '验证码为4位';
                return $m3_result->toJson();
            }
            
            $validate_code_session = $request->session()->get('validate_code', '');
            if($validate_code_session != $validate_code) {
                $m3_result->status = 8;
                $m3_result->message = '验证码不正确';
                return $m3_result->toJson();
            }
            
            if($member == null){
                $member = new Member;
            }
            $member->email = $email;
            $member->password = Crypt::encrypt($password);
            $member->save();

            $uuid = UUID::create();

            $m3_email = new M3Email;
            $m3_email->to = $email;
            $m3_email->cc = 'ouyushunlzu@163.com';
            $m3_email->subject = '邮箱注册验证消息';
            $m3_email->content = '请于24小时点击该链接完成验证. http://book.com/service/validate_email'
                . '?member_id=' . $member->id
                . '&code=' . $uuid;

           $tempEmail = TempEmail::where('email',$email)->first();
            if($tempEmail == null){
                $tempEmail = new TempEmail;
            }
            $tempEmail->member_id = $member->id;
            $tempEmail->email = $email;
            $tempEmail->code = $uuid;
            $tempEmail->deadline = time() + 500;
            $tempEmail->save();

            Mail::send('email_register', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
                // $m->from('hello@app.com', 'Your Application');
                $m->to($m3_email->to, '尊敬的用户')
                    ->cc($m3_email->cc)
                    ->subject($m3_email->subject);
            });

            $m3_result->status = 0;
            $m3_result->message = '注册成功';
            return $m3_result->toJson();
        }
    }

    public function login(Request $request)
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
        
        //判断账号为邮箱或手机号
        if(strpos($username, '@')) {
            if(strpos($username, '.')){
                $m3_result->status = 4;
                $m3_result->message = '账号格式不正确';
                return $m3_result->toJson();
            }
            $member = Member::where('email',$username)->first();
        }else{
            if(strlen($username) != 11 || $username[0] != 1){
                $m3_result->status = 4;
                $m3_result->message = '账号格式不正确';
                return $m3_result->toJson();
            }
            $member = Member::where('phone',$username)->first();
        }
        
        if($member == null){
            $m3_result->status = 2;
            $m3_result->message = '用户不存在';
            return $m3_result->toJson();
        }
        if(Crypt::decrypt($member->password) != $password){
            $m3_result->status = 3;
            $m3_result->message = '用户名或密码错误';
            return $m3_result->toJson();
        }
        
        $request->session()->put('member',$member);
        
        $m3_result->status = 0;
        $m3_result->message = '登录成功';
        return $m3_result->toJson();
        
        
        
        
        
    }
}
