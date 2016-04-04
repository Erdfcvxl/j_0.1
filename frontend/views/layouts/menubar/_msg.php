<?php

use common\models\User;
use frontend\models\InfoClear;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Expression;

if(substr(Yii::$app->user->identity->info->iesko, 0, 1) == "v"){
    $fitssex = ['mm', 'mv'];
}elseif(substr(Yii::$app->user->identity->info->iesko, 0, 1)  == "m"){
    $fitssex = ['vv', 'vm'];
}

$lastOnline = time()-600;


$select = ['u.id', 'u.username', 'u.avatar', 'u.expires', 'u.lastOnline', 'i.iesko'];

$query = new Query;
$query->select($select)  
	->from('user AS u')
	->join('LEFT JOIN', 'info AS i', 'u.id = i.u_id')
	->where(['i.iesko' => $fitssex])
	->andWhere(['<', 'u.lastOnline', $lastOnline])
	->andWhere(['not', ['u.id' => Yii::$app->user->id]])
	->orderBy(new Expression('rand()'))
	->limit(8); 
		
$command = $query->createCommand();
$usersOffline = $command->queryAll();


$query = new Query;
$query->select($select)  
	->from('user AS u')
	->join('LEFT JOIN', 'info AS i', 'u.id = i.u_id')
	->where(['i.iesko' => $fitssex])
	->andWhere(['>=', 'u.lastOnline', $lastOnline])
	->andWhere(['not', ['u.id' => Yii::$app->user->id]])
	->orderBy(new Expression('rand()'))
	->limit(8); 
		
$command = $query->createCommand();
$usersOnline = $command->queryAll();	


$chat = new \frontend\models\Chat;
$chat = $chat::whochats();

$models = array_merge($usersOnline, $usersOffline);

?>

<div class="row" style="margin: 0 -20px;">

	<div class="col-xs-12"  id="randomLineNew" style="display: none; background-color: white; height: 100px; padding-top: 10px;"></div>

	<div class="col-xs-12 noMarginLeftOnFirst" id="randomLine" style="background-color: white; height: 100px;">
		<?= (count($models) > 0)? '<div style="float: left; color: #c0db66; font-size: 35px; margin-top: 24px; position: relative; left: -6px; "><a href="">&#x2039;</a></div>' : '' ?>
		<?php
			$i = 0;

			foreach ($models as $model) {

				$timeDiff = time() - $model['lastOnline'];

                if($timeDiff <= 600){
                    $online = 1;
                }else{
                    $online = 0;
                }

				?>

						<div class="avatar" style="background-color: black; position: relative;" onclick='javascript:window.location.href="<?= Url::to(['member/msg', 'id' => $model['id']])?>"'>
							<?php
								if($online):
			                ?>
			                    <img src="/css/img/online.png" title="Prisijungęs" style="position: absolute; z-index: 1; left: 1px; bottom: 1px;">
			                <?php endif; ?>
							<img src="<?= \frontend\models\Misc::getAvatarADP($model, substr($model['iesko'], 0, 1)); ?>" class="centerMe hoverAvMsg" name="<?= $model['username']; ?>"id="avatar<?= $i; ?>"/>
						</div>


				<?php
				$i++;

				if($i == 8){
					break;
				}
			}

		?>			
		<?= (count($models) > 0)? '<div style="float: left; color: #c0db66; font-size: 35px; margin-top: 24px; position: relative; left: 10px;"><a href="javascript:window.location.href=window.location.href">&#x203A;</a></div>' : '' ?>
	</div>

</div>

<script type="text/javascript">
	$(function ()
	{
		$('.avatar').css({"height" : $('.avatar').width() + "px"});
	});

	function centerAvatar(item)
	{
		var i =  $('#'+item.id),
			iW = i.width(),
			iH = i.height(),
			ar = iW/iH;

		if(iW > iH){
			iH = 80;
			iW = iH * ar;

			var left = (80 - iW) / 2;
			i.css({"height" : 100 + "%", "margin-left" : left + "px"});

		}else{
			iW = 80;
			iH = iW / ar;

			var top = (80 - iH) / 2;
			i.css({"width" : 100 + "%", "margin-top" : top + "px"});
		}
	}

	$('.centerMe').one("load", function() {
      centerAvatar(this);
    }).each(function() {
      if(this.complete) $(this).load();
    });

</script>