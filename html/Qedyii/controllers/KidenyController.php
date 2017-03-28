<?php
/**
 * Created by PhpStorm.
 * User: ddxs
 * Date: 17-3-2
 * Time: 上午11:51
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Kideny;
class KidenyController extends ApiCommonController
{
    /**
     * @inheritdoc
     */
    public function actionKidcon()
    {
        try {
            mk_log($_REQUEST, 'kidenycon.txt');//创建日志
            if (empty($_REQUEST['modname'])) throw new \Exception('please input modname!');
            if (empty($_REQUEST['param'])) throw new \Exception('please input param!');
            $modname = trim($_REQUEST['modname']);
            $param = trim($_REQUEST['param']);
            if (is_json($param)) {
                $reparam = json_decode($param, true);
            } else {
                throw new \Exception('Please enter the param in JSON format!');
            }
            $dicomid = $reparam['dicomid'];
            $data = Yii::$app->db->createCommand("SELECT * FROM qed_kideny WHERE dicomid='$dicomid'")
                ->queryOne();
            //var_dump($reparam);
            if ($data) {
                $kideny = Kideny::findOne($data['id']);
                $kideny->modname = $modname;
                $kideny->dicomid = $reparam['dicomid'];
                //保存数据
                $re = $kideny->save();
                $id = $data['id'];
            } else {
                $kideny = new kideny();
                $kideny->modname = $modname;
                $kideny->dicomid = $reparam['dicomid'];
                //添加数据
                $re = $kideny->save();
                $id = Yii::$app->db->getLastInsertID();
            }
            $reparam['id'] = $id;
            $param = json_encode($reparam);
            mk_log($param, 'exekideny.txt');//创建日志
            $out = 1;
            if (!$out) {
                Yii::$app->db->createCommand("delete from qed_kideny where id={$id}")->execute();
                throw new \Exception('Process execution exception!');
            } else {
                $data = Yii::$app->db->createCommand("SELECT * FROM qed_kideny WHERE id='$id'")
                    ->queryOne();

                $this->response(0, 'Successful execution process!', $data);
            }
        } catch (\Exception $e) {
            $this->response('1', $e->getMessage(), null);
        }
    }

    public function actionKidmsg()
    {
        mk_log($_REQUEST, 'kidenymsg.txt');//创建日志
        try {
            if (empty($_REQUEST['id'])) throw new \Exception('please input id');
            $id = trim($_REQUEST['id']);
            $id = intval($id);
            $kideny = Kideny::findOne($id);
            if (empty($kideny)) throw new \Exception('id not exist!');
            $request = Yii::$app->request;
            $data = $request->get();
            //$data = $request->post();
            foreach($data as $key=>$val){
                $kideny->$key=$val;
            }
            $re = $kideny->save();
            $con['id'] = $id;
            if ($re) {
                $this->response('0', 'insert data successfully!', $con);
            } else {
                throw new \Exception('repeat commit!');
            }
        } catch (\Exception $e) {
            $this->response('1', $e->getMessage(), null);
        }

    }

    public function actionKiddata()
    {
        try {
            mk_log($_REQUEST, 'kidenydata.txt');//创建日志
            if (empty($_REQUEST['dicomid'])) throw new \Exception('please input dicomid');
            $dicomid = $_REQUEST['dicomid'];
            $data = Yii::$app->db->createCommand("SELECT * FROM qed_kideny WHERE dicomid='$dicomid'")
                ->queryOne();
            if (empty($data)) {
                $data = Yii::$app->db->createCommand("SELECT * FROM qed_kideny WHERE ndicomid='$dicomid'")
                    ->queryOne();
            }      
            var_dump($data);die;
            $this->response('0', 'Get data successfully!', $data);
        } catch (\Exception $e) {
            $this->response('1', $e->getMessage(), null);
        }
    }
    public function actionDel()
    {
        try {
            if (empty($_REQUEST['dicomid'])) throw new \Exception('Please input dicomid!');
            $dicomid = $_REQUEST['dicomid'];
            if ($dicomid == 'all') {
                $re = Yii::$app->db->createCommand("DELETE FROM qed_kideny")
                    ->execute();
                if ($re) $this->response('0', 'Successfully deleted all data!', null);
                else$this->response('1', 'Data is empty!', null);
            } else {
                $data = Yii::$app->db->createCommand("SELECT * FROM qed_kideny WHERE dicomid='$dicomid'")
                    ->queryOne();
                $ndata = Yii::$app->db->createCommand("SELECT * FROM qed_kideny WHERE ndicomid='$dicomid'")
                    ->queryOne();
                if ($data) {
                    $re = Yii::$app->db->createCommand("DELETE FROM qed_kideny WHERE dicomid='$dicomid'")
                        ->execute();
                    if ($re) $this->response('0', 'Successfully deleted data!', $data['ndicomid']);
                } elseif ($ndata) {
                    $re = Yii::$app->db->createCommand("DELETE FROM qed_kideny WHERE ndicomid='$dicomid'")
                        ->execute();
                    if ($re) $this->response('0', 'Successfully deleted data!', null);
                } else {
                    throw new \Exception('dicomid not exist!');
                }
            }
        } catch (\Exception $e) {
            $this->response('1', $e->getMessage(), null);
        }
    }
}