<?php 
use Yii\helpers\Url;

$link = (isset($url))? $url : Url::canonical();

?>

<div style="position:absolute; right: <?= $right; ?>px; top: <?= $left; ?>px;">
	<a href="<?= $link; ?>">
		<span style="font-size: <?= $size; ?>px;" class="glyphicon glyphicon-remove"></span>
	</a>
</div>
