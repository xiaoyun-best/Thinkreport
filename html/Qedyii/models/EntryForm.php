<?php
/**
 * Created by PhpStorm.
 * User: ddxs
 * Date: 17-1-22
 * Time: 下午5:30
 */
namespace app\models;
use Yii;
use yii\base\Model;
class EntryForm extends Model{
    public $name;
    public $email;
    public function rules(){
        return[
            [['name','email'],'required'],
            ['email','email'],
        ];
    }
}