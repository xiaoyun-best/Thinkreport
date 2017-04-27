<?php
namespace Admin\Controller;
use Think\Controller;
class FindController extends CommonController {
	public function findlist(){
	    	$map=array();
	    	$tblFinding_Find = trim($_REQUEST['tblFinding_Find']);
		if(!empty($tblFinding_Find)){
			$map['tblFinding_Find'] = array("like","%".$tblFinding_Find."%");
			$search['tblFinding_Find'] = $tblFinding_Find;
		}
		$model = M ( 'Finding' );
		$page_size = 10;
		$count = $model->where($map)->count (); // 查询满足要求的总记录数
		$p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
		$page = $p->show (); // 分页显示输出
		$fields = "*";
		$order = "tblfinding_seq DESC";
		$Lsql = "{$p->firstRow},{$p->listRows}";
		$list = $model->field($fields)->where($map)->order($order)->limit($Lsql)->select ();
		//$this->assign('search',$search);
		$this->assign('list',$list);
		//dump($list);die;
		$this->assign('page',$page);
		$this->display();
	}
	public function editFind(){
		$menuname=$_GET['menuname'];
		$model = M ( 'Finding' );
		//dump($_GET);die;	
		if($_POST){
			$data['tblfinding_title']=trim($_POST['tblfinding_title']);
			if(!empty($_POST['id'])){
				$re=$model->where('tblfinding_ID='.$_POST['id'])->save($data);
				if($re)$this->success('修改成功！',U('Find/findlist'));

			}else{
				$re=$model->add($data);
				if($re)$this->success('添加成功！',U('Find/findlist'));
			}

		}else{
			if($_GET['id'])$vol=$model->where('tblfinding_ID='.$_GET['id'])->find();
			$this->assign('menuname',$menuname);
			$this->assign('vol',$vol);
			$this->display();
		}
	}
	public function del(){
		$id=$_GET['id'];
		$re= M ( 'Finding' )->where('tblfinding_ID='.$id)->delete();
		if($re)$this->success('删除成功！',U('Find/findlist'));

	}

	public function findsub(){
	    	$map=array();
	    	$map['tblfinding_ID']=$_GET['tblfinding_ID'];
	    	//dump($map);die;
	    	/*$tblFinding_Find = trim($_REQUEST['tblFinding_Find']);
		if(!empty($tblFinding_Find)){
			$map['tblFinding_Find'] = array("like","%".$tblFinding_Find."%");
			$search['tblFinding_Find'] = $tblFinding_Find;
		}*/
		$model = M ( 'Findingsub' );
		$page_size = 10;
		$count = $model->where($map)->count (); // 查询满足要求的总记录数
		$p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
		$page = $p->show (); // 分页显示输出
		$fields = "*";
		$order = "tblfindingsub_seq DESC";
		$Lsql = "{$p->firstRow},{$p->listRows}";
		$list = $model->field($fields)->where($map)->order($order)->limit($Lsql)->select ();
		//$this->assign('search',$search);
		$this->assign('list',$list);
		$this->assign('tblfinding_ID',$_GET['tblfinding_ID']);
		$this->assign('page',$page);
		$this->display();
	}
	public function editFindsub(){
		$menuname=$_GET['menuname'];
		$model = M ( 'Findingsub' );
		//dump($_GET);die;	
		if($_POST){
			$data['tblfindingsub_subtitle']=trim($_POST['tblfindingsub_subtitle']);
			$data['tblfindingsub_finding']=trim($_POST['tblfindingsub_finding']);
			$data['tblfindingsub_suggest']=trim($_POST['tblfindingsub_suggest']);
			//dump($_POST);die;
			if(!empty($_POST['id'])){
				$re=$model->where('tblfindingsub_ID='.$_POST['id'])->save($data);
				if($re)$this->success('修改成功！',U('Find/findsub',array('tblfinding_ID'=>$_POST['tblfinding_ID'])));

			}else{
				$re=$model->add($data);
				if($re)$this->success('添加成功！',U('Find/findsub'));
			}

		}else{
			if($_GET['id'])$vol=$model->where('tblfindingsub_ID='.$_GET['id'])->find();
			$this->assign('menuname',$menuname);
			$this->assign('tblfinding_ID',$_GET['tblfinding_ID']);
			$this->assign('vol',$vol);
			$this->display();
		}
	}
	public function delsub(){
		$id=$_GET['id'];
		$re= M ( 'Finding' )->where('tblfinding_ID='.$id)->delete();
		if($re)$this->success('删除成功！',U('Find/findlist'));

	}
}