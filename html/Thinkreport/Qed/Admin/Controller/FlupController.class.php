<?php
namespace Admin\Controller;
use Think\Controller;
class FlupController extends CommonController
{
    public function flupedit()
    {
        $tblpatient_ID = $_REQUEST['tblpatient_ID'];
        $tblstudy_ID   = $_REQUEST['tblstudy_ID'];
        if($_POST){
            if($_POST['id']){//修改
                echo'1';
                $data['tblflup_state'] = $_POST['tblflup_state'];
                $data['tblflup_Des']   = $_POST['tblflup_Des'];
                $data['tblflup_date']  = $_POST['tblflup_date'];
                $re = M('flup')->where('tblflup_ID=%d',$_POST['id'])->save($data);
                if( $re!==false ){
                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }else{//添加
                //echo'2';
                $data['tblpatient_ID'] = $tblpatient_ID;
                $data['tblstudy_ID']   = $tblstudy_ID;
                $data['tblflup_state'] = $_POST['tblflup_state'];
                $data['tblflup_Des']   = $_POST['tblflup_Des'];
                $data['tblflup_date']  = $_POST['tblflup_date'];
                $re = M('flup')->add($data);
                if( $re ){
                    $this->success('添加成功');
                }else{
                    $this->error('添加失败');
                }
            }
        }else{
            $vol = M('flup')->where('tblpatient_ID=%d',$tblpatient_ID)->find();
            //dump($_REQUEST);dump($vol);die;
            $this->assign('tblpatient_ID',$tblpatient_ID);
            $this->assign('tblstudy_ID',$tblstudy_ID);
            $this->assign('vol',$vol);
            $this->display();
        }

    }
}