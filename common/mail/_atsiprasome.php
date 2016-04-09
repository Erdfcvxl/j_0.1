<?php
use yii\base\Security;
use yii\helpers\Url;

?>

<center>
	<img src="<?= $message->embed($logo); ?>" height="70" style="display: inline-block;">

	<p style="font-size: 20px; color:#000; max-width: 768px; font-family: OpenSans;" >
		Atsiprašome, jeigu turėjote problemų jungdamiesi prie mūsų svetainės. Buvo atliekami tobulinimo darbai. Laukiame Jūsų grįžtant. Tiesiog paspauskite ant mygtuko prisijungti ir facebook ženkliuko. Sekmės!<br><br>

		Pazintyslietuviams.co.uk komanda.
	</p>

	<div style="padding: 80px 0; margin-top: 80px; position: relative;">

		<img src="<?= $message->embed($avatars); ?>">

		<div style="margin-top: -100px; ">
			<a href="https://pazintyslietuviams.co.uk"><img src="<?= $message->embed($link); ?>"></a>
		</div>

	</div>

</center>