<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\UploadForm2;

?>

<?php if(Yii::$app->session->hasFlash("success")): ?>
<div id="alert" class="col-xs-12"> 
	<div class="alert alert-success">
	    <a href="#" class="close" data-dismiss="alert"></a>
	    <strong>Baigta!</strong> Viršelio nuotrauka sėkmingai pakeista.
	</div>
</div>

<script type="text/javascript">
	setTimeout(function(){
		$('#alert').fadeOut();
	},5000);
</script>
<?php endif; ?>

<div class="col-xs-6"> 
	<h5>Pakeisti albumo viršelį</h5>
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

		<?= $form->field($model, 'file', ['template' => '{input}<div class="new_er">{error}</div>'])->fileInput()->label(false);   ?>

		<?= Html::submitButton('Keisti', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 14px; padding: 0 20px 0 20px;  font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7); border-radius: 0;']) ?>
	<?php ActiveForm::end() ?>
</div>