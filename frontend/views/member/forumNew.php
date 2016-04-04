<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="container-fluid" style="background-color: #e8e8e8; text-align: left; padding: 15px;">
	<div class="row">
		<div class="col-xs-12"><h4>Sukurti naują <b>forumą</b></h4></div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(); ?>
				<?= $form->field($model, 'name')->textInput()->label('Pavadinimas');   ?>
				<?= $form->field($model, 'extra_info')->textArea(['style' => 'width: 100%;'])->label('Pirmasis pranešimas');   ?>

				<?= Html::submitButton('Kurti', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 14px; padding: 0 20px 0 20px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7); border-radius: 0;']) ?>
			<?php ActiveForm::end() ?>
		</div>
	</div>
</div>