<?php
namespace Admin\Controller;
use Think\Controller;
class StudyController extends CommonController {
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Study');
    }
    public function studylist(){
        $day = $_GET['day'];
        $map = array();
        if($day=='1'){
            $map['s.tblstudy_studyDate']=array('egt',date('Y-m-d 00:00:00',time()  ));
        }elseif($day=='2'){
            $map['s.tblstudy_studyDate']=array('egt',date('Y-m-d 00:00:00',strtotime('-1 days') ));
        }elseif($day=='7'){
            $map['s.tblstudy_studyDate']=array('egt',date('Y-m-d 00:00:00',strtotime('-7 days') ));
        }
        //高级查询
        $start_tblstudy_studyDate = trim($_GET['start_tblstudy_studyDate']);
        if($_GET['start_is_studydate'] == 1 && !empty($start_tblstudy_studyDate)){
            $map['s.tblstudy_studyDate'][] = array('egt',$start_tblstudy_studyDate );
        }
        $end_tblstudy_studyDate = trim($_GET['end_tblstudy_studyDate']);
        if($_GET['end_is_studydate']==1 && !empty($end_tblstudy_studyDate)){
            $map['s.tblstudy_studyDate'][] = array('elt',$end_tblstudy_studyDate );
        }
        $tblInspectionItem_ID=trim($_GET['tblInspectionItem_ID']);
        if($_GET['is_item'] == 1 && !empty($tblInspectionItem_ID)){
            $map['s.tblInspectionItem_ID'] = $tblInspectionItem_ID;
        }
        $tblstudy_SID = $_GET['tblstudy_SID'];
        if($_GET['is_sid'] == 1 && !empty($tblstudy_SID)){
            $map['s.tblstudy_SID'] = array("like","%".$tblstudy_SID."%");
        }
        $tblpatient_name = $_GET['tblpatient_name'];
        if($_GET['is_name'] == 1 && !empty($tblpatient_name)){
            $map['p.tblpatient_name'] = array("like","%".$tblpatient_name."%");
        }
        $tblstudy_reportState = trim($_GET['tblstudy_reportState']);
        if($_GET['is_reportstate'] == 1 && !empty($tblstudy_reportState)){
            $map['s.tblstudy_reportState'] = $tblstudy_reportState;
        }
        $tblflup_state = trim($_GET['tblflup_state']);
        if($_GET['is_flupstate'] == 1 && $tblflup_state != ""){
            $map['fl.tblflup_state'] = $tblflup_state;
        }
        $tbldepartment_ID = trim($_GET['tbldepartment_ID']);
        if($_GET['is_department'] == 1 && !empty($tbldepartment_ID)){
            $map['d.tbldepartment_ID'] = $tbldepartment_ID;
        }
        $start_tblpatient_age = trim($_GET['start_tblpatient_age']);
        if($_GET['start_is_age'] == 1 && !empty($start_tblpatient_age)){
            $map['p.tblpatient_birthday'][] = array('elt',date('Y-m-d H:i:s',strtotime('- '.$start_tblpatient_age.' years')));
        }
        $end_tblpatient_age = trim($_GET['end_tblpatient_age']);
        if($_GET['end_is_age'] == 1 && !empty($end_tblpatient_age)){
            $map['p.tblpatient_birthday'][] = array('egt',date('Y-m-d H:i:s',strtotime('- '.$end_tblpatient_age.' years')));
        }
        $tblstudy_clinical = $_GET['tblstudy_clinical'];
        if($_GET['is_clinical'] == 1  && !empty($tblstudy_clinical) ){
            $map['s.tblstudy_clinical'] = array("like","%".$tblstudy_clinical."%");
        }
        $tblstudy_finding = $_GET['tblstudy_finding'];
        if($_GET['is_finding'] == 1  && !empty($tblstudy_finding)){
            $map['s.tblstudy_finding'] = array("like","%".$tblstudy_finding."%");
        }
        $tblstudy_suggestion = $_GET['tblstudy_suggestion'];
        if($_GET['is_suggestion'] == 1  && !empty($tblstudy_suggestion)){
            $map['s.tblstudy_suggestion'] = array("like","%".$tblstudy_suggestion."%");
        }
        $tblflup_Des = $_GET['tblflup_Des'];
        if($_GET['is_des'] == 1  && !empty($tblflup_Des)){
            $map['fl.tblflup_Des'] = array("like","%".$tblflup_Des."%");
        }
        //dump($_GET);die;
        $page_size = 10;
        $count = M('Study s')->join('LEFT JOIN tblpatient p ON s.tblpatient_ID = p.tblpatient_ID')
            ->join('LEFT JOIN tbldepartment d ON s.tbldepartment_ID = d.tbldepartment_ID')//科室
            ->join('LEFT JOIN tblinpatientarea a ON s.tblInpatientArea_ID = a.tblInpatientArea_ID')//病区
            ->join('LEFT JOIN tblinspectionitem m ON s.tblInspectionItem_ID = m.tblInspectionItem_ID')//检查项目
            ->join('LEFT JOIN tbltracer t ON s.tbltracer_ID = t.tbltracer_ID')//示踪剂
            ->join('LEFT JOIN tblstatuscolor ta ON s.tblstudy_reportState = ta.tblstatuscolor_ID')//报告状态
            ->join('LEFT JOIN tblflup fl ON s.tblstudy_ID = fl.tblstudy_ID')//随访
            ->where($map)->count (); // 查询满足要求的总记录数
        $p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
        $page = $p->show (); // 分页显示输出
        $order = "s.tblstudy_ID DESC";
        $Lsql = "{$p->firstRow},{$p->listRows}";
        $fields='p.tblpatient_ID,p.tblpatient_PID,p.tblpatient_name,p.tblpatient_pinyin,p.tblpatient_sex,
                p.tblpatient_birthday,p.tblpatient_height,p.tblpatient_weight,p.tblpatient_tel,p.tblpatient_tm,
                s.tblstudy_ID,s.tblstudy_SID,s.tblstudy_hospitalizedID,s.tblstudy_sickbedID,s.tblstudy_outpatientID,s.tblstudy_imageID,
                s.tblstudy_modality, s.tblstudy_BloodSugarLevels,s.tblstudy_injectionDate, s.tblstudy_studyDate,
                d.tbldepartment_department,a.tblInpatientArea_area,m.tblInspectionItem_item,t.tbltracer_tracer,
                s.tblstudy_dose,s.tblstudy_reportState,s.tblstudy_clinical,s.tblstudy_ischarges,u.tbluser_displayname,
                r.tblreport_doctor,r.tblreport_checkdoctor,r.tblreport_islock,fl.tblflup_state,ta.tblstatuscolor_name,
                (select count(tblreportcon_ID) from tblreportcon where tblreport_ID=r.tblreport_ID) as repage';
        //count(r.tblreport_page) as report_page';
        $list=M('Study s')
            ->join('LEFT JOIN tblpatient p ON s.tblpatient_ID = p.tblpatient_ID')
            ->join('LEFT JOIN tbldepartment d ON s.tbldepartment_ID = d.tbldepartment_ID')//科室
            ->join('LEFT JOIN tblinpatientarea a ON s.tblInpatientArea_ID = a.tblInpatientArea_ID')//病区
            ->join('LEFT JOIN tblinspectionitem m ON s.tblInspectionItem_ID = m.tblInspectionItem_ID')//检查项目
            ->join('LEFT JOIN tbltracer t ON s.tbltracer_ID = t.tbltracer_ID')//示踪剂
            ->join('LEFT JOIN tblstatuscolor ta ON s.tblstudy_reportState = ta.tblstatuscolor_ID')//报告状态
            ->join('LEFT JOIN tblflup fl ON s.tblstudy_ID = fl.tblstudy_ID')//随访
            ->join('LEFT JOIN tblreport r ON s.tblstudy_ID = r.tblstudy_ID')
            ->join('LEFT JOIN tbluser u ON s.tbluser_ID = u.tbluser_ID')
            ->field($fields)
            ->where($map)
            ->order($order)
            ->limit($Lsql)
            ->select();
        foreach($list as $key=>$val){
            $list[$key]['tblpatient_birthday'] = birthday($val['tblpatient_birthday']);
            if($val['tblflup_state']=='0'){
                $list[$key]['tblflup_state']='随访中';
            }elseif($val['tblflup_state']=='1'){
                $list[$key]['tblflup_state']='随访完';
            }
        }
        //echo M()->getLastSql();die;
        $inspectionitem = M('inspectionitem')->order('tblInspectionItem_seq DESC')->select();
        $statuscolor    = M('statuscolor')->select();
        $flupstate      = C('FLUP_STATE');
        $department     = M('department')->order('tbldepartment_seq DESC')->select();
        $this->assign('inspectionitem',$inspectionitem);
        $this->assign('statuscolor',$statuscolor);
        $this->assign('flupstate',$flupstate);
        $this->assign('department',$department);
        $this->assign('page',$page);
        $this->assign('list',$list);
        $this->display();
    }
    public function exportStudy(){
        $day = $_GET['day'];
        $map = array();
        if($day=='1'){
            $map['s.tblstudy_studyDate']=array('egt',date('Y-m-d 00:00:00',time()  ));
        }elseif($day=='2'){
            $map['s.tblstudy_studyDate']=array('egt',date('Y-m-d 00:00:00',strtotime('-1 days') ));
        }elseif($day=='7'){
            $map['s.tblstudy_studyDate']=array('egt',date('Y-m-d 00:00:00',strtotime('-7 days') ));
        }
        //高级查询
        $start_tblstudy_studyDate = trim($_GET['start_tblstudy_studyDate']);
        if($_GET['start_is_studydate'] == 1 && !empty($start_tblstudy_studyDate)){
            $map['s.tblstudy_studyDate'][] = array('egt',$start_tblstudy_studyDate );
        }
        $end_tblstudy_studyDate = trim($_GET['end_tblstudy_studyDate']);
        if($_GET['end_is_studydate']==1 && !empty($end_tblstudy_studyDate)){
            $map['s.tblstudy_studyDate'][] = array('elt',$end_tblstudy_studyDate );
        }
        $tblInspectionItem_ID=trim($_GET['tblInspectionItem_ID']);
        if($_GET['is_item'] == 1 && !empty($tblInspectionItem_ID)){
            $map['s.tblInspectionItem_ID'] = $tblInspectionItem_ID;
        }
        $tblstudy_SID = $_GET['tblstudy_SID'];
        if($_GET['is_sid'] == 1 && !empty($tblstudy_SID)){
            $map['s.tblstudy_SID'] = array("like","%".$tblstudy_SID."%");
        }
        $tblpatient_name = $_GET['tblpatient_name'];
        if($_GET['is_name'] == 1 && !empty($tblpatient_name)){
            $map['p.tblpatient_name'] = array("like","%".$tblpatient_name."%");
        }
        $tblstudy_reportState = trim($_GET['tblstudy_reportState']);
        if($_GET['is_reportstate'] == 1 && !empty($tblstudy_reportState)){
            $map['s.tblstudy_reportState'] = $tblstudy_reportState;
        }
        $tblflup_state = trim($_GET['tblflup_state']);
        if($_GET['is_flupstate'] == 1 && $tblflup_state != ""){
            $map['fl.tblflup_state'] = $tblflup_state;
        }
        $tbldepartment_ID = trim($_GET['tbldepartment_ID']);
        if($_GET['is_department'] == 1 && !empty($tbldepartment_ID)){
            $map['d.tbldepartment_ID'] = $tbldepartment_ID;
        }
        $start_tblpatient_age = trim($_GET['start_tblpatient_age']);
        if($_GET['start_is_age'] == 1 && !empty($start_tblpatient_age)){
            $map['p.tblpatient_birthday'][] = array('elt',date('Y-m-d H:i:s',strtotime('- '.$start_tblpatient_age.' years')));
        }
        $end_tblpatient_age = trim($_GET['end_tblpatient_age']);
        if($_GET['end_is_age'] == 1 && !empty($end_tblpatient_age)){
            $map['p.tblpatient_birthday'][] = array('egt',date('Y-m-d H:i:s',strtotime('- '.$end_tblpatient_age.' years')));
        }
        $tblstudy_clinical = $_GET['tblstudy_clinical'];
        if($_GET['is_clinical'] == 1  && !empty($tblstudy_clinical) ){
            $map['s.tblstudy_clinical'] = array("like","%".$tblstudy_clinical."%");
        }
        $tblstudy_finding = $_GET['tblstudy_finding'];
        if($_GET['is_finding'] == 1  && !empty($tblstudy_finding)){
            $map['s.tblstudy_finding'] = array("like","%".$tblstudy_finding."%");
        }
        $tblstudy_suggestion = $_GET['tblstudy_suggestion'];
        if($_GET['is_suggestion'] == 1  && !empty($tblstudy_suggestion)){
            $map['s.tblstudy_suggestion'] = array("like","%".$tblstudy_suggestion."%");
        }
        $tblflup_Des = $_GET['tblflup_Des'];
        if($_GET['is_des'] == 1  && !empty($tblflup_Des)){
            $map['fl.tblflup_Des'] = array("like","%".$tblflup_Des."%");
        }
        //dump($map);die;
        $page_size = 10;
        $count = M('Study s')->join('LEFT JOIN tblpatient p ON s.tblpatient_ID = p.tblpatient_ID')
            ->join('LEFT JOIN tbldepartment d ON s.tbldepartment_ID = d.tbldepartment_ID')//科室
            ->join('LEFT JOIN tblinpatientarea a ON s.tblInpatientArea_ID = a.tblInpatientArea_ID')//病区
            ->join('LEFT JOIN tblinspectionitem m ON s.tblInspectionItem_ID = m.tblInspectionItem_ID')//检查项目
            ->join('LEFT JOIN tbltracer t ON s.tbltracer_ID = t.tbltracer_ID')//示踪剂
            ->join('LEFT JOIN tblstatuscolor ta ON s.tblstudy_reportState = ta.tblstatuscolor_ID')//报告状态
            ->join('LEFT JOIN tblflup fl ON s.tblstudy_ID = fl.tblstudy_ID')//随访
            ->where($map)->count (); // 查询满足要求的总记录数
        $p = new \Think\Page ( $count, $page_size); // 实例化分页类传入总记录数和每页显示的记录数
        $page = $p->show (); // 分页显示输出
        $order = "s.tblstudy_ID DESC";
        $Lsql = "{$p->firstRow},{$p->listRows}";
        $fields='p.tblpatient_ID,p.tblpatient_PID,p.tblpatient_name,p.tblpatient_pinyin,p.tblpatient_sex,
                p.tblpatient_birthday,p.tblpatient_height,p.tblpatient_weight,p.tblpatient_tel,p.tblpatient_tm,
                s.tblstudy_ID,s.tblstudy_SID,s.tblstudy_hospitalizedID,s.tblstudy_sickbedID,s.tblstudy_outpatientID,s.tblstudy_imageID,
                s.tblstudy_modality, s.tblstudy_BloodSugarLevels,s.tblstudy_injectionDate, s.tblstudy_studyDate,
                d.tbldepartment_department,a.tblInpatientArea_area,m.tblInspectionItem_item,t.tbltracer_tracer,
                s.tblstudy_dose,s.tblstudy_reportState,s.tblstudy_clinical,s.tblstudy_ischarges,u.tbluser_displayname,
                r.tblreport_doctor,r.tblreport_checkdoctor,r.tblreport_islock,fl.tblflup_state,ta.tblstatuscolor_name,
                (select count(tblreportcon_ID) from tblreportcon where tblreport_ID=r.tblreport_ID) as repage';
        //count(r.tblreport_page) as report_page';
        $list=M('Study s')
            ->join('LEFT JOIN tblpatient p ON s.tblpatient_ID = p.tblpatient_ID')
            ->join('LEFT JOIN tbldepartment d ON s.tbldepartment_ID = d.tbldepartment_ID')//科室
            ->join('LEFT JOIN tblinpatientarea a ON s.tblInpatientArea_ID = a.tblInpatientArea_ID')//病区
            ->join('LEFT JOIN tblinspectionitem m ON s.tblInspectionItem_ID = m.tblInspectionItem_ID')//检查项目
            ->join('LEFT JOIN tbltracer t ON s.tbltracer_ID = t.tbltracer_ID')//示踪剂
            ->join('LEFT JOIN tblstatuscolor ta ON s.tblstudy_reportState = ta.tblstatuscolor_ID')//报告状态
            ->join('LEFT JOIN tblflup fl ON s.tblstudy_ID = fl.tblstudy_ID')//随访
            ->join('LEFT JOIN tblreport r ON s.tblstudy_ID = r.tblstudy_ID')
            ->join('LEFT JOIN tbluser u ON s.tbluser_ID = u.tbluser_ID')
            ->field($fields)
            ->where($map)
            ->order($order)
            ->limit($Lsql)
            ->select();
        foreach($list as $key=>$val){
            $list[$key]['tblpatient_birthday'] = birthday($val['tblpatient_birthday']);
            if($val['tblflup_state']=='0'){
                $list[$key]['tblflup_state']='随访中';
            }elseif($val['tblflup_state']=='1'){
                $list[$key]['tblflup_state']='随访完';
            }
        }
        $info=array();
        $info[0] =  array('登记列表（导表时间'.date('Ymd').'）');
        $info[1] = array();
        $info[2]=array('病例号','姓名','拼音姓名','性别','年龄','身高','体重','电话','检查号', '住院号','床号',
            '门诊号','影像号','检查类型','血糖(mmol/L)','科室','病区','检查项目','示踪剂','检查时间','临床诊断',
            '报告状态','报告医师','报告页数','审核医师','锁定状态','随访状态','收费情况','添加人');
        $k =3;
        foreach($list as $row){
            $info[$k]['tblpatient_pid']            = $row['tblpatient_pid'];
            $info[$k]['tblpatient_name']           = $row['tblpatient_name'];
            $info[$k]['tblpatient_pinyin']         = $row['tblpatient_pinyin'];
            $info[$k]['tblpatient_sex']            = $row['tblpatient_sex'];
            $info[$k]['tblpatient_birthday']       = $row['tblpatient_birthday'];
            $info[$k]['tblpatient_height']         = $row['tblpatient_height'];
            $info[$k]['tblpatient_weight']         = $row['tblpatient_weight'];
            $info[$k]['tblpatient_tel']            = $row['tblpatient_tel'];
            $info[$k]['tblstudy_sid']              = $row['tblstudy_sid'];
            $info[$k]['tblstudy_hospitalizedid']   = $row['tblstudy_hospitalizedid'];
            $info[$k]['tblstudy_sickbedid']        = $row['tblstudy_sickbedid'];
            $info[$k]['tblstudy_outpatientid']     = $row['tblstudy_outpatientid'];
            $info[$k]['tblstudy_imageid']          = $row['tblstudy_imageid'];
            $info[$k]['tblstudy_modality']         = $row['tblstudy_modality'];
            $info[$k]['tblstudy_bloodsugarlevels'] = $row['tblstudy_bloodsugarlevels'];
            $info[$k]['tbldepartment_department']  = $row['tbldepartment_department'];
            $info[$k]['tblinpatientarea_area']     = $row['tblinpatientarea_area'];
            $info[$k]['tblinspectionitem_item']    = $row['tblinspectionitem_item'];
            $info[$k]['tbltracer_tracer']          = $row['tbltracer_tracer'];
            $info[$k]['tblstudy_studydate']        = $row['tblstudy_studydate'];
            $info[$k]['tblstudy_clinical']         = $row['tblstudy_clinical'];
            $info[$k]['tblstatuscolor_name']       = $row['tblstatuscolor_name'];
            $info[$k]['tblreport_doctor']          = $row['tblreport_doctor'];
            $info[$k]['repage']                    = $row['repage'];
            $info[$k]['tblreport_checkdoctor']     = $row['tblreport_checkdoctor'];
            $info[$k]['tblreport_islock']          = $row['tblreport_islock'];
            $info[$k]['tblflup_state']             = $row['tblflup_state'];
            $info[$k]['tblstudy_ischarges']        = $row['tblstudy_ischarges'];
            $info[$k]['tbluser_displayname']       = $row['tbluser_displayname'];
            $k++;
        }
        $xls = new \Think\Excel('UTF-8', false, '登记列表');
        $xls->addArray($info);
        $xls->generateXML( '登记列表（导表时间'.date('Ymd').'）');

    }
    public function studyadd(){
        if($_POST){
            $patient['tblpatient_PID']       = trim($_POST['tblpatient_PID']);
            $patient['tblpatient_name']      = trim($_POST['tblpatient_name']);
            $patient['tblpatient_pinyin']    = trim($_POST['tblpatient_pinyin']);
            $patient['tblpatient_sex']       = trim($_POST['tblpatient_sex']);
            $patient['tblpatient_birthday']  = trim($_POST['tblpatient_birthday']);
            $patient['tblpatient_height']    = trim($_POST['tblpatient_height']);
            $patient['tblpatient_weight']    = trim($_POST['tblpatient_weight']);
            $patient['tblpatient_tel']       = trim($_POST['tblpatient_tel']);
            $patient['tblpatient_tm']        = trim($_POST['tblpatient_tm']);
            $patientModel = D('Patient');
            $patientModel->startTrans();//开启事物
            $PID = $patientModel->add($patient);
            if($PID){
                //一个study报告
                $study['tblpatient_ID']               = $PID;
                $study['tblstudy_SID']              = trim($_POST['tblstudy_SID']);
                $study['tblstudy_hospitalizedID']   = trim($_POST['tblstudy_hospitalizedID']);
                $study['tblstudy_sickbedID']        = trim($_POST['tblstudy_sickbedID']);
                $study['tblstudy_outpatientID']     = trim($_POST['tblstudy_outpatientID']);
                $study['tblstudy_modality']         = trim($_POST['tblstudy_modality']);
                $study['tblstudy_imageID']          = trim($_POST['tblstudy_imageID']);
                $study['tblstudy_BloodSugarLevels'] = trim($_POST['tblstudy_BloodSugarLevels']);
                $study['tbldepartment_ID']          = $_POST['tbldepartment_ID'];
                $study['tblInpatientArea_ID']       = $_POST['tblInpatientArea_ID'];
                $study['tbltracer_ID']              = $_POST['tbltracer_ID'];
                $study['tblInspectionItem_ID']      = $_POST['tblInspectionItem_ID'];
                $study['tblstudy_dose']             = trim($_POST['tblstudy_dose']);
                $study['tblstudy_reportState']      = $_POST['tblstudy_reportState'];
                $study['tblstudy_injectionDate']    = trim($_POST['tblstudy_injectionDate']);
                $study['tblstudy_studyDate']        = trim($_POST['tblstudy_studyDate']);
                $study['tblstudy_clinical']         = trim($_POST['tblstudy_clinical']);
                $study['tblstudy_s_destination']    = trim($_POST['tblstudy_s_destination']);
                $study['tblstudy_pathological']     = trim($_POST['tblstudy_pathological']);
                $study['tblstudy_doctoradvice']     = trim($_POST['tblstudy_doctoradvice']);
                $study['tblstudy_ischarges']        = $_POST['tblstudy_ischarges'];
                $study['tbluser_ID']                = $_SESSION['user']['tbluser_id'];
                $SID = M('study')->add($study);
                if($SID){
                    $patientModel->commit();
                    $this->success('添加成功',U('Study/studylist'));
                }else{
                    $patientModel->rollback();
                    $this->error('添加失败');
                }
            }else{
                $patientModel->rollback();
                $this->error('添加失败');
            }
        }else{
            $inpatientarea  = M('inpatientarea')->order('tblInpatientArea_seq DESC')->select();
            $department     = M('department')->order('tbldepartment_seq DESC')->select();
            $tracer         = M('tracer')->order('tbltracer_seq DESC')->select();
            $inspectionitem = M('inspectionitem')->order('tblInspectionItem_seq DESC')->select();
            $statuscolor    = M('statuscolor')->select();
            $this->assign('inpatientarea',$inpatientarea);
            $this->assign('department',$department);
            $this->assign('tracer',$tracer);
            $this->assign('inspectionitem',$inspectionitem);
            $this->assign('statuscolor',$statuscolor);
            $this->assign('time',date('Y-m-d:H:i:s',time()));
            $this->assign('sexs',C('SEXS'));
            $this->assign('changes',C('CHANGES'));
            $this->display();
        }

    }
    public function studyedit(){
        $id = $_REQUEST['id'];
        $study=$this->model->where('tblstudy_ID='.$id)->find();
        if($study['tbluser_id']!=$_SESSION['user']['tbluser_id']){
            $this->error('非添加人不能编辑');
        }
        $vol = M('Study s')
            ->join('LEFT JOIN tblpatient p ON s.tblpatient_ID = p.tblpatient_ID')
            ->where('tblstudy_ID='.$id)->find();
        if($_POST) {
            $patient['tblpatient_PID']      = trim($_POST['tblpatient_PID']);
            $patient['tblpatient_name']     = trim($_POST['tblpatient_name']);
            $patient['tblpatient_pinyin']   = trim($_POST['tblpatient_pinyin']);
            $patient['tblpatient_sex']      = trim($_POST['tblpatient_sex']);
            $patient['tblpatient_birthday'] = trim($_POST['tblpatient_birthday']);
            $patient['tblpatient_height']   = trim($_POST['tblpatient_height']);
            $patient['tblpatient_weight']   = trim($_POST['tblpatient_weight']);
            $patient['tblpatient_tel']      = trim($_POST['tblpatient_tel']);
            $patient['tblpatient_tm']       = trim($_POST['tblpatient_tm']);
            $patientModel = D('Patient');
            $patientModel->startTrans();//开启事物
            $PID = $patientModel->where('tblpatient_ID='.$vol['tblpatient_id'])->save($patient);
            if ($PID!==false) {
                //一个study报告
                $study['tblstudy_SID']              = trim($_POST['tblstudy_SID']);
                $study['tblstudy_hospitalizedID']   = trim($_POST['tblstudy_hospitalizedID']);
                $study['tblstudy_sickbedID']        = trim($_POST['tblstudy_sickbedID']);
                $study['tblstudy_outpatientID']     = trim($_POST['tblstudy_outpatientID']);
                $study['tblstudy_modality']         = trim($_POST['tblstudy_modality']);
                $study['tblstudy_imageID']          = trim($_POST['tblstudy_imageID']);
                $study['tblstudy_BloodSugarLevels'] = trim($_POST['tblstudy_BloodSugarLevels']);
                $study['tbldepartment_ID']          = $_POST['tbldepartment_ID'];
                $study['tblInpatientArea_ID']       = $_POST['tblInpatientArea_ID'];
                $study['tbltracer_ID']              = $_POST['tbltracer_ID'];
                $study['tblInspectionItem_ID']      = $_POST['tblInspectionItem_ID'];
                $study['tblstudy_dose']             = trim($_POST['tblstudy_dose']);
                $study['tblstudy_reportState']      = $_POST['tblstudy_reportState'];
                $study['tblstudy_injectionDate']    = trim($_POST['tblstudy_injectionDate']);
                $study['tblstudy_studyDate']        = trim($_POST['tblstudy_studyDate']);
                $study['tblstudy_clinical']         = trim($_POST['tblstudy_clinical']);
                $study['tblstudy_s_destination']    = trim($_POST['tblstudy_s_destination']);
                $study['tblstudy_pathological']     = trim($_POST['tblstudy_pathological']);
                $study['tblstudy_doctoradvice']     = trim($_POST['tblstudy_doctoradvice']);
                $study['tblstudy_ischarges']        = $_POST['tblstudy_ischarges'];
               // $study['tbluser_ID'] = $_SESSION['user']['tbluser_id'];
                $SID = M('study')->where('tblstudy_ID='.$id)->save($study);
                if ($SID!== false) {
                    $patientModel->commit();
                    $this->success('修改成功', U('Study/studylist'));
                } else {
                    $patientModel->rollback();
                    $this->error('修改失败');
                }
            } else {
                $patientModel->rollback();
                $this->error('修改失败');
            }
        }else{
            $age = birthday($vol['tblpatient_birthday']);
            $inpatientarea  = M('inpatientarea')->order('tblInpatientArea_seq DESC')->select();
            $department     = M('department')->order('tbldepartment_seq DESC')->select();
            $tracer         = M('tracer')->order('tbltracer_seq DESC')->select();
            $inspectionitem = M('inspectionitem')->order('tblInspectionItem_seq DESC')->select();
            $statuscolor    = M('statuscolor')->select();
            //dump(C('CHANGES'));dump($vol);die;
            $this->assign('inpatientarea',$inpatientarea);
            $this->assign('department',$department);
            $this->assign('tracer',$tracer);
            $this->assign('inspectionitem',$inspectionitem);
            $this->assign('statuscolor',$statuscolor);
            $this->assign('age',$age);
            $this->assign('sexs',C('SEXS'));
            $this->assign('changes',C('CHANGES'));
            $this->assign('vol',$vol);
            $this->display();
        }
    }
    public function del(){
        $id = $_GET['id'];
        $study=$this->model->where('tblstudy_ID='.$id)->find();
       // dump($id);dump($study);die;
        if($study['tbluser_id']!=$_SESSION['user']['tbluser_id']){
            $this->error('非添加人不能删除');
        }
        $re= $this->model->where('tblstudy_ID='.$id)->delete();
        if($re)$this->success('删除成功！',U('Study/studylist'));

    }
    //自动生成检查号
    public function getBuildsid(){
        $SID = M('study')->field('max(tblstudy_SID) as maxsid')->find();
        $PID = M('patient')->field('max(tblpatient_PID) as maxsid')->find();
        $modSID = max($SID['maxsid'],$PID['maxsid']);
        $mixSID = substr($modSID,-6)+1;
        $len = strlen($mixSID);
        for($i=1;$i<=(6-$len);$i++){
            $mixSID='0'.$mixSID;
        }
        $tblstudy_SID = 'PT'.date('Ymd',time()).$mixSID;
        $data['tblstudy_SID']=$tblstudy_SID;
        $this->ajaxReturn($data);
    }
    //根据年龄计算生日
    public function getBirthday(){
        $birth = date('Y-01-01',strtotime('- '.$_POST['age'].' years'));
        $data['birthday'] = $birth;
        $this->ajaxReturn($data);
    }
    //根据生日计算年龄
    public function getAge(){
        $day = $_POST['tblpatient_birthday'];
        $age = birthday($day);
        $data['age'] = $age;
        $this->ajaxReturn($data);
    }
}