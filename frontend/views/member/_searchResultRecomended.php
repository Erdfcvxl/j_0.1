<?php

use yii\db\Query;
use yii\helpers\Url;

require(__DIR__ ."/../site/form/_list.php");

$atitikimai = new frontend\models\Atitikimai;

$keys = array_keys($atitikimai->main($model));

$query = new Query;

$query->select('u_id, diena, menuo, metai, miestas')
->where(['u_id'=>$model->id])
->from('info');
$command = $query->createCommand();
$dataInfo = $command->queryOne();  

?>

<?php

$d1 = new DateTime($dataInfo['diena'].'.'.$dataInfo['menuo'].'.'.$dataInfo['metai']);
$d2 = new DateTime();

$diff = $d2->diff($d1);
//var_dump($model);
/* 
prie session prideda ++, kai session daugiau negu 6 uzdedi </div><div class="row">. Kitas </div> turi buti viduje pacio search failo dalyje.
*/
?>
<div class="col-xs-3" style="padding: 5px 5px;">
    <span class="ProfName" style="font-size: 20px; color: #93c501;"><?= $model->username; ?><?= \frontend\models\Misc::vip($model, '5A7900'); ?></span><br>
    <span class="ProfInfo" style="color: #5b5b5b; font-size: 11px; position: relative; top: -3px;"><?= $diff->y; ?> metai, <?= $list[$dataInfo['miestas']]; ?></span>

	<div id="holder" style="width:100%;">
	    <a href="<?= Url::to(['member/user', 'id' => $model->id])?>" >
	        <div id="a<?= $model->id; ?>" class="recentImgHolder">
	           <img id="imga<?= $model->id; ?>" src="<?= \frontend\models\Misc::getAvatar($user); ?>" width="100%" />
            </div>
	    </a>
        <img class="searchDec" src="/css/img/searchDec.png" width="168px" height="19px">
	</div>

    <div style="background-color: #e1e1e1; padding: 14px 12px; margin-top: -12px;">
        <?php 
            foreach($keys as $atitikmuo){
                echo $atitikmuo."<br>";
            }
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

    var id = '<?= $model->id; ?>';


    $('#imga<?= $model->id; ?>').one("load", function() {
      fixAv('<?= $model->id; ?>');
    }).each(function() {
      if(this.complete) $(this).load();
    });
    
    
</script>

<?php 

if(Yii::$app->params['close'] == 5){
    echo "</div><div class='row'>";
    Yii::$app->params['close'] = 0;
}

Yii::$app->params['close']++;

?>
