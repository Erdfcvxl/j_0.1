<?php
use yii\widgets\ListView;
use frontend\models\Forum;
use yii\helpers\Url;
use frontend\models\CheckedForums;

$id = (isset($_GET['id']))? $_GET['id'] : '';
$color = (isset($_GET['color']))? $_GET['color'] : '#90C3D4'; 

$forum = Forum::find()->where(['id' => $id])->one();


?>

<div class="container-fluid" style="background-color: #e8e8e8; text-align: left; padding: 5px;">
	<div class="row" style="margin-right: -10px; margin-bottom: -10px;">
		<div class="col-xs-8">
			<div style="font-size: 20px; margin-left: 5px; margin-top: 10px;">
				<b><?= $forum->name; ?></b>
			</div>
		</div>
		<div class="col-xs-4" style="text-align: right; padding-top: 5px;">
			<?php if(!CheckedForums::isChecked($forum->id)): ?>
				<a href="<?= Url::to(['member/check', 'id' => $forum->id]); ?>" class="btn btn-success"><img src="/css/img/icons/sirdele_black.png" height="20px"></a>
			<?php else: ?>
				<a href="<?= Url::to(['member/uncheck', 'id' => $forum->id]); ?>" class="btn btn-success"><img src="/css/img/icons/baltas_sirdele.png" height="20px"></a>
			<?php endif; ?>

			<?php if(!\frontend\models\Expired::prevent()): ?>
				<a href="<?= Url::to(['member/forumats', 'id' => $id, 'color' => $color ]); ?>" class="btn btn-success">Atsakyti</a>		
			<?php endif; ?>

			<?php if(frontend\models\Misc::iga()): ?>
				<a href="<?= Url::to(['member/delete', 'class' => '\frontend\models\Forum', 'k' => 'id', 'v' => $forum->id]); ?>" class="btn btn-danger"><span style="color: black" class="glyphicon glyphicon-trash"></span></a>
			<?php endif; ?>
			
		</div>
	</div>

	<?php if(\frontend\models\Expired::prevent()): ?>
		<div class="row">
			<div class="col-xs-12">
				<div class="alert alert-warning">
	                <b>Jūsų abonimento galiojimas baigėsi.</b>
	                <br>
	               	Atsakyti gali tik tie nariai, kurių abonimentas yra galiojantis.
	            </div>
			</div>
		</div>
	<?php endif; ?>

	<?= ListView::widget( [
	    'layout' => '<div style="padding: 20px;">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
	    'dataProvider' => $dataProvider,
	    'itemView' => '//member/_forumPost',
	    'pager' =>[
	        'maxButtonCount'=>3,
	        'nextPageLabel'=>'Kitas &#9658;',
	        'nextPageCssClass' => 'removeStuff',
	        'prevPageLabel'=>'&#9668; Atgal',
	        'prevPageCssClass' => 'removeStuff',
	        'disabledPageCssClass' => 'off',
	    ],
	    'showOnEmpty' => 'false',

	    ] ); 
	?>
</div>
	
