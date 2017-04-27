<?php
namespace Admin\Model;
use Think\Model;
class InspectionitemModel extends Model{
    protected $_validate=array(
        //4----用户添加场景
       // array('tblInspectionItem_item','','检查项目已存在！',0,'unique',4),//用于添加场景
        array('tblInspectionItem_item','0,20','长度不超过20个字符！',0,'length'),//用于添加场景
    );

}