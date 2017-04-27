<?php
namespace Admin\Controller;
use Think\Controller;
class RolenodeController extends CommonController {
    public function __construct()
    {
        parent::__construct();
        $this->roleNodeModel= D('Rolenode');
    }
    public function nodelist(){
        $menuModel=D('Menu');
        $menuArr=$menuModel->getMenulist(0);
        foreach($menuArr as $key=>$val){
            $menusub=$menuModel->getMenulist($val['tblmenu_id']);
            $menuArr[$key]['menulist']=$menusub;
        }
        $RolenodeMenu=$this->roleNodeModel->getRolenodeMenu($_GET['rid']);
        $nodesubMenu=$this->roleNodeModel->getNodesubMenu($RolenodeMenu);
        $this->assign('nodesubMenu',$nodesubMenu);
        $this->assign('menuArr',$menuArr);
        $this->display();
    }
    public function nodeAdd(){
        $menuNode=array();
        foreach($_POST['menu'] as $key=>$val) {
            $menuNode[$key]['menu'] = $val;
            foreach (I($val) as $value) {
                $sub = explode('$$', $value);
                $menusub['menuname'] = $sub[0];
                $menusub['menuurl'] = $sub[1];
                $menuNode[$key]['menusub'][] = $menusub;
            }
        }
        $menuNode = $this->roleNodeModel->filterNull($menuNode);
        $data['tblrolenode_RID'] = $_POST['rid'];
        $data['tblrolenode_menu'] = json_encode($menuNode);
        $data['tblrolenode_adduser'] = $_SESSION['user']['tbluser_loginname'];
        if($this->roleNodeModel->create($data)){
            $re=$this->roleNodeModel->add($data);
        }else{
            $re = $this->roleNodeModel->where('tblrolenode_RID='.$_POST['rid'])->save($data);
        }
        if($re){
            $this->success('添加成功',U('Role/rolelist'));
        }else{
            $this->error('权限未修改');
        }
    }
}