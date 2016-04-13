<?php

namespace frontend\models;

use Yii;

Class Notifications
{
    static public function countNewMessages($u_id)
    {
        $chat = new Chat;
        
        $user = UserPack::find()->where(['id' => $u_id])->one();

        $newMsg = count($chat->isNew()) + $user->adminChat;


        return $newMsg;
    }
}

?>