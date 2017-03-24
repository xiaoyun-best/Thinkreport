<?php
namespace Admin\Model;
use Think\Model;
class RolenodeModel extends Model
{
    protected $_validate = array(
        array('tblrolenode_RID', '', '用户已经设置权限', 0, 'unique'),
    );
    public function filterNull($array){
        foreach($array as $key=>$val){
            if(count($val)!=1){
                $result[]=$val;
            }
        }
        return $result;
    }
    //获取权限菜单
    public function getRolenodeMenu($rid){
        $menu=$this->where('tblrolenode_RID='.$rid)->getfield('tblrolenode_menu');
        $remenu=json_decode($menu,true);
        return $remenu;
    }
    //获取子权限菜单
    public function getNodesubMenu($array){
        foreach($array as $key=>$val){
            foreach($val['menusub'] as $value){
                $nodesub[]=$value['menuname'];
            }
        }
        return $nodesub;
    }
}