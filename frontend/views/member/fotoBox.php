<?php
use frontend\models\getPhotoList;
use frontend\models\User;
use yii\helpers\Url;
use frontend\models\Likes;
use frontend\models\LikesNot;
use frontend\models\Comments;
use frontend\models\filterFileName;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

$model = new Comments;

$dir = (isset($_GET['d']))? $_GET['d']: '';
$photo = (isset($_GET['n']))? $_GET['n']: '';
$type = (isset($_GET['type']))? $_GET['type']: '';
$id = (isset($_GET['id']))? $_GET['id']: '';
$action = Yii::$app->controller->action->id;

$notification = LikesNot::updateAll(['new' => 0], ['and', ['u_id' => Yii::$app->user->id, 'o_info' => $photo, 'new' => 1]]);

$nFilter = new filterFileName;
$photo = $nFilter->convertToFull($photo);

if($type != "dovana"):

	if($action == "myfoto"){

		$photoList = getPhotoList::makeArray($dir);
		if(!$photoList){
			return Yii::$app->getResponse()->redirect(Url::to(['member/fotoer']));
		}else {
			$currentPhoto = array_search($photo, $photoList);

			if ($currentPhoto === false) {
				Yii::$app->getResponse()->redirect(Url::to(['member/fotoer']));
			}
			$lastPhoto = count($photoList) - 1;

			$nextPhoto = ($currentPhoto + 1 > $lastPhoto) ? $photoList[0] : $photoList[$currentPhoto + 1];
			$prevPhoto = ($currentPhoto - 1 < 0) ? $photoList[$lastPhoto] : $photoList[$currentPhoto - 1];

			$psl = (isset($_GET['psl'])) ? $_GET['psl'] : "";
			$id = (isset($_GET['id'])) ? $_GET['id'] : "";

			if ($psl && $id) {
				$urlBack = Url::to(['member/' . $action, 'psl' => $psl, 'id' => $id]);
				$url = Url::to(['member/myfoto', 'ft' => 'showFoto', 'n' => $nextPhoto, 'd' => $dir, 'psl' => $psl, 'id' => $id]);
				$urlb = Url::to(['member/myfoto', 'ft' => 'showFoto', 'n' => $prevPhoto, 'd' => $dir, 'psl' => $psl, 'id' => $id]);
			} elseif ($psl) {
				$urlBack = Url::to(['member/' . $action, 'psl' => $psl]);
				$url = Url::to(['member/myfoto', 'ft' => 'showFoto', 'n' => $nextPhoto, 'd' => $dir, 'psl' => $psl]);
				$urlb = Url::to(['member/myfoto', 'ft' => 'showFoto', 'n' => $prevPhoto, 'd' => $dir, 'psl' => $psl]);
			} else {
				$urlBack = Url::to(['member/' . $action]);
				$url = Url::to(['member/myfoto', 'ft' => 'showFoto', 'n' => $nextPhoto, 'd' => $dir]);
				$urlb = Url::to(['member/myfoto', 'ft' => 'showFoto', 'n' => $prevPhoto, 'd' => $dir]);
			}
		}

	}else{


		$photoList = getPhotoList::makeArray($dir);
		if(!$photoList){
			return Yii::$app->getResponse()->redirect(Url::to(['member/fotoer']));
		}
		$currentPhoto = array_search($photo, $photoList);
		$lastPhoto = count($photoList) - 1;

		$nextPhoto = ($currentPhoto + 1 > $lastPhoto)? $photoList[0] : $photoList[$currentPhoto + 1];
		$prevPhoto = ($currentPhoto - 1 < 0)? $photoList[$lastPhoto] : $photoList[$currentPhoto - 1];

		$Aid = (isset($_GET['Aid']))? $_GET['Aid'] : "";
		$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
		$id = (isset($_GET['id']))? $_GET['id'] : "";

		if($psl && $id && $Aid){
			$urlBack = Url::to(['member/'.$action, 'psl' => $psl, 'id' => $id, 'Aid' => $Aid]);
			$url = Url::to(['member/'.$action, 'ft' => 'showFoto', 'n' => $nextPhoto, 'd' => $dir, 'psl' => $psl, 'id' => $id, 'Aid' => $Aid]);
			$urlb = Url::to(['member/'.$action, 'ft' => 'showFoto', 'n' => $prevPhoto, 'd' => $dir, 'psl' => $psl, 'id' => $id, 'Aid' => $Aid]);
		}elseif($psl){
			$urlBack = Url::to(['member/'.$action, 'id' => $id, 'psl' => $psl]);
			$url = Url::to(['member/'.$action, 'ft' => 'showFoto', 'n' => $nextPhoto, 'd' => $dir, 'id' => $id, 'psl' => $psl]);
			$urlb = Url::to(['member/'.$action, 'ft' => 'showFoto', 'n' => $prevPhoto, 'd' => $dir, 'id' => $id, 'psl' => $psl]);
		}else{
			$urlBack = Url::to(['member/'.$action, 'id' => $id]);
			$url = Url::to(['member/'.$action, 'ft' => 'showFoto', 'n' => $nextPhoto, 'd' => $dir, 'id' => $id]);
			$urlb = Url::to(['member/'.$action, 'ft' => 'showFoto', 'n' => $prevPhoto, 'd' => $dir, 'id' => $id]);
		}
	}

	$likes = count(Likes::getLikes($photo, ''));
	$arMegstu = Likes::arMegstu($photo, '');

	$photoOwner = getPhotoList::nameExtraction($photo)['ownerId'];


	$offeset = (isset($_GET['allC']))? 0 : Comments::find()->where(['commented_on' => $photo])->count()-5; 
	$limit = (isset($_GET['allC']))? Comments::find()->where(['commented_on' => $photo])->count() : 20; 

	$comments = Comments::find()->where(['commented_on' => $photo])->offset(0)->limit($limit)->orderBy(['timestamp'=>SORT_DESC])->all();

?>



<div class="fotoHover">
	<div id="mygtukas" style="background-image: url(/css/img/pamegti<?= ($arMegstu)? "H" : ""; ?>.png); width: 222px; height: 222px; text-align: center; ">
		<a href="<?= Url::to(['member/likeit', 'photoName' => $photo]); ?>">
			<div style="width: 100%; height: 222px;">
				<span style="position: relative; top: 135px; font-size: 24px;">
					<?= ($arMegstu)? "mėgstu" : "pamėgti"; ?>
				</span>
			</div>
		</a>
	</div>
	<div id="commentbox">

		<div class="container-fluid"> 
			<?php if(!\frontend\models\Expired::prevent()): ?>
				<?php $form = ActiveForm::begin(['action' => Url::to(['member/comment', 'object' => 'ft', 'name' => $photo, 'u_id' => $photoOwner, 'phover' => 1])]); ?>
					<div class="row"><?= $form->field($model, 'comment')->textInput(['class' => 'commentInput', 'rows' => '1', 'autocomplete' => "off"])->label(false); ?></div>
					     
					<div class="row" style="margin-top: -10px;">
						<div class="col-xs-8" style="padding: 0;"><a href="<?= Url::to(['member/'.$action, 'ft' => $_GET['ft'], 'n' => $photo, 'd' => $dir, 'id' => $id, 'allC' => 1]); ?>" style=" background-color: #363a3b; padding: 3px 10px; font-size: 12px;"><span style="color: white;">Rodyti visus komentarus</span> &#x25BC;</a></div>
						<div class="col-xs-4" style="padding: 0;"><?= Html::submitButton('Komentuoti', ['class' => 'btn btn-komentuoti']) ?></div>
					</div>
				<?php ActiveForm::end() ?>
			<?php endif;	?>
			

			<div id="comentarai" class="row">
				<div id="pilnasAukstis">
					<?php foreach($comments as $comment): ?>
						<?php
							$user = User::find()->where(['id' => $comment->commented_by])->one();
						?>
						<div class="row " style="margin-top: 1px;">
							<div class="col-xs-2 col-xs-height col-top" style="padding: 0;"><img src="/uploads/531B<?= $user->id; ?>Iav.<?= $user->avatar; ?>" width="100%" /></div>
							<div class="col-xs-10 col-xs-height col-top" style="background-color: #c1c0bc; padding: 3px 10px; font-size: 12px;"><?= $comment->comment;?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

		</div>

	</div>
</div>


<center><div id="trigger"> <img id="img" src="<?= $dir.'/'.$photo; ?>" style="position:relative;"> </div></center>
<a href="<?= $urlBack ?>" id="exit"><div class="photoBoxExit glyphicon glyphicon-remove" ></div></a>
<a href="<?= $urlb ?>" id="atgalhref"><img src="/css/img/icons/atgal.png" class="photoBoxAtgal"></a>
<a href="<?= $url ?>" id="pirmynhref"><img src="/css/img/icons/pirmyn.png" class="photoBoxPirmyn"></a>


<div class="likeSpot" style="background-image: url(/css/img/icons/megst<?= ($arMegstu)? "u" : "a"; ?>.png);">
	<div style="width: 25px; height: 22px; text-align: center; padding-top: 2px; display: inline-block;">
		<?= $likes; ?>
	</div>
	<span style="color: #80A60C"> <b>mėgsta</b></span>
</div>



<script type="text/javascript">
	function fixing()
	{
		var windowW = $( window ).width(),
			windowH = $( window ).height(),
			phtobox = $('#photobox'),
			image = $('#img'),
			imageW = image.width(),
			imageH = image.height();

		var windowAR = windowW/windowH,
			imageAR = imageW/imageH;

		var windowWidth70 = windowW * 0.7,
			imageWidth70 = windowWidth70,
			imageHeight70 = imageWidth70 / imageAR;

		if(imageHeight70 > windowH - 100){
			var currentImageWidth = (windowH - 100) * imageAR,
				currentImageHeight = windowH - 100 ;

			if(windowH - 100 > 222 && (windowH - 100) * imageAR > 222){
				image.css({"height" : windowH - 100 + "px", "width" : (windowH - 100) * imageAR});
				phtobox.css({"top" : "50px", "margin-left" : currentImageWidth / -2 + "px"});
			}

		}else{
			var currentImageWidth = imageWidth70,
				currentImageHeight = imageHeight70;

			if(windowH - 100 > 222 && (windowH - 100) * imageAR > 222){
				image.css({"height" : imageHeight70 + "px", "width" : imageWidth70});
				phtobox.css({"top" : "50px", "margin-left" : imageWidth70 / -2 + "px"});
			}
		}

		phtobox.css({"width" : currentImageWidth + "px", "height" : currentImageHeight + "px"});
		image.css({"display" : "block"});

		likeFixing(phtobox.width(), phtobox.height());
/*
		setTimeout(function(){
			$("#comentarai").scrollTop($('#pilnasAukstis').height());
		},200);
		*/
	}

	function likeFixing(outterW, outterH){
		$('#mygtukas').css({"margin-left" : (outterW * 0.5) - (222 * 0.5) + "px", "margin-top" : (outterH * 0.5) - 161 + "px"});
		$('#commentbox').css({"margin-left" : (outterW * 0.5) - (222 * 0.5) + 272 + "px", "margin-top" : (outterH * 0.5) - 50 + "px"});
		$('#comentarai').css({'height' :  (outterH * 0.5) - 72 + "px"});


		var pilnasWidth = (outterW * 0.5) - (222 * 0.5) + 222 + 50 + 300;

		if(pilnasWidth > outterW){
			console.log('per mazas boxas');
			var newWidth = 222 + 300 + 50 + 300 + 50;
			$('#photobox').css({"width" : newWidth + "px", "margin-left" : newWidth / -2 + "px"});
			likeFixing(newWidth, $('#photobox').height());
		}
	}


	$(document).mousemove(function(){
		mousemoved = true;
		
		if(mousemoved == true){
			if ($('#trigger').is(':hover')) {
		        $('.fotoHover').css({"display" : "block"});
		    }

			$('.fotoHover').mouseleave(function (){
				$('.fotoHover').css({"display" : "none"});
			});
		}
	});

	

	$(window).resize(function () {
		$('#overflow').css({"width" : "100%", "height" : $( window ).height() + "px"});
		fixing();
	});


	$('#img').load(function (){

		$('#overflow').css({"width" : "100%", "height" : $( window ).height() + "px"});
		fixing();

		var preHover = <?= (isset($_GET['allC']) || isset($_GET['phover']) )? 1 : 0; ?>;

		if(preHover){
			$('.fotoHover').css({"display" : "block"});
		}
	});

	$('#curtains').click(function () {
		window.location.href = '<?= $urlBack ?>';
	});

	$(window).load(function(){

        $("#img").attr('src','');
        $("#img").attr('src','<?= $dir.'/'.$photo; ?>');

		$(document).keydown(function(e) {
			console.log(e);
		  if(e.keyCode == 37) { // left
		    $('#atgalhref')[0].click();
		  }
		  else if(e.keyCode == 39) { // right
		    $('#pirmynhref')[0].click();
		  }
		  else if(e.keyCode == 27){
	        window.location.href = '<?= $urlBack ?>';
	        $('#exit')[0].click();
	      }
	  	});

	});


</script>

<?php else: ?>

	<?php
		$dovanos = \frontend\models\Dovanos::find()->where(['reciever' => $id])->andWhere(['object' => 'pav'])->andWhere(['opened' => 1])->all();

		$ids = [];
		foreach ($dovanos as $dovanos) {
			$ids[] = $dovanos->object_id;
		}
		$urlBack = Url::to(['member/'.$action, 'id' => $id, 'psl' => 'd']);

		if(count($ids) == 1){
			$urlb = Url::to(['member/'.$action, 'ft' => 'showFoto', 'type' => $type, 'id' => $id, 'photo_id' => $_GET['photo_id']]);
			$url = $urlb;
		}elseif(count($ids) == 2){

			$key = array_search($_GET['photo_id'], $ids);

			$back = ($key == 0)? 1 : 0;

			$urlb = Url::to(['member/'.$action, 'ft' => 'showFoto', 'type' => $type, 'id' => $id, 'photo_id' =>  $ids[$back]]);
			$url = $urlb;
		}else{

			$key = array_search($_GET['photo_id'], $ids);

			if($key + 1 == count($ids)){
				$back = $key - 1;
				$forw = 0;
			}elseif($key == 0){
				$back = count($ids) - 1;
				$forw = 1;
			}else{
				$back = $key - 1;
				$forw = $key + 1;
			}

			$urlb = Url::to(['member/'.$action, 'ft' => 'showFoto', 'type' => $type, 'id' => $id, 'photo_id' =>  $ids[$back]]);
			$url = Url::to(['member/'.$action, 'ft' => 'showFoto', 'type' => $type, 'id' => $id, 'photo_id' =>  $ids[$forw]]);
		}


	?>

<center><div id="trigger"> <img id="img" src="/css/img/dovanos/<?= $_GET['photo_id']?>.jpg" style="position:relative;"> </div></center>
<a href="<?= $urlBack ?>" id="exit"><div class="photoBoxExit glyphicon glyphicon-remove" ></div></a>
<a href="<?= $urlb ?>" id="atgalhref"><img src="/css/img/icons/atgal.png" class="photoBoxAtgal"></a>
<a href="<?= $url ?>" id="pirmynhref"><img src="/css/img/icons/pirmyn.png" class="photoBoxPirmyn"></a>




<script type="text/javascript">
	function fixing()
	{
		var windowW = $( window ).width(),
			windowH = $( window ).height(),
			phtobox = $('#photobox'),
			image = $('#img'),
			imageW = image.width(),
			imageH = image.height();

		var windowAR = windowW/windowH,
			imageAR = imageW/imageH;

		var windowWidth70 = windowW * 0.7,
			imageWidth70 = windowWidth70,
			imageHeight70 = imageWidth70 / imageAR;

		if(imageHeight70 > windowH - 100){
			var currentImageWidth = (windowH - 100) * imageAR,
				currentImageHeight = windowH - 100 ;

			if(windowH - 100 > 222 && (windowH - 100) * imageAR > 222){
				image.css({"height" : windowH - 100 + "px", "width" : (windowH - 100) * imageAR});
				phtobox.css({"top" : "50px", "margin-left" : currentImageWidth / -2 + "px"});
			}

		}else{
			var currentImageWidth = imageWidth70,
				currentImageHeight = imageHeight70;

			if(windowH - 100 > 222 && (windowH - 100) * imageAR > 222){
				image.css({"height" : imageHeight70 + "px", "width" : imageWidth70});
				phtobox.css({"top" : "50px", "margin-left" : imageWidth70 / -2 + "px"});
			}
		}

		phtobox.css({"width" : currentImageWidth + "px", "height" : currentImageHeight + "px"});
		image.css({"display" : "block"});

		likeFixing(phtobox.width(), phtobox.height());
/*
		setTimeout(function(){
			$("#comentarai").scrollTop($('#pilnasAukstis').height());
		},200);
		*/
	}

	function likeFixing(outterW, outterH){
		$('#mygtukas').css({"margin-left" : (outterW * 0.5) - (222 * 0.5) + "px", "margin-top" : (outterH * 0.5) - 161 + "px"});
		$('#commentbox').css({"margin-left" : (outterW * 0.5) - (222 * 0.5) + 272 + "px", "margin-top" : (outterH * 0.5) - 50 + "px"});
		$('#comentarai').css({'height' :  (outterH * 0.5) - 72 + "px"});


		var pilnasWidth = (outterW * 0.5) - (222 * 0.5) + 222 + 50 + 300;

		if(pilnasWidth > outterW){
			console.log('per mazas boxas');
			var newWidth = 222 + 300 + 50 + 300 + 50;
			$('#photobox').css({"width" : newWidth + "px", "margin-left" : newWidth / -2 + "px"});
			likeFixing(newWidth, $('#photobox').height());
		}
	}


	$(document).mousemove(function(){
		mousemoved = true;
		
		if(mousemoved == true){
			if ($('#trigger').is(':hover')) {
		        $('.fotoHover').css({"display" : "block"});
		    }

			$('.fotoHover').mouseleave(function (){
				$('.fotoHover').css({"display" : "none"});
			});
		}
	});

	

	$(window).resize(function () {
		$('#overflow').css({"width" : "100%", "height" : $( window ).height() + "px"});
		fixing();
	});


	$('#img').load(function (){

		$('#overflow').css({"width" : "100%", "height" : $( window ).height() + "px"});
		fixing();

		var preHover = <?= (isset($_GET['allC']) || isset($_GET['phover']) )? 1 : 0; ?>;

		if(preHover){
			$('.fotoHover').css({"display" : "block"});
		}
	});

	$('#curtains').click(function () {
		window.location.href = '<?= $urlBack ?>';
	});

	$(window).load(function(){

        $("#img").attr('src','');
        $("#img").attr('src','/css/img/dovanos/<?= $_GET["photo_id"]?>.jpg');

		$(document).keydown(function(e) {
			console.log(e);
		  if(e.keyCode == 37) { // left
		    $('#atgalhref')[0].click();
		  }
		  else if(e.keyCode == 39) { // right
		    $('#pirmynhref')[0].click();
		  }
		  else if(e.keyCode == 27){
	        window.location.href = '<?= $urlBack ?>';
	        $('#exit')[0].click();
	      }
	  	});

	});


</script>

<?php endif; ?>
