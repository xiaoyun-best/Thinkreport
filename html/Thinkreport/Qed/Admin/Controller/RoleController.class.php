<?php
namespace Admin\Controller;
use Think\Controller;
class RoleController extends CommonController {
    public function rolelist(){
        $map=array();
        $tblrole_name = trim($_REQUEST['tblrole_name']);
        if(!empty($tblrole_name)){
            $map['tblrole_name'] = array("like","%".$tblrole_name."%");
            $search['tblrole_name'] = $tblrole_name;
        }
        $model = M ( 'Role' );
        $page_size = 10;
        $count = $model->where($map)->count (); // 查询满足要求的总记录数
        $p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
        $page = $p->show (); // 分页显示输出
        $fields = "*";
        $order = "tblrole_ID DESC";
        $Lsql = "{$p->firstRow},{$p->listRows}";
        $list = $model->field($fields)->where($map)->order($order)->limit($Lsql)->select ();
        $this->assign('search',$search);
        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->display();
    }
    public function editRole(){
        $menuname = $_GET['menuname'];
        $model = M ( 'Role' );
        if($_POST){
            $data['tblrole_name']=trim($_POST['tblrole_name']);
            $data['tblrole_content']=trim($_POST['tblrole_content']);
            $data['tblrole_adduser']=$_SESSION['user']['tbluser_loginname'];
            if(!empty($_POST['id'])){
                $re=$model->where('tblrole_ID='.$_POST['id'])->save($data);
                if($re)$this->success('修改成功！',U('Role/rolelist'));

            }else{
                $re=$model->add($data);
                if($re)$this->success('添加成功！',U('Role/rolelist'));
            }

        }else{
            if($_GET['id'])$val=$model->where('tblrole_ID='.$_GET['id'])->find();
            $this->assign('menuname',$menuname);
            $this->assign('val',$val);
            $this->display();
        }
    }
    public function del(){
        $id = $_GET['id'];
        $re= M ( 'Role' )->where('tblrole_ID='.$id)->delete();
        if($re)$this->success('删除成功！',U('Role/rolelist'));

    }
}