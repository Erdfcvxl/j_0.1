<?php 

use frontend\models\Post;
use frontend\models\User;
use frontend\models\Info;
use frontend\models\Ago;
use yii\helpers\Url;
use frontend\models\Misc;


if($user = User::find()->where(['id' => $model->u_id])->one()):

$color = (isset($_GET['color']))? $_GET['color'] : '#90C3D4'; 

if($user->avatar){
    $avataras = "/uploads/531B".$user->id."Iav.".$user->avatar;
}else{
    $avataras = "/css/img/icons/no_avatar.png";
}


$info = Info::find()->where(['u_id' => $model->u_id])->one(); 

$d1 = new DateTime($info->diena.'.'.$info->menuo.'.'.$info->metai);
$d2 = new DateTime();

$diff = $d2->diff($d1);

require(__DIR__ ."/../site/form/_list.php");

?>

<div class="row" style="background-color: <?= $color; ?>; padding: 5px; margin-bottom: 10px;">
	<div class="col-xs-3" style="padding-left: 0;">
		<div style="position: relative;">
			<a href="<?= Url::to(['member/user', 'id' => $user->id]);?>">
				<img width="100%" src="<?= $avataras; ?>">
			    <?php 
		            $timeDiff = time() - $user->lastOnline;

		            if($timeDiff <= 600){
		                $online = 1;
		            }else{
		                $online = 0;
		            }
		            if($online):
		        ?>
		            <img src="/css/img/online.png" title="Prisijungęs" style="position: absolute; z-index: 1; margin-top: -14px; margin-left: 1px; left: 0; bottom: 1px;">
		        <?php endif; ?>
	        </a>
	    </div>
		<div style="background-color: white; text-align: center; font-size: 14px;">
			<b><?= $user->username; ?><?= \frontend\models\Misc::vip($user); ?></b> <br>
			<?= $diff->y; ?> m., <?= $list[$info->miestas]; ?>
		</div>
	</div>
	<div class="col-xs-9" style="font-weight: normal;">
		<div class="row" style="margin: 5px 0; font-size: 10px; text-align: right;">

			<div class="col-xs-3 col-xs-offset-8" style="padding: 0; margin-right: -10px;"><?= Ago::timeAgo($model->timestamp); ?></div>
			<div class="col-xs-1" style="padding: 0;"><?= $this->render('//member/iga/_forumPost', ['id' => $model->id]); ?></div>
			
		</div>
		<div class="row" style="background-color: white; padding: 5px;">
			<div class="col-xs-12">
				<?= $model->text; ?>
			</div>
		</div>
	</div>
	
</div>

<?php endif; ?>