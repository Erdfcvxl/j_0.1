<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Url;

use frontend\models\User;

$model = new User;



?>

<div class="container-fluid">
	
	<div class="row">
		<div class="popUp col-xs-12 col-sm-10 col-md-6 col-sm-offset-1 col-md-offset-3" style="background-color: white;">
			<a href="<?= Url::canonical(); ?>"><div class="glyphicon glyphicon-remove" style="position: absolute; top: 5px; right: 5px; font-size: 20px;"></div></a>

			<h3>Duomenų priminimas</h3>
			<?php if(isset($_GET['psl']) && $_GET['psl'] == 'proceed'): ?>

				<p>
					Jūsų naujas slaptažodis yra: <b><?= Yii::$app->view->params['newPass'] ?></b><br>
					<div class="alert alert-info"><b>Pastaba!</b> Laiškas su slaptažodžio kopija išsiųstas jums į el. paštą. Dabar galite prisijungti naudojant šį slaptažodį, o jį pakeisti galima prisijungus, skiltyje <i>"Nustatymai"</i>.</div>
					<a href="<?= Url::canonical(); ?>" class="btn btn-success">Tęsti</a>
				</p>

			<?php elseif(isset($_GET['psl']) && $_GET['psl'] == 'issiusta'): ?>
				<p>
					Laiškas su tolimesniais nurodymais išsiųstas Jums į el. paštą.
				</p>
			<?php else: ?>

				<h3>Slaptažodžio priminimas</h3>
				<p>
					Jei pamiršote salptažodį ar prisijungimo vardą, įveskite el. pašto adresą į žemiau pateiktą laukelį ir mes atsiųsimę naujus prisijungimo duomenis jums į el. paštą.

					<?php $form = ActiveForm::begin(['id' => 'lost', 'action' => Url::to(['site/lost']) ]);?>

						<?= $form->field($model, 'email')->textInput()->label('El. paštas'); ?>

						<?= Html::submitButton('Siųsti', ['class' => 'btn btn-success']) ?>


					<?php ActiveForm::end() ?>

				</p>

			<?php endif; ?>

		</div>
	</div>

</div>



