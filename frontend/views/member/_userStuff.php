<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use common\models\User;
use frontend\models\Info;
use frontend\models\Chat;
use yii\db\Query;
use yii\helpers\Url;
use frontend\models\Ago;
use frontend\models\Favourites;


$trueId = Yii::$app->user->identity->id;
$thisId = $_GET['id'];
$plimit = (isset($_GET['limit'])? $_GET['limit'] : "10");

$me = User::find()->where(['id' => $trueId])->one();

$user = User::find()->where(['id' => $thisId])->one();
$info = Info::find()->where(['u_id' => $thisId])->one();

$arFavoritas = Favourites::arFavoritas($thisId);

?>

<div class="row" style="margin-top: 5px; padding-bottom: 70px;">
    <div class="col-xs-3" style="background-color: #d1d1d1; ">
    
        <div class="row">

            <div style="position: relative;">
            	<?php if($user->avatar == ""): ?>
                    <img src="/css/img/icons/no_avatar.png" width="100%" />

                <?php else: ?>
                        <img src="/uploads/531B<?= $user->id; ?>Iav.<?= $user->avatar; ?>" width="100%" />
                <?php endif ?>
                <?php 
                    $timeDiff = time() - $user->lastOnline;

                    if($timeDiff <= 600){
                        $online = 1;
                    }else{
                        $online = 0;
                    }
                    if($online):
                ?>
                    <img src="/css/img/online.png" title="Prisijungęs" style="position: absolute; z-index: 1; margin-top: -14px; margin-left: 1px; left: 0; bottom: 1px;">
                <?php endif; ?>
            </div>

            <div class="col-xs-12" style="text-align: center; padding: 5px 0 2px; background-color: #fff;">
                <span class="ProfName"><?= $user->username;?></span><br>

                <?php 
                    $info = Info::find()->where(['u_id' => Yii::$app->user->identity->id])->one(); 

                    $d1 = new DateTime($info->diena.'.'.$info->menuo.'.'.$info->metai);
                    $d2 = new DateTime();

                    $diff = $d2->diff($d1);

                    require(__DIR__ ."/../../site/form/_list.php");
                ?>
                <span class="ProfInfo" style="color: #5b5b5b; position: relative; top: -3px;"><?= $diff->y; ?> metai, <?= $list[$info->miestas]; ?></span>

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
            <div class="col-xs-9"><a href="#" class="btn btn-prof-two">Įteikti dovaną</a></div>        
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


    <div class="col-xs-9" >
    	<div class="container" style="width:100%; background-color: #e8e8e8; min-height: 150px; font-size: 12px; text-align: left; padding: 10px 30px;">
    		
    </div>
</div>