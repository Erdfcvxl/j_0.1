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

$thisId = (isset($_GET['id']))? $_GET['id'] : '';

$plimit = (isset($_GET['limit'])? $_GET['limit'] : "10");



if(!$thisId){
    return Yii::$app->getResponse()->redirect( Url::to(['member/index']));
}



$me = User::find()->where(['id' => $trueId])->one();



$user = User::find()->where(['id' => $thisId])->one();

$info = Info::find()->where(['u_id' => $thisId])->one();



$query = new Query;

$query->select('sender, reciever, message, timestamp')
    ->where(['and', ['or', 'sender = '.$trueId , 'reciever = '.$trueId], ['or', 'sender = '.$thisId , 'reciever = '.$thisId]])
    ->andWhere(['not', ['dontShow' => $trueId]])
    ->from('chat')
    ->orderBy('timestamp DESC')
    ->limit($plimit);
$command = $query->createCommand();
$chatQ = $command->queryAll();  


Chat::updateAll(['newID' => 0], 'newID = :me AND sender = :sender', [':me' => Yii::$app->user->id, ':sender' => $thisId]);  


\frontend\models\Chatnot::remove($thisId);


$arFavoritas = Favourites::arFavoritas($thisId);

$manoAvataras = \frontend\models\Misc::getAvatar($me);

/*
if(!is_dir('uploads/'.$user->id.'/profile')){
    if(!is_dir('uploads/'.$user->id)){

        mkdir('uploads/'.$user->id);
    }  
    mkdir('uploads/'.$user->id.'/profile');
}

$files=\yii\helpers\FileHelper::findFiles('uploads/'.$user->id.'/profile');
*/

if(!empty($files)){

    $file = explode('\\', $files[0]);

    if(count($file) > 0){
        $urlToProfilePhoto = Url::to(['member/fotos', 'ft' => 'showFoto', 'd' => '/uploads/'.$user->id.'/profile', 'psl' => 'p', 'id' => $user->id, 'n' => $file[1]]);
    }else{
        $urlToProfilePhoto = "#";
    }

}else{
    $urlToProfilePhoto = "#";
}




if(!empty($files)){

    $file = explode('/', $files[0]);



    if(count($file) > 0){

        $urlToProfilePhoto = Url::to(['member/fotos', 'ft' => 'showFoto', 'd' => '/uploads/'.$user->id.'/profile', 'psl' => 'p', 'id' => $user->id, 'n' => $file[3]]);

    }else{

        $urlToProfilePhoto = "#";

    }

}else{

    $urlToProfilePhoto = "#";

}



?>



<div class="row" style="margin-top: 5px; padding-bottom: 70px;">

    <div class="col-xs-3" style="background-color: #d1d1d1; ">

    

         <div class="row">



         <div style="position: relative;">

            <a href="<?= $urlToProfilePhoto; ?>">

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

                    <img src="/css/img/online.png" title="Prisijungęs" style="position: absolute; z-index: 1; margin-top: -14px; margin-left: 1px; left: 0; bottom: 1px;">

                <?php endif; ?>

            </a>

        </div>



                <div class="col-xs-12" style="text-align: center; padding: 5px 0 2px; background-color: #fff;">

                    <span class="ProfName"><?= $user->username;?><?= \frontend\models\Misc::vip($user); ?></span><br>



                    <?php 

                        $info = Info::find()->where(['u_id' => $thisId])->one(); 



                        $d1 = new DateTime($info->diena.'.'.$info->menuo.'.'.$info->metai);

                        $d2 = new DateTime();



                        $diff = $d2->diff($d1);



                        require(__DIR__ ."/../site/form/_list.php");

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

                    <div class="btn btn-reg"><a href="<?= Url::to(['member/unfriend', 'id' => $_GET['id']]); ?>">Nebedraugauti</a></div>

                <?php elseif($pakvietimai2): ?>

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

                	<a href="<?= Url::to(['member/help']); ?>">Pranešti apie profilį</a>

                </div>

            </div>

        </div>



        <div class="row" style="background-color: #F7F4ED;">

            <div class="col-xs-12">

                <div class="row" style="margin-top: 10px; min-height: 25px;" id="zodisRow">

                    <div id="regIco" style="position: absolute; z-index: 1; left: 0; padding: 0; margin: 0; text-align: right;"><a href="<?= Url::to(['member/zodis']); ?>" class="glyphicon glyphicon-pencil" style="display: none; position: relative; left: 5px;border: 1px solid grey; border-radius: 2px; padding: 2px;"></a></div>

                    <div class="col-xs-12" style="font-style: italic;" id="zodis">&nbsp&nbsp&nbsp&nbsp&nbsp<?= ($info->zodis)? $info->zodis: '<span style="color: grey;">Žodis apie mane</span>'; ?></div>

                </div>

            </div>

        </div>



    </div>





    <div class="col-xs-9" >

    	<div class="container" style="width:100%; background-color: #e8e8e8; min-height: 150px; font-size: 12px; text-align: left; padding: 10px 30px;">

    		<div class="row" style="padding: 0px 15px;">Parašyti</div>

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

    		<div class="row">

    			<div class="col-xs-12">

                    <?php if(\frontend\models\Expired::prevent()): ?>

                        <div class="alert alert-warning">

                            <b>Jūsų abonimento galiojimas baigėsi.</b>

                            <br>

                            Rašyti gali tik tie nariai, kurių abonimentas yra galiojantis.

                        </div>

                    <?php else: ?>



                        <?php $form = ActiveForm::begin(['id' => 'chat', 'enableAjaxValidation' => true]);?>

                            <?= $form->field(new Chat, 'message')->textarea(['style' => 'background-color: #f6f6f6; width: 100%; resize: none; padding: 8px;', 'class' => 'trans_box', 'id' => 'msgArea'])->label(false); ?>



                            <?= Html::submitButton('Siusti', ['id' => 'send', 'class' => 'btn btn-reg', 'style' => 'font-size: 14px; padding: 0px 7px; margin-top: -10px;']) ?>

                        <?php ActiveForm::end() ?>



                    <?php endif; ?>



                    Susirašinėjimas



                    <div id="chatContainer" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;">

                        <?php 

                            

                        ?>

                        <?php foreach($chatQ as $message){ ?>

                            <?php

                                if(substr($message['message'], 0, 8) == "-%necd%%"){

                                    $content = substr($message['message'], 8);



                                }else{

                                    $content = HTML::encode($message['message']);

                                }



                                 if($message['sender'] == $thisId){

                                    if($user->avatar){



                                        $avataras = "/uploads/531B".$thisId."Iav.".$user->avatar;

                                    }else{

                                        $avataras = "/css/img/icons/no_avatar.png";

                                    }

                                }else{

                                    if($me->avatar){

                                        $avataras = "/uploads/531B".$trueId."Iav.".$me->avatar;

                                    }else{

                                        $avataras = "/css/img/icons/no_avatar.png";

                                    }

                                }

                            ?>

                            <div class="row" style="margin: 0 0 0 -15px">

                                <div style="margin: 5px 0;" class="col-xs-2"><img width="100%" src="<?= $avataras; ?>"></div>

                                <div style="margin: 5px 0;" class="col-xs-10 trans_box <?php echo($message['sender'] == $thisId)? "yourCloud" : "myCloud" ?>"><?= $content; ?></div>

                                <div style="margin: 0px 0; float: right;"><span style="position: relative; font-size: 10px; top: -8px; color: #9b9b9b;"><?= Ago::timeAgo($message['timestamp']); ?></span></div>

                            </div>

                        <?php } ?>



                    </div>



                    <?php if((count($chatQ) >= $plimit)): ?>

                        <center><a href="?r=member/user&id=<?= $thisId; ?>&limit=<?= $plimit + 10; ?>">Rodyti daugiau</a></center>

                    <?php endif ?>



                </div>

        	</div>

    	</div>

    </div>

</div>

<script type="text/javascript" src="/js/ajax.js"></script>

<script type="text/javascript">
    var avatar = '<?= $manoAvataras; ?>',
        url =  '<?= Url::to(["member/updatechat"]) ?>',
        otherId = '<?= $thisId; ?>', 
        myId = '<?= $trueId; ?>', 
        myAvatar = '<?= $me->avatar; ?>';
</script>

<?php

$this->registerJsFile('/js/updateChat.js');

?>