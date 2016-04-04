<?php
use yii\helpers\Url;
use frontend\models\FunctionsSettings;

$error = '';

if($success = Yii::$app->session->getFlash('success') || $danger = Yii::$app->session->getFlash('danger')){

if($success){
	$message = "Veiksmas sėkmingai atliktas";
	$class = "success";
}elseif($danger){
	$class = "danger";
	$message = "Veiksmas nebuvo atliktas";
}

$pavadinimas = Yii::$app->session->getFlash('success');

$error = <<<EOD
<div class="alert alert-$class"><b>$pavadinimas</b> $message</div>
EOD;

}

$settings = FunctionsSettings::find()->all();

$fnames = [
	'MWeekendsFree' => 'Nemokamas savaitgalis moterims',
	'AllWeekendsFree' => 'Nemokamas savaitgalis visiems',
]

?>

<div class="container">

	<h1>Akcijos</h1>

	<div class="row">
		<div class="col-xs-12"><?= $error; ?></div>
	</div>
	<div class="row">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Pavadinimas</th>
					<th>Būsena</th>
					<th>Veiksmas</th>
				</tr>
			</thead>
			<?php foreach ($settings as $model) : ?>
				<tr>
					<td><?= $fnames[$model->name] ?></td>
					<td class="<?= ($model->on)? 'success' : ''; ?>"><?= ($model->on)? 'Įjungta' : 'Išjungta'; ?></td>
					<td style="text-align: center;" >
						<a href="<?= Url::to(['site/switch', 'fid' => $model->id]); ?>" style="color: #<?= ($model->on)? 'D64747' : '47D674';?>">
							<span class="<?= ($model->on)? 'glyphicon glyphicon-off' : 'glyphicon glyphicon-record'; ?>"></span>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>

		</table>
	</div>

</div>
