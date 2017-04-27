<?php
namespace Admin\Controller;
use Think\Controller;
class AreaController extends CommonController {
	public function arealist(){
	    	$map=array();
	    	$tblInpatientArea_area = trim($_REQUEST['tblInpatientArea_area']);
		if(!empty($tblInpatientArea_area)){
			$map['tblInpatientArea_area'] = array("like","%".$tblInpatientArea_area."%");
			$search['tblInpatientArea_area'] = $tblInpatientArea_area;
		}
		$model = M ( 'Inpatientarea' );
		$page_size = 10;
		$count = $model->where($map)->count (); // 查询满足要求的总记录数
		$p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
		$page = $p->show (); // 分页显示输出
		$fields = "*";
		$order = "tblInpatientArea_ID DESC";
		$Lsql = "{$p->firstRow},{$p->listRows}";
		$list = $model->field($fields)->where($map)->order($order)->limit($Lsql)->select ();
		//$this->assign('search',$search);
		$this->assign('list',$list);
		//dump($list);die;
		$this->assign('page',$page);
		$this->display();
	}
	public function editArea(){
		$menuname=$_GET['menuname'];
		$model = M ( 'Inpatientarea' );		
		if($_POST){
			$data['tblInpatientArea_area']=trim($_POST['tblInpatientArea_area']);
			if(!empty($_POST['id'])){
				$re=$model->where('tblInpatientArea_ID='.$_POST['id'])->save($data);
				if($re)$this->success('修改成功！',U('Area/arealist'));

			}else{
				$re=$model->add($data);
				if($re)$this->success('添加成功！',U('Area/arealist'));
			}

		}else{
			if($_GET['id'])$vol=$model->where('tblInpatientArea_ID='.$_GET['id'])->find();
			$this->assign('menuname',$menuname);
			$this->assign('vol',$vol);
			$this->display();
		}
	}
	public function del(){
		$id=$_GET['id'];
		$re= M ( 'Inpatientarea' )->where('tblInpatientArea_ID='.$id)->delete();
		if($re)$this->success('删除成功！',U('Area/arealist'));

	}
}