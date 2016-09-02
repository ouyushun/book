<?php
namespace App\Http\Controllers\Service;
use App\Entity\Member;
use App\Entity\TempEmail;
use App\Entity\TemPhone;
use App\Http\Controllers\Controller;
use  Illuminate\Http\Request;
use Validator;
//use App\Tool\Validate\ValidateCode;
//use \App\Tool\SMS\SendTemplateSMS

class ValidateController extends Controller{

    /**
     * 发生成验证码
     */
    public function create(Request $request)
    {
        $validateCode = new \App\Tool\Validate\ValidateCode();
        $request->session()->put('validate_code', $validateCode->getCode());
        return $validateCode -> doimg();
        
    }

    /**
    * 发送短信验证
    */
    public function sendSMS(Request $request)
    {
        
        $m3_result = new \App\Models\M3Result;
        
        $phone = $request->input('phone','');
        
        if($phone == ''){
            $m3_result->status = 1;
            $m3_result->message = "手机号不能为空aafff" ;
            return $m3_result->toJson();
        }
        if(strlen($phone) != 11 || $phone[0] != '1') {
            $m3_result->status = 2;
            $m3_result->message = "手机格式不正确" ;
            return $m3_result->toJson();
        }
        
        $sendTemplateSMS = new \App\Tool\SMS\SendTemplateSMS();
        $charset = "1234567890";
        $code = '';
        for ($i = 0;$i <6;++$i) {
            $code .= $charset[mt_rand(0, 9)];
        }
        
        $m3_result = $sendTemplateSMS->sendTemplateSMS($phone,array($code,60),1);
        if($m3_result->status == 0){
            $temphone = TemPhone::where('phone',$phone)->first();
            if($temphone == null){
                $temphone = new TemPhone();
            }
            $temphone->phone = $phone;
            $temphone->code = $code;
            $temphone->deadline = time() + 60*60;
            $temphone->save();
        }
        
        return $m3_result->toJson();
    }

    public function validateEmail(Request $request)
    {
        $member_id = $request->input('member_id','');
        $code = $request->input('code','');
        if($member_id == '' || $code == ''){
            return "验证异常";
        }
        $temp_email = TempEmail::where('member_id',$member_id)->first();
        if($temp_email == null){
            return "验证异常";
        }
        if($temp_email->code == $code){
            if(time() > $temp_email->deadline){
                $temp_email->delete();
                Member::find($member_id)->delete();
                return "此链接已失效，请重新注册";
            }
            $member = Member::find($member_id);
            $member->active = 1;
            $member->save();
            return redirect('login');    
            
        }else{
            return "链接已失效";
        }
    }
}
