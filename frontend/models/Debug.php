<?php

namespace frontend\models;

use Yii;

class Debug
{
    /*
     * Type User object, id, username
     */

    public function check($value='')
    {
        # code...
    }

    static public function run($users = false, $type = 'id')
    {
        if(!$users){
            return true;
        }

        if($type == 'id'){
            if(array_search(Yii::$app->user->id, $users) !== false){
                return true;
            }
        }elseif($type == "username"){
           if(array_search(Yii::$app->user->identity['username'], $users) !== false){
                return true;
            } 
        }elseif($type == "object"){
            die('DEBUG.PHP fill if statement :29');
        }
    }

    static public function skip($users = false, $type = 'id')
    {
        if(!$users){
            return false;
        }

        if($type == 'id'){
            if(array_search(Yii::$app->user->id, $users) !== false){
                return false;
            }
        }elseif($type == "username"){
           if(array_search(Yii::$app->user->identity['username'], $users) !== false){
                return false;
            } 
        }elseif($type == "object"){
            die('DEBUG.PHP fill if statement :29');
        }
    }
}
