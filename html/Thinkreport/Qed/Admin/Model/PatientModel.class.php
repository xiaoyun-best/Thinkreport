<?php
namespace Admin\Model;
use Think\Model;
class PatientModel extends Model{
    protected $_validate=array(
        array('tblpatient_name','require','姓名不能为空！'),
        array('tblpatient_pinyin','require','拼音姓名不能为空！'),
        array('tblpatient_sex','require','性别不能为空！'),
        array('age','require','年龄不能为空！'),
        array('tblpatient_weight','require','体重不能为空！'),
    );
}