<?php
use yii\helpers\Url;

if(!$dovana = \frontend\models\Dovanos::find()->where(['id' => $_GET['dopen']])->andWhere(['reciever' => Yii::$app->user->id])->one()){
	return Yii::$app->getResponse()->redirect( Url::to(['member/index']));
}
if($dovana->opened == 0){

	$user = \frontend\models\User::find()->where(['id' => $dovana->reciever])->one();
	if($dovana->object == 'talpa'){
		$user->photoLimit += 5;
		$user->save(false);
	}elseif($dovana->object == 'aboni'){
		if($user->expires < time()){
			$user->expires = time() + 60 * 60 * 24 * 31;
		}else{
			$user->expires += 60 * 60 * 24 * 31;
		}
		
		$user->vip = 1;
		$user->save(false);
	}

	$dovana->opened = 1;
	$dovana->save(false);
}


$sender = \frontend\models\User::find()->where(['id' => $dovana->sender])->one();

$info = \frontend\models\Info::find()->where(['u_id' => $sender->id])->one(); 

$d1 = new DateTime($info->diena.'.'.$info->menuo.'.'.$info->metai);
$d2 = new DateTime();

$diff = $d2->diff($d1);

require(__DIR__ ."/../site/form/_list.php");

?>

<div class="dopen">

	<a href="<?= Url::canonical() ?>" id="xas" style="position: absolute; right: 1px; top: -30px; color: #b7b7b7; cursor: pointer; font-size: 20px;" class="glyphicon glyphicon-remove"></a>


	<div class="row">
			<div style="height : 120px; float: left; padding-left: 15px;">
			<img src="/uploads/531B<?= $sender->id; ?>Iav.jpg" height="100%" id="avatar">
		</div>
		
		<div id="whatsLeft" style="float: left; color: white">
			<div class="row">
				<div class="col-xs-6" style="padding: 10px 30px;">
					<span>
						<?=$sender->username?><br><?= $diff->y; ?> metai, <?= $list[$info->miestas]; ?>
					</span>
				</div>		
				<div class="col-xs-6" style="padding: 10px 30px 10px 7px;text-align: right;">
					<a href="<?= Url::to(['member/user', 'id' => $sender->id]) ?>" style="padding: 3px 10px; border: 1px solid #95c501">Peržiūrėti profilį</a>
				</div>		
			</div>
			
			<div class="row">
				<center><h3>ATSIUNTĖ TAU DOVANĄ!</h3></center>
			</div>

		</div>

	</div>
	<?php if($dovana->object == "pav"): ?>

		<div class="row">
			<div class="col-xs-12">
				<img src="/css/img/dovanos/<?= $dovana->object_id; ?>.jpg" width="100%">
			</div>
		</div>

	<?php elseif($dovana->object == "talpa"): ?>

		<div class="row">
			<div class="col-xs-12" style="color: white;">
				<br>
				<center><h1>5 nuotraukos vietos</h1></center>
				<br>
			</div>
		</div>

	<?php elseif($dovana->object == "aboni"): ?>

		<div class="row">
			<div class="col-xs-12" style="color: white;">
				<br>
				<center><h1>1 mėnesio abonimentas</h1></center>
				<br>
			</div>
		</div>

	<?php endif; ?>
</div>

<script type="text/javascript">
	$('#whatsLeft').css({
		'width' : 500 - $('#avatar').width() + "px"
	});
</script>
