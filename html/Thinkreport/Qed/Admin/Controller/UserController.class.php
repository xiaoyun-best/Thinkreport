<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {
    public function __construct(){
        parent::__construct();
        $this->model = D('user');
        $this->roleModel=D('Role');
    }

    public function userlist(){
	    	$map=array();
	    	$tbluser_loginname = trim($_REQUEST['tbluser_loginname']);
		if(!empty($tbluser_loginname)){
			$map['tbluser_loginname'] = array("like","%".$tbluser_loginname."%");
			$search['tbluser_loginname'] = $tbluser_loginname;
		}
		$tbluser_displayname = trim($_REQUEST['tbluser_displayname']);
		if(!empty($tbluser_displayname)){
			$map['tbluser_displayname'] = array("like","%".$tbluser_displayname."%");
			$search['tbluser_displayname'] = $tbluser_displayname;
		}
		$model = M ( 'User' );
		$page_size = 10;
		$count = $model->where($map)->count (); // 查询满足要求的总记录数
		$p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
		$page = $p->show (); // 分页显示输出
		$fields = "*";
		$order = "tbluser_seq DESC";
		$Lsql = "{$p->firstRow},{$p->listRows}";
		$list = $model->field($fields)->where($map)->order($order)->limit($Lsql)->select ();
        $role = $this->roleModel->getRolelist();
        foreach($list as $key=>$val){
            foreach($role as $value){
                if($val['tbluser_rid']==$value['tblrole_id']){
                    $list[$key]['tbluser_role']=$value['tblrole_name'];
                }
            }
        }
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->display();
	}
	public function editUser(){
		$menuname=$_GET['menuname'];
		$model = M ( 'User' );		
		if($_POST){
			$data['tbluser_loginname']=trim($_POST['tbluser_loginname']);
			$data['tbluser_displayname']=trim($_POST['tbluser_displayname']);
			$password=trim($_POST['tbluser_password']);
			$data['tbluser_password']=md5($password);
			if($_POST['tbluser_password']!=$_POST['re_password']){
				$this->error('两次密码不一致！');
			}
			if(!empty($_POST['id'])){
				$re=$model->where('tbluser_ID='.$_POST['id'])->save($data);
				if($re)$this->success('修改成功！',U('User/userlist'));

			}else{
				$re=$model->add($data);
				if($re)$this->success('添加成功！',U('User/userlist'));
			}

		}else{
			if($_GET['id'])$user=$model->where('tbluser_ID='.$_GET['id'])->find();	
			$this->assign('menuname',$menuname);
			$this->assign('user',$user);
			$this->display();
		}
	}
	public function del(){
		$id=$_GET['id'];
		$re= M ( 'User' )->where('tbluser_ID='.$id)->delete();
		if($re)$this->success('删除成功！',U('User/userlist'));

	}
    public function editRole(){
        if($_POST){
            $tbluser_RID = $_POST['tbluser_RID'];
            $re = $this->model->where('tbluser_ID='.$_GET['id'])->setfield('tbluser_RID',$tbluser_RID);
            if($re){
                $this->success('设置成功',U('User/userlist'));
            }else{
                $this->error('权限未修改或修改失败',U('User/userlist'));
            }
        }else{
            $user = $this->model->where('tbluser_ID='.$_GET['id'])->find();
            $role = $this->roleModel->getRolelist();
            $this->assign('role',$role);
            $this->assign('rid',$user['tbluser_rid']);
            $this->display();
        }
    }
}