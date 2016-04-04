<?php
use yii\helpers\Url;

$folder_id = (isset($_GET['id']))? $_GET['id'] : Yii::$app->user->id;

$dir = "/uploads/".$folder_id ."/".$model->name."/";

if(!file_exists($dir)){
	mkdir($dir, 0777);
}

$dh  = opendir($dir);

while (false !== ($filename = readdir($dh))) {
    if(strlen($filename) > 2){
    	$files[] = $filename;
	}
}

if(isset($files)):
sort($files);

?>

<div id="holderisalb" class="col-xs-6" style="padding: 0 5px; margin-bottom: 10px;">
	<div class="albumas" style="overflow: hidden; padding: 0; position: relative;">

		<a href="<?= Url::to(['member/fotosalbumview', 'psl' => 'albumview', 'Aid' => $model->id, 'id' => $_GET['id']]) ?>">
			<div class="albumHover" id="<?= $model->id; ?>" style="position: absolute; z-index: 5; bottom: 0; text-align: center; width: 100%; background-color: rgba(255,255,255,0.7); line-height: 1;"><?= $model->name." (".((count($files)-2)/2) .")"; ?></div>

			<img id="centerMeAlbm<?= $model->id; ?>" src="/uploads/<?= $folder_id ; ?>/<?= $model->name; ?>/<?= '6o73r'.$folder_id .'Eth.'.$model->cover; ?>" style="position: relative;"/>
		</a>

	</div>
</div>

<script type="text/javascript">

	function fixcenterMeAlbm(id)
	{
		var hBox = $('#holderisalb').width(),
			wBox = hBox,
			hImg = $('#centerMeAlbm'+id).height(),
			wImg = $('#centerMeAlbm'+id).width(),
			aRatio = hImg / wImg,
			margin = Array();

		$('.albumas').css({"height" : $('#holderisalb').width() + "px"});
	
		if(aRatio >= 1){ //portrait
			$('#centerMeAlbm'+id).css({"width" : 100+"%", "height" : "auto"});

			hImg = $('#centerMeAlbm'+id).height();
			wImg = $('#centerMeAlbm'+id).width();

		}else{ 
			$('#centerMeAlbm'+id).css({"height" : 100+"%", "width" : "auto"});

			hImg = $('#centerMeAlbm'+id).height();
			wImg = $('#centerMeAlbm'+id).width();

		}

		margin[0] = (wImg - wBox) / -2;
		margin[1] = (hBox - hImg) / -2;

		$('#centerMeAlbm'+id).css({"left" : margin[0] + "px", "bottom" : margin[1] + "px"});
	}

	$('#centerMeAlbm<?= $model->id; ?>').one('load', function() {
	  fixcenterMeAlbm(<?= $model->id; ?>);
	}).each(function() {
	  if(this.complete) $(this).load();
	});
</script>
<?php endif; ?>