<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


if(isset($_GET['t'])){
	$model->subject = $_GET['t'];
}
?>

<div class="row" style="margin-top: 5px;">
    <div class="col-xs-12" >
	      <div class="container fix-form" style="width:100%; background-color: #e8e8e8; height: auto; font-size: 12px; text-align: left; padding: 10px 20px;">

			<div class="row">
				<?php if(Yii::$app->session->hasFlash('success') || Yii::$app->session->hasFlash('danger')): ?>
				<div id="alert" class="col-xs-12"> 
					<div class="alert alert-<?= (Yii::$app->session->hasFlash('success'))? 'success' : 'danger' ?>">
					    <a href="#" class="close" data-dismiss="alert"></a>
					    <?= Yii::$app->session->getFlash('danger')?>
					    <?= (Yii::$app->session->hasFlash('success'))? "<strong>Baigta!</strong> ".Yii::$app->session->getFlash('success') : '';?> 
					</div>
				</div>
				<?php endif; ?>
			</div>

	      	    <div class="row">
			        <div class="col-lg-12">
			            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
			                <?= $form->field($model, 'subject') ?>
			                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
			                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
			                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>', 
			                ]) ?>
			                <div class="form-group" style="margin-top: 10px;">
			                    <?= Html::submitButton('Siųsti', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
			                </div>
			            <?php ActiveForm::end(); ?>
			        </div>
			    </div>

	      </div>
    </div>
</div>