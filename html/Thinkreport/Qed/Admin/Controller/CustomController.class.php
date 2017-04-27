<?php
namespace Admin\Controller;
use Think\Controller;
class CustomController extends CommonController {
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Custom');
    }
    public function customlist(){
        $map = array();
        $tblcustom_name = trim($_GET['tblcustom_name']);
        if(!empty($_GET['tblcustom_name'])){
            $map['tblcustom_name'] = array('like','%'.$tblcustom_name.'%');
        }
        $tblcustom_displayname = trim($_GET['tblcustom_displayname']);
        if(!empty($_GET['tblcustom_displayname'])){
            $map['tblcustom_displayname'] = array('like','%'.$tblcustom_displayname.'%');
        }
        $page_size = 10;
        $count = $this->model->where($map)->count (); // 查询满足要求的总记录数
        $p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
        $page = $p->show (); // 分页显示输出
        $order = "tblcustom_ID DESC";
        $Lsql = "{$p->firstRow},{$p->listRows}";
        $fields='*';
        $list = $this->model->field($fields)->where($map)->order($order)->limit($Lsql)->select();
        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->display();
    }
    public function editCustom(){
        $menuname = $_GET['menuname'];
       // $displayname = $this->model->where($con)->getfield('')
        if( $_POST ){
            if( $this->model->create($_POST) ){
                $data['tblcustom_name']        = trim($_POST['tblcustom_name']);
                $data['tblcustom_displayname'] = trim($_POST['tblcustom_displayname']);
                if( !empty( $_POST['id'] ) ){
                    $re = $this->model->where('tblcustom_ID='.$_POST['id'])->save($data);
                    if($re) $this->success('修改成功！',U('Custom/customlist'));

                }else{
                    $re = $this->model->add($data);
                    if($re) $this->success('添加成功！',U('Custom/customlist'));
                }
            }else{
                exit($this->model->getError());
            }


        }else{
            if( $_GET['id'] ) $vol = $this->model->where('tblcustom_ID='.$_GET['id'])->find();
            $this->assign('menuname',$menuname);
            $this->assign('vol',$vol);
            $this->display();
        }
    }
    public function del(){
        $id = $_GET['id'];
        $isshow = $this->model->where('tblcustom_ID='.$id)->getfield('tblcustom_isshow');
        if( $isshow ){
            $this->error('该字段已存在于报告表！',U('Custom/customlist'));
        }
        $re = $this->model->where('tblcustom_ID='.$id)->delete();
        if($re) $this->success('删除成功！',U('Custom/customlist'));

    }
    public function isshow(){
        $studymodel = D('Study');
        $id = $_GET['id'];
        if( $_GET['tblcustom_isshow'] == 0 ){
            $sql = "alter table tblstudy add ".$_GET['tblcustom_displayname']." varchar(255) not null default ''";
            $data['tblcustom_isshow'] = 1;
        }else{
            $sql = 'alter table tblstudy drop '.$_GET['tblcustom_displayname'];
            $data['tblcustom_isshow'] = 0;
        }
        $this->model->startTrans();
        $re = $this->model->where('tblcustom_ID='.$id)->save($data);
        if($re) {
            $addre=$studymodel->execute($sql);
           // dump($addre);die;
            if( $addre===0 ){
                $this->model->commit();
                $this->success('操作成功！',U('Custom/customlist'));
            }else{
                $this->model->rollback();
                $this->error($studymodel->getError(),U('Custom/customlist'));
            }


        }else{
            $this->model->rollback();
            $this->error('操作失败！',U('Custom/customlist'));
        }

    }



}