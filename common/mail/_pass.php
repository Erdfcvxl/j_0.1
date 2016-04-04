<?php
use yii\base\Security;
use yii\helpers\Url;

?>

<center>
	<img src="<?= $message->embed($logo); ?>" height="70" style="display: inline-block;">

	<p style="font-size: 20px; color:#000; font-family: OpenSans;" >
		<b>
			Jūs sėkmingai pakeitėte slaptažodį!
		</b>
	</p>
	<br>
	<p style="font-size: 20px; color:#5a5a5a; font-family: OpenSans;">
		Slaptažodžio priminimas: <b><span style="color: #000;"><?= $pass; ?></span></b><br>
	</p>

	<div style="padding: 80px 0; margin-top: 80px; position: relative;">

		<img src="<?= $message->embed($avatars); ?>">

		<div style="margin-top: -100px; ">
			<a href="<?= Url::to(['site/login'], true);?>"><img src="<?= $message->embed($link); ?>"></a>
		</div>

	</div>

</center>