<?php
namespace Admin\Model;
use Think\Model;
class CustomModel extends Model{
    protected $_validate=array(
        //4----用户添加场景
        array('tblcustom_displayname','','该显示名称已存在！',0,'unique'),
        // array('tblmenu_name','','该菜单名称已存在！',0,'unique',5),//用于编辑场景
        //array('tblmenu_url','','该菜单地址已存在！',0,'unique'),
    );

}