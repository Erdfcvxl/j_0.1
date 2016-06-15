<?php

use yii\db\Query;
use yii\helpers\Url;

//var_dump($model['lastOnline']);

include('../views/site/form/_list.php');

if ($model->info['diena'] != NULL && $model->info['menuo'] != NULL && $model->info['metai'] != NULL)
{
    $d1 = new DateTime($model->info['diena'] . '.' . $model->info['menuo'] . '.' . $model->info['metai']);
    $d2 = new DateTime();

    $diff = $d2->diff($d1);
}

?>

<div class="col-xs-3" style="padding: 5px 5px;">
    <span class="ProfName" style="font-size: 20px; color: #93c501;"><?= $model['username']; ?><?= \frontend\models\Misc::vip($model, '5A7900'); ?></span><br>
    <span class="ProfInfo" style="color: #5b5b5b; font-size: 11px; position: relative; top: -3px;"><?= ($model->info['diena'] != NULL && $model->info['menuo'] != NULL && $model->info['metai'] != NULL) ? $diff->y . ' m., ' : ""; ?><?= ($model->info->miestas != NULL)? $list[$model->info->miestas] : "nenurodyta"; ?></span>

	<div id="holder" style="width:100%;">
	    <a href="<?= Url::to(['member/user', 'id' => $model['id']])?>" >
	        <div id="a<?= $model['id']; ?>" class="recentImgHolder">
                <img id="imga<?= $model['id']; ?>" src="<?= \frontend\models\Misc::getAvatarADP($model); ?>" width="100%" />
            </div>
	    </a>    <?php 
        $timeDiff = time() - $model['lastOnline'];

        if($timeDiff <= 600){
            $online = 1;
        }else{
            $online = 0;
        }
        if($online):
    ?>
        <img src="/css/img/online.png" title="Prisijungęs" style="position: absolute; z-index: 1; margin-top: -14px; left: 5px; margin-left: 1px;">
    <?php endif; ?>
        <img class="searchDec" src="/css/img/searchDec.png" width="168px" height="19px">
	</div>

    <div style="background-color: #e1e1e1; padding: 14px 12px; margin-top: -12px;">
        <?php
        echo $statusas[$model->info->statusas] . "<br>";
        echo 'Tikslas: ' . $tikslas[$model->info->tikslas] . "<br>";
//            foreach($model['aititikimai'] as $atitikmuo){
//                echo $atitikmuo."<br>";
//            }
        ?>
        <?php //var_dump($atitikimai->main($model)); ?>
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

    var id = '<?= $model["id"]; ?>';


    $('#imga<?= $model["id"]; ?>').one("load", function() {
      fixAv('<?= $model["id"]; ?>');
    }).each(function() {
      if(this.complete) $(this).load();
    });
    
    
</script>

<?php 

if(Yii::$app->params['close'] == 3){
    echo "</div><div class='row'>";
    Yii::$app->params['close'] = -1;
}

//echo Yii::$app->params['close'];

Yii::$app->params['close']++;

?>
