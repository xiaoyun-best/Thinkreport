<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>回学报告管理平台</title>
<link rel="stylesheet" href="/Public/admin/css/bootstrap.css" />
<link rel="stylesheet" href="/Public/admin/css/css.css" />
<script type="text/javascript" src="/Public/admin/js/jquery1.9.0.min.js"></script>
<script type="text/javascript" src="/Public/admin/js/jquery.form.min.js"></script>
<script type="text/javascript" src="/Public/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/admin/js/sdmenu.js"></script>
<script type="text/javascript" src="/Public/admin/js/laydate/laydate.js"></script>
<script type="text/javascript" src="/Public/admin/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<div class="header">
	 <div class="logo"><img  src="/Public/admin/image/logo.png" /></div>
     
				<div class="header-right">
                 <a href="">欢迎【<?php echo ($_SESSION['user']['tbluser_displayname']); ?>】登录</a>
                 <a href="/Admin/Public/editpsd">修改密码</a><a id="modal-973558" href="#modal-container-973558" role="button" data-toggle="modal">退出登录</a>
                <div id="modal-container-973558" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:300px; margin-left:-150px; top:30%">
				<div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">
						退出登录
					</h3>
				</div>
				<div class="modal-body">
					<p>
						您确定要注销退出系统吗？
					</p>
				</div>
				<div class="modal-footer">
					 <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button> <a class="btn btn-primary" style="line-height:20px;" href="/Admin/Public/loginout" >确定退出</a>
				</div>
			</div>
				</div>
</div>
<!-- 顶部 -->     
            
<div id="middle">
<div class="left">
     
     <script type="text/javascript">
var myMenu;
window.onload = function() {
	myMenu = new SDMenu("my_menu");
	myMenu.init();
};
</script>

<div id="my_menu" class="sdmenu">
	<!--动态菜单部分-->
	<?php if(count($_SESSION['menu'])>=1){ ?>
	<?php foreach($_SESSION['menu'] as $value){ ?>
		<div class="collapsed">
		<span><?php echo ($value["menu"]); ?></span>
		<?php foreach($value['menusub'] as $val){ ?>
		<a href="/Admin/<?php echo ($val["menuurl"]); ?>"><?php echo ($val["menuname"]); ?></a>
		<?php } ?>
		</div>
	<?php } ?>
	<?php }else{ ?>
	<span style='color:red;'>无浏览菜单权限</span>
	<?php } ?>
	 <!--<div class="collapsed">
		<span>管理员系统</span>
		 <a href="/Admin/User/userlist">用户</a>
		 <a href="/Admin/Role/rolelist">角色</a>
		 <a href="/Admin/Menu/menulist">菜单</a>
		 <a href="/Admin/Item/itemlist">检查项目</a>
		 <a href="/Admin/Tracer/tracerlist">示踪器</a>
		 <a href="/Admin/Depart/departlist">科室</a>
		 <a href="/Admin/Area/arealist">病区</a>
		 <a href="/Admin/Find/findlist">文字模板</a>
		 <a href="/Admin/User/index">状态</a>
	</div>
	<div class="collapsed">
		<span>预登记系统</span>
		<a href="/App/index">文字模板</a>
		<a href="/App/index">用户</a>
		<a href="/App/index">病区</a>
	</div>
	 <div class="collapsed">
		<span>报告系统</span>
		<a href="/App/index">文字模板</a>
		<a href="/App/index">用户</a>
		<a href="/App/index">病区</a>
	</div>
	<div class="collapsed">
		<span>审核系统</span>
		<a href="/App/index">文字模板</a>
		<a href="/App/index">用户</a>
		<a href="/App/index">病区</a>
	</div>-->
	
	
</div>

</div>
     <div class="Switch"></div>
<script type="text/javascript">
	$(document).ready(function(e) {
    $(".Switch").click(function(){
	$(".left").toggle();
	 
		});
});
</script>

<div class="right"  id="mainFrame">
  <div class="right_cont">
    <ul class="breadcrumb">&nbsp;
      <span class="pull-right margin-bottom-5 gohistory" style='cursor:pointer;color:#000;'>返回上一级</span>
    </ul>
    <div class="title_right"><strong><?php echo ($menuname); ?>：<?php echo ($user['tbluser_loginname']); ?>
      </tr></strong>
    </div>
    <form method="post" action=""  enctype="multipart/form-data">
      <table>
        <tbody>
        <input type="hidden"name="id" value="<?php echo ($user["tbluser_id"]); ?>" />
        <tr>
          <td align="right">登录名:</td>
          <td align="left"><input name="tbluser_loginname" type="text" value="<?php echo ($user['tbluser_loginname']); ?>"/></td>
        </tr>
        <tr>
          <td align="right">显示名:</td>
          <td align="left"><input name="tbluser_displayname" type="text" value="<?php echo ($user['tbluser_displayname']); ?>"/></td>
        </tr>
       <!-- <tr>
          <td align="right">密码:</td>
          <td align="left"><input name="tbluser_password" type="password" value="<?php echo ($user['tbluser_password']); ?>"/></td>
        </tr>
        <tr>
          <td align="right">确认密码:</td>
          <td align="left"><input name="re_password" type="password" value="<?php echo ($user['tbluser_password']); ?>"/></td>
        </tr>-->
        </tbody>
      </table>
      <div class="page_btm">
        <input type="submit" class="btn_b" value="提交" />
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">
//返回上一页
$('.gohistory').on('click',function(){
    window.history.go(-1);
})
//验证两次密码是否一致 
 $('[name=re_password]').on('change',function(){  
 var tbluser_password=$('[name=tbluser_password]').val();
 var re_password=$('[name=re_password]').val(); 
    if( tbluser_password!=re_password){
        alert('两次密码不一致！！！');
        return false;
      }
  });
</script>

    
<!-- 底部 -->
<div id="footer">版权所有:雅森 &copy; 2017&nbsp;&nbsp;&nbsp;&nbsp;</div>
    
    

 <script>
!function(){
laydate.skin('molv');
laydate({elem: '#Calendar'});
}();
 
</script>



 
</body>
</html>