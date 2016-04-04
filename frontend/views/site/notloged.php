<?php
use yii\helpers\Url;
?>
<div class="alert alert-danger">
	<H3>Prisijungimas nesėkmingas</H3>	
</div>

<a class="btn btn-default" href="<?= Url::to(['site/login']); ?>">Grįžti į puslapį</a>