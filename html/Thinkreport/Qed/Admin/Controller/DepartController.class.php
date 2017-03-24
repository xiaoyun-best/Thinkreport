<?php
namespace Admin\Controller;
use Think\Controller;
class DepartController extends CommonController {
	public function departlist(){
	    	$map=array();
	    	$tbldepartment_department = trim($_REQUEST['tbldepartment_department']);
		if(!empty($tbldepartment_department)){
			$map['tbldepartment_department'] = array("like","%".$tbldepartment_department."%");
			$search['tbldepartment_department'] = $tbldepartment_department;
		}
		$model = M ( 'Department' );
		$page_size = 10;
		$count = $model->where($map)->count (); // 查询满足要求的总记录数
		$p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
		$page = $p->show (); // 分页显示输出
		$fields = "*";
		$order = "tbldepartment_ID DESC";
		$Lsql = "{$p->firstRow},{$p->listRows}";
		$list = $model->field($field)->where($map)->order($order)->limit($Lsql)->select ();
		//$this->assign('search',$search);
		$this->assign('list',$list);
		//dump($list);die;
		$this->assign('page',$page);
		$this->display();
	}
	public function editDepart(){
		$menuname=$_GET['menuname'];
		$model = M ( 'Department' );	
		if($_POST){
			$data['tbldepartment_department']=trim($_POST['tbldepartment_department']);
			if(!empty($_POST['id'])){
				$re=$model->where('tbldepartment_ID='.$_POST['id'])->save($data);
				if($re)$this->success('修改成功！',U('Depart/departlist'));

			}else{
				$re=$model->add($data);
				if($re)$this->success('添加成功！',U('Depart/departlist'));
			}

		}else{
			if($_GET['id'])$val=$model->where('tbldepartment_ID='.$_GET['id'])->find();
			$this->assign('menuname',$menuname);
			$this->assign('val',$val);
			$this->display();
		}
	}
	public function del(){
		$id=$_GET['id'];
		$re= M ( 'Department' )->where('tbldepartment_ID='.$id)->delete();
		if($re)$this->success('删除成功！',U('Depart/departlist'));

	}
}