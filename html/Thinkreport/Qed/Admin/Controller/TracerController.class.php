<?php
namespace Admin\Controller;
use Think\Controller;
class TracerController extends CommonController {
	public function tracerlist(){
        $map = array();
        $tbltracer_tracer = trim($_REQUEST['tbltracer_tracer']);
		if(!empty($tbltracer_tracer)){
			$map['tbltracer_tracer'] = array("like","%".$tbltracer_tracer."%");
			$search['tbltracer_tracer'] = $tbltracer_tracer;
		}
		$model = M ( 'Tracer' );
		$page_size = 10;
		$count = $model->where($map)->count (); // 查询满足要求的总记录数
		$p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
		$page = $p->show (); // 分页显示输出
		$fields = "*";
		$order = "tbltracer_ID DESC";
		$Lsql = "{$p->firstRow},{$p->listRows}";
		$list = $model->field($fields)->where($map)->order($order)->limit($Lsql)->select ();
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->display();
	}
	public function editTracer(){
		$menuname = $_GET['menuname'];
		$model = M ( 'Tracer' );
		if($_POST){
			$data['tbltracer_tracer']=trim($_POST['tbltracer_tracer']);
            $data['tbltracer_method']=trim($_POST['tbltracer_method']);
			if(!empty($_POST['id'])){
				$re=$model->where('tbltracer_ID='.$_POST['id'])->save($data);
				if($re)$this->success('修改成功！',U('Tracer/tracerlist'));

			}else{
				$re=$model->add($data);
				if($re)$this->success('添加成功！',U('Tracer/tracerlist'));
			}
		}else{
			if($_GET['id'])$vol=$model->where('tbltracer_ID='.$_GET['id'])->find();
			$this->assign('menuname',$menuname);
			$this->assign('vol',$vol);
			$this->display();
		}
	}
	public function del(){
		$id=$_GET['id'];
		$re= M ( 'Tracer' )->where('tbltracer_ID='.$id)->delete();
		if($re)$this->success('删除成功！',U('Tracer/tracerlist'));

	}
}