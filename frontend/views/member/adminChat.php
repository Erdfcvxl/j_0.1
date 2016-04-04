<?php
use frontend\models\Ago;
use frontend\models\AdminChat;
use yii\helpers\Url;

$chats = AdminChat::find()->where(['u_id' => Yii::$app->user->id])->all();
$user = \common\models\User::find()->where(['id' => Yii::$app->user->id])->one();
$user->adminChat = 0;
$user->save();
?>
<div class="row" style="margin: 2px 0 20px -15px">
	<div class="col-xs-12">
		<a href="<?= Url::to(['member/help']);?>" class="btn btn-info">Parašyti</a>
	</div>
</div>


<?php foreach ($chats as $chat): ?>

	<div class="row" style="margin: 2px 0 0 -15px">
	    <div class="col-xs-2"><img width="100%" src="/css/img/adav.jpg"></div>
	    <div class="col-xs-10 trans_box yourCloud" ><?= $chat->msg ?></div>
	    <div style="margin: 0px 0; float: right;"><span style="position: relative; font-size: 10px; top: -3px; color: #9b9b9b;"><?= Ago::timeAgo($chat->timestamp); ?></span></div>
	</div>

<?php endforeach; ?>
