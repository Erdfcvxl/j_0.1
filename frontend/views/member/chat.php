<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use common\models\User;
use common\models\UserPack;
use frontend\models\Info2;
use frontend\models\Chat;
use yii\db\Query;
use yii\helpers\Url;
use frontend\models\Ago;

$trueId = Yii::$app->user->identity->id;
$thisId = (isset($_GET['id']))? $_GET['id'] : "";
$plimit = (isset($_GET['limit'])? $_GET['limit'] : "10");

$me = User::find()->where(['id' => $trueId])->one();

if(!$thisId){
   $chat = Yii::$app->params['chatNew'];
   $lasChat = $chat::find()->where(['or', 'sender ='. $trueId, 'reciever ='. $trueId])->orderBy(['timestamp'=>SORT_DESC])->one();

    if($lasChat){
        $thisId = ($lasChat->sender == $trueId)? $lasChat->reciever : $lasChat->sender; 
        $_GET['id'] = $thisId;
    }
}

if($thisId):
$user = User::find()->where(['id' => $thisId])->one();
$info = Info2::find()->where(['u_id' => $thisId])->one();

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

$manoAvataras = \frontend\models\Misc::getAvatar($me);
\frontend\models\Chatnot::remove($thisId);


?>
<div class="row" style="padding: 0px 15px;">Parašyti</div>

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
                <?= $form->field(new Chat, 'message')->textarea(['style' => 'background-color: #fff; width: 100%; resize: none; padding: 8px;', 'class' => 'trans_box', 'id' => 'msgArea'])->label(false); ?>

                <?= Html::submitButton('Siusti', ['id' => 'send', 'class' => 'btn btn-reg', 'style' => 'font-size: 14px; padding: 0px 7px; margin-top: -10px;']) ?>
            <?php ActiveForm::end() ?>

        <?php endif; ?>

        Susirašinėjimas su <span style="font-weight: bold;"><?= $user->username ?></span>

        <div id="chatContainer" style="max-height: 500px; overflow-y: auto;">

            <?php foreach($chatQ as $message){ ?>
                <?php
                    if(substr($message['message'], 0, 8) == "-%necd%%"){
                        $content = substr($message['message'], 8);

                    }else{
                        $content = HTML::encode($message['message']);
                    }

                    if($message['sender'] == $thisId){
                        $avataras = \frontend\models\Misc::getAvatar($user);
                    }else{
                        $avataras = \frontend\models\Misc::getAvatar($me);
                    }
                    
                ?>
                <div class="row" style="margin: 2px 0 0 -15px">
                    <div class="col-xs-2"><img width="100%" src="<?= $avataras; ?>"></div>
                    <div class="col-xs-10 trans_box <?php echo($message['sender'] == $thisId)? "yourCloud" : "myCloud" ?>" ><?= $content; ?></div>
                    <div style="margin: 0px 0; float: right;"><span style="position: relative; font-size: 10px; top: -3px; color: #9b9b9b;"><?= Ago::timeAgo($message['timestamp']); ?></span></div>
                </div>
            <?php } ?>

        </div>

        <?php if((count($chatQ) >= $plimit)): ?>
            <center><a href="?r=member/msg&id=<?= $thisId; ?>&limit=<?= $plimit + 10; ?>">Rodyti daugiau</a></center>
        <?php endif ?>


    </div>
</div>

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

<?php endif; ?>

