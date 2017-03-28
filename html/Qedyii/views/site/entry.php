<?php
/**
 * Created by PhpStorm.
 * User: ddxs
 * Date: 17-1-23
 * Time: 上午10:33
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form=ActiveForm::begin();?>
<?=$form->field($model,'name')?>
<?=$form->field($model,'email')?>
<div class="form-group">
    <?=Html::submitButton('Submit',['class'=>'btn btn-primary'])?>

</div>
<?php ActiveForm::end();?>
