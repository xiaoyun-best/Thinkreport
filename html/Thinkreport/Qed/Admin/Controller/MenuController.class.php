<?php
namespace Admin\Controller;
use Think\Controller;
class MenuController extends CommonController {
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Menu');
    }
    public function Menulist(){
        $map=array();
        $map['tblmenu_PID']=0;
        $tblmenu_name = trim($_REQUEST['tblmenu_name']);
        if(!empty($tblmenu_name)){
            $map['tblmenu_name'] = array("like","%".$tblmenu_name."%");
        }
        $page_size = 10;
        $count = $this->model->where($map)->count (); // 查询满足要求的总记录数
        $p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
        $page = $p->show (); // 分页显示输出
        $fields = "*";
        $order = "tblmenu_ID DESC";
        $Lsql = "{$p->firstRow},{$p->listRows}";
        $list = $this->model->field($fields)->where($map)->order($order)->limit($Lsql)->select ();
        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->display();
    }
    public function editMenu(){
        $menuname = $_GET['menuname'];
        $pid = $_REQUEST['tblmenu_PID'];
        $menu =$this->model->field('tblmenu_ID,tblmenu_name')->where('tblmenu_PID=0')->select();
        if($_POST){
            $data['tblmenu_name']=trim($_POST['tblmenu_name']);
            $data['tblmenu_PID']=trim($_POST['tblmenu_PID']);
            $data['tblmenu_url']=trim($_POST['tblmenu_url']);
            $data['tblmenu_adduser']=$_SESSION['user']['tbluser_loginname'];
            if( empty($data['tblmenu_name']) ){
                $this->error('菜单名不能为空');
            }
            if( $data['tblmenu_PID']!=0 && empty($data['tblmenu_url']) ){
                $this->error('菜单地址不能为空');
            }
            if($this->model->create($data)){
                if(!empty($_POST['id'])){
                    $re=$this->model->where('tblmenu_ID='.$_POST['id'])->save($data);
                    if( $re){
                        if($pid==0)$this->success('修改成功！',U('Menu/menulist'));
                        else $this->success('修改成功！',U('Menu/menusub',array('id'=>$pid)));
                    }
                }else{
                    $re=$this->model->add($data);
                    if($re)$this->success('添加成功！',U('Menu/menulist'));
                }
            }else{
                $this->error($this->model->getError());
            }
        }else{
            if($_GET['id'])$val = $this->model->where('tblmenu_ID='.$_GET['id'])->find();
            $this->assign('menuname',$menuname);
            $this->assign('menu',$menu);
            $this->assign('pid',$pid);
            $this->assign('val',$val);
            $this->display();
        }
    }
    public function menusub(){
        $map=array();
        $map['tblmenu_PID']=$_GET['id'];
        $tblmenu_name = trim($_REQUEST['tblmenu_name']);
        if(!empty($tblmenu_name)){
            $map['tblmenu_name'] = array("like","%".$tblmenu_name."%");
        }
        $page_size = 10;
        $count = $this->model->where($map)->count (); // 查询满足要求的总记录数
        $p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
        $page = $p->show (); // 分页显示输出
        $fields = "*";
        $order = "tblmenu_ID DESC";
        $Lsql = "{$p->firstRow},{$p->listRows}";
        $list = $this->model->field($fields)->where($map)->order($order)->limit($Lsql)->select ();
        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->display();
    }
    public function del(){
        $id = $_GET['id'];
        $menulist=$this->model->getMenulist($id);
        if($menulist){
            $this->error('该菜单下有子菜单，不允许删除！',U('Menu/menulist'));
        }
        $re= M ( 'Menu' )->where('tblmenu_ID='.$id)->delete();
        if($re)$this->success('删除成功！',U('Menu/menulist'));

    }
}