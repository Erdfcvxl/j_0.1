<?php

use yii\helpers\Url;
use frontend\models\getPhotoList;
use yii\helpers\BaseFileHelper;


$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
$id = (isset($_GET['id']))? $_GET['id'] : "";
$extra = (isset($_GET['extra']))? $_GET['extra'] : "";

if(!isset($dir)){
	$dir = "uploads/".Yii::$app->user->id;
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
		$url = Url::to(['member/myfoto', 'ft' => 'showFoto', 'n' => $fullname, 'd' => '/'.$dir, 'psl' => $psl, 'id' => $id]);
	}elseif($psl){
		$url = Url::to(['member/myfoto', 'ft' => 'showFoto', 'n' => $fullname, 'd' => '/'.$dir, 'psl' => $psl]);
	}else{
		$url = Url::to(['member/myfoto', 'ft' => 'showFoto', 'n' => $fullname, 'd' => '/'.$dir]);
	}

?>
	
	<div id="holderis" class="col-xs-4" style="padding: 0 1px; margin-bottom: 2px;">
		<?php if($extra): ?>
			<div class="photoHover">
				<?php if($extra == "del"): ?><div id="cross" file="<?= $dir."/".$file; ?>" class="glyphicon glyphicon-remove remove"></div><?php endif; ?>
				<?php if($extra == "choosePPic"): ?><a href="<?= Url::to(['member/chooseppic', 'file' => $dir."/".$file]);?>"><div id="tick" class="glyphicon glyphicon-ok"></div></a><?php endif; ?>
			</div>
		<?php endif; ?>
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
			$('.photoHover').css({'width' : $('#holderis').width() + "px"});

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

		/*function hoverOn(id)
		{
			$(id+'fixHeight').css({"display" : "block"});
		}

		function hoverOff(id)
		{
			if(id[1] == 'a'){
				$(id).css({"display" : "none"});
			}
		}

		$('.foto').mouseenter(function (e){
			console.log(e.target.id);
			hoverOn('#a'+e.target.id);
		});

		$('#cia<?= $i ?>').mouseleave(function (e){
			console.log(e.target.id);
			hoverOff('#'+e.target.id);
		});*/

	</script>

<?php $i++; ?>

<?php endforeach; ?>

<script type="text/javascript">
	$('.glyphicon').click(function(){
		$('#myAlert').fadeIn();
		$('#confirm').attr('link', "/member/deletefoto?file="+$(this).attr('file'));
		//$('#confirm').attr('link', "member?foto="+$(this).attr('file'));
	});

	$('#confirm').click(function(){
		window.location.href = $(this).attr('link');
	});

	$('#decline').click(function(){
		$('#myAlert').fadeOut();
	});

	$('#xas').click(function(){
		$('#myAlert').fadeOut();
	});
</script>



<?php endif; ?>