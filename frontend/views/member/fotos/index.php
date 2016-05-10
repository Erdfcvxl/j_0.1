<?php

use common\models\User;
use frontend\models\Info;
use frontend\models\Favourites;
use yii\helpers\Url;
use yii\helpers\BaseFileHelper;
use frontend\models\getPhotoList;



$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
$thisId = (isset($_GET['id']))? $_GET['id'] : "";
$extra = (isset($_GET['extra']))? $_GET['extra'] : "";
$trueId = Yii::$app->user->identity->id;
$plimit = (isset($_GET['limit'])? $_GET['limit'] : "10");



$me = User::find()->where(['id' => $trueId])->one();

$user = User::find()->where(['id' => $thisId])->one();
$info = Info::find()->where(['u_id' => $thisId])->one();

$arFavoritas = Favourites::arFavoritas($thisId);

$structure = "uploads/".$user->id;

if (!is_dir($structure)) {
    BaseFileHelper::createDirectory($structure, $mode = 0777);
}

getPhotoList::fixProfileDir($thisId);



$photos = \yii\helpers\BaseFileHelper::findFiles("uploads/".$user->id."/");
$count = count($photos) / 2;

?>

<div class="row" style="margin-top: 5px; padding-bottom: 70px;">
    <div class="col-xs-3" style="background-color: #d1d1d1; ">

        <div class="row">

            <div style="position: relative;">
            	<img src="<?= \frontend\models\Misc::getAvatar($user); ?>" width="100%" />
                <?php
                    $timeDiff = time() - $user->lastOnline;

                    if($timeDiff <= 600){
                        $online = 1;
                    }else{
                        $online = 0;
                    }
                    if($online):
                ?>
                    <img src="/css/img/online.png" title="Prisijungęs" style="position: absolute; z-index: 5; margin-top: -14px; margin-left: 1px; left: 0; bottom: 1px;">
                <?php endif; ?>
            </div>

            <div class="col-xs-12" style="text-align: center; padding: 5px 0 2px; background-color: #fff;">
                <span class="ProfName"><?= $user->username;?></span><br>

                <?php
                    $info = Info::find()->where(['u_id' => $thisId])->one();

                    $d1 = new DateTime($info->diena.'.'.$info->menuo.'.'.$info->metai);
                    $d2 = new DateTime();

                    $diff = $d2->diff($d1);

                    require(__DIR__ ."/../../site/form/_list.php");
                ?>
                <span class="ProfInfo" style="color: #5b5b5b; position: relative; top: -3px;"><?= $diff->y; ?> metai, <?= (isset($info->miestas) && $info->miestas !== '')? $list[$info->miestas] : 'nenustatyta'; ?></span>

            </div>
        </div>

   		<br>

        <?php
            $pakvietimai = \frontend\models\Pakvietimai::find()->where(['sender' => Yii::$app->user->identity->id, 'reciever' => $_GET['id']])->one();
            $pakvietimai2 = \frontend\models\Pakvietimai::find()->where(['sender' => $_GET['id'], 'reciever' => Yii::$app->user->identity->id])->one();

            $arDraugas = \frontend\models\Friends::arDraugas($thisId);
        ?>

        <div class="row">
            <div class="col-xs-8">
                <?php if($arDraugas !== false):?>
                    <div class="btn btn-reg disabled">Draugai</div>
                <?php elseif($pakvietimai2): ?>
                    <a href="<?= Url::to(['member/acceptinvitation', 'id' => $_GET['id']]); ?>" class="btn btn-reg" style="width: 100%; line-height: 16px; font-size: 18px; font-family: OpenSansSemibold">Priimti<br>pakvietimą</a>
                <?php else: ?>
                    <a href="<?= Url::to(['member/addtofriends', 'id' => $_GET['id']]); ?>" class="btn btn-reg <?= ($pakvietimai)? 'disabled' : '' ?>" style="width: 100%; line-height: 16px; font-size: 18px; font-family: OpenSansSemibold"><?= ($pakvietimai)? 'Kvietimas<br>išsiųstas' : 'Pridėti prie <br>draugų' ?></a>
                <?php endif; ?>
            </div>
            <div class="col-xs-4" style="text-align: center; padding-left: 0;"><a href="#"><img src="/css/img/mirkteleti.png"><br><span style="font-size: 12px;">Mirktelėti</span></a></div>
        </div>

        <div class="row">
            <div class="col-xs-3" style="text-align: center; padding-right: 0;"><img src="/css/img/dovana.png"></div>
            <div class="col-xs-9"><a href="<?= Url::canonical()."&dovana=1&id=".$_GET['id'] ?>" class="btn btn-prof-two">Įteikti dovaną</a></div>
        </div>

        <div class="row">
            <div class="col-xs-3" style="text-align: center; padding-right: 0;"><img src="/css/img/sirdele.png"></div>
            <div class="col-xs-9"><a href="<?= URL::to(['member/addtofavs', 'id' => $_GET['id']]); ?>" class="btn btn-prof-two <?= ($arFavoritas)? 'disabled' : ''; ?>"><?= ($arFavoritas)? 'Mėgstamas' : 'Pridėti prie mėgstamų'; ?></a></div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="leftcorner">
                	<a href="#">Blokuoti naudotoją</a><br>
                	<a href="#">Pranešti apie profilį</a>
                </div>
            </div>
        </div>

    </div>


    <div class="col-xs-9" style=" min-height: 150px; font-size: 12px; text-align: left; margin-top: -1px;">
        <div class="col-xs-12" style="background-color: #f9f9f9;  padding: 15px;">
            <?= $this->render('_fotos', ['photos' => $photos]); ?>
            <?php if(!isset(Yii::$app->params['photoOK'])): ?>
                <div class="alert alert-warning">Nuotraukų nėra arba jos skirtos tik draugams.</div>
            <?php endif;?>
        </div>
    </div>

    <script type="text/javascript">
        $(".cntrm").fakecrop({wrapperWidth: 222.5,wrapperHeight: 222, center: true });

    </script>

</div>


