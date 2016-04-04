<?php

use yii\helpers\Url;

require(__DIR__ ."/../site/form/_list.php");

$id = ($model->u1 == Yii::$app->user->id)? $model->u2 : $model->u1;

$user = \frontend\models\UserPack::find()->where(['id' => $id])->one();

$dataInfo = $user->info;

$d1 = new DateTime($dataInfo['diena'].'.'.$dataInfo['menuo'].'.'.$dataInfo['metai']);
$d2 = new DateTime();

$diff = $d2->diff($d1);

$chat = new \frontend\models\Chat;


$new = 0;

foreach ($chat::isNew() as $id) {
    if($id == $user['id']){
        $new = 1;
    }
}

$i = $user['id'];

$timeDiff = time() - $user['lastOnline'];

if($timeDiff <= 600){
    $online = 1;
}else{
    $online = 0;
}

if(isset($current)){
    $opacity = ($user['id'] == $current)? 1 : 0.6 ;
}else{
    $opacity = (isset($_GET['id']) && $user['id'] == $_GET['id'])? 1 : 0.6 ;
}

echo $this->render('_alert', ['model' => 'susirasinejimas', 'id' =>  $user['id'], 'del' => Url::to(['member/deletechat', 'id'=> Yii::$app->user->id, 'id2' => $user['id'], 'who' => 'both'])]);
?>
<div class="row" id="chatterid<?= $user['id']; ?>" style="margin: 0; margin-top: 5px;">   
    <div class="col-xs-6" style="padding: 0;">
        <div style="position: absolute; right: 1px; color: #fffeff;"><span class="glyphicon glyphicon-remove" onclick="trinti(<?= $user['id']; ?>)" id="trinti" style="cursor: pointer; z-index: 1;"></span></div>
        <div class="aavatar2" style="background-color: black; position: relative; opacity: <?= $opacity; ?>" onclick='javascript:window.location.href="<?= Url::to(['member/msg', 'id' => $user['id']])?>"'>
        
            <?php
                if($online):
            ?>
                <img src="/css/img/online.png" title="Prisijungęs" style="position: absolute; z-index: 0; left: 1px; bottom: 1px;">
            <?php endif; ?>
            <img src="<?= \frontend\models\Misc::getAvatar($user); ?>" class="centerMe" id="aaavatar2<?= $i; ?>"/>
        </div>
    </div>
    <div id="infoPart<?= $user['id']; ?>" class="col-xs-6 infoPart" style="text-align: left; padding: 15px 5px 0 3px;position: relative; <?= ($new)?  'border-top : 2px solid #94c500; border-right : 2px solid #94c500; border-bottom : 2px solid #94c500;' : ''; ?> ">

        <span class="ProfName" style="font-size: 13px; opacity: <?= $opacity; ?>"><?= $user->username; ?><?= \frontend\models\Misc::vip($user); ?></span><br>

        <span class="ProfInfo" style="font-size: 11px; position: relative; opacity: <?= $opacity; ?>"><?= $diff->y; ?>, <?= ($dataInfo['miestas'] !== '')? $list[$dataInfo['miestas']] : "Nenurodyta"; ?></span>

    </div>
</div>

<?php $src = \frontend\models\Misc::getAvatarADP($model); ?>

<script type="text/javascript">
    function trinti(id){
        $('#myAlert'+id).prependTo($('body'));
        $('#myAlert'+id).css({'display' : "block"})
    };

    var id = '<?= $i; ?>';

    $("#aavatar2"+id).attr('src','');
    $("#aavatar2"+id).attr('src',"<?= $src; ?>");

    $(function ()
    {
        $('.aavatar2').css({"height" : $('.aavatar2').width() + "px"});
    });

    $(".aavatar2 img.centerMe").fakecrop({wrapperWidth: $('.aavatar2').width(),wrapperHeight: $('.aavatar2').width()});
    

</script>