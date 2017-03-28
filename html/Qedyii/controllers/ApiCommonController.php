<?php
/**
 * Created by PhpStorm.
 * User: ddxs
 * Date: 17-2-8
 * Time: 下午1:42
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
class ApiCommonController extends Controller
{
    public function _construct(){
        error_log(print_r($_GET,1).date('Y-m-d H:i:s',time())."\r\n",3,dirname(dirname(__FILE__)).'/getmsg.txt');

    }
    public function response($sta,$msg,$data){
        //$data['ntime']=time();
        //$data['param']=$this->param;//上线前去除
        $return	= array('status'=>$sta, 'msg'=>$msg,'data'=>$data);
        $return = json_encode($return);
        echo $return;
        exit;
    }
}