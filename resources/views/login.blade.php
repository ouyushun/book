
@extends('master')
@include('/component/dialog')
@section('title','登录')  <!--两个参数，已经闭合，无需关闭-->

@section('content')
    <div class="weui_cells_title"></div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">帐号</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="tel" name="account" placeholder="邮箱或手机号"/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" name="password"  placeholder="不少于6位"/>
            </div>
        </div>
        <div class="weui_cell weui_vcode">
            <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text"  name="validate_code" placeholder="请输入验证码"/>
            </div>
            <div class="weui_cell_ft">
                <img src="{{url('service/validatecode/create')}}"   class="bk_validate_code"/>
            </div>
        </div>
    </div>
    <div class="weui_cells_tips"></div>
    <div class="weui_btn_area">
        <a class="weui_btn weui_btn_primary" href="javascript:" onclick="onLoginClick();">登录</a>
    </div>
    
    <a href="{{url('register')}}" class="bk_bottom_tips bk_important">没有帐号? 去注册</a>
@endsection

@section('my_js')
 <script>
     $('.bk_validate_code').click(function () {
        $(this).attr('src', '/service/validatecode/create?random='+ Math.random())
     });
     
 </script>   


<script>
    function onLoginClick() {
        var username = $('input[name=account]').val();
        var password = $('input[name=password]').val();
        var validate_code = $('input[name=validate_code]').val();
        if(username.length == 0) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html('请输入账号');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return false;
        }
        if(username.indexOf('@') == -1){
            if(username.length != 11 || username[0] != 1){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('账号格式不正确');
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                return false;
            }
        }else{
            if(username.indexOf('.') == -1){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('账号格式不正确');
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                return false;
            }
        }
        
        //密码校验
        if(password.length == 0) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html('请输入密码');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return false;
        }
        if(password.length < 6){
            $('.bk_toptips').show();
            $('.bk_toptips span').html('密码长度不小于6位');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return false;
        }
        
        //验证码校验
        if(validate_code == '') {
            $('.bk_toptips').show();
            $('.bk_toptips span').html('请输入验证码');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return false;
        }
        if(validate_code.length != 4){
            $('.bk_toptips').show();
            $('.bk_toptips span').html('验证码长度为4');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return false;
        }

        $.ajax({
            type: "POST",
            url: '/service/login',
            dataType: 'json',
            cache: false,
            data: {username: username,password: password, validate_code: validate_code, _token: "{{csrf_token()}}"},
            success: function(data) {
                if(data == null) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('服务端错误');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }
                if(data.status != 0) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html(data.message);
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }
                
                $('.bk_toptips').show();
                $('.bk_toptips span').html(data.message);
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                if('{{$return_url}}' == ''){
                    location.href = '/category';
                }else{
                    location.href = '{{$return_url}}';
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });//end ajax
        
    }
</script>
@endsection
