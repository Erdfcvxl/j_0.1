<?php
use yii\helpers\Url;

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

?>

<div class="row">
	<div class="col-xs-12"><?= $error; ?></div>
	<div class="col-xs-12"><a href="<?= Url::to(['site/cleanavatar']);?>" class="btn btn-function">Išvalyti neegzistuojančius avatarus</a></div>
</div>