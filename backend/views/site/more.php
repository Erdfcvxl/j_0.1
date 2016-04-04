<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\pass */
/* @var $form ActiveForm */
?>
<div class="more">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'password')->label(false); ?>
        <?= $form->field($model, 'days')->label(false); ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- more -->
