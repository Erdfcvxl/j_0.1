<?php
use frontend\models\Ago;

$d1 = new DateTime();
$d1->setTimestamp($model->gimimoTS);
$d2 = new DateTime();

require(__DIR__ ."/../../site/form/_list.php");

$diff = $d2->diff($d1);

$avatar = \frontend\models\Misc::getAvatar($model);

if(isset(Yii::$app->params['close'])){
    Yii::$app->params['close']++;
}
?>


<div class="col-xs-6">
	<div class="row">

		<div class="col-xs-4" style="padding: 0;">
			<div class="avatarHolder">
				<img src="<?= $avatar ?>" width="100%">
			</div>
		</div>

		<div class="col-xs-8"style="padding: 0 5px;">
			<span style="font-size: 16px;"><?= $model->username ?><?= \frontend\models\Misc::vip($model); ?></span><br>
			<?= $diff->y; ?>, <?= (!empty($model->miestas))? $list[$model->miestas] : 'nenustatyta'; ?><br>
			<span style="color: #95c501;"><?= Ago::TimeAgo($model->timestamp); ?></span>
		</div>

	</div>
	
</div>

<?php if(isset(Yii::$app->params['close']) && Yii::$app->params['close'] > 1): Yii::$app->params['close'] = 0; ?>

    </div>
    <div class="row" style="padding-left: 15px; padding-right: 15px;">

<?php endif; ?>
