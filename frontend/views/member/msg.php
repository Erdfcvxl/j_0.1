<?php

use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use frontend\models\Chat;
use frontend\models\User;
use frontend\models\UserPack;
use frontend\models\UserSearch;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use frontend\models\Info2;
use frontend\models\Favourites;
use frontend\models\Ago;
use frontend\models\AdminChat;

//use frontend\models\Expired;

//if(Expired::prevent()){ return Yii::$app->getResponse()->redirect( Url::home() ); }



$trueId = Yii::$app->user->identity->id;
$thisId = (isset($_GET['id']))? $_GET['id'] : "";
$additional = (isset($_GET['additional']))? $_GET['additional'] : "";
$me = Yii::$app->user->identity;

$urlToComplete = Url::to(['member/backtoreg', 'id' => $me->id, 're' => \frontend\models\Functions::StepsNotCompleted($me), 'ra' => $me->auth_key]);
$notCompleteMsg = '<h4>Jūsų anketa nėra pilnai užpildyta</h4><p>Norėdami baigti pildyti anketa spauskite <b><a href="'.$urlToComplete.'">čia</a></b>.</p>';

$AllSearch = new UserSearch();
$adchats = AdminChat::find()->where(['u_id' => Yii::$app->user->id])->all();

if(!$thisId){

   $chat = new Chat;
   $lasChat = $chat::find()->where(['or', 'sender ='. $trueId, 'reciever ='. $trueId])->orderBy(['timestamp'=>SORT_DESC])->one();

    if($lasChat){
        $thisId = ($lasChat->sender == $trueId)? $lasChat->reciever : $lasChat->sender;
        $_GET['id'] = $thisId;
    }else{
        $thisId = 'nera';
        $_GET['id'] = $thisId;

    }
}


if($thisId != "nera"):

if(!$user)
    $user = UserPack::find()->where(['id' => $_GET['id']])->one();





$arFavoritas = Favourites::arFavoritas($thisId);

$opacity = ($thisId == 'admin')? 1 : 0.7;

?>



<div class="container-fluid" style="padding: 0; font-size: 12px; ">

    <div class="row" >
        <div class="col-xs-3" style="background-color: #D1D1D1;">

            <a href="<?= Url::to(['member/user', 'id'=>$thisId]); ?>">
                <div class="row" style="margin-top: -25px;">
                    <div style="position: relative;">
                        <?php if($thisId == 'admin'): ?>
                            <img src="/css/img/adav.jpg" width="100%" />
                        <?php else: ?>
                                <img src="<?= \frontend\models\Misc::getAvatar($user); ?>" width="100%" />
                        <?php endif ?>
                        <?php
                            if($thisId != 'admin'):
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
                        <?php endif; ?>
                    </div>

                    <div class="col-xs-12" style="text-align: center; padding: 5px 0 2px; background-color: #fff;">
                        <span class="ProfName"><?= ($thisId == 'admin')? 'Administratorius' : $user->username;?><?= \frontend\models\Misc::vip($user); ?></span><br>

                        <?php
                            if($thisId != 'admin'):
                                $Info2 = $user->info;

                                $d1 = new DateTime($Info2->diena.'.'.$Info2->menuo.'.'.$Info2->metai);
                                $d2 = new DateTime();

                                $diff = $d2->diff($d1);

                                require(__DIR__ ."/../site/form/_list.php");
                        ?>
                            <span class="ProfInfo2" style="color: #5b5b5b; position: relative; top: -3px;"><?= $diff->y; ?> metai, <?= ($Info2->miestas)? $list[$Info2->miestas] : ''; ?></span>
                        <?php else: ?>
                            <span class="ProfInfo2" style="color: #5b5b5b; position: relative; top: -3px;">26, London</span>
                        <?php endif; ?>

                    </div>
                </div>
            </a>

            <br>

            <?php
                $arDraugas = \frontend\models\Friends::arDraugas($thisId);

                if($arDraugas === false){
                    $pakvietimai = \frontend\models\Pakvietimai::find()->where(['sender' => Yii::$app->user->identity->id, 'reciever' => $_GET['id']])->orWhere(['sender' => $_GET['id'], 'reciever' => Yii::$app->user->identity->id])->one();
                }
            ?>

            <div class="row">
                <div class="col-xs-8">
                    <?php if($arDraugas !== false):?>
                        <div class="btn btn-reg"><a href="<?= Url::to(['member/unfriend', 'id' => $_GET['id']]); ?>">Nebedraugauti</a></div>
                    <?php elseif($pakvietimai && $pakvietimai->sender == $_GET['id']): ?>
                        <a href="<?= Url::to(['member/acceptinvitation', 'id' => $_GET['id']]); ?>" class="btn btn-reg" style="width: 100%; line-height: 16px; font-size: 18px; font-family: OpenSansSemibold">Priimti<br>pakvietimą</a>
                    <?php else: ?>
                        <a href="<?= Url::to(['member/addtofriends', 'id' => $_GET['id']]); ?>" class="btn btn-reg <?= ($pakvietimai)? 'disabled' : '' ?>" style="width: 100%; line-height: 16px; font-size: 18px; font-family: OpenSansSemibold"><?= ($pakvietimai)? 'Kvietimas<br>išsiųstas' : 'Pridėti prie <br>draugų' ?></a>
                    <?php endif; ?>
                </div>
                <div class="col-xs-4" style="text-align: center; padding-left: 0;"><a href="<?= Url::to(['member/mirkt', 'to' => $thisId]);?>"><img src="/css/img/mirkteleti.png"><br><span style="font-size: 12px;">Mirktelėti</span></a></div>
            </div>

            <div class="row">
                <div class="col-xs-3" style="text-align: center; padding-right: 0;"><img src="/css/img/dovana.png"></div>
                <div class="col-xs-9"><a href="<?= Url::current(['dovana' => 1, 'id' => $_GET['id']]) ?>" class="btn btn-prof-two">Įteikti dovaną</a></div>
            </div>

            <div class="row">
                <div class="col-xs-3" style="text-align: center; padding-right: 0;"><img src="/css/img/sirdele.png"></div>
                <div class="col-xs-9">
                    <?php if($arFavoritas): ?>
                        <a href="<?= URL::to(['member/removefromfavs', 'id' => $_GET['id']]); ?>" class="btn btn-prof-two">Nebemėgti</a>
                    <?php else: ?>
                        <a href="<?= URL::to(['member/addtofavs', 'id' => $_GET['id']]); ?>" class="btn btn-prof-two">Pridėti prie mėgstamų</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="leftcorner">
                        <a href="<?= Url::to(['member/help']); ?>">Blokuoti naudotoją</a><br>
                        <a href="<?= Url::to(['member/help', 'id' => $_GET['id']]); ?>">Pranešti apie profilį</a>
                    </div>
                </div>
            </div>
        </div>


    	<div class="col-xs-9" style="padding: 0px 9px;">

            <div style="margin-top: 7px; padding: 0 1px;">
                <?= $this->render('//member/index/progress'); ?>
            </div>


    		<div class="col-xs-9" id="col1" style="padding: 7px 20px; background-color: #f4f4f4; text-align: left;  margin-bottom: 700px;">

                <?php if(\frontend\models\Functions::StepsNotCompleted($me) !== false): ?>
                    <div class="alert alert-info" style="text-align: left; margin-bottom: 0;" ><?= $notCompleteMsg; ?></div>
                <?php endif; ?>

                <?php $form = ActiveForm::begin();?>
                    <?= $form->field($AllSearch, 'username')->textInput(['id' => 'ajaxSearch', 'class' => 'trans_input', 'style' => 'padding: 0 5px; margin-top: 5px; width: 200px; background-color: #ebebeb;', 'autocomplete' => 'off', 'placeholder' => 'Ieškoti tarp visų narių'])->label(false); ?>
                <?php ActiveForm::end() ?>


                <?php if($additional):?>
                    <?php

                    $select = ['u.id', 'u.username', 'u.avatar', 'u.expires', 'u.lastOnline', 'i.iesko', 'i.diena', 'i.menuo', 'i.metai', 'i.miestas'];

                    $query = new Query;
                    $query->select($select)
                        ->from('user AS u')
                        ->join('LEFT JOIN', 'info AS i', 'u.id = i.u_id')
                        ->where(['not', ['u.id' => Yii::$app->user->id]])
                        ->andWhere(['like', 'u.username', $additional]);



                    $dataProviderExpand = new ActiveDataProvider([
                        'query' => $query,
                        'pagination' => [
                            'pageSize' =>18,
                        ],
                    ]);

                    $dataProviderExpand->sort->attributes['user'] = [
                        'asc' => ['u.lastOnline' => SORT_ASC],
                        'desc' => ['u.lastOnline' => SORT_DESC],
                        'label' => 'lastOnline',
                    ];

                    $dataProviderExpand->sort->defaultOrder = ['user' => SORT_DESC];

                    ?>

                    <?php Yii::$app->params['close'] = 0; ?>

                    <?= ListView::widget( [
                        'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
                        'dataProvider' => $dataProviderExpand,
                        'itemView' => '//member/_searchResultP',
                        'pager' =>[
                            'maxButtonCount'=>0,
                            'nextPageLabel'=>'Kitas &#9658;',
                            'nextPageCssClass' => 'removeStuff',
                            'prevPageLabel'=>'&#9668; Atgal',
                            'prevPageCssClass' => 'removeStuff',
                            'disabledPageCssClass' => 'off',
                        ]

                        ] );
                    ?>



                <?php endif; ?>

                <?php if(Yii::$app->session->hasFlash("success")): ?>
                <div class="row">
                    <div id="alert" class="col-xs-12">
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert"></a>
                            Jūs mirktelėjote akį
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    setTimeout(function(){
                        $('#alert').fadeOut();
                    },3000);
                </script>

                <?php elseif(Yii::$app->session->hasFlash("error")): ?>

                    <div class="row">
                        <div id="alert" class="col-xs-12">
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert"></a>
                                Mirktelti akį galėsite kiek vėliau
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                        setTimeout(function(){
                            $('#alert').fadeOut();
                        },3000);
                    </script>


                <?php endif; ?>

                <?php if($thisId != "admin"): ?>
                    <?= $this->render('chat'); ?>
                <?php else: ?>
                    <?= $this->render('adminChat'); ?>
                <?php endif; ?>


                <script type="text/javascript" src="/js/ajax.js"></script>


    		</div>
    		<div class="col-xs-3" id="col2" style="background-color: #f4f4f4; min-height: 642px; padding: 7px 5px; max-height 643px; overflow-y: auto; overflow-x: hidden;">

                <?php $form = ActiveForm::begin();?>
                    <?= $form->field($searchModel, 'username')->textInput(['id' => 'ajaxSearch2', 'class' => 'trans_input', 'style' => 'padding: 0 5px; margin-top: 5px; background-color: #ebebeb;', 'autocomplete' => 'off', 'placeholder' => 'Ieškoti tarp visų pašnekovų'])->label(false); ?>
                <?php ActiveForm::end() ?>

                <a href="<?= Url::to(['member/msg', 'f' => null]);?>">Visos</a> &nbsp; &nbsp; &nbsp;
                <a href="<?= Url::to(['member/msg', 'f' => 'new']);?>">Naujos žinutės <span id="newBadge" style="background-color: #93c501;" class="badge"><?= \frontend\models\Notifications::countNewMessages(Yii::$app->user->id); ?></span></a>

    	        <?php Pjax::begin(); ?>
                    <div class="row"  id="pasnekovaiNew" style="display: none; padding-left: 15px; padding-right: 15px;"></div>

                    <?= ListView::widget( [
                        'layout' => '<div id="pasnekovai"><div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div></div>',
                        'dataProvider' => $dataProvider,
                        'itemView' => '//member/_msg',
                        'pager' =>[
                            'maxButtonCount'=>0,
                            'nextPageLabel'=>'Kitas &#9658;',
                            'nextPageCssClass' => 'removeStuff',
                            'prevPageLabel'=>'&#9668; Atgal',
                            'prevPageCssClass' => 'removeStuff',
                            'disabledPageCssClass' => 'off',
                        ]

                        ] );
                    ?>
                <?php Pjax::end(); ?>

                <?php if($me->adminChat): ?>

                    <div class="row" id="chatterid" style="margin: 0; margin-top: 5px; opacity: <?= $opacity; ?>">
                    <div class="col-xs-6" style="padding: 0;">
                        <div class="avatar2" style="border-top : 2px solid #94c500; border-left : 2px solid #94c500; border-bottom : 2px solid #94c500; background-color: black;" onclick='javascript:window.location.href="<?= Url::to(['member/msg', 'id' => 'admin'])?>"'>
                            <img src="/css/img/adav.jpg" width="100%" />
                        </div>
                    </div>
                    <div id="infoPart" class="col-xs-6 infoPart" style="text-align: left; padding: 15px 5px 0 3px; position: relative; border-top : 2px solid #94c500; border-right : 2px solid #94c500; border-bottom : 2px solid #94c500;">

                        <span class="ProfName" style="font-size: 13px; ">Administratorius</span><br>

                        <span class="ProfInfo" style="font-size: 11px; position: relative;">26, London</span>

                    </div>
                </div>

                <?php elseif($adchats): ?>

                    <div class="row" id="chatterid" style="margin: 0; margin-top: 5px; opacity: <?= $opacity; ?>">
                    <div class="col-xs-6" style="padding: 0;">
                        <div class="avatar2" style="background-color: black;" onclick='javascript:window.location.href="<?= Url::to(['member/msg', 'id' => 'admin'])?>"'>
                            <img src="/css/img/adav.jpg" width="100%" />
                        </div>
                    </div>
                    <div id="infoPart" class="col-xs-6 infoPart" style="text-align: left; padding: 15px 5px 0 3px; position: relative; ">

                        <span class="ProfName" style="font-size: 13px; ">Administratorius</span><br>

                        <span class="ProfInfo" style="font-size: 11px; position: relative;">26, London</span>

                    </div>
                </div>

                <?php endif; ?>

    		</div>

    	</div>
    </div>
</div>



<?php else:  ?>

<div class="container-fluid" style="padding: 0; font-size: 12px;">

    <div class="row">
        <div class="col-xs-3">

            <div class="row" style="margin-top: -25px;">
                 <div style="position: relative;">
                        <img src="/css/img/adav.jpg" width="100%" />
                </div>

                <div class="col-xs-12" style="text-align: center; padding: 5px 0 2px; background-color: #fff;">
                    <span class="ProfName">Administratorius</span><br>

                    <span class="ProfInfo2" style="color: #5b5b5b; position: relative; top: -3px;">25 metai, London </span>

                </div>
            </div>

        </div>


        <div class="col-xs-9" style="padding: 0px 9px;">

            <?php if(\frontend\models\Functions::StepsNotCompleted($me) !== false): ?>
                <div class="alert alert-info" style="text-align: left; margin-bottom: 0;" ><?= $notCompleteMsg; ?></div>
            <?php endif; ?>


            <div class="col-xs-9" style="padding: 7px 20px; background-color: #f4f4f4; min-height: 642px; text-align: left;">

                <?php $form = ActiveForm::begin();?>
                    <?= $form->field($AllSearch, 'username')->textInput(['id' => 'ajaxSearch', 'class' => 'trans_input', 'style' => 'padding: 0 5px; margin-top: 5px; width: 200px; background-color: #ebebeb;', 'autocomplete' => 'off', 'placeholder' => 'Ieškoti tarp visų narių'])->label(false); ?>
                <?php ActiveForm::end() ?>

                <div class="alert alert-info">Išsirinkite pašnekovą iš viršuje esančios juostos, arba parašykite užsukę į pašnekovo profilį</div>

                <div id="chatContainer" style="max-height: 500px; overflow-y: auto;">

                <?php
                    $user = Yii::$app->user->identity;
                ?>

                    <div class="row" style="margin: 2px 0 0 -15px">
                        <div class="col-xs-2"><img width="100%" src="/css/img/icons/no_avatar.png"></div>
                        <div class="col-xs-10 trans_box yourCloud" >Sveikiname prisiregistravus pažinčių svetainėje!</div>
                        <div style="margin: 0px 0; float: right;"><span style="position: relative; font-size: 10px; top: -3px; color: #9b9b9b;"><?= Ago::timeAgo($user->created_at); ?></span></div>
                    </div>

            </div>



            </div>
            <div class="col-xs-3" id="col2" style="background-color: #f4f4f4; min-height: 642px; padding: 7px 5px; max-height 643px; overflow-y: auto; overflow-x: hidden;">

                <?php $form = ActiveForm::begin();?>
                    <?= $form->field($searchModel, 'username')->textInput(['id' => 'ajaxSearch2', 'class' => 'trans_input', 'style' => 'padding: 0 5px; margin-top: 5px; background-color: #ebebeb;', 'autocomplete' => 'off', 'placeholder' => 'Ieškoti tarp visų pašnekovų'])->label(false); ?>
                <?php ActiveForm::end() ?>


                <div class="alert alert-info">Dar su niekuo nebendravote</div>
            </div>

        </div>
    </div>
</div>

<?php endif; ?>



<?php

$url = Yii::$app->urlManager->createUrl('/member/chatallsearch');
$url2 = Yii::$app->urlManager->createUrl('/member/chatchatterssearch');

$this->registerJs(<<<EOS

function searchAll(username)
{
    $.ajax({
            type: "post",
            url: "$url",
            global: false,
            async: true,
            cache: false,
            data: {'username' : username, 'ajax' : 1},
            dataType: 'html',
            success: function(data){
                
                $("#randomLine").css({"display" : "none"});
                $("#randomLineNew").css({"display" : "block"});
                $("#randomLineNew").html(data);
            },
            error:function(ts){
                console.log(ts);
               //$("body").html(ts.responseText);
               // alert('zopa');
            },
            complete: function (data) {
               // alert('prasisukau');
            }

        });
}


function searchChatchatterssearch(username)
{
    $.ajax({
        type: "get",
        url: "$url2",
        global: false,
        async: false,
        cache: false,
        data: {'username' : username, 'current' : $thisId},
        dataType: 'html',
        success: function(data){
            //console.log(data);
            $("#pasnekovai").css({"display" : "none"});
            $("#pasnekovaiNew").css({"display" : "block"});
            $("#pasnekovaiNew").html('');
            $("#pasnekovaiNew").html(data);
        },
        error:function(ts){
            console.log(ts);
           $("body").html(ts.responseText);
           //alert('zopa');
        },
        complete: function (data) {
           // alert('prasisukau');
        }

    }); 
    
}


var called = 0;
var reset;

var delay = (function(){
var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


var timer;

$("#ajaxSearch2").keyup(function() {
    clearTimeout(timer);

    timer = setTimeout(function(){
        if($("#ajaxSearch2").val()){
            searchChatchatterssearch($("#ajaxSearch2").val());
        }else{
            $("#pasnekovaiNew").css({"display" : "none"});
            $("#pasnekovai").css({"display" : "block"});
        }
    }, 500 );
});


$("#ajaxSearch").keyup(function() {
    delay(function(){
        if($("#ajaxSearch").val()){
            searchAll($("#ajaxSearch").val());
        }else{
            $("#randomLineNew").css({"display" : "none"});
            $("#randomLine").css({"display" : "block"});
        }
    }, 200 );
});


EOS
);
