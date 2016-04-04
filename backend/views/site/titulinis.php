<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="container">
	<h1>Titulinio nuotraukos keitimas</h1>

	<div class="row">
		<div class="col-xs-4">
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

			    <?= $form->field($model, 'imageFile')->fileInput() ?>

				<?= Html::submitButton('Keisti', ['class' => 'btn btn-primary', 'value'=>'Create & Add New']) ?>

			<?php ActiveForm::end() ?>
		</div>

		<div class="col-xs-7 col-xs-offset-1">
			<img src="../../frontend/web/css/img/pazintys_lietuviams.jpg?t=<?= time(); ?>" width="100%">
		</div>
	</div>
</div>
