<?php
namespace Admin\Model;
use Think\Model;
class StudyModel extends Model{
    protected $_validate=array(
        array('tblstudy_SID','require','检查号不能为空！'),
        array('tbldepartment_ID','require','科室不能为空！'),
        array('tblInpatientArea_ID','require','病区不能为空！'),
        array('tbltracer_ID','require','示踪剂不能为空！'),
        array('tblInspectionItem_ID','require','检查项目不能为空！'),
        array('tblstudy_dose','require','剂量不能为空！'),
    );
}