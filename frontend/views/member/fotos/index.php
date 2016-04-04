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
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\helpers\BaseFileHelper;


$trueId = Yii::$app->user->identity->id;
$thisId = $_GET['id'];
$plimit = (isset($_GET['limit'])? $_GET['limit'] : "10");

$me = User::find()->where(['id' => $trueId])->one();

$user = User::find()->where(['id' => $thisId])->one();
$info = Info::find()->where(['u_id' => $thisId])->one();

$arFavoritas = Favourites::arFavoritas($thisId);


$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
$id = (isset($_GET['id']))? $_GET['id'] : "";
$extra = (isset($_GET['extra']))? $_GET['extra'] : "";

$structure = "uploads/".$id;

if (!is_dir($structure)) {
    BaseFileHelper::createDirectory($structure, $mode = 0777);
}

$arDraugas = \frontend\models\Friends::arDraugas($_GET['id']);
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


    <div class="col-xs-9" >
    	<div class="container" id="atskaita" style="width:100%; background-color: #f9f9f9; min-height: 150px; font-size: 12px; text-align: left; padding: 0;">
            <div class="container rowme" style="width:100%">
                <div class="row">
    		
                    <div class="col-xs-2" id="col1" style="background-color: #ffffff; text-align:center; padding: 10px;">

                        <div class="row">
                            <div class="col-xs-12">
                                <span style="border-bottom: 1px solid #999999; color: #999999;">&nbsp <b>Albumai</b> &nbsp</span>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px; opacity: <?= ($psl == "p")? 1 : 0.6; ?>">
                            <div class="col-xs-12"> 
                                <a href="<?= Url::to(['member/fotos', 'id' => $id, 'psl' => 'p']); ?>">
                                    <div style="border: 1px solid #929292; padding-bottom: 10px; color: #3a3a3a;">
                                        <img src="/css/img/icons/pfoto.png" style="padding: 15px;">
                                        Profilio nuotraukos
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px; opacity: <?= ($psl == "")? 1 : 0.6; ?>">
                            <div class="col-xs-12"> 
                                <a href="<?= Url::to(['member/fotos', 'id' => $id]); ?>">
                                    <div style="border: 1px solid #929292; padding-bottom: 10px; color: #3a3a3a;">
                                        <img src="/css/img/icons/fotoaparatas2.png" style="padding: 15px;">
                                        Privačios nuotraukos
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px; opacity: <?= ($psl == "d")? 1 : 0.6; ?>">
                            <div class="col-xs-12"> 
                                <a href="<?= Url::to(['member/fotos', 'id' => $id, 'psl' => 'd']); ?>">
                                    <div style="border: 1px solid #929292; padding-bottom: 10px; color: #3a3a3a;">
                                        <img src="/css/img/icons/fotoaparatas2.png" style="padding: 15px;">
                                        Atvirutes
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="col-xs-10" id="col2" style="padding: 10px;">

                        <div class="row">
                            <div class="col-xs-11">
                                <span style="border-bottom: 1px solid #999999; color: #999999;">&nbsp <b>Nuotraukos</b> &nbsp</span>
                            </div>

                        </div>

                        <div class="row" style="margin-top: 10px;">

                            <?php if($psl == ""): ?>
                                <div class="col-xs-12">
                                    <?php if($arDraugas !== false): ?>
                                        <?= $this->render('//member/fotos/_fotos', ['extra' => $extra]); ?>
                                    <?php else: ?>
                                            <div class="alert alert-info">
                                                Tik draugai gali matyti šias nuotraukas.
                                            </div>
                                    <?php endif; ?> 
                                </div>
                            <?php elseif($psl == "p"): ?>
                                <div class="col-xs-12">
                                    <?= $this->render('//member/fotos/_fotos', ['dir' => "uploads/".$id."/profile"]); ?>
                                </div>

                            <?php elseif($psl == "d"): ?>
                                <div class="col-xs-12">
                                    <?= $this->render('//member/fotos/_dovanos', ['id' => $id]); ?>
                                </div>
                            <?php endif; ?> 

                            

                        </div>
                    
                    </div>
                    
                </div>
                    
             </div>
        </div>
    </div>

        <script type="text/javascript">
            $(function(){
                $('#col1').css({"height" : $('#atskaita').outerHeight() + "px"});
                $('#col2').css({"height" : $('#atskaita').outerHeight() + "px"});
            }); 

            $('#more').click(function(){
                $('#moreBox').toggle();
            });

            $('#moreBox').mouseleave(function(){
                $('#moreBox').css({"display" : "none"});
            });
        </script>

    </div>
