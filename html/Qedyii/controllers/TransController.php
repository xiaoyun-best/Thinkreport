<?php
/**
 * Created by PhpStorm.
 * User: ddxs
 * Date: 17-1-23
 * Time: 下午3:25
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Trans;
class TransController extends ApiCommonController
{
    /**
     * @inheritdoc
     */
    function actionExeres(){
        //执行进程
        $somecontent= "cd /var/www/dicom1";
        $modname='thyroid';
        $param='{"dicomid":"82becdbc-5075a98a-21bbc961-1a7836c8-52773301","left_density":"1","right_density":"1","coord":"76 64 199 199","url":"http://orthanc/instances/82becdbc-5075a98a-21bbc961-1a7836c8-52773301/file",
        "url2":"http://orthanc/instances","url3":"http://192.168.1.96/Qedyii/web/trans/resmsg"}';
        $somecontent.="./Midware ".$modname." "." ' ".$param." ' ";
        mk_log($somecontent,'somecontent.txt');
       // $con=chdir('/var/www/dicom1');
        //$re=shell_exec($somecontent);
        $somecontent="ls -a";
        $re=exec($somecontent,$out,$status);
        $res['out']=$out;
        $res['status']=$status;

        var_dump($re);
    }
    public function actionRescon()
    {
        try{
            mk_log($_REQUEST,'rescon.txt');//创建日志
            if(empty($_REQUEST['modname'])) throw new \Exception('please input modname!');
            if(empty($_REQUEST['param'])) throw new \Exception('please input param!');
            $modname=trim($_REQUEST['modname']);
            $param=trim($_REQUEST['param']);
            if(is_json($param)){
                $reparam=json_decode($param,true);
            }else{
                throw new \Exception('Please enter the param in JSON format!');
            }
            $dicomid=$reparam['dicomid'];
            $data=Yii::$app->db->createCommand("SELECT * FROM qed_trans WHERE dicomid='$dicomid'")
                ->queryOne();
            //var_dump($reparam);
            if($data){
                $trans=Trans::findOne($data['id']);
               /* foreach($reparam as $key=>$val){
                    $trans->$key=$val;
                }*/
                $trans->modname=$modname;
                $trans->dicomid=$reparam['dicomid'];
                $trans->left_density=$reparam['left_density'];
                $trans->right_density=$reparam['right_density'];
                $trans->coord=$reparam['coord'];
                $trans->url=$reparam['url'];
                $trans->raiu_2h=$reparam['raiu_2h'];
                $trans->raiu_24h=$reparam['raiu_24h'];
                $trans->AIU=$reparam['AIU'];
                //保存数据
                $re=$trans->save();
                $id=$data['id'];
            }else{
                $trans=new Trans();
                $trans->modname=$modname;
                $trans->dicomid=$reparam['dicomid'];
                $trans->left_density=$reparam['left_density'];
                $trans->right_density=$reparam['right_density'];
                $trans->coord=$reparam['coord'];
                $trans->url=$reparam['url'];
                $trans->raiu_2h=$reparam['raiu_2h'];
                $trans->raiu_24h=$reparam['raiu_24h'];
                $trans->AIU=$reparam['AIU'];
                //添加数据
                $re=$trans->save();
                $id=Yii::$app->db->getLastInsertID();
            }
            $reparam['id']=$id;
            $param=json_encode($reparam);
            mk_log($param,'exeres.txt');//创建日志
            $out=exeres($modname,$param);
            if(!$out){
                Yii::$app->db->createCommand("delete from qed_trans where id={$id}")->execute();
                throw new \Exception('Process execution exception!');
            }else{
                $data=Yii::$app->db->createCommand("SELECT * FROM qed_trans WHERE id='$id'")
                    ->queryOne();
                //$con=array();
                /*$con['id']=$data['id'];
                $con['dicomid']=$data['dicomid'];
                $con['ndicomid']=$data['ndicomid'];
                //$con['tiur']=$data['tiur'];
                $con['vol']=$data['vol'];//体积
                $con['left_vol']=$data['left_vol'];
                $con['right_vol']=$data['right_vol'];
                $con['area']=$data['area'];//面积
                $con['left_area']=$data['left_area'];
                $con['right_area']=$data['right_area'];
                $con['weight']=$data['weight'];//重量
                $con['left_weight']=$data['left_weight'];
                $con['right_weight']=$data['right_weight'];
                $con['left_density']=$data['left_density'];//密度
                $con['right_density']=$data['right_density'];
                $con['left_depth']=$data['left_depth'];//厚度
                $con['right_depth']=$data['right_depth'];
                $con['left_tiur']=$data['left_tiur'];//吸碘率
                $con['right_tiur']=$data['right_tiur'];*/
                unset($data['tiur']);
                $this->response('0','Successful execution process!',$data);
            }
        }catch(\Exception $e){
            $this->response('1',$e->getMessage(),null);
        }
    }
    public function actionResmsg()
    {
        mk_log($_REQUEST,'resmsg.txt');//创建日志
        try{
            if(empty($_REQUEST['id'])) throw new \Exception('please input id');
            if(empty($_REQUEST['vol'])) throw new \Exception('please input vol!');
            if(empty($_REQUEST['area'])) throw new \Exception('please input area!');
            if(empty($_REQUEST['weight'])) throw new \Exception('please input weight!');
            if(empty($_REQUEST['ndicomid'])) throw new \Exception('please input ndicomid!');
            $id=trim($_REQUEST['id']);
            $id=intval($id);
            $trans=Trans::findOne($id);
            if(empty($trans)) throw new \Exception('id not exist!');
            /*$trans->vol=trim($_REQUEST['vol']);//体积
            $trans->left_vol=trim($_REQUEST['left_vol']);
            $trans->right_vol=trim($_REQUEST['right_vol']);
            $trans->area=trim($_REQUEST['area']);//面积
            $trans->left_area=trim($_REQUEST['left_area']);
            $trans->right_area=trim($_REQUEST['right_area']);
            $trans->weight=trim($_REQUEST['weight']);//重量
            $trans->left_weight=trim($_REQUEST['left_weight']);
            $trans->right_weight=trim($_REQUEST['right_weight']);
            $trans->left_depth=trim($_REQUEST['left_depth']);//厚度
            $trans->right_depth=trim($_REQUEST['right_depth']);
            $trans->left_tiur=trim($_REQUEST['left_tiur']);//厚度
            $trans->right_tiur=trim($_REQUEST['right_tiur']);
            $trans->ndicomid=trim($_REQUEST['ndicomid']);*/
            $request = Yii::$app->request;
            $data = $request->post();
            foreach($data as $key=>$val){
                $trans->$key=$val;
            }
            $re=$trans->save();
            $con['id']=$id;
            if($re){
                $this->response('0','insert data successfully!',$con);
            }else{
                throw new \Exception('repeat commit!');
            }
        }catch(\Exception $e){
            $this->response('1',$e->getMessage(),null);
        }

    }
    public function actionResdata()
    {
        try{
            mk_log($_REQUEST,'resdata.txt');//创建日志
            if(empty($_REQUEST['dicomid'])) throw new \Exception('please input dicomid');
            $dicomid=$_REQUEST['dicomid'];
            $data=Yii::$app->db->createCommand("SELECT * FROM qed_trans WHERE dicomid='$dicomid'")
                ->queryOne();
            if(empty($data)){
                $data=Yii::$app->db->createCommand("SELECT * FROM qed_trans WHERE ndicomid='$dicomid'")
                    ->queryOne();
            }
            /*$con['id']=$data['id'];
            $con['dicomid']=$data['dicomid'];
            $con['ndicomid']=$data['ndicomid'];
            //$con['tiur']=$data['tiur'];
            $con['vol']=$data['vol'];//体积
            $con['left_vol']=$data['left_vol'];
            $con['right_vol']=$data['right_vol'];
            $con['area']=$data['area'];//面积
            $con['left_area']=$data['left_area'];
            $con['right_area']=$data['right_area'];
            $con['weight']=$data['weight'];//重量
            $con['left_weight']=$data['left_weight'];
            $con['right_weight']=$data['right_weight'];
            $con['left_density']=$data['left_density'];//密度
            $con['right_density']=$data['right_density'];
            $con['left_depth']=$data['left_depth'];//厚度
            $con['right_depth']=$data['right_depth'];
            $con['left_tiur']=$data['left_tiur'];//吸碘率
            $con['right_tiur']=$data['right_tiur'];*/
            unset($data['tiur']);
            $this->response('0','获取数据成功',$data);
        }catch(\Exception $e){
            $this->response('1',$e->getMessage(),null);
        }
    }
    public function actionGetcon()
    {
        try{
            mk_log($_REQUEST,'getcon.txt');//创建日志
            if(empty($_REQUEST['modname'])) throw new \Exception('please input modname!');
            if(empty($_REQUEST['param'])) throw new \Exception('please input param!');
            $modname=trim($_REQUEST['modname']);
            $param=trim($_REQUEST['param']);
            if(is_json($param)){
                $reparam=json_decode($param,true);
            }else{
                throw new \Exception('Please enter the param in JSON format!');
            }
            $dicomid=$reparam['dicomid'];
            $data=Yii::$app->db->createCommand("SELECT * FROM qed_trans WHERE dicomid='$dicomid'")
                ->queryOne();
            //var_dump($reparam);
            if($data){
                $trans=Trans::findOne($data['id']);
                $trans->modname=$modname;
                $trans->dicomid=$reparam['dicomid'];
                $trans->tiur=$reparam['tiur'];
                $trans->coord=$reparam['coord'];
                $trans->url=$reparam['url'];
                //保存数据
                $re=$trans->save();
                $id=$data['id'];
            }else{
                $trans=new Trans();
                $trans->modname=$modname;
                $trans->dicomid=$reparam['dicomid'];
                $trans->tiur=$reparam['tiur'];
                $trans->coord=$reparam['coord'];
                $trans->url=$reparam['url'];
                //添加数据
                $re=$trans->save();
                $id=Yii::$app->db->getLastInsertID();
            }
            $reparam['id']=$id;
            $param=json_encode($reparam);
            mk_log($param,'execon.txt');//创建日志
            $out=execon($modname,$param);
            if(!$out){
                Yii::$app->db->createCommand("delete from qed_trans where id={$id}")->execute();
                throw new \Exception('Process execution exception!');
            }else{
                $data=Yii::$app->db->createCommand("SELECT * FROM qed_trans WHERE id='$id'")
                    ->queryOne();
                $con=array();
                $con['id']=$data['id'];
                $con['dicomid']=$data['dicomid'];
                $con['ndicomid']=$data['ndicomid'];
                $con['tiur']=$data['tiur'];
                $con['vol']=$data['vol'];
                $con['area']=$data['area'];
                $con['weight']=$data['weight'];
                $this->response('0','Successful execution process!',$con);
            }
        }catch(\Exception $e){
            $this->response('1',$e->getMessage(),null);
        }
    }
    public function actionGetmsg()
    {
        mk_log($_REQUEST,'getmsg.txt');//创建日志
        try{
            if(empty($_REQUEST['id'])) throw new \Exception('please input id');
            if(empty($_REQUEST['vol'])) throw new \Exception('please input vol!');
            if(empty($_REQUEST['area'])) throw new \Exception('please input area!');
            if(empty($_REQUEST['weight'])) throw new \Exception('please input weight!');
            if(empty($_REQUEST['ndicomid'])) throw new \Exception('please input ndicomid!');
            $id=trim($_REQUEST['id']);
            $id=intval($id);
            $trans=Trans::findOne($id);
            if(empty($trans)) throw new \Exception('id not exist!');
            $trans->vol=trim($_REQUEST['vol']);
            $trans->area=trim($_REQUEST['area']);
            $trans->weight=trim($_REQUEST['weight']);
            $trans->ndicomid=trim($_REQUEST['ndicomid']);
            $re=$trans->save();
            $con['id']=$id;
            if($re){
                $this->response('0','insert data successfully!',$con);
            }else{
                throw new \Exception('repeat commit!');
            }
        }catch(\Exception $e){
            $this->response('1',$e->getMessage(),null);
        }

    }
    public function actionGetdata()
    {
        try{
            mk_log($_REQUEST,'getdata.txt');//创建日志
            if(empty($_REQUEST['dicomid'])) throw new \Exception('please input dicomid');
            $dicomid=$_REQUEST['dicomid'];
            $trans=Yii::$app->db->createCommand("SELECT * FROM qed_trans WHERE dicomid='$dicomid'")
                ->queryOne();
            if(empty($trans)){
                $trans=Yii::$app->db->createCommand("SELECT * FROM qed_trans WHERE ndicomid='$dicomid'")
                    ->queryOne();
            }
            $con['id']=$trans['id'];
            $con['dicomid']=$trans['dicomid'];
            $con['ndicomid']=$trans['ndicomid'];
            $con['tiur']=$trans['tiur'];
            $con['vol']=$trans['vol'];
            $con['area']=$trans['area'];
            $con['weight']=$trans['weight'];
            $this->response('0','获取数据成功',$con);
        }catch(\Exception $e){
            $this->response('1',$e->getMessage(),null);
        }
    }
    public function actionDel(){
        mk_log($_REQUEST,'del.txt');//创建日志
        try{
            if(empty($_REQUEST['dicomid'])) throw new \Exception('Please input dicomid!');
            $dicomid=$_REQUEST['dicomid'];
            if($dicomid=='all'){
                $re=Yii::$app->db->createCommand("DELETE FROM qed_trans")
                    ->execute();
                if($re)$this->response('0','Successfully deleted all data!',null);
                else$this->response('1','Data is empty!',null);
            }else{
                $data=Yii::$app->db->createCommand("SELECT * FROM qed_trans WHERE dicomid='$dicomid'")
                    ->queryOne();
                $ndata=Yii::$app->db->createCommand("SELECT * FROM qed_trans WHERE ndicomid='$dicomid'")
                    ->queryOne();
                if($data){
                    $re=Yii::$app->db->createCommand("DELETE FROM qed_trans WHERE dicomid='$dicomid'")
                        ->execute();
                    if($re)$this->response('0','Successfully deleted data!',$data['ndicomid']);
                }elseif($ndata){
                    $re=Yii::$app->db->createCommand("DELETE FROM qed_trans WHERE ndicomid='$dicomid'")
                        ->execute();
                    if($re)$this->response('0','Successfully deleted data!',null);
                }else{
                    throw new \Exception('dicomid not exist!');
                }
            }
        }catch(\Exception $e){
            $this->response('1',$e->getMessage(),null);
        }
    }
}

