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
            <a href="#">登记管理</a>
            <span class="pull-right margin-bottom-5 gohistory" style='cursor:pointer;color:#000;'>返回上一级</span>
        </ul>
        <div class="title_right">
            <span class="pull-right margin-bottom-5">
                <input type="button" onclick='outexcel()' value="导出EXCEL" class="btn btn-info"  />
            </span>
            <strong>登记列表</strong>
        </div>
        <!--start悬浮框搜索部分-->
        <div id="modal-container-9735581" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:600px; margin-left:-300px; top:20%">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">
                    搜索
                </h3>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                    <form method="get"  name='super_form' enctype="multipart/form-data">
                        <tr>
                            <td align="left"><input name="start_is_studydate" type="checkbox" value="1"/>起始日期</td>
                            <td><input type="text"  style="width:156px" name='start_tblstudy_studyDate' value="<?php echo ($_GET["start_tblstudy_studyDate"]); ?>" class="Wdate" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>&nbsp;&nbsp;<!--onclick="laydate()"-->
                            </td>

                        </tr>
                        <tr>
                            <td align="left"><input name="end_is_studydate" type="checkbox" value="1"/>截止日期</td>
                            <td><input type="text"  style="width:156px"  name='end_tblstudy_studyDate' value="<?php echo ($_GET["end_tblstudy_studyDate"]); ?>" class="Wdate"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>
                            </td>

                        </tr>
                        <tr>
                            <td><input name="is_item" type="checkbox" value="1"/>检查项目</td>
                            <td>
                                <select name="tblInspectionItem_ID" style="width:163px;">
                                    <option value=""></option>
                                    <?php if(is_array($inspectionitem)): foreach($inspectionitem as $key=>$item): if($item['tblinspectionitem_id']==$_GET['tblInspectionItem_ID']): ?><option value="<?php echo ($item["tblinspectionitem_id"]); ?>" selected="selected"><?php echo ($item["tblinspectionitem_item"]); ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo ($item["tblinspectionitem_id"]); ?>"><?php echo ($item["tblinspectionitem_item"]); ?></option><?php endif; endforeach; endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><input name="is_sid" type="checkbox" value="1"/>检查号</td>
                            <td><input name="tblstudy_SID" type="text" value="<?php echo ($_GET["tblstudy_SID"]); ?>"/></td>
                        </tr>
                        <tr>
                            <td><input name="is_name" type="checkbox" value="1"/>姓名</td>
                            <td><input name="tblpatient_name" type="text" value="<?php echo ($_GET["tblpatient_name"]); ?>"/></td>
                        </tr>
                        <tr>
                            <td><input name="is_reportstate" type="checkbox" value="1"/>报告状态</td>
                            <td>
                                <select name="tblstudy_reportState" style="width:163px;">
                                    <option value=""></option>
                                    <?php if(is_array($statuscolor)): foreach($statuscolor as $key=>$status): if($status['tblstatuscolor_id']==$_GET['tblstudy_reportState']): ?><option value="<?php echo ($status["tblstatuscolor_id"]); ?>" selected="selected"><?php echo ($status["tblstatuscolor_name"]); ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo ($status["tblstatuscolor_id"]); ?>"><?php echo ($status["tblstatuscolor_name"]); ?></option><?php endif; endforeach; endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><input name="is_flupstate" type="checkbox" value="1"/>随访状态</td>
                            <td>
                                <select name="tblflup_state" style="width:163px;" >
                                    <option value=""></option>
                                    <?php if(is_array($flupstate)): foreach($flupstate as $key=>$flup): if(strval($key)===$_GET['tblflup_state']): ?><option value="<?php echo ($key); ?>" selected="selected"><?php echo ($flup); ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo ($key); ?>"><?php echo ($flup); ?></option><?php endif; endforeach; endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><input name="is_department" type="checkbox" value="1"/>科室</td>
                            <td>
                                <select name="tbldepartment_ID" style="width:163px;">
                                    <option value=""></option>
                                    <?php if(is_array($department)): foreach($department as $key=>$depart): if($depart['tbldepartment_id']==$_GET['tbldepartment_ID']): ?><option value="<?php echo ($depart["tbldepartment_id"]); ?>" selected="selected"><?php echo ($depart["tbldepartment_department"]); ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo ($depart["tbldepartment_id"]); ?>"><?php echo ($depart["tbldepartment_department"]); ?></option><?php endif; endforeach; endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><input name="start_is_age" type="checkbox" value="1"/>最小年龄</td>
                            <td><input name="start_tblpatient_age" type="text" value="<?php echo ($_GET["start_tblpatient_age"]); ?>"/></td>
                        </tr>
                        <tr>
                            <td><input name="end_is_age" type="checkbox" value="1"/>最大年龄</td>
                            <td><input name="end_tblpatient_age" type="text" value="<?php echo ($_GET["end_tblpatient_age"]); ?>"/></td>
                        </tr>
                        <tr>
                            <td><input name="is_clinical" type="checkbox" value="1"/>临床诊断</td>
                            <td><input name="tblstudy_clinical" type="text" value="<?php echo ($_GET["tblstudy_sid"]); ?>"/ ></td>
                        </tr>
                        <tr>
                            <td><input name="is_finding" type="checkbox" value="1"/>检查所见</td>
                            <td><input name="tblstudy_finding" type="text" value="<?php echo ($_GET["tblstudy_finding"]); ?>"/></td>
                        </tr>
                        <tr>
                            <td><input name="is_suggestion" type="checkbox" value="1"/>诊断意见</td>
                            <td><input name="tblstudy_suggestion" type="text" value="<?php echo ($_GET["tblstudy_suggestion"]); ?>"/></td>
                        </tr>
                        <tr>
                            <td><input name="is_des" type="checkbox" value="1"/>随访结果</td>
                            <td><input name="tblflup_Des" type="text" value="<?php echo ($_GET["tblflup_Des"]); ?>"/></td>
                        </tr>
                    </form>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info tijiao" data-dismiss="modal" aria-hidden="true" style="width:80px">搜索</button>
                <button class="btn btn-info" data-dismiss="modal" aria-hidden="true" style="width:80px">取消</button>
            </div>
        </div>
        <!--end悬浮框搜索部分-->
        <form method="get" name='form'>
            <div id="trans">
            <table style="width:100%;">

                <tr align="left">
                    <td  align="left" nowrap="nowrap" bgcolor="#f1f1f1" >
                        <a  class="btn btn-info"  href="javascript:void(0)" onclick="tijiao1()" role="button" style="width:50px;">一天</a>&nbsp;
                        <a  class="btn btn-info"  href="javascript:void(0)" onclick="tijiao2()" role="button" style="width:50px;">两天</a>&nbsp;
                        <a  class="btn btn-info"  href="javascript:void(0)" onclick="tijiao3()" role="button" style="width:50px;">一周</a>&nbsp;
                        <a  class="btn btn-info"  href="#modal-container-9735581" role="button" data-toggle="modal">高级搜索</a>
                    </td>
                </tr>
            </table>
            </div>
        </form>

        <table class="table table-bordered table-striped table-hover">
            <tbody>
            <tr align="center">
                <td nowrap="nowrap" style="width:25%;"><strong>操作</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>病例号</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>姓名</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>拼音姓名</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>性别</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>年龄</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>身高</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>体重</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>电话</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>登记时间</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>检查号</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>住院号</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>床号</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>门诊号</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>影像号</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>检查类型</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>血糖(mmol/L)</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>科室</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>病区</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>检查项目</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>示踪剂</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>临床诊断</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>报告状态</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>报告医师</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>报告页数</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>审核医师</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>锁定状态</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>随访状态</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>收费情况</strong></td>
                <td nowrap="nowrap" style="width:25%;"><strong>添加人</strong></td>
            </tr>
            <?php if($list): if(is_array($list)): foreach($list as $key=>$val): ?><tr align="center" class='itemChange'>
                        <td nowrap="nowrap">
                            <input type="hidden" class='id' value="<?php echo ($val["tblstudy_id"]); ?>" />&nbsp;
                            <a href="<?php echo U('flup/flupedit',array('tblstudy_ID'=>$val['tblstudy_id'],'tblpatient_ID'=>$val['tblpatient_id']));?>" style="cursor:pointer;">【随访】</a>
                            <a href="<?php echo U('Medicalhistory/medicaledit',array('p_id'=>$val['tblpatient_id']));?>" style="cursor:pointer;">【病史管理】</a>
                            <a href="<?php echo U('Study/studyedit',array('id'=>$val['tblstudy_id']));?>" style="cursor:pointer;">【修改】</a>
                            <a class='delete' style="cursor:pointer;">【删除】</a>
                        </td>
                        <td nowrap="nowrap"><?php echo ($val['tblpatient_pid']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblpatient_name']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblpatient_pinyin']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblpatient_sex']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblpatient_birthday']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblpatient_height']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblpatient_weight']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblpatient_tel']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblpatient_tm']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblstudy_sid']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblstudy_hospitalizedid']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblstudy_sickbedid']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblstudy_outpatientid']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblstudy_imageid']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblstudy_modality']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblstudy_bloodsugarlevels']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tbldepartment_department']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblinpatientarea_area']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblinspectionitem_item']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tbltracer_tracer']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblstudy_clinical']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblstatuscolor_name']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblreport_doctor']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['repage']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblreport_checkdoctor']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblreport_islock']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblflup_state']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tblstudy_ischarges']); ?></td>
                        <td nowrap="nowrap"><?php echo ($val['tbluser_displayname']); ?></td>
                    </tr><?php endforeach; endif; ?>
                <tr align="center" class='itemChange'>
                    <td colspan="30"><?php echo ($page); ?></td>
                </tr>
                <?php else: ?>
                <tr align="center" class='itemChange'><td colspan="5" style="color:red;">暂无菜单</td></tr><?php endif; ?>
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
        $('[name=super_form]').submit();
    })
    function tijiao1(){
        $("#trans").html();
        addShow='<input type="hidden" name="day" value="1">';
        $("#trans").html(addShow);
        $('[name=form]').submit();
    }
    function tijiao2(){
        $("#trans").html();
        addShow='<input type="hidden" name="day" value="2">';
        $("#trans").html(addShow);
        $('[name=form]').submit();
    }
    function tijiao3(){
        $("#trans").html();
        addShow='<a  class="btn btn-info" role="button" style="width:50px;">一周</a>';
        //addShow='<input type="hidden" name="day" value="7">';
        $("#trans").html(addShow);
        $('[name=form]').submit();
    }
    $('.delete').on('click',function(){
        if(confirm('确定要删除吗？')){
            var id=$(this).parents('.itemChange').find('.id').val();
            window.location.href='/Admin/Study/del/id/'+id;
        }
    })
    function outexcel() {
        var tblpatient_birthday = '';
        var day                      = $('[name=day]').val();
        var start_tblstudy_studyDate = $('[name=start_tblstudy_studyDate]').val();
        var end_tblstudy_studyDate   = $('[name=end_tblstudy_studyDate]').val();
        var tblInspectionItem_ID     = $('[name=tblInspectionItem_ID]').val();
        var tblstudy_SID             = $('[name=tblstudy_SID]').val();
        var tblpatient_name          = $('[name=tblpatient_name]').val();
        var tblstudy_reportState     = $('[name=tblstudy_reportState]').val();
        var tblflup_state            = $('[name=tblflup_state]').val();
        var tbldepartment_ID         = $('[name=tbldepartment_ID]').val();
        var start_tblpatient_age     = $('[name=start_tblpatient_age]').val();
        var end_tblpatient_age       = $('[name=end_tblpatient_age]').val();
        var tblstudy_clinical        = $('[name=tblstudy_clinical]').val();
        var tblstudy_finding         = $('[name=tblstudy_finding]').val();
        var tblstudy_suggestion      = $('[name=tblstudy_suggestion]').val();
        var tblflup_Des              = $('[name=tblflup_Des]').val();
        window.location = '/Admin/Study/exportStudy?day=' + day +'&start_is_studydate=1&start_tblstudy_studyDate=' + start_tblstudy_studyDate +
            '&end_is_studydate=1&end_tblstudy_studyDate=' + end_tblstudy_studyDate + '&is_item=1&tblInspectionItem_ID=' + tblInspectionItem_ID +
            '&is_sid=1&tblstudy_SID=' + tblstudy_SID + '&is_name=1&tblpatient_name=' + tblpatient_name + '&is_reportstate=1&tblstudy_reportState=' + tblstudy_reportState +
            '&is_flupstate=1&tblflup_state=' + tblflup_state + '&is_department=1&tbldepartment_ID=' + tbldepartment_ID + '&start_is_age=1&start_tblpatient_age=' + start_tblpatient_age +
            '&end_is_age=1&end_tblpatient_age=' + end_tblpatient_age + '&is_clinical=1&tblstudy_clinical=' + tblstudy_clinical + '&is_finding=1&tblstudy_finding=' + tblstudy_finding +
            '&is_suggestion=1&tblstudy_suggestion=' + tblstudy_suggestion + '&is_des=1&tblflup_Des=' + tblflup_Des;
    }
</script>
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