<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>回学报告管理平台</title>
<link rel="stylesheet" href="/Public/admin/css/bootstrap.css" />
 
<script type="text/javascript" src="/Public/admin/js/jquery1.9.0.min.js"></script>
<script type="text/javascript" src="/Public/admin/js/bootstrap.min.js"></script>
<style type="text/css">
body{ background: #abcdef no-repeat center 0px;}
.tit{ margin:auto; margin-top:170px; text-align:center; width:350px; padding-bottom:20px;}
.login-wrap{ width:220px; padding:30px 50px 0 330px; height:220px; background:#fff url(/Public/admin/image/first.png) no-repeat 30px 40px; margin:auto; overflow: hidden;}
.login_input{ display:block;width:210px;}
.login_user{ background: url(/Public/admin/image/input_icon_1.png) no-repeat 200px center; font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif}
.login_password{ background: url(/Public/admin/image/input_icon_2.png) no-repeat 200px center; font-family:"Courier New", Courier, monospace}
.btn-login{ background:#40454B; box-shadow:none; text-shadow:none; color:#fff; border:none;height:35px; line-height:26px; font-size:14px; font-family:"microsoft yahei";}
.btn-login:hover{ background:#333; color:#fff;}
.copyright{ margin:auto; margin-top:10px; text-align:center; width:370px; color:#CCC}
@media (max-height: 700px) {.tit{ margin:auto; margin-top:100px; }}
@media (max-height: 500px) {.tit{ margin:auto; margin-top:50px; }}
</style>
</head>

<body>
<div class="tit"><img src="/Public/admin/image/logo.png" alt="" /></div>
<form method="post" name='login'>
<div class="login-wrap" style="height:260px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25" valign="bottom">用户名：</td>
    </tr>
    <tr>
      <td>
      <input type="text" class="login_input login_user" style="height:28px" name='username'/>
      </td>
    </tr>
    <tr>
      <td height="25" valign="bottom">密  码：</td>
    </tr>
    <tr>
      <td><input type="password"  class="login_input login_password"  style="height:28px" name='password'/></td>
    </tr>
    <tr>
      <td height="25" valign="bottom">验证码：</td>
    </tr>
    <tr> 
    <td>      
       <input type="text" maxlength="4" class="in_r_1" name="verify" style="width:80px;height:28px">
       <img onclick="this.src=this.src+'?t='+Math.random()" id="imVcode" alt="点击换一个校验码" class="login_YZ" src="/Admin/Public/verify" style=" float:none;margin:0 3px"><!-- <a href="javascript:document.getElementById('imVcode').onclick();" style="color:black">刷新</a> -->
    </td>
   </tr>     
          
    <tr>
      <td height="60" valign="bottom"><a class="btn btn-block btn-login">登录</a></td>
    </tr>
   
  </table>
<script type="text/javascript">
  $('.btn').on('click',function(){
    var username=$('[name=username]').val();
    if(!username){
      alert('请输入用户名！！！');
      return false;
    }

    var username=$('[name=password]').val();
    if(!username){
      alert('请输入密码！！！');
      return false;
    }
     var verify=$('[name=verify]').val();
    if(!verify){
      alert('请输入验证码！！！');
      return false;
    }
    $('[name=login]').submit();
  });
  $('.login-wrap').keydown(function(e){  
  if(e.keyCode==13){  
   $('[name=login]').submit();//处理事件  
  }  
})
</script>
</div>
</form>
<div class="copyright">建议使用IE8以上版本或谷歌浏览器</div>
</body>
</html>