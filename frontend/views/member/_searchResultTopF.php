<?php
use frontend\models\filterFileName;
use yii\db\Query;
use yii\helpers\Url;


$name = filterFileName::nameExtraction($model['photo_name']);

$thumbnailFile = "BTh".$name['pure']."Eth".$name['lastChar'];

$directory = ['uploads/'.$name['ownerId'].'/' , 'uploads/'.$name['ownerId'].'/profile/'];

if(file_exists($directory[0].$thumbnailFile)){
	$dir = 0;
}elseif(file_exists($directory[1].$thumbnailFile)){
	$dir = 1;
}

if(isset($dir)):


if(isset(Yii::$app->params['close'])){
    Yii::$app->params['close']++;
}

?>
<div class="col-xs-2" style="padding: 5px 5px;">
    
    <div id="holder" style="background-color: #fff; width:100%;">
        
        <a href="<?= Url::to(['member/search', 'ft' => 'showFoto', 'd' => '/'.$directory[$dir], 'psl' => 'topF', 'id' => $name['ownerId'], 'n' => $model['photo_name']]); ?>" >
            
            <div id="a<?= $model['id']; ?>" class="recentImgHolder">
                <?php if($model['photo_name']): ?>
                   <img class="cntrm" id="imga<?= $model['id']; ?>" src="/<?= $directory[$dir].$thumbnailFile; ?>" width="100%" />
                <?php else: ?>
                    <img class="cntrm" id="imga<?= $model['id']; ?>" src="/css/img/icons/no_avatar.png" width="100%" />
                <?php endif; ?>
            </div>

            <div class="col-xs-12" style="text-align: center; padding: 0px 2px;background-color: #fff;">
                <?php 
                    $timeDiff = time() - $model['lastOnline'];

                    $d1 = new DateTime();
                    $d1 = $d1->setTimestamp($model['gimimoTS']);
                    $d2 = new DateTime();
                    $diff = $d2->diff($d1);

                    require(__DIR__ ."/../site/form/_list.php");


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

                <span class="ProfInfo" style="color: #5b5b5b; font-size: 11px; position: relative; top: -3px;"><?= $diff->y ?>, <?= (isset($model['miestas']) && $model['miestas'] !== '')? $list[$model['miestas']] : 'nenustatyta'; ?></span>
            </div>
        
        </a>

    </div>

</div>

<script src="/js/centerInBox.js"></script>

<script type="text/javascript">

    function fixAv(id){

        $('#a'+id).css({"height" :  $('#holder').width() + "px"});

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


<?php endif; ?>
