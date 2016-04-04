<?php
use frontend\models\getPhotoList;
use yii\helpers\Url;

use frontend\models\Albums;
use frontend\models\User;

$albums = Albums::find()->where(['u_id' => Yii::$app->user->id])->all();

?>

<div class="curtains" id="curtains"></div>

<div class="listBox">
	Pasirinkite albumą<br>

	<?php if($albums): ?>
		<?php foreach($albums as $album): ?>
			<a href="<?= Url::to(['member/movetoalbum', 'file' => $_GET['file'], 'albmn' => $album->name]) ?>"><?= $album->name; ?></a>
		<?php endforeach; ?>
	<?php else: ?>
		Jūs nesate sukūrę nei vieno albumo
	<?php endif; ?>
</div>