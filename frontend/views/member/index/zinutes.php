<?php
use yii\helpers\Url;
use frontend\models\Chat;
use yii\helpers\Html;
use frontend\models\User;

if(Chat::isNew()){
    $shortcut = Chat::isNew()[count(Chat::isNew())-1];
}else{
    $shortcut = null;
}

?>
<div class="col-xs-2">
    Žinutės

    <br>
    <br>

    <a href="<?= Url::to(['member/msg', 'id' => $shortcut])?>">
        <img id="laiskoImg" link="<?= Url::to(['member/msg' , 'id' => $shortcut]); ?>" src="/css/img/icons/laiskas<?= (count(Chat::isNew()) > 0)? 'New' : '' ?>.png">
    </a>

    <span class="btn btn-circle" id="msgIndexIndicator" style="margin-left: -10px; margin-top: -20px;<?= (count(Chat::isNew()) > 0)? 'display: inline-block' : 'display: none'; ?>"><?= (count(Chat::isNew()) > 0)? count(Chat::isNew()) : ""; ?></span>
    
</div>


<div id="pre" class="col-xs-10">
    <?php $lastMsgTotal = Chat::find('message')->where(['reciever' => Yii::$app->user->id])->limit(2)->orderBy(['timestamp' => SORT_DESC])->all();?>

    <?php

    if(!isset($lastMsgTotal) && !$newIds){
        echo "Nėra naujų žinučių";
    }else{
        if(isset($lastMsgTotal[1]))
            echo $this->render('includes/msgEncode', ['sender' => $lastMsgTotal[1]->sender, 'message' => $lastMsgTotal[1]->message, 'o' => 0.5]);
        
        if(isset($lastMsgTotal[0]))
            echo $this->render('includes/msgEncode', ['sender' => $lastMsgTotal[0]->sender, 'message' => $lastMsgTotal[0]->message, 'o' => 0.7]);
    }

    ?>
</div> 

<div id="quickMsgPreview" class="col-xs-10 col-xs-offset-2">
    <?php
    $newIds = Chat::isNew();

    for($i = count($newIds)-1; $i >= 0; $i--):
        $user = User::find('username')->where(['id' => $newIds[$i]])->one();
        $lastMsg = Chat::find()->where(['sender' => $newIds[$i]])->andWhere(['reciever' => Yii::$app->user->id])->orderBy(['timestamp' => SORT_DESC])->one();

        if(!User::find()->where(['id' => $lastMsg->sender])->one() && $lastMsg){
            $lastMsg->delete();

            continue;
        }
    ?>

        <div class="col-xs-10 trans_box" style="padding: 2px 15px; margin: 1px 0;">
            <a href="<?= Url::to(['member/msg', 'id' => $user->id]); ?>">

                <?php
                if(substr($lastMsg->message, 0, 8) == "-%necd%%"){
                    $content = substr($lastMsg->message, 8);
                }else{
                    $content = HTML::encode($lastMsg->message);
                }

                echo $user->username.": ".$content;
                ?>

            </a>

        </div>


    <?php endfor; ?>

</div>

