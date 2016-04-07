<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ListView;
use kartik\daterange\DateRangePicker;


require(__DIR__ . '/../../../frontend/views/site/form/_list.php');

$data = [
	'Grupės' =>['Anglija' => 'Visa Anglija', 'Airija' => 'Visa Airija'],
	'Pavieniai' => $list,
];


$datepicker2 = DateRangePicker::widget([
	'name'=>'created_at',
	'convertFormat'=>true,
	'pluginOptions'=>[
		'locale'=>[
			'format'=>'Y-m-d',
			'separator'=>' - ',
		],
	],
	'hideInput' => true,
	'containerTemplate' => '
        <span class="input-group-addon">
            <i class="glyphicon glyphicon-calendar"></i>
        </span>
        <span class="form-control text-right">
            <span class="pull-left">
                <span class="range-value">{value}</span>
            </span>
            {input}
        </span>
    ',
]);

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
						<td width="400px;">

							<p class="text-center">Naudoti automtinį įvedimą <?= Html::input('radio', 'ivestis', 'auto', ['style' => 'display: inline-block;', 'checked' => true]) ?></p>

							<p><?= Html::checkBox('mass[pla]', false) ?> Priešingos lyties atstovams (ne VIP'ams)</p>
							<p><?= Html::checkBox('mass[plaV]', false) ?> Priešingos lyties atstovams (VIP'ams)</p>
							<p><?= Html::checkBox('mass[tpla]', false) ?> Tos pačios lyties atstovams (ne VIP'ams)</p>
							<p><?= Html::checkBox('mass[tplaV]', false) ?> Tos pačios lyties atstovams (VIP'ams)</p>

							<hr>

							<label class="control-label"><?= Html::checkBox('mass[miestai]', false, ['id' => 'miestai', 'class' => 'prock']) ?> Miestai </label>
							<div id="miestaiB" style="display: none;">
								<?= Select2::widget([
									'name' => 'miestai',
									'data' => $data,
									'options' => [
										'placeholder' => 'Pasirinkite miestus ...',
										'multiple' => true,
										'style' => 'width: 100%;',
									],
								]);
								?>
							</div>

							<hr>

							<label class="control-label"><?= Html::checkBox('mass[amzius]', false, ['id' => 'amzius', 'class' => 'prock']) ?> Amžius</label>
							<div id="amziusB" style="display: none;">
								<?= Html::input('text', 'amzius[nuo]', '', ['class' => 'form-control', 'placeholder' => 'Nuo', 'style' => 'width: 75px; display: inline-block;']) ?>
								<?= Html::input('text', 'amzius[iki]', '', ['class' => 'form-control', 'placeholder' => 'Iki', 'style' => 'width: 75px; display: inline-block;']) ?>
							</div>

							<hr>

							<label class="control-label"><?= Html::checkBox('mass[tikslas]', false, ['id' => 'tikslas', 'class' => 'prock']) ?> Tikslas</label>
							<div id="tikslasB" style="display: none;">
								<?= Select2::widget([
									'name' => 'tikslas',
									'data' => $tikslas,
									'options' => [
										'placeholder' => 'Pasirinkite tikslus ...',
										'multiple' => true,
										'style' => 'width: 100%;',
									],
								]);
								?>
							</div>

							<hr>

							<label class="control-label"><?= Html::checkBox('mass[orentacija]', false, ['id' => 'orentacija', 'class' => 'prock']) ?> Orentacija</label>
							<div id="orentacijaB" style="display: none;">
								<?= Html::checkBox('orentacija[0]', false) ?> Biseksuali 		&nbsp; &nbsp; &nbsp;
								<?= Html::checkBox('orentacija[1]', false) ?> Heteroseksuali 	&nbsp; &nbsp; &nbsp;
								<?= Html::checkBox('orentacija[2]', false) ?> Homoseksuali  	&nbsp; &nbsp; &nbsp;
							</div>

							<hr>

							<label class="control-label"><?= Html::checkBox('mass[foto]', false) ?> Tik su nuotrauka</label>

							<hr>

							<label class="control-label"><?= Html::checkBox('mass[registracija]', false, ['id' => 'registracija', 'class' => 'prock']) ?> Registracijos laikas</label>
							<div id="registracijaB" style="display: none;">
								<?= $datepicker2; ?>
							</div>



						</td>
					</tr>

					<tr style="background-color: #eee">
						<th style="vertical-align: middle; text-align: center;">Testavimui</th>
						<td><?= Html::checkBox('mass[fake]', false) ?> Automatinius filtrus taikyti tik fake nariams</td>
					</tr>

					<tr>
						<th colspan="2" style="vertical-align: middle; text-align: center;">Žinutė</th>
					</tr>

					<tr>
						<td colspan="2"><textarea name="msg" style="width: 100%;"></textarea></td>
					</tr>

					<tr>
						<th colspan="2"><?= Html::submitButton('Ieškoti', ['class' => 'btn btn-primary', 'value'=>'Create & Add New', 'style' => 'width: 100%']) ?></th>
					</tr>
				</table>

				
				<br>


			<?php ActiveForm::end() ?>
		</div>

	</div>

</div>

<script type="text/javascript">

	$('.prock').change(function(){
		var id = this.id;

		if($(this).is(":checked"))
			$('#'+id+'B').fadeIn();
		else
			$('#'+id+'B').fadeOut();

	});




</script>
