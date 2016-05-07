<?php
use yii\helpers\Url;
use frontend\models\Info2;
?>

<div class="col-xs-3" id="profile">

        <div class="row" style="background-color: #fff;">
            <img src="<?= \frontend\models\Misc::getAvatar($user); ?>" width="100%"/>

            <?php if(!$user->avatar): ?>
                <div class="uploadHint">
                    <a href="<?= Url::to(['member/myfoto', 'psl' => 'changePPic',]);?>">
                        <img src="/css/img/uploadHint.png">
                    </a>
                </div>
            <?php endif; ?>

            <div class="col-xs-12" style="text-align: center; padding: 5px 0 2px;">
                <span class="ProfName"><?= $user->username;?><?= \frontend\models\Misc::vip($user); ?></span><br>

                <?php 
                    $info = Info2::find()->where(['u_id' => Yii::$app->user->identity->id])->one();

                    if(substr($info->metai, 0, 1) == 'a'){
                        $info->metai = substr($info->metai, 1);
                        $info->save(false);
                    }

                    if($info->diena != '' && $info->menuo != '' && $info->metai != ''){
                        $d1 = new DateTime($info->diena.'.'.$info->menuo.'.'.$info->metai);
                    }else{
                        $d1 = new DateTime();
                    }
                    $d2 = new DateTime();
                    $diff = $d2->diff($d1);
                    require(__DIR__ ."/../../site/form/_list.php");

                    $miestas = ($info->miestas !== '')? $list[$info->miestas] : 'nenustatyta';
                ?>
                <span class="ProfInfo" style="color: #5b5b5b; position: relative; top: -3px;"><?= $diff->y; ?> metai, <?= $miestas ?></span>

            </div>
        </div>


        <div class="row" style="margin-top: 10px; min-height: 25px;" id="zodisRow">
            <div id="regIco" style="position: absolute; z-index: 1; left: 0; padding: 0; margin: 0; text-align: right;">
                <a href="<?= Url::to(['member/zodis']); ?>" class="glyphicon glyphicon-pencil" style="display: none; position: relative; left: 5px;border: 1px solid grey; border-radius: 2px; padding: 2px;"></a>
            </div>

            <div class="col-xs-12" style="font-style: italic;" id="zodis">
                &nbsp&nbsp&nbsp&nbsp&nbsp
                <?= ($info->zodis)? $info->zodis: '<span style="color: grey;">Žodis apie mane</span>'; ?>
            </div>
        </div>


        <?php
            if($user->expires > time() + 60 * 60 * 24 * 7){
                $good = "Abonimentas galioja iki: ".date('o-m-d G:i', $user->expires);
            }else{
                $good = "<span style='color: #a94442; font-size: 15px;'>Abonimentas galioja iki: ".date('o-m-d G:i', $user->expires)."</span>";
            }
            $data = ($user->expires > time())? $good: "<span style='color: #a94442; font-size: 15px;'>Abonimento galiojimas baigėsi</span>";
        ?>

        <div class="row" style="margin-top: 20px;">
            <div class="col-xs-12" style="font-size: 12px; color: grey; text-align: center;">
                <?= $data; ?><br> 
                <a href="<?= Url::current(['pratesti' => 1]); ?>" class="btn btn-reg" style="font-size: 14px; padding: 0 20px; border-radius: 0;">Pratęsti</a>
            </div>
        </div>

        <?php //$this->render('//events/kaledos/zaisliukas'); //Kaledine dekoracija?>

</div>

<script type="text/javascript">
    $('#zodis').mouseover(function(){
        $('#regIco a').fadeIn();
    });

    $('#zodisRow').mouseleave(function(){
        $('#regIco a').fadeOut();
    });
</script>