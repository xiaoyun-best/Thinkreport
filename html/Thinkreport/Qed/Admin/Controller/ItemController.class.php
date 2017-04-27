<?php
namespace Admin\Controller;
use Think\Controller;
class ItemController extends CommonController {
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Inspectionitem');
    }
    public function itemlist(){
	    	$map=array();
	    	$tblInspectionItem_item = trim($_REQUEST['tblInspectionItem_item']);
		if(!empty($tblInspectionItem_item)){
			$map['tblInspectionItem_item'] = array("like","%".$tblInspectionItem_item."%");
			$search['tblInspectionItem_item'] = $tblInspectionItem_item;
		}
		$page_size = 10;
		$count = $this->model->where($map)->count (); // 查询满足要求的总记录数
		$p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
		$page = $p->show (); // 分页显示输出
		$fields = "*";
		$order = "tblInspectionItem_ID DESC";
		$Lsql = "{$p->firstRow},{$p->listRows}";
		$list = $this->model->field($fields)->where($map)->order($order)->limit($Lsql)->select ();
		//$this->assign('search',$search);
		$this->assign('list',$list);
		//dump($list);die;
		$this->assign('page',$page);
		$this->display();
	}
	public function editItem(){
		$menuname=$_GET['menuname'];
		if($_POST){
			$data['tblInspectionItem_item']=trim($_POST['tblInspectionItem_item']);
			if(!empty($_POST['id'])){
			    if($this->model->create($_POST,4)){
                    $re=$this->model->where('tblInspectionItem_ID='.$_POST['id'])->save($data);
                    if($re)$this->success('修改成功！',U('Item/itemlist'));
                }else{
                    $this->error($this->model->getError());
                }
			}else{
			    if($this->model->create($_POST)){
                    $re=$this->model->add($data);
                    if($re)$this->success('添加成功！',U('Item/itemlist'));
                }else{
			        $this->error($this->model->getError());
                }
			}
		}else{
			if($_GET['id'])$vol=$this->model->where('tblInspectionItem_ID='.$_GET['id'])->find();
			$this->assign('menuname',$menuname);
			$this->assign('vol',$vol);
			$this->display();
		}
	}
	public function del(){
		$id=$_GET['id'];
		$re= M ( 'Inspectionitem' )->where('tblInspectionItem_ID='.$id)->delete();
		if($re)$this->success('删除成功！',U('Item/itemlist'));

	}
}