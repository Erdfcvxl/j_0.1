<?php

use frontend\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;
use frontend\models\Ago;

$user = User::find()->where(['id' => $model->u_id])->one();

$user2 = User::find()->where(['id' => $model->giver_id])->one();

if($user && $user2):

?>

<div class="row" style="margin: 0 5px 1px 5px">

		<?php if($model->object == "foto"): ?>
			<?php

				if(file_exists('uploads/'.$user->id.'/'.$model->o_info)){
					$d = '/uploads/'.$user->id;
				}else{
					$d = '/uploads/'.$user->id.'/profile';
				}
			?>
			<div class="col-xs-12 highlight changeA" style="background-color: #E1F1D7;"> 

				<img src="/css/img/balta_sirdele.png" height="20px" style="margin-top: 4px;"> <div style="position: relative; top: 1px; display: inline-block;"> <a href="<?= Url::to(['member/user', 'id' => $user2->id]); ?>" class="hoverAv" name="<?= $user2 ->username; ?>"><?= $user2->username; ?></a> pamėgo jūsų <a href="<?= Url::to(['member/myfoto', 'ft' => 'showFoto', 'n' => $model->o_info, 'd' => $d ]); ?>" >nuotrauką</a> </div>

		<?php elseif($model->object == "comment"): ?>
			<?php

				if(file_exists('uploads/'.$user->id.'/'.$model->o_info)){
					$d = '/uploads/'.$user->id;
				}else{
					$d = '/uploads/'.$user->id.'/profile';
				}
			?>

			<div class="col-xs-12 highlight changeA" style="background-color: #D1F1EE;">
				<img src="/css/img/balta_sirdele.png" height="20px" style="margin-top: 4px;"> <div style="position: relative; top: 1px; display: inline-block;"> <a href="<?= Url::to(['member/user', 'id' => $user2->id]); ?>" class="hoverAv" name="<?= $user2 ->username; ?>"><?= $user2->username; ?></a> pakomentavo jūsų <a href="<?= Url::to(['member/myfoto', 'ft' => 'showFoto', 'n' => $model->o_info, 'd' => $d ]); ?>" >nuotrauką</a> </div>	
			
		<?php endif; ?>
		<div style="float: right; opacity: 0.8; margin-top: 4px;"><?= Ago::timeAgo($model->timestamp); ?></div>
	</div>
</div>

<?php endif; ?>
