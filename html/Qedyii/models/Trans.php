<?php
namespace app\models;

use Yii;
class Trans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qed_trans';
    }
}
