<?php

use yii\helpers\Url;
use frontend\models\Albums;
use frontend\models\getPhotoList;
use yii\helpers\BaseFileHelper;

$Aid = (isset($_GET['Aid']))? $_GET['Aid'] : "";
$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
$id = (isset($_GET['id']))? $_GET['id'] : "";


if(!isset($dir)){
	$dir = "uploads/".$id;
}

if(!file_exists($dir)){
	BaseFileHelper::createDirectory($dir, $mode = 0777);
}

$dh  = opendir($dir);



while (false !== ($filename = readdir($dh))) {
	
	
    if(strlen($filename) > 2){

    	$pirmostrys = substr($filename, 0, 3);

    	if($pirmostrys == "BTh"){
    		$files[] = $filename;
		}
	}
}

if(isset($files)):
	sort($files);




$i = 0;

foreach($files as $file): ?>

<?php 
	$extract = getPhotoList::nameExtraction($file);

	$fullname = "BFl".$extract['pure']."EFl".$extract['lastChar'];

	if($psl && $id){
		$url = Url::to(['member/'.Yii::$app->controller->action->id, 'ft' => 'showFoto', 'n' => $fullname, 'd' => '/'.$dir, 'psl' => $psl, 'id' => $id, 'Aid' => $Aid]);
	}elseif($psl){
		$url = Url::to(['member/'.Yii::$app->controller->action->id, 'ft' => 'showFoto', 'n' => $fullname, 'd' => '/'.$dir, 'id' => $id, 'psl' => $psl]);
	}else{
		$url = Url::to(['member/'.Yii::$app->controller->action->id, 'ft' => 'showFoto', 'n' => $fullname, 'd' => '/'.$dir, 'id' => $id]);
	}

?>
	
	<div id="holderis" class="col-xs-4" style="padding: 0 5px; margin-bottom: 10px;">
		<div class="foto" id="cia<?= $i; ?>">
			<a href="<?= $url ?>">
				<div class="nuotraukaTh" style="overflow: hidden; padding: 0; position: relative;">

					<img id="centerMe<?= $i; ?>" src="<?= '/'.$dir."/".$file ?>" style="position: relative; display: block !important;"/>

				</div>
			</a>
		</div>
	</div>

	<script type="text/javascript">

		function fixCenterMe(id)
		{
			$('.nuotraukaTh').css({'height' : $('#holderis').width() + "px"});

			var hBox = $('#holderis').width(),
				wBox = hBox,
				hImg = $('#centerMe'+id).height(),
				wImg = $('#centerMe'+id).width(),
				aRatio = hImg / wImg,
				margin = Array();

		
			if(aRatio >= 1){ //portrait
				$('#centerMe'+id).css({"width" : 100+"%", "height" : "auto"});

				hImg = $('#centerMe'+id).height();
				wImg = $('#centerMe'+id).width();

			}else{ 
				$('#centerMe'+id).css({"height" : 100+"%", "width" : "auto"});

				hImg = $('#centerMe'+id).height();
				wImg = $('#centerMe'+id).width();

			}

			margin[0] = (wImg - wBox) / -2;
			margin[1] = (hBox - hImg) / -2;

			$('#centerMe'+id).css({"left" : margin[0] + "px", "bottom" : margin[1] + "px"});
		}

		function fixHeight(id)
		{
			$('#acenterMe'+id+'fixHeight').css({'height' : $('#holderis').width() + "px",'width' : $('#holderis').width() + "px"});
		}


		$('#centerMe<?= $i; ?>').one('load', function() {
		  fixCenterMe(<?= $i; ?>);
		  fixHeight(<?= $i; ?>);
		}).each(function() {
		  if(this.complete) $(this).load();
		});

	</script>

<?php $i++; ?>

<?php endforeach; ?>

<?php endif; ?>