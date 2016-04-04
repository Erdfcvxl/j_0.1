<?php

use yii\helpers\Url;

require(__DIR__ ."/../../site/form/_list.php");

$user = \frontend\models\User::find()->where(['id' => $model->id])->one();

$dataInfo = \frontend\models\Info2::find()->where(['u_id' => $model->id])->one();

$d1 = new DateTime($dataInfo['diena'].'.'.$dataInfo['menuo'].'.'.$dataInfo['metai']);
$d2 = new DateTime();

$diff = $d2->diff($d1);

if(isset(Yii::$app->params['close'])){
    Yii::$app->params['close']++;
}


?>
<div class="col-xs-3" style="padding: 5px;">
	<div id="holder" style="background-color: #fff; width:100%;">
	    <a href="<?= Url::to(['member/user', 'id' => $user->id])?>" >
	        <div id="a<?= $user->id; ?>" class="recentImgHolder">
                <?php if($user->avatar): ?>
	               <img id="imga<?= $user->id; ?>" src="/uploads/531B<?= $user->id; ?>Iav.<?= $user->avatar; ?>" width="100%" />
	            <?php else: ?>
                    <img id="imga<?= $user->id; ?>" src="/css/img/icons/no_avatar.png" width="100%" />
                <?php endif; ?>
            </div>
            <div class="col-xs-12" style="text-align: center; padding: 0px 2px;background-color: #fff;">
                <span class="ProfName" style="font-size: 13px;"><?= $user->username; ?><?= \frontend\models\Misc::vip($user); ?></span><br>

                <span class="ProfInfo" style="color: #5b5b5b; font-size: 11px; position: relative; top: -3px;"><?= $diff->y; ?>, <?= ($dataInfo['miestas'] !== '')? $list[$dataInfo['miestas']] : "Nenurodyta"; ?></span>

            </div>
	    </a>
	</div>
</div>

<script src="/js/centerInBox.js"></script>

<?php //$this->registerJs($this->render('script.js')); ?>

<script type="text/javascript">

    function fixAv(id){

        $('#a'+id).css({"height" :  $('#holder').width() + "px"});

        var holderBoreder = $('#holder').width();

        console.log(id);

        if($('#imga'+id).height() < $('#imga'+id).width()){
            $('#imga'+id).attr("width","auto").attr("height","100%");
        }

        centerInBox($('#a'+id).width(), $('#a'+id).height(), $('#imga'+id).width(), $('#imga'+id).height(), '#imga'+id);
        
    };

    var id = '<?= $user->id; ?>';


    $('#imga<?= $user->id; ?>').one("load", function() {
      fixAv('<?= $user->id; ?>');
    }).each(function() {
      if(this.complete) $(this).load();
    });
    
    
</script>

<?php if(isset(Yii::$app->params['close']) && Yii::$app->params['close'] > 3): Yii::$app->params['close'] = 0; ?>

    </div>
    <div class="row" style="padding-left: 15px; padding-right: 15px;">

<?php endif; ?>

