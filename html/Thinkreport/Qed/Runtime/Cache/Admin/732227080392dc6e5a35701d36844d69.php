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
        <ul class="breadcrumb">当前位置：
            <a href="#">子菜单管理</a>
            <span class="pull-right margin-bottom-5 gohistory" style='cursor:pointer;color:#000;'>返回上一级</span>
        </ul>
        <div class="title_right"><strong>子菜单列表</strong></div>
        <form method="get" name='form'>
            <table style="width:100%;">
                <tr align="left">
                    <td  align="left" nowrap="nowrap" bgcolor="#f1f1f1" >
                        子菜单名称：<input type="search" name='tblmenu_name'  value="<?php echo ($_GET['tblmenu_name']); ?>" />
                        <input type="button" value="查询" class="tijiao btn btn-info " style="width:80px;" /></td>
                </tr>
            </table>
        </form>

        <table class="table table-bordered table-striped table-hover">
            <tbody>
            <tr align="center">
                <td nowrap="nowrap sort" style="width:25%;"><strong>ID</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>子菜单名称</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>URL</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>添加人</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>编辑时间</strong></td>
                <td width="140" nowrap="nowrap" style="width:25%;"><strong>操作</strong></td>
            </tr>
            <?php if($list): if(is_array($list)): foreach($list as $key=>$val): ?><tr align="center" class='itemChange'>
                        <td nowrap="nowrap"><?php echo ($val['tblmenu_id']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblmenu_name']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblmenu_url']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblmenu_adduser']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblmenu_edittime']); ?></td>
                        <td nowrap="nowrap"><input type="hidden" class='id' value="<?php echo ($val["tblmenu_id"]); ?>" />
                            <a href="<?php echo U('Menu/editMenu',array('menuname'=>'修改子菜单','id'=>$val['tblmenu_id'],'tblmenu_PID'=>$val['tblmenu_pid']));?>">【修改】</a>&nbsp;&nbsp;
                            <a class='delete' style="cursor:pointer;">【删除】</a>
                    </tr><?php endforeach; endif; ?>
                <tr align="center" class='itemChange'>
                    <td colspan="6"><?php echo ($page); ?></td>
                </tr>
                <?php else: ?>
                <tr align="center" class='itemChange'><td colspan="5" style="color:red;">暂无子菜单</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    //返回上一页
    $('.gohistory').on('click',function(){
        window.history.go(-1);
    })
    $('.tijiao').on('click',function(){
        $('[name=form]').submit();
    })
    $('.delete').on('click',function(){
        if(confirm('确定要删除吗？')){
            var id=$(this).parents('.itemChange').find('.id').val();
            window.location.href='/Admin/Menu/del/id/'+id;
        }
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