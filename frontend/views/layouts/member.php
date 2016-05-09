<?php
/* @var $this yii\web\View */
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\models\User;
use yii\helpers\Url;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

use frontend\models\Chat;
use frontend\models\Forum;

use frontend\models\LikesNot;
use yii\widgets\Pjax;


$user = Yii::$app->user->identity;

$pakvietimaiKiti = \frontend\models\Pakvietimai::find()->where(['reciever' => Yii::$app->user->identity->id])->all();

$newNot = count($pakvietimaiKiti) + LikesNot::notification();

AppAsset::register($this);
$this->registerJsFile('/js/jquery.fakecrop.js');

$puslapis = $this->context->module->controller->module->requestedAction->id;

$forumas = Forum::find()->where(['u_id' => Yii::$app->user->id])->all();

$forumNew = 0;

$chatNew = \frontend\models\Notifications::countNewMessages(Yii::$app->user->id);

foreach ($forumas as $forumasVienetas) {
    $forumNew = $forumNew + $forumasVienetas->new;
}

$kitas = array('1' => 'search', 'user', 'msg', 'fotos', 'fotosalbumview', 'iesko', 'anketa');

if($puslapis == 'statistika' && isset($_GET['id']))
    $kitas[] = 'statistika';

$urlToComplete = Url::to(['member/backtoreg', 'id' => $user->id, 're' => \frontend\models\Functions::StepsNotCompleted($user), 'ra' => $user->auth_key]);

$notCompleteMsg = '<h4>Jūsų anketa nėra pilnai užpildyta</h4><p>Norėdami baigti pildyti anketa spauskite <b><a href="'.$urlToComplete.'">čia</a></b>.</p>';


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>
    <title>Pažintys lietuviams</title>
    <?php $this->head() ?>

    <script type="text/javascript" src="/js/casual.js"></script>
    <script type="text/javascript" src="/js/hoverAv.js"></script>
    <link href="/css/member.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="favicon.ico">
</head>
<body>
    
    <script type="text/javascript">var puslapis = '<?= $puslapis ?>'; </script>

    <?php $this->beginBody() ?>
    <div class="wrap">

        <?php if(isset($_GET['ft']) && $_GET['ft'] == "showFoto"): ?>

            <div class="curtains" id="curtains"></div>
        
            <div id="overflow" style="overflow: hidden;">
                <div class="photobox" id="photobox">

                    <?php Pjax::begin();?>
                        <?= $this->render('//member/fotoBox', ['user' => $user]); ?>
                    <?php Pjax::end(); ?>

                </div>
            </div>

        <?php endif; ?>

        <?php if(isset($_GET['mta']) && $_GET['mta'] == "1"): ?>
            <?= $this->render('//member/myfoto/_mva'); ?>

        <?php elseif(isset($_GET['psl']) && $_GET['psl'] == "limit"): ?>
            <div class="curtains" id="curtains"></div>

        <?php elseif(isset($_GET['pratesti']) && $_GET['pratesti'] == "1"): ?>
            <div class="curtains" id="curtains"></div>
            <?= $this->render('//member/_pratesti'); ?>

        <?php elseif(isset($_GET['dovana'])): ?>
            <div class="curtains" id="curtains"></div>
            <?= $this->render('//member/_dovana', ['id' => $_GET['id']]); ?>

        <?php elseif(isset($_GET['dopen'])): ?>
            <div class="curtains" id="curtains"></div>
            <?= $this->render('//member/_dopen', ['id' => $_GET['dopen']]); ?>

        <?php elseif(isset($_GET['success']) && $puslapis == "executepayment"): ?>
            <div class="curtains" id="curtains"></div>

        <?php elseif(isset($_GET['expired'])): ?>

            <div class="curtains" id="curtains"></div>
            <?= $this->render('//member/_expired'); ?>

        <?php elseif(isset($_GET['issite'])): ?>

            <?php if(($user->expires - time()) <= 60 * 60 * 24 ): ?>
                <div id="delayMe" style="display: none">
                    <div class="curtains" id="curtains"></div>

                    <?= $this->render('//member/_expired', ['psl' => 'expiresIn']); ?>
                </div>
                <script type="text/javascript"> 
                    setTimeout(function(){
                        $('#delayMe').css({"display" : "block"});
                    }, 4000);
                    
                </script>
            <?php endif; ?>

        <?php elseif(isset($_GET['eventpresent'])): ?>
            <div class="curtains" id="curtains"></div>
            <?= $this->render('//member/eventpresent', ['user' => $user]); ?>

        <?php endif; ?>

        <?php if(isset($_GET['extra']) && $_GET['extra'] == "del"): ?>
            <div id="myAlert" class="myAlert" style="z-index: 100; margin-top: -200px;">
                <div class="container-fluid" >

                    <div id="xas" style="position: absolute; right: 1px; top: 1px; color: #A8A8A8; cursor: pointer;" class="glyphicon glyphicon-remove"></div>


                    <div class="row" style="margin-bottom: 15px;">

                        <div class="col-xs-12">
                            <b>Ar tikrai norite ištrinti nuotrauką?</b>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xs-3 col-xs-offset-2 mygtukas" id="confirm" style="cursor: pointer;">Taip</div>
                        <div class="col-xs-3 col-xs-offset-2 mygtukas" id="decline" style="cursor: pointer;">Ne</div>
                    </div>

                </div>
            </div>
        <?php endif; ?>

        <div class="header">
            <?php if($user->f){ echo $this->render('//layouts/includes/toAdmin'); } ?>

            <div class="container">
                <div class="row">
                    <!-- <div class="col-xs-3" style="text-align: center; margin-top: 5px;">
                        <img src="/../web/css/img/icons/logo.png" style="margin: 0 auto;" width="35px" alt="Pažintys lietuviams Anglijoje" title="Pažintys lietuviams Anglijoje"/>
              
                        <h4 class="title" style="color:#94c500; font-size: 12px; margin-top: 3px;">PAŽINTYS <span class="title_bold">LIETUVIAMS.co.uk</span></h4>
                    </div> -->
                    <div class="col-xs-3" style="text-align: center; margin-top: 15px;">
                        <div class="row">
                            <div class="col-xs-2">
                                <!-- <div class="Ldeco"><img src="/css/img/santaHat.png"></div> -->
                                <img src="/css/img/icons/logo3.png" height="30px">
                            </div>
                            <div class="col-xs-9" style="padding: 5px 0 0 5px;"><span style="color: #94c500; font-size: 15px;"><b>Pažintyslietuviams.co.uk</b></span></div>
                        </div>
                    </div>
                    <div class="col-xs-9" >

                        <?= $this->render('includes/GmenuBar', [
                            'puslapis' => $puslapis,
                            'newNot' => $newNot,
                            'chatNew' => $chatNew,
                            'user' => $user,
                            'forumNew' => $forumNew
                        ]); ?>

                    </div>
                </div>
            </div> 
        </div>




        <?php //$this->render('//events/dekoCh'); // Kaledine dekoracija ?>

        <div class="container">
            <div class="row" style="margin-top: 20px; <?= (array_search($puslapis , $kitas))? '' : 'padding-bottom: 70px;'; ?>">

                <?php if(array_search($puslapis , $kitas)): ?>

                    <?= $this->render('includes/avatarHolderMini.php', ['user' => $user]); ?>

                <?php else: ?>

                    <?= $this->render('includes/avatarHolder.php', ['user' => $user]); ?>

                <?php endif ?>


                <div class="col-xs-9" >
                    <div class="container" style="width:100%; min-height: 70px; font-size: 12px; text-align: center;">
                        
                        <?php 
                        if($puslapis == "search"){
                            echo $this->render('menubar/_search.php', ['puslapis' => $puslapis]);
                        }elseif($puslapis == "msg"){
                            echo $this->render('menubar/_msg.php', ['puslapis' => $puslapis]);
                        }elseif($puslapis == "friends"){
                            echo $this->render('menubar/_friends.php', ['puslapis' => $puslapis]);
                        }elseif($puslapis == "favs"){
                            echo $this->render('menubar/_favs.php', ['puslapis' => $puslapis]);
                        }elseif($puslapis == "date"){
                            echo $this->render('menubar/_date.php', ['puslapis' => $puslapis]);
                        }elseif($puslapis == "settings" || $puslapis == "help" || $puslapis == "duk"){
                            echo $this->render('menubar/_settings.php', ['puslapis' => $puslapis]);
                        }elseif($puslapis == "user" || $puslapis == "fotos" || $puslapis == "fotosalbumview" || $puslapis == "iesko" || $puslapis == "anketa"){
                            echo $this->render('menubar/_user.php', ['puslapis' => $puslapis]);
                        }elseif($puslapis == "forum" || $puslapis == "post" || $puslapis == "forumnewru" || $puslapis == "forumats"){
                            echo $this->render('menubar/_forum.php', ['puslapis' => $puslapis]);
                        }else{
                            echo $this->render('menubar/_else.php', ['puslapis' => $puslapis]);
                        }
                        ?>



                                            
                        <?php if(!array_search($puslapis , $kitas)): ?>

                            <div class="row" style="margin-top: 5px;">

                                <?= $this->render('//member/index/progress'); ?>


                                <?php /*if(\frontend\models\Functions::StepsNotCompleted($user) !== false): */?><!--
                                    <div class="alert alert-info" style="text-align: left; margin-bottom: 0;" ><?/*= $notCompleteMsg; */?></div>
                                --><?php /*endif; */?>

                                <?= $content ?>
                             </div>

                        <?php endif ?>

                    </div>
                </div>

            </div>


            <?php if(array_search($puslapis , $kitas)): ?>


                <div id="ats">
                    <?= $content ?>
                </div>
                

            <?php endif ?>
        </div>

    <footer class="footerMine">
        <div class="container">
            <div class="row">
                <div class="col-sm-4" style="font-size: 12px; color: #126e9f">
                    <table>
                        <tr>
                            <td width="80px;"><p style="font-size: 12px; color: #126e9f">Privatumas</p></td>
                            <td><p style="font-size: 12px; color: #126e9f">Rekomenduok draugams</p></td>
                        </tr>
                        <tr>
                            <td><p style="font-size: 12px; color: #126e9f">Straipsniai</p></td>
                            <td><p style="font-size: 12px; color: #126e9f"><a href="mailto:pazintys@pazintyslietuviams.co.uk" target="_top">Kontaktai</a></p></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-8" style="color: #636363;">
                    <div class="row">
                        <div class="col-xs-12" style="text-align: right">
                            <span style="font-size: 18px;"><B>&copy; Pazintyslietuviams.co.uk <?= date('Y') ?></b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" style="text-align: right;font-size: 12px;">
                            <p>Pazintys Anglijoje &nbsp&nbsp&nbsp&nbsp Pazintys Airijoje &nbsp&nbsp&nbsp&nbsp Pazintys Londone &nbsp&nbsp&nbsp&nbsp Pazintys UK &nbsp&nbsp&nbsp&nbsp Nemokamos pažintys Anglijoje.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
        


    </div>

    <?php if(Yii::$app->user->id == 3587): ?>

        <button onclick="myFunction()">Try it</button>
        <script>
        function myFunction() {
            confirm("Press a button!");
        }
    </script>
        

    <?php endif; ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<?php

if($user->avatar){

    if(!file_exists('uploads/531B'.$user->id."Iav.".$user->avatar)){

        $user->avatar = "";
        $user->save(false);

    }
}

?>
