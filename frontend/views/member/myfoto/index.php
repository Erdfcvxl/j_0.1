<?php

use frontend\models\User;
use frontend\models\Albums;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\BaseFileHelper;


$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
$id = (isset($_GET['id']))? $_GET['id'] : "";
$extra = (isset($_GET['extra']))? $_GET['extra'] : "";


$user = User::find()->where(['id' => Yii::$app->user->id])->one();

$structure = "uploads/".Yii::$app->user->id;

if (!is_dir($structure)) {
    BaseFileHelper::createDirectory($structure, $mode = 0777);
}


?>

<div class="container" id="atskaita" style="width:100%; background-color: #f9f9f9; min-height: 150px; font-size: 12px; text-align: left; padding: 0;">
    <div class="container rowme" style="width:100%">
        <div class="row">

			<div class="col-xs-2" id="col1" style="background-color: #ffffff; text-align:center; padding: 10px;">

				<div class="row">
					<div class="col-xs-12">
						<span style="border-bottom: 1px solid #999999; color: #999999;">&nbsp <b>Albumai</b> &nbsp</span>
					</div>
				</div>

				<div class="row" style="margin-top: 10px; opacity: <?= ($psl == "p")? 1 : 0.6; ?>">
					<div class="col-xs-12">	
						<a href="<?= Url::to(['member/myfoto', 'psl' => 'p']); ?>">
							<div style="border: 1px solid #929292; padding-bottom: 10px; color: #3a3a3a;">
								<img src="/css/img/icons/pfoto.png" style="padding: 15px;">
								Profilio foto
							</div>
						</a>
					</div>
				</div>

				<div class="row" style="margin-top: 10px; opacity: <?= ($psl == "")? 1 : 0.6; ?>">
					<div class="col-xs-12">	
						<a href="<?= Url::to(['member/myfoto']); ?>">
							<div style="border: 1px solid #929292; padding-bottom: 10px; color: #3a3a3a;">
								<img src="/css/img/icons/fotoaparatas2.png" style="padding: 15px;">
								Nuotraukos
							</div>
						</a>
					</div>
				</div>

				<div class="row" style="margin-top: 10px; opacity: <?= ($psl == "d")? 1 : 0.6; ?>">
                    <div class="col-xs-12"> 
                        <a href="<?= Url::to(['member/myfoto', 'psl' => 'd']); ?>">
                            <div style="border: 1px solid #929292; padding-bottom: 10px; color: #3a3a3a;">
                                <img src="/css/img/icons/fotoaparatas2.png" style="padding: 15px;">
                                Atvirutes
                            </div>
                        </a>
                    </div>
                </div>

			</div>

			<div class="col-xs-10" id="col2" style="padding: 10px;">

				<div class="row">
					<div class="col-xs-7">
						<span style="border-bottom: 1px solid #999999; color: #999999;">&nbsp <b>Nuotraukos</b> &nbsp</span>
					</div>
					<div class="col-xs-5" style="position: relative; top: 4px; margin-top: -4px; right: 5px; text-align: right;">
						<?php 
							$files = (count(\yii\helpers\BaseFileHelper::findFiles("uploads/".Yii::$app->user->id."/"))) / 2;

							if($files == 1):
						?>
							<span style="color: #3C763D;"><a href="<?= Url::to(['member/myfoto', 'psl' => 'newFoto', 'str' => $psl]); ?>">Įkelkite nuotrauką</a></span>
						<?php endif; ?>
						<img id="more" src="/css/img/icons/pmore.jpg" style="cursor: pointer;">
					</div>

					<div class="moreBox" id="moreBox">
						<img class="trianbleSide" src="/css/img/icons/triangleside.jpg">
						<a href="<?= Url::to(['member/myfoto', 'psl' => $psl, 'extra' => 'del']); ?>">Ištrinti nuotrauką</a><br>
						<a href="<?= Url::to(['member/myfoto', 'psl' => 'newFoto', 'str' => $psl]); ?>">Įkelti nuotrauką</a><br>
						<a href="<?= Url::to(['member/myfoto', 'psl' => 'changePPic', 'str' => $psl]); ?>">Įkelti profilio n.</a><br>
						<a href="<?= Url::to(['member/myfoto', 'psl' => $psl, 'extra' => 'choosePPic']); ?>">Pasirinkti profilio n.</a>
					</div>

				</div>

				<div class="row" style="margin-top: 10px;">

					<?php if($psl == ""): ?>
						<div class="col-xs-12">
							<?= $this->render('//member/myfoto/_fotos', ['extra' => $extra]); ?>
						</div>
		        	<?php elseif($psl == "p"): ?>
		        		<div class="col-xs-12">
		        			<?= $this->render('//member/myfoto/_fotos', ['dir' => "uploads/".Yii::$app->user->id."/profile"]); ?>
		        		</div>
		        	<?php elseif($psl == "d"): ?>
		        		<div class="col-xs-12">
		        			<?= $this->render('//member/fotos/_dovanos', ['id' => Yii::$app->user->id]); ?>
		        		</div>
	        		<?php elseif($psl == "newFoto"): ?>
		        		<div class="col-xs-12">
		        			<?= $this->render('newFoto', ['user' => $user, 'model' => $model]); ?>
		        		</div>
	        		<?php elseif($psl == "changePPic"): ?>
		        		<div class="col-xs-12">
		        			<?= $this->render('changePPic', ['user' => $user, 'UploadForm' => $UploadForm]); ?>
		        		</div>
	        		<?php elseif($psl == "limit"): ?>
	        			<?= $this->render('_limit'); ?>
		        	<?php endif; ?> 

		        	

				</div>
			
			</div>
			
        </div>
    </div>
</div>

<script type="text/javascript">
	$(function(){
		$('#col1').css({"height" : $('#atskaita').height() + "px"});
		$('#col2').css({"height" : $('#atskaita').height() + "px"});
	});	

	$('#more').click(function(){
		$('#moreBox').toggle();
	});

	$('#moreBox').mouseleave(function(){
		$('#moreBox').css({"display" : "none"});
	});
</script>
