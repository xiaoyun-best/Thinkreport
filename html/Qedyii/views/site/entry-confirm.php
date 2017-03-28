<?php
/**
 * Created by PhpStorm.
 * User: ddxs
 * Date: 17-1-23
 * Time: 上午10:22
 */
use yii\helpers\Html;
?>
<p>You have entered the following information:</p>
<ul><li><label>Name</label>:<?=Html::encode($model->name)?></li>
    <li><label>Email</label>:<?=Html::encode($model->email)?></li>
</ul>
