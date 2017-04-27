<?php
namespace Admin\Controller;
use Think\Controller;
class MedicalhistoryController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Medicalhistory');
    }

    public function medicaledit()
    {
        $p_id = $_GET['p_id'];
        if($_POST){
            $data['tblpatient_ID']                   = $_POST['p_id'];
            $data['tblMedicalHistory_ChiefComplaint']= $_POST['tblMedicalHistory_ChiefComplaint'];
            $data['tblMedicalHistory_now']           = $_POST['tblMedicalHistory_now'];
            $data['tblMedicalHistory_past']          = $_POST['tblMedicalHistory_past'];
            $data['tblMedicalHistory_signs']         = $_POST['tblMedicalHistory_signs'];
            $data['tblMedicalHistory_study']         = $_POST['tblMedicalHistory_study'];
            $data['tblMedicalHistory_other']         = $_POST['tblMedicalHistory_other'];
            if($_POST['tblMedicalHistory_ID']){
                $re = $this->model->where("tblMedicalHistory_ID=%d",$_POST['tblMedicalHistory_ID'])->save($data);
            }else{
                $re = $this->model->add($data);
            }
            if($re) $this->success('保存成功');
            else $this->error('保存成功');
        }else{
            $vol = $this->model->where("tblpatient_ID=%d",$p_id)->find();//预处理,防SQL注入
            $this->assign('vol',$vol);
            $this->assign('p_id',$p_id);
            $this->display();
        }
    }
}