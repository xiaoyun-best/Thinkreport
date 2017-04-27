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
    body,p,div,h1,h2,h3,h4,h5,h6,ul,ol,li,dl,dt,dt,table,tr,td,th,form,input,select,textarea{
        padding:0;
        margin:0;
    }
</style>
<div class="right"  id="mainFrame">
    <div class="right_cont">
        <ul class="breadcrumb">&nbsp;
            <span class="pull-right margin-bottom-5 gohistory" style='cursor:pointer;'>返回上一级</span>
        </ul>
        <div class="title_right">
            <strong>登记信息</strong>
        </div>
        <div id="modal-container-9735581" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:600px; margin-left:-300px; top:20%">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">
                    添加报告
                </h3>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                    <form method="post"  name='form' enctype="multipart/form-data">
                        <tr>
                            <td align="right">检索条件</td>
                            <td align="left">
                                <select name="type" style="width:190px;">
                                <?php if(is_array($classes)): foreach($classes as $key=>$c): ?><option value="<?php echo ($key); ?>"><?php echo ($c); ?></option><?php endforeach; endif; ?></td>
                        </tr>
                        <tr>
                            <td align="right">所属属性：</td>
                            <td align="left"><select name="type" style="width:190px;" >
                                <?php if(is_array($classes)): foreach($classes as $key=>$c): ?><option value="<?php echo ($key); ?>"><?php echo ($c); ?></option><?php endforeach; endif; ?>
                            </select></td>
                        </tr>
                        <tr>
                            <td align="right">报告图片:</td>
                            <td align="left"><input name="image" type="file" value="0" class="span1-1" accept="image/*"/></td>
                        </tr>
                    </form>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" data-dismiss="modal" aria-hidden="true" style="width:80px">保存</button>
                <button class="btn btn-info" data-dismiss="modal" aria-hidden="true" style="width:80px">取消</button>
            </div>
        </div>
        <!-- 添加 -->
            <form method="post" action="/Admin/Study/studyadd" name='cform' enctype="multipart/form-data">
            <table>
                <tbody>
                <tr>
                    <!--左边表格-->
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td align="right">检索条件</td>
                                    <td align="left">
                                        <select name="condition" style="width:163px" >
                                            <?php if(is_array($classes)): foreach($classes as $key=>$c): ?><option value="<?php echo ($key); ?>"><?php echo ($c); ?></option><?php endforeach; endif; ?>
                                            <option value="<?php echo ($key); ?>">住院号</option>
                                            <option value="<?php echo ($key); ?>">门诊号</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">&nbsp;</td>
                                    <td align="left"><input name="content" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">病历号</td>
                                    <td align="left"><input name="tblpatient_PID" type="text"></td></td>
                                </tr>
                                <tr>
                                    <td align="right">姓名*</td>
                                    <td align="left"><input name="tblpatient_name" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">性别*</td>
                                    <td align="left">
                                        <select name="tblpatient_sex" style="width:163px;">
                                            <?php if(is_array($sexs)): foreach($sexs as $key=>$sex): ?><option value="<?php echo ($key); ?>"><?php echo ($sex); ?></option><?php endforeach; endif; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">年龄*</td>
                                    <td align="left"><input name="age" type="text" ></td>
                                </tr>
                                <tr>
                                    <td align="right">生日</td>
                                    <td align="left"><input name="tblpatient_birthday" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">住院号</td>
                                    <td align="left"><input name="tblstudy_hospitalizedID" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">门诊号</td>
                                    <td align="left"><input name="tblstudy_outpatientID" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">检查类型</td>
                                    <td align="left"><input name="tblstudy_modality" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">科室*</td>
                                    <td align="left">
                                        <select name="tbldepartment_ID" style="width:163px;">
                                            <option value=""></option>
                                            <?php if(is_array($department)): foreach($department as $key=>$depart): ?><option value="<?php echo ($depart["tbldepartment_id"]); ?>"><?php echo ($depart["tbldepartment_department"]); ?></option><?php endforeach; endif; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">示踪剂*</td>
                                    <td align="left">
                                        <select name="tbltracer_ID" style="width:163px;">
                                            <option value=""></option>
                                            <?php if(is_array($tracer)): foreach($tracer as $key=>$trac): ?><option value="<?php echo ($trac["tbltracer_id"]); ?>"><?php echo ($trac["tbltracer_tracer"]); ?></option><?php endforeach; endif; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">剂量(mCi)*</td>
                                    <td align="left"><input name="tblstudy_dose" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">登记时间</td>
                                    <td align="left"><input name="tblpatient_tm"  value="<?php echo ($time); ?>" class="Wdate" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">检查时间</td>
                                    <td align="left"><input name="tblstudy_studyDate" value="<?php echo ($time); ?>" class="Wdate" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">病理结果</td>
                                    <td align="left"><input name="tblstudy_pathological" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">医嘱</td>
                                    <td align="left">
                                        <textarea name="tblstudy_doctoradvice" cols="60" rows="35" style="width: 162px; height: 80px;"><?php echo ($vol['tblfindingsub_finding']); ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">收费情况</td>
                                    <td align="left">
                                        <select name="tblstudy_ischarges" style="width:163px;">
                                            <?php if(is_array($changes)): foreach($changes as $key=>$change): ?><option value="<?php echo ($key); ?>"><?php echo ($change); ?></option><?php endforeach; endif; ?>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <!--左边表格-->
                    <!--右边表格-->
                    <td>
                        <table>
                            <tbody>
                                <tr >
                                    <td align="right">&nbsp; </td>
                                    <td align="left" rowspan="2"><a class="btn btn-info" href="#modal-container-9735581" role="button" data-toggle="modal">连到hisi</a></td>
                                </tr>
                                <tr>
                                    <td align="right">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right">检查号*</td>
                                    <td align="left">
                                        <input name="tblstudy_SID"type="text" >
                                        <input name="build" value='1' type="checkbox">生成
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">姓名拼音*</td>
                                    <td align="left"><input name="tblpatient_pinyin"type="text" ></td>
                                </tr>
                                <tr>
                                    <td align="right">身高(cm)</td>
                                    <td align="left"><input name="tblpatient_height" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">体重(kg)*</td>
                                    <td align="left"><input name="tblpatient_weight" type="text" ></td>
                                </tr>
                                <tr>
                                    <td align="right">电话</td>
                                    <td align="left"><input name="tblpatient_tel" type="text" ></td>
                                </tr>
                                <tr>
                                    <td align="right">床号</td>
                                    <td align="left"><input name="tblstudy_sickbedID" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">影像号</td>
                                    <td align="left"><input name="tblstudy_imageID" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">血糖</td>
                                    <td align="left"><input name="tblstudy_BloodSugarLevels" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">病区*</td>
                                    <td align="left">
                                        <select name="tblInpatientArea_ID" style="width:163px;">
                                        <option value=""></option>
                                        <?php if(is_array($inpatientarea)): foreach($inpatientarea as $key=>$area): ?><option value="<?php echo ($area["tblinpatientarea_id"]); ?>"><?php echo ($area["tblinpatientarea_area"]); ?></option><?php endforeach; endif; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">检查项目*</td>
                                    <td align="left">
                                        <select name="tblInspectionItem_ID" style="width:163px;">
                                            <option value=""></option>
                                            <?php if(is_array($inspectionitem)): foreach($inspectionitem as $key=>$item): ?><option value="<?php echo ($item["tblinspectionitem_id"]); ?>"><?php echo ($item["tblinspectionitem_item"]); ?></option><?php endforeach; endif; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">状态</td>
                                    <td align="left">
                                        <select name="tblstudy_reportState" style="width:163px;">
                                            <option value=""></option>
                                            <?php if(is_array($statuscolor)): foreach($statuscolor as $key=>$status): ?><option value="<?php echo ($status["tblstatuscolor_id"]); ?>"><?php echo ($status["tblstatuscolor_name"]); ?></option><?php endforeach; endif; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">注射时间</td>
                                    <td align="left"><input name="tblstudy_injectionDate" value="<?php echo ($time); ?>" class="Wdate" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">临床诊断</td>
                                    <td align="left"><input name="tblstudy_clinical" type="text"></td>
                                </tr>
                                <tr>
                                    <td align="right">检查目的</td>
                                    <td lign="left"><input name="tblstudy_s_destination" type="text"></td>
                                </tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
                            </tbody>
                        </table>
                    </td>
                    <!--右边表格-->
                </tr>
                <tr>
                    <td rolspan="2">  <input type="button" class="btn btn-info tijiao" value="提交" /></td>
                </tr>
                <tbody>
            </table>
            </form>
    </div>
</div>
</div>
<script type="text/javascript">
    //返回上一页
    $('.gohistory').on('click',function(){
        window.history.go(-1);
    })
    //自动生成检查号
    $('[name=build]').on('click',function(){
        var attr = $('[name=build]').attr("checked");
        if(attr == 'checked'){
            $.ajax({
                type:'post',
                url:'/Admin/Study/getBuildsid',
                data:'',
                datatype:'json',
                success:function(req){
                    $('[name=tblstudy_SID]').val(req.tblstudy_SID);
                    $('[name=tblpatient_PID]').val(req.tblstudy_SID);
                }
            });
        }
    });
    //根据年龄计算生日
    $('[name=age]').on('change',function(){
        var age = $('[name=age]').val();
            $.ajax({
                type:'post',
                url:'/Admin/Study/getBirthday',
                data:{'age':age},
                datatype:'json',
                success:function(req){
                    $('[name=tblpatient_birthday]').val(req.birthday);
                }
            });
    });
    //根据生日计算年龄
    $('[name=tblpatient_birthday]').on('change',function(){
        var tblpatient_birthday = $('[name=tblpatient_birthday]').val();
        $.ajax({
            type:'post',
            url:'/Admin/Study/getAge',
            data:{'tblpatient_birthday':tblpatient_birthday},
            datatype:'json',
            success:function(req){
                $('[name=age]').val(req.age);
            }
        });
    });
    //校验必填参数
    $('.tijiao').on('click',function(){
        var tblstudy_SID = $('[name=tblstudy_SID]').val();
        if(!tblstudy_SID){
            alert('请填写检查号');
            return false;
        }
        var tblpatient_name = $('[name=tblpatient_name]').val();
        if(!tblpatient_name){
            alert('请填写姓名');
            return false;
        }
        var tblpatient_pinyin = $('[name=tblpatient_pinyin]').val();
        if(!tblpatient_pinyin){
            alert('请填写拼音姓名');
            return false;
        }
        var tblpatient_sex = $('[name=tblpatient_sex]').val();
        if(!tblpatient_sex){
            alert('请填写性别');
            return false;
        }
        var age = $('[name=age]').val();
        if(!age){
            alert('请填写年龄');
            return false;
        }
        var tblpatient_weight = $('[name=tblpatient_weight]').val();
        if(!tblpatient_weight){
            alert('请填写体重');
            return false;
        }
        var tbldepartment_ID = $('[name=tbldepartment_ID]').val();
        if(!tbldepartment_ID) {
            alert('请填写科室');
            return false;
        }
        var tblInpatientArea_ID = $('[name=tblInpatientArea_ID]').val();
        if(!tblInpatientArea_ID){
            alert('请填写病区');
            return false;
        }
        var tbltracer_ID = $('[name=tbltracer_ID]').val();
        if(!tbltracer_ID){
            alert('请填写示踪剂');
            return false;
        }
        var tblInspectionItem_ID = $('[name=tblInspectionItem_ID]').val();
        if(!tblInspectionItem_ID){
            alert('请填写检查项目');
            return false;
        }
        var tblstudy_dose = $('[name=tblstudy_dose]').val();
        if(!tblstudy_dose){
            alert('请填写剂量');
            return false;
        }
        $('[name=cform]').submit();
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