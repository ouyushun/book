@extends('admin.master')

@section('content')
  <link href="css/H-ui.login.css" rel="stylesheet" type="text/css" />

  <div class=""></div>
  <div class="loginWraper">
    <div id="loginform" class="loginBox">
      <form class="form form-horizontal" action="" method="post">
        <div class="row cl">
          <label class="form-label col-3"><i class="Hui-iconfont">&#xe60d;</i></label>
          <div class="formControls col-8">
            <input id="" name="username" type="text" placeholder="账户" class="input-text size-L">
          </div>
        </div>
        <div class="row cl">
          <label class="form-label col-3"><i class="Hui-iconfont">&#xe60e;</i></label>
          <div class="formControls col-8">
            <input id="" name="password" type="password" placeholder="密码" class="input-text size-L">
          </div>
        </div>
        <div class="row cl">
          <div class="formControls col-8 col-offset-3">
            <input class="input-text size-L" type="text"  name="code" placeholder="验证码" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
              <img src="{{url('service/validatecode/create')}}"   class="bk_validate_code"/> <a id="change" href="javascript:;">看不清，换一张</a> </div>
           
        </div>
        <div class="row">
          <div class="formControls col-8 col-offset-3">
            <label for="online">
              <input type="checkbox" name="online" id="online" value="">
              使我保持登录状态</label>
          </div>
        </div>
        <div class="row">
          <div class="formControls col-8 col-offset-3">
            <input onclick="onLogin();" name="" type="button" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
            <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="footer">Copyright 我的书店</div>
@endsection

@section('my-js')
    <script>
        
        $("#change").click(function () {
            $('.bk_validate_code').attr('src', '/service/validatecode/create?random='+ Math.random())
        })
        $('.bk_validate_code').click(function () {
            $(this).attr('src', '/service/validatecode/create?random='+ Math.random())
        });
    </script>
<script type="text/javascript">

  function onLogin() {

    var username = $('input[name=username]').val();
    var password = $('input[name=password]').val();
    var validate_code = $('input[name=code]').val();

      if(username.length == 0) {
          layer.msg('请输入账号', {icon:2, time:2000});
          return false;
      }
      

      //密码校验
      if(password.length == 0) {
          layer.msg('请输入密码', {icon:2, time:2000});
          return false;
      }
      if(password.length < 6){
          layer.msg('密码不小于6位', {icon:2, time:2000});
          return false;
      }

      //验证码校验
      if(validate_code == '') {
          layer.msg('请输入验证码', {icon:2, time:2000});
          return false;
      }
      if(validate_code.length != 4){
          layer.msg('验证码为4位', {icon:2, time:2000});
          return false;
      }
      
      $.ajax({
        type: 'post', // 提交方式 get/post
        url: '/admin/service/login', // 需要提交的 url
        dataType: 'json',
        data: {
          username: username,
          password: password,
          validate_code:validate_code,  
          _token: "{{csrf_token()}}"
        },
        success: function(data) {
          if(data == null) {
            layer.msg('服务端错误', {icon:2, time:2000});
            return;
          }
          if(data.status != 0) {
            layer.msg(data.message, {icon:2, time:2000});
            return;
          }

          location.href = '/admin/index';
        },
        error: function(xhr, status, error) {
          console.log(xhr);
          console.log(status);
          console.log(error);
          layer.msg('ajax error', {icon:2, time:1500});
        },
        beforeSend: function(xhr){
          layer.load(0, {shade: false});
        }
    });
  }

</script>
@endsection
