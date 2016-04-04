<?php
use yii\base\Security;
use yii\helpers\Url;

?>

<center>
	<img src="<?= $message->embed($logo); ?>" height="70" style="display: inline-block;">

	<p style="font-size: 20px; color:#5a5a5a; font-family: OpenSans;">
		Jūsų prisijungimo vardas: <b><span style="color: #000;"><?= $name; ?></span></b><br>
		Jei norite gauti naują slaptažodį paspauskite šią nuorodą: <a href="<?= Url::to(['site/login', 'lost' => 1, 'name' => $name, 'psl' => 'proceed', 'token' => $token], true); ?>">Pažintyslietuviams.co.uk</a><br>
	</p>

	<div style="padding: 80px 0; margin-top: 80px; position: relative;">

		<img src="<?= $message->embed($avatars); ?>">

		<div style="margin-top: -100px; ">
			<a href="<?= Url::to(['site/login'], true);?>"><img src="<?= $message->embed($link); ?>"></a>
		</div>

	</div>

</center>