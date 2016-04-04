<?php
use yii\helpers\Url;

$this->registerCssFile('css/events.css');

?>

<div class="zaisliukas">
	<img src="css/img/zaisliukas.png" style="position:relative; z-index: -1;">

	<p>
		Išsiųsti kalėdinį sveikinimą

	</p>

	
	<div class="laiskas">
		<img src="css/img/icons/arrow.png"><br>
		<a href="<?= Url::current(['eventpresent' => 1]); ?>">
			<img src="css/img/icons/laiskasEvent.jpg">
		</a>
	</div>
	
	
</div>
