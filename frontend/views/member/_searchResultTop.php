<?php

use yii\db\Query;
use yii\helpers\Url;

require(__DIR__ ."/../site/form/_list.php");


/* 
prie session prideda ++, kai session daugiau negu 6 uzdedi </div><div class="row">. Kitas </div> turi buti viduje pacio search failo dalyje.
*/

if(isset(Yii::$app->params['close'])){
    Yii::$app->params['close']++;
}

?>
<div class="col-xs-2" style="padding: 5px 5px;">
	<div id="holder" style="background-color: #fff; width:100%;">
	    <a href="<?= Url::to(['member/user', 'id' => $model['id']])?>" >
	        <div id="a<?= $model['id']; ?>" class="recentImgHolder">
                <img id="imga<?= $model['id']; ?>" src="<?= \frontend\models\Misc::getAvatarADP($model); ?>" width="100%" />
            </div>
	        <div class="col-xs-12" style="text-align: center; padding: 0px 2px;background-color: #fff;">
                <?php 
                    $timeDiff = time() - $model['lastOnline'];

                    if($timeDiff <= 600){
                        $online = 1;
                    }else{
                        $online = 0;
                    }
                    if($online):
                ?>
                    <img src="/css/img/online.png" title="Prisijungęs" style="position: absolute; z-index: 1; margin-top: -14px; left: 0; margin-left: 1px;">
                <?php endif; ?>
	            <span class="ProfName" style="font-size: 13px;"><?= $model['username']; ?><?= \frontend\models\Misc::vip($model); ?></span><br>

	            <span class="ProfInfo" style="color: #5b5b5b; font-size: 11px; position: relative; top: -3px;"><?=  $model['metai'] ?>, <?= $model['miestas']; ?></span>

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

        if($('#imga'+id).height() < $('#imga'+id).width()){
            $('#imga'+id).attr("width","auto").attr("height","100%");
        }

        centerInBox($('#a'+id).width(), $('#a'+id).height(), $('#imga'+id).width(), $('#imga'+id).height(), '#imga'+id);
        
    };

    var id = '<?= $model['id']; ?>';


    $('#imga<?= $model['id']; ?>').one("load", function() {
      fixAv('<?= $model['id']; ?>');
    }).each(function() {
      if(this.complete) $(this).load();
    });
    
    
</script>

<?php if(isset(Yii::$app->params['close']) && Yii::$app->params['close'] > 5): Yii::$app->params['close'] = 0; ?>

    </div>
    <div class="row" style="padding-left: 15px; padding-right: 15px;">

<?php endif; ?>


