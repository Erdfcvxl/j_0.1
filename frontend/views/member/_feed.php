<?php

use frontend\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;
use frontend\models\Ago;



?>

<div class="row" style="margin: 0 5px 1px 5px">
	<div class="col-xs-12 highlight"> 

		<?php if($model->action == "tapoDraugais"): ?>
			<?php

				$user = User::find()->where(['id' => $model->u_id])->one();

				$user2 = User::find()->where(['id' => $model->info])->one();
			?>
			

			<img src="/css/img/icons/tapoDraugais.png" height="30px"> <a href="<?= Url::to(['member/user', 'id' => $user->id]); ?>" class="hoverAv" name="<?= $user->username; ?>"><?= $user->username; ?></a> tapo draugais su <a href="<?= Url::to(['member/user', 'id' => $user2->id]); ?>" class="hoverAv" name="<?= $user2->username; ?>"><?= $user2->username; ?></a>


		<?php elseif($model->action == "newUser"): ?>
			<?php
				$user = User::find()->where(['id' => $model->u_id])->one();

				if(!$user){
					$model->delete();
				}
			?>
			

			<img src="/css/img/icons/newUser.png" height="30px"> <a href="<?= Url::to(['member/user', 'id' => $user->id]); ?>" class="hoverAv" name="<?= $user->username; ?>"><?= $user->username; ?></a> prisijungė prie portalo

		<?php elseif($model->action == "pakeitePPic"): ?>
			<?php
				$user = User::find()->where(['id' => $model->u_id])->one();
			?>
			

			<img src="/css/img/icons/pakeitePPic.png" height="30px"> <a href="<?= Url::to(['member/user', 'id' => $user->id]); ?>" class="hoverAv" name="<?= $user->username; ?>"><?= $user->username; ?></a> pasikeitė profilio nuotrauką
		
		<?php elseif($model->action == "newFoto"): ?>
			<?php
				$user = User::find()->where(['id' => $model->u_id])->one();

				$info = explode(' ', $model->info);
			
			?>

			<img src="/css/img/icons/newFoto.png" height="30px"> <a href="<?= Url::to(['member/user', 'id' => $user->id]); ?>" class="hoverAv" name="<?= $user->username; ?>"><?= $user->username; ?></a> Įkėlė naują <a href="<?= Url::to(['member/fotos', 'id' => $user->id, 'ft' => 'showFoto', 'n' => $info[0], 'd' => '/'.$info[1]]); ?>">nuotrauką</a>

		<?php elseif($model->action == "newAlbum"): ?>
			<?php
				$user = User::find()->where(['id' => $model->u_id])->one();

				$albums = new \frontend\models\Albums;

				$albumas = $albums::find()->where(['name' => $model->info])->one();

			?>

			<img src="/css/img/icons/lupos.png" height="30px" width="33px"> <a href="<?= Url::to(['member/user', 'id' => $user->id]); ?>" class="hoverAv" name="<?= $user->username; ?>"><?= $user->username; ?></a> Sukurė naują <a href="<?= Url::to(['member/fotosalbumview', 'id' => $user->id, 'psl' => 'albumview', 'Aid' => $albumas->id]); ?>">albumą</a>
		
		<?php elseif($model->action == "editIesko"): ?>
			<?php
				$user = User::find()->where(['id' => $model->u_id])->one();

			?>

			<img src="/css/img/icons/piestukas.png" height="30px" style="margin-right: 5px;"> <a href="<?= Url::to(['member/user', 'id' => $user->id]); ?>" class="hoverAv" name="<?= $user->username; ?>"><?= $user->username; ?></a> pakeitė savo anketos duomenis, <a href="<?= Url::to(['member/iesko', 'id' => $user->id]); ?>">peržiūrėti</a>

		<?php elseif($model->action == "editAnketa"): ?>
			<?php
				$user = User::find()->where(['id' => $model->u_id])->one();

			?>

			<img src="/css/img/icons/piestukas.png" height="30px" style="margin-right: 5px;"> <a href="<?= Url::to(['member/user', 'id' => $user->id]); ?>" class="hoverAv" name="<?= $user->username; ?>"><?= $user->username; ?></a> pakeitė savo anketos duomenis, <a href="<?= Url::to(['member/anketa', 'id' => $user->id]); ?>">peržiūrėti</a>

		<?php elseif($model->action == "pakeiteZodi"): ?>
			<?php
				$user = User::find()->where(['id' => $model->u_id])->one();

			?>

			<img src="/css/img/icons/piestukas.png" height="30px" style="margin-right: 5px;"> <a href="<?= Url::to(['member/user', 'id' => $user->id]); ?>" class="hoverAv" name="<?= $user->username; ?>"><?= $user->username; ?></a> pakeitė žodį apie save, <a href="<?= Url::to(['member/anketa', 'id' => $user->id]); ?>">peržiūrėti</a>


		<?php endif; ?>
		<div style="float: right; opacity: 0.8; margin-top: 8px;"><?= Ago::timeAgo($model->timestamp); ?></div>
	</div>
</div>