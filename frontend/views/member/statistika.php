<?php
use yii\helpers\Url;
use frontend\models\User;
use frontend\models\Chat;

$id = (isset($_GET['id']))? $_GET['id'] : '';
$psl = (isset($_GET['psl']))? $_GET['psl'] : '';

$sent = Chat::find()->where(['sender' => Yii::$app->user->id])->all();
$recieved = Chat::find()->where(['reciever' => Yii::$app->user->id])->all();
$user = ($id) ? User::find()->where(['id' => $id])->one() : Yii::$app->user->identity;

$overall = $model->{'overall'.$psl}();
$model->ratings();

?>
<div class="container" style="font-family: OpenSansLight; width:100%; background-color: #f9f9f9; min-height: 150px; font-size: 12px; text-align: left; padding: 0;">
    <div class="container" style="width:100%;">

    	<center><h2><?= ($id) ? $user->username : 'Tavo';?> reitingas pagal</h2></center>

    	<div class="row">

    		<div class="col-xs-7" id="pickerHolder">
				<a class="col-xs-3 <?= ($psl == "views")? 'active' : ''; ?>" href="<?= Url::current(['psl' => 'views']); ?>">
					<div class="gSquare"><?= $model->viewsRating ?></div>
					<span style="margin-top: 3px; display: block;">Peržiūras</span>
				</a>
				<a class="col-xs-3 <?= ($psl == "msg")? 'active' : ''; ?>" href="<?= Url::current(['psl' => 'msg']); ?>">
					<div class="gSquare"><?= $model->msgRating ?></div>
					<span style="margin-top: 3px; display: block;">Žinutes</span>
				</a>
				<a class="col-xs-3 <?= ($psl == "like")? 'active' : ''; ?>" href="<?= Url::current(['psl' => 'like']); ?>">
					<div class="gSquare"><?= $model->likeRating ?></div>
					<span style="margin-top: 3px; display: block;">Laikus</span>
				</a>
				<a class="col-xs-3 <?= ($psl == "pop")? 'active' : ''; ?>" href="<?= Url::current(['psl' => 'pop']); ?>">
					<div class="gSquare" ><?= $model->popRating ?></div>
					<span style="margin-top: 3px; display: block;">Populiarumą</span>
				</a>
				<a class="col-xs-3 <?= ($psl == "forum")? 'active' : ''; ?>" href="<?= Url::current(['psl' => 'forum']); ?>">
					<div class="gSquare"><?= $model->forumRating ?></div>
					<span style="margin-top: 3px; display: block;">Forumą</span>
				</a>
    		
    		</div>
    		<div class="col-xs-5">
    			<div class="frame" style="margin-top: 8px;">
					<?= $this->render('statistika/_overall', ['models' => $overall, 'rating' => $model->{$psl.'Rating'}]); ?>

    			</div>
    		</div>
    	</div>

    	<script type="text/javascript">
    		var items = 4,
    			width = ($('#pickerHolder').width() / 5) - 20;
    		$('.gSquare').css({
    			'width' : width + "px",
    			'height' : width + "px",
    			'padding-top' : (width - 38) / 2 + "px",
    		});
    	</script>

    	<hr style="margin-left: -15px; margin-right: -15px;">
    	
    	<?php if($psl): ?>
    		<?= $this->render('statistika/'.$psl, ['dataProvider' => $dataProvider, 'model' => $model]); ?>
    	<?php endif; ?>


    </div>
</div>


<script type="text/javascript">
	$('.hKvadratas').each(function(){
		var p = $(this).parent();

		$(this).css({
			'width' : p.height() + 'px',
			'height' :  p.height() + 'px',
			'padding-top' : (p.height() - 38) / 2 + "px",
		});
		console.log(p);
	});
</script>