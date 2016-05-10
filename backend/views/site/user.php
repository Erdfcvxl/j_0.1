<?php
use yii\helpers\Url;
use frontend\models\InfoClear;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use kartik\select2\Select2;

$info = InfoClear::find()->where(['u_id' => $model->id])->one();

if(!$info){
	$info = new InfoClear;
	$info->u_id = $model->id;
	$info->save(false);
}

$lytis = [
	'' => 'nenustatyta',
 	'vv' => 'vyras ieškantis vyro',
	'vm' => 'vyras ieškantis moters',
	'mm' => 'moteris ieškantis moters',
	'mv' => 'moteris ieškantis vyro',
];


?>

<div class="container">
	
	<?php if(Yii::$app->session->hasFlash('success')): ?>

		<div class="row">
			<div class="col-xs-12">
				<div class="alert alert-success"><?= Yii::$app->session->getFlash('success')?></div>
			</div>
		</div>

	<?php endif; ?>


</div>

<div class="container"style="border: 1px solid #666666; border-radius: 5px; margin-bottom: 15px;">

	<div class="row">

		<div class="col-xs-6" style="text-align: left;">
			<h1><?= $model->username; ?><?= $model->f ? '<small>(fake)</small>' : ''; ?></h1>
		</div>
		<div class="col-xs-6" style="margin-top: 21px; text-align: right;">
			<?php if($model->f): ?>
				<a href="<?= Url::to(['site/fparam', 'id' => $model->id, 'val' => '0']); ?>" class="btn btn-info"><b>Panaikinti</b> 'fake' statusą</a>
			<?php else: ?>
				<a href="<?= Url::to(['site/fparam', 'id' => $model->id, 'val' => '1']); ?>" class="btn btn-info"><b>Įjungti</b> 'fake' statusą</a>
			<?php endif;?>
			<?php if(!isset($blocking)): ?>
				<!-- <a href="<?= Url::to(['site/userblock', 'id' => $model->id]); ?>" class="btn btn-<?= ($model->blocked)? 'success' : 'warning' ?>"><?= ($model->blocked)? 'Atblokuoti' : 'Blokuoti' ?></a> -->
			<?php endif; ?>
			<a href="<?= Url::to(['site/userdelete', 'id' => $model->id]); ?>" class="btn btn-danger">Trinti</a>
		</div>	
		
			

	</div>

	<?php if(isset($blocking)): ?>
		<div class="row">
			<div class="col-xs-12">

				<table class="table table-striped table-bordered table-hover">
					<?php $form = ActiveForm::begin();?>
						<thead>
							<th colspan="2"><h3>Blokavimo informacija:</h3></th>
						</thead>
						<tr>
							<td width="100px" style="vertical-align : middle;">Žinutė</td>
							<td>
								<?= $form->field($model, 'blockedInfo')->textArea(['placeholder' => 'Tekstas...'])->label(false) ?>
							</td>
						</tr>
						<tfoot>
							<td colspan="2"><?= Html::submitButton('Blokuoti', ['class' => 'btn btn-warning']) ?></td>
						</tfoot>
						
					<?php ActiveForm::end(); ?>
				</table>

			</div>
		</div>
	<?php endif; ?>



	<div class="row">
		<div class="col-xs-12">

			<table class="table table-striped table-bordered table-hover">
				<?php $form = ActiveForm::begin();?>
					<thead>
						<th colspan="2"><h3>Keisti informacija:</h3></th>
					</thead>

					<tr>
						<td width="100px" style="vertical-align : middle;">Lytis</td>
						<td>
							<?= $form->field($info, 'iesko')->widget(Select2::classname(), ['data' => $lytis, 'hideSearch' => true])->label(false);?>
						</td>
					</tr>

					<tfoot>
						<td colspan="2"><?= Html::submitButton('Išsaugoti', ['class' => 'btn btn-success']) ?></td>
					</tfoot>

					

				<?php ActiveForm::end(); ?>
			</table>

		</div>
	</div>
</div>
