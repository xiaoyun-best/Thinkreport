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

<style type="text/css">
    fieldset {
        border: 2px groove threedface;
        border-image-source: initial;
        border-image-slice: initial;
        border-image-width: initial;
        border-image-outset: initial;
        border-image-repeat: initial;
    }
</style>
<div class="right"  id="mainFrame">

    <div class="right_cont">
        <ul class="breadcrumb">当前位置：
            <a>权限管理</a> <span class="divider">/</span>
            <a>权限列表</a> <span class="divider">/</span>
            <span class="pull-right margin-bottom-5 gohistory" style='cursor:pointer;'>返回上一级</span>
        </ul>

        <div class="title_right"><span class="pull-right margin-bottom-5"></span><strong>权限列表</strong></div>
        <form action="/Admin/Rolenode/nodeAdd" method="post" onsubmit="return checkName();"/>
        <?php if(count($menuArr) >= 1 ): ?><table width='96%' border='0' align='center' cellpadding='5' cellspacing='1' bgcolor="#CCCCCC" id="xz">
                <tr bgcolor="#ffffff">
                    <td width="181" align='right' bgcolor="#f5f5f5"><span class="z_red">*</span> <b>角色名称</b>：</td>
                    <td width="750" bgcolor="#ffffff">
                        <span style='color:red;'><?php echo ($_GET['rolename']); ?></span>
                    </td>
                </tr>
                <tr bgcolor="#ffffff">
                    <td colspan="2" align='right'>
                        <table width='100%' border='0' cellspacing='10' cellpadding='0'>
                            <?php if(is_array($menuArr)): foreach($menuArr as $key=>$value): if(count($value['menulist'])>=1){ ?>
                                <tr>
                                    <td>
                                        <fieldset style="margin-top:10px">
                                            <legend style="font-size:12px;">此管理员负责管理【<b><font color="#FF0000"><input type="hidden" name='menu[]' value="<?php echo ($value["tblmenu_name"]); ?>" /><?php echo ($value["tblmenu_name"]); ?></font></b>】
                                                模块</legend>
                                            <table width='100%' id="table3">
                                                <?php if(is_array($value["menulist"])): foreach($value["menulist"] as $key=>$val): ?><tr>
                                                        <td width="50%">
                                                            <dt style="float:left; margin-left:95px;">【<?php echo ($val["tblmenu_name"]); ?>】
                                                                <?php if(in_array($val['tblmenu_name'],$nodesubMenu)){ ?>
                                                                <input  type="checkbox" name="<?php echo ($value["tblmenu_name"]); ?>[]" class="areaId" value="<?php echo ($val["tblmenu_name"]); ?>$$<?php echo ($val["tblmenu_url"]); ?>" style="vertical-align:middle;" checked="checked">
                                                                <?php }else{ ?>
                                                                <input  type="checkbox" name="<?php echo ($value["tblmenu_name"]); ?>[]" class="areaId" value="<?php echo ($val["tblmenu_name"]); ?>$$<?php echo ($val["tblmenu_url"]); ?>" style="vertical-align:middle;">
                                                                <?php } ?>
                                                            </dt>
                                                        </td>
                                                    </tr><?php endforeach; endif; ?>
                                            </table>
                                        </fieldset>
                                    </td>
                                </tr>
                                <?php } endforeach; endif; ?>
                        </table></td>
                </tr>
                <input type='hidden' value="<?php echo ($_GET['rid']); ?>" name='rid'/>
                <tr bgcolor="#ffffff">
                    <td height="30" colspan="2" align='center' bgcolor="#ffffff">
                        <input type="Submit" name="Submit" value=" 确认 " onClick="return check();"/>
                        &nbsp;  <input type="reset" name="Submit2" value=" 重置  "/></td>
                </tr>
            </table>
            <?php else: ?>
            <table width='96%' border='0' align='center' cellpadding='5' cellspacing='1' bgcolor="#CCCCCC" id="xz" style="display:none1" >
                <tr>
                    <td colspan="11" style="color:red;font-size:24px;" align="center">暂无权限可以添加</td>
                </tr>
            </table><?php endif; ?>
    </div>
</div>
<script type="text/javascript">
    $('.gohistory').on('click',function(){
        window.history.go(-1);
    })
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