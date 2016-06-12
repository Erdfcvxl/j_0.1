<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use frontend\models\User;

$user = User::find()->where(['id' => Yii::$app->user->id])->one();

$data = date('o-m-d G:i', $user->expires);

?>

 <div class="row" style="margin-top: 5px;">
    <div class="col-xs-12" >
        <div class="container fix-form" style="width:100%; background-color: #e8e8e8; height: auto; font-size: 12px; text-align: left; padding: 10px 20px;">
            <?php if(Yii::$app->session->getFlash('success')): ?>
            <div class="alert alert-success" id="success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>
            <?php endif; ?>

           	<div class="row" style="padding: 0; margin: 0 0 15px;"><span class="h4" style="color: #96c503;">Keisti slaptažodį</span></div>

            <?php $form = ActiveForm::begin(); ?>
           	<div class="row" style="padding: 0; margin: 0;">
           		<div class="col-xs-4">
           			<div class="row">Dabartinis slaptažodis</div>
           			<div class="row"><?= $form->field($model, 'passwordOld')->passwordInput(['class' => 'trans_input', 'style' => 'margin-top: 5px; width:80%; outline-width: 0; padding: 0 5px;', 'autocomplete' => 'off'])->label(false); ?></div>
           			<div class="row"><span style="font-size:9px;">Norėdami Keisti slaptažodį, įveskitę seną</span></div>
           		</div>
           		<div class="col-xs-3">
           			<div class="row">Naujas slaptažodis</div>
           			<div class="row"><?= $form->field($model, 'passwordNew')->passwordInput(['class' => 'trans_input', 'style' => 'margin-top: 5px; width:95%; outline-width: 0; padding: 0 5px;'])->label(false); ?></div>
           			<div class="row">Pakartok naują slaptažodį</div>
           			<div class="row"><?= $form->field($model, 'passwordNew2')->passwordInput(['class' => 'trans_input', 'style' => 'margin-top: 5px; width:95%; outline-width: 0; padding: 0 5px;'])->label(false); ?></div>
           		</div>
           		<div class="col-xs-3">
           			<div class="row"><bR></div>
           			<div class="row"><?= Html::submitButton('Keisti', ['class' => 'btn btn-green btn-xs', 'style' => 'padding: 0px 10px; margin:7px 0 0; line-height: 1.3;', 'name' => 'name', 'value' => 'pass']) ?></div>
           		</div>
           	</div>
            <?php ActiveForm::end(); ?>

           	<div class="row" style="padding: 0; margin: 0 0 15px;"><span class="h4" style="color: #96c503;">Keisti el. paštą</span></div>

            <?php $form = ActiveForm::begin(); ?>
           	<div class="row" style="padding: 0; margin: 0;">
           		<div class="col-xs-4">
           			<div class="row">Dabartinis e-paštass</div>
           			<div class="row"><?= $form->field($model, 'emailOld')->textInput(['class' => 'trans_input', 'style' => 'margin-top: 5px; width:80%; outline-width: 0; padding: 0 5px;', 'autocomplete' => 'off'])->label(false); ?></div>
           			<div class="row"><span style="font-size:9px;">Norėdami Keisti e-paštą, įveskitę seną</span></div>
           		</div>
           		<div class="col-xs-3">
           			<div class="row">Naujas e-paštass</div>
           			<div class="row"><?= $form->field($model, 'emailNew')->textInput(['class' => 'trans_input', 'style' => 'margin-top: 5px; width:95%; outline-width: 0; padding: 0 5px;'])->label(false); ?></div>
           			<div class="row">Pakartok naują e-paštą</div>
           			<div class="row"><?= $form->field($model, 'emailNew2')->textInput(['class' => 'trans_input', 'style' => 'margin-top: 5px; width:95%; outline-width: 0; padding: 0 5px;'])->label(false); ?></div>
           		</div>
           		<div class="col-xs-3">
					    <div class="row"><bR></div>
           			<div class="row"><?= Html::submitButton('Keisti', ['class' => 'btn btn-green btn-xs', 'style' => 'padding: 0px 10px; margin:7px 0 0; line-height: 1.3;', 'name' => 'name', 'value' => 'email']) ?></div>
           		</div>
           	</div>
            <?php ActiveForm::end(); ?>
            
            <br>
            <div class="row" style="padding: 0; margin: 0 0 15px;"><span class="h4" style="color: #96c503;">Keisti vardą ar amžių</span></div>

            <div class="row" style="padding: 0; margin-top: -30px;">
              <div class="col-xs-7">
              </div>
              <div class="col-xs-4">
                <div class="row"><a href="<?= Url::to(['member/help', 't' => 'Vardo/Amžiaus keitimas']); ?>" class="btn btn-green btn-xs" style="padding: 0px 10px;line-height: 1.3;">Keisti</a></div>
              </div>
            </div>
            
            <Br>

           	<div class="row" style="padding: 0; margin: 0;margin-top: 10px;">
	           	<div class="col-xs-7" style="background-color: #94c301; margin-left: -20px; margin-right: 10px; padding: 10px 35px; width: 60%;">
	           		<div class="row"><span style="color: white; font-size: 16px;">Abonimentas apmokėtas iki: <?= $data; ?></span></div>
	           	</div>
	           	<div class="col-xs-3">
	           		<div class="row"><a href='<?= Url::current(['expired' => 1]); ?>' class="btn btn-green btn-xs" style="padding: 0px 10px; margin:0; line-height: 1.3;">Pratęsti</a></div>
	           	</div>
           	</div>

           	<div class="row" style="padding: 0; margin: 0; margin-top: 10px; padding-left: 20px;">
           		Pagalba - <a href="<?= Url::to(['member/help']); ?>" class="btn btn-green btn-xs" style="padding: 0px 5px; margin:0px; line-height: 1.2;">Rašyti laišką</a>
           	</div>

            <br>

        </div>
    </div>
</div>


<script type="text/javascript">

$(".close").click(function(){
    $("#success").fadeOut();
});

</script>