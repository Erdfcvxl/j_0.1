<?php

use yii\helpers\Url;

$i = $model->id;

$timeDiff = time() - $model->lastOnline;

if($timeDiff <= 600){
    $online = 1;
}else{
    $online = 0;
}

?>
<div class="avatar" style="background-color: black; position: relative;" onclick='javascript:window.location.href="<?= Url::to(['member/msg', 'id' => $model->id])?>"'>
	<?php
		if($online):
    ?>
        <img src="/css/img/online.png" title="Prisijungęs" style="position: absolute; z-index: 20; left: 1px; bottom: 1px;">
    <?php endif; ?>
	<img src="<?= \frontend\models\Misc::getAvatar($model); ?>" class="centerMe" id="avatar<?= $i; ?>"/>
</div>


<script type="text/javascript">
	$(function ()
	{

		centerAvatar("avatar<?= $i; ?>");
		$('.avatar').css({"height" : $('.avatar').width() + "px"});
	});

	function centerAvatar(item)
	{

		var i =  $('#'+item),
			iW = i.width(),
			iH = i.height(),
			ar = iW/iH;

		if(iW > iH){
			iH = 80;
			iW = iH * ar;

			var left = (80 - iW) / 2;
			i.css({"height" : 100 + "%", "margin-left" : left + "px"});

		}else{
			iW = 80;
			iH = iW / ar;

			var top = (80 - iH) / 2;
			i.css({"width" : 100 + "%", "margin-top" : top + "px"});
		}
	}

</script>

