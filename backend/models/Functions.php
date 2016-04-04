<?php

namespace backend\models;

class Functions 
{
    static public function CleanAvatar()
    {
        $users = \frontend\models\User::find()->select(['id','avatar'])->where(['not', ['avatar' => '']])->all();

        foreach ($users as $user) {
            if(!file_exists('../../frontend/web/uploads/531B'.$user->id."Iav.".$user->avatar)){

                $user->avatar = "";
                $user->save(false);

            }
        }

        return true;
    }
}