<?php
use yii\base\Security;
use yii\helpers\Url;



?>

<center>

	<img src="<?= $message->embed($logo); ?>" height="70" style="display: inline-block;">

	<p style="font-family: Arial;">
		<?= $body; ?>
	</p>

	<br>

	<div style="padding: 80px 0; margin-top: 80px; position: relative;">

		<img src="<?= $message->embed($avatars); ?>">

		<div style="margin-top: -100px; ">
			<a href="http://pazintyslietuviams.co.uk/"><img src="<?= $message->embed($link); ?>"></a>
		</div>

	</div>

</center>