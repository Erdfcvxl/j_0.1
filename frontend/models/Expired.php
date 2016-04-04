<?php

namespace frontend\models;

use Yii;
use frontend\models\User;

class Expired
{

    public static function prevent()
    {
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();

        if($user->expires < time()){
        	if($user->expires == 0){
            	$user->expires = time() + 86400;
                $user->save(false);
                return false;
        	}else{
        		return true;
        	}
        }else{
            return false;
        }
        
    }
}