<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="container" style="width:100%; background-color: #e8e8e8; min-height: 150px; font-size: 12px; text-align: left; padding: 15px 20px;">
	<?php $form = ActiveForm::begin(); ?>
		<h4>Žodis apie save</h4>
		<?= $form->field($model, 'zodis')->textArea(['style' => 'width: 100%;'])->label(false);   ?>

		<?= Html::submitButton('Išsaugoti', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 14px; padding: 0 20px 0 20px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7); border-radius: 0;']) ?>
	<?php ActiveForm::end() ?>
</div>