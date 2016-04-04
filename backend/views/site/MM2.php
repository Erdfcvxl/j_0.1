<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;

require(__DIR__ . '/../../../frontend/views/site/form/_list.php');
?>

<div class="container">
	<h1>Rašyti masinę žinutę iš fake nario</h1>

	<div class="row">
		<div class="col-xs-12 col-lg-3">
			<div style="width: 200px;">
				<?= $this->render('avatar', ['model' => $user]);?>

				Nario orentacija: <?= $orentacija[$user->info->orentacija]; ?>
			</div>

			<script type="text/javascript">
		        $(".manualAvatar img.cntrm").fakecrop({wrapperWidth: 200,wrapperHeight: 200, center: true });
		    </script>

		    <br>

		    <p>Žinutė visiems priešingos lyties ir tinkamos pakraipos nariams bus išsiųsta šio nario vardu.</p>

		</div>

		<div class="col-xs-12 col-lg-9">
			<p>Rašyti žinutę</p>

			<?php $form = ActiveForm::begin() ?>
				<?= Html::input('hidden', 'id', $user->id) ?>
				<?= Html::input('hidden', 'lytis', substr($user->info->iesko, 0, 1)) ?>

				<table class="table table-bordered" width="100%">
					<tr>
						<th colspan="2" style="vertical-align: middle; text-align: center;">Gavėjai</th>
					</tr>

					<tr>
						<td>

							<p class="text-center">Naudoti rankinį įvedimą <?= Html::input('radio', 'ivestis', 'manual', ['style' => 'display: inline-block;']) ?></p>

							<?= Html::input('text', 'recievers', '', ['class' => 'form-control', 'placeholder' => 'Vaikis,Sima,Vasara']) ?>
							<small style="color: #777">Rašyti slapyvardžius. Kiekvieną slapyvardį atskirti kableliu</small>

							
							
						</td>
						<td>

							<p class="text-center">Naudoti automtinį įvedimą <?= Html::input('radio', 'ivestis', 'auto', ['style' => 'display: inline-block;', 'checked' => true]) ?></p>

							<p><?= Html::checkBox('mass[pla]', false) ?> Priešingos lyties atstovams (ne VIP'ams)</p>
							<p><?= Html::checkBox('mass[plaV]', false) ?> Priešingos lyties atstovams (VIP'ams)</p>
							<p><?= Html::checkBox('mass[tpla]', false) ?> Tos pačios lyties atstovams (ne VIP'ams)</p>
							<p><?= Html::checkBox('mass[tplaV]', false) ?> Tos pačios lyties atstovams (VIP'ams)</p>
						</td>
					</tr>

					<tr>
						<th colspan="2" style="vertical-align: middle; text-align: center;">Žinutė</th>
					</tr>

					<tr>
						<td colspan="2"><textarea name="msg" style="width: 100%;"></textarea></td>
					</tr>
				</table>

				
				<br>
				<?= Html::submitButton('Ieškoti', ['class' => 'btn btn-primary', 'value'=>'Create & Add New']) ?>

			<?php ActiveForm::end() ?>
		</div>

	</div>


</div>
