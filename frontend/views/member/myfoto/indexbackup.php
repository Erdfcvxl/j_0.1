<?php

use frontend\models\User;
use frontend\models\Albums;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;


$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
$id = (isset($_GET['id']))? $_GET['id'] : "";

$user = User::find()->where(['id' => Yii::$app->user->id])->one();

$structure = "/uploads/".Yii::$app->user->id;

if (!is_dir($structure)) {
    mkdir($structure, 0777);
}


?>

<div class="container" style="width:100%; background-color: #e8e8e8; min-height: 150px; font-size: 12px; text-align: left; padding: 0;">
    <div class="container rowme" style="width:100%">
        <div class="row" style="padding: 15px 0;">

			
			<?php if(isset($fromController)): ?>

				<?php if($fromController == "caname"): ?>
					<?= $this->render('caname', ['user' => $user, 'model' => $AlbumsModel]); ?>

				<?php elseif($fromController == "cac"): ?>
					<?= $this->render('cac', ['user' => $user, 'model' => $AlbumsModel]); ?>
				<?php endif; ?>

			<?php else: ?>

				<?php if($psl == "changePPic"): ?>

					<?= $this->render('changePPic', ['user' => $user, 'UploadForm' => $UploadForm]); ?>

				<?php elseif($psl == "newAlbum"): ?>

					<?= $this->render('newAlbum', ['user' => $user, 'model' => $model]); ?>

				<?php elseif($psl == "newFoto"): ?>

					<?= $this->render('newFoto', ['user' => $user, 'model' => $model]); ?>

				<?php elseif($psl == "myAlbum"): ?>
					<?php
						$nameAlb = Albums::find()->where(['id' => $id])->one();
					?>

	   				<div style="col-xs-12" >
	   					<a class="btn btn-reg" href="<?= Url::to(['member/myfoto', 'psl' => 'newFoto', 'str' => $nameAlb->name]) ?>" style="margin-left: 10px; font-size: 14px; padding: 0 20px 0 20px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7); border-radius: 0;">Pridėti nuotrauką</a>
	   					<a class="btn btn-reg" href="<?= Url::to(['member/caname', 'id' => $_GET['id']]); ?>" style="margin-left: 10px; font-size: 14px; padding: 0 20px 0 20px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7); border-radius: 0;">Pervadinti albumą</a>
	   					<a class="btn btn-reg" href="<?= Url::to(['member/cac', 'id' => $_GET['id']]); ?>" style="margin-left: 10px; font-size: 14px; padding: 0 20px 0 20px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7); border-radius: 0;">Pakeisti viršelį</a>
	   					<a class="btn btn-warning" href="<?= Url::to(['member/da', 'id' => $_GET['id']]); ?>" style="margin-left: 10px; font-size: 14px; margin-top:-15px; padding: 0 20px 0 20px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7); border-radius: 0;">Trinti albumą</a>
	   				</div>

					<?php $name = Albums::find()->where(['id' => $_GET['id']])->one(); ?>
					<?= $this->render('_fotos', ['user' => $user, 'dir' => "/uploads/".$name->u_id."/".$name->name]); ?>

				<?php else: ?>

		       		<div class="col-xs-3" id="1" style="border-right: 1px solid white;">

		       			<div class="row" style="margin-bottom: 10px;">
		       				<div class="col-xs-12">Profilio nuotrauka</div>
		       			</div>

		       			<div class="row">
		       				<div class="col-xs-12">

			       				<?php if($user->avatar == ""): ?>

							        <img src="/css/img/icons/no_avatar.png" width="100%" />

							    <?php else: ?>

							        <img src="/uploads/531B<?= $user->id; ?>Iav.<?= $user->avatar; ?>" width="100%" />

							    <?php endif ?>
							    <a href="<?= Url::to(['member/myfoto', 'psl' => 'changePPic']); ?>" class="btn btn-reg btn-xs" style="width: 100%; font-size: 13px; border-radius: 0; padding: 2px 0;">Keisti profilio nuotrauką</a>

						    </div>
		       			</div>

		       		</div>


		       		<div class="col-xs-3" id="2" style="border-right: 1px solid white;">

		       			<div class="row" style="margin-bottom: 10px;">
		       				<div class="col-xs-12">Albumai</div>
		       			</div>

		       			<div class="row">
		       				<div class="col-xs-6" style="padding: 0 5px; margin-bottom: 10px;"><a href="<?= Url::to(['member/myfoto', 'psl' => 'newAlbum']) ?>"><div class="albumas" id="albm"><img src="/css/img/plus.png" id="albmimg" class="circleShaddow"><br>Pridėti naują albumą</div></a></div>
		       				<?php Pjax::begin();?>
				            <?= ListView::widget( [
				                'layout' => '{items}<div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
				                'dataProvider' => $dataProvider,
				                'itemView' => '//member/_albumsResult',
				                'emptyText' => '',
				                'pager' =>[
				                    'maxButtonCount'=>0,
				                    'nextPageLabel'=>'Kitas &#9658;',
				                    'nextPageCssClass' => 'removeStuff',
				                    'prevPageLabel'=>'&#9668; Atgal',
				                    'prevPageCssClass' => 'removeStuff',
				                    'disabledPageCssClass' => 'off',
				                ]

				                ] ); 
				            ?>
				            <?php Pjax::end(); ?>
		       			
				            </div>
		       		</div>


		       		<div class="col-xs-6" id="3">

		       			<div class="row" style="margin-bottom: 10px;">
		       				<div class="col-xs-12">Pavienės nuotraukos</div>
		       			</div>

		       			<div class="row">
		       				<div class="col-xs-4" style="padding: 0 5px; margin-bottom: 10px;">
		       					<a href="<?= Url::to(['member/myfoto', 'psl' => 'newFoto']) ?>">
		       						<div class="nuotraukaTh" id="nutrauka"><br><img src="/css/img/plus.png" id="nuotrimg" class="circleShaddow" width="30%">
		       							<br>Pridėti nuotrauką
		       						</div>
		       					</a>
		       				</div>

		       				<?= $this->render('_fotos'); ?>
		       			</div>

		       		</div>


		       		<script type="text/javascript">
		       			$(function (){
		       				
			       			var h = Array(),				    
			       				max = 0;

			       			h[0] = $('#1').height();
			       			h[1] = $('#2').height();
			       			h[2] = $('#3').height();

			       			for(var i = 0; i < h.length; i++){
			       				if(h[i] > max){
			       					max = h[i];
			       				}
			       			}

			       			for(var i = 0; i < h.length; i++){
			       				$('#'+i).css({"height" : max + "px"});
			       			}

		       			});

		       			$('#albm').hover(function(){
		       				 if($("#albmimg").attr("src") == "/css/img/plus.png"){
		       				 	$("#albmimg").attr("src", "/css/img/plusH.png");
		       				 }else{
		       				 	$("#albmimg").attr("src", "/css/img/plus.png");
		       				 }
		       			});

		       			$('#nutrauka').hover(function(){
		       				 if($("#nuotrimg").attr("src") == "/css/img/plus.png"){
		       				 	$("#nuotrimg").attr("src", "/css/img/plusH.png");
		       				 }else{
		       				 	$("#nuotrimg").attr("src", "/css/img/plus.png");
		       				 }
		       			});
		       		</script>

				<?php endif; ?>
			<?php endif; ?>


        </div>
    </div>
</div>