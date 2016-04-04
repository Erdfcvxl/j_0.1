<?php

namespace frontend\models;

use Yii;

class Functions
{

    private function convertToSeconds($time)
    {
        $parts = explode(':', $time);
        $hours = $parts[0];
        $minutes = $parts[1];

        $result = ($hours * 60) + $minutes;

        return $result;
    }

    public function MWeekendsFree($value='')
    {
        $ends = strtotime ('next monday')-1;
        $diena = date("N", time()); //pirmadienis => 1, antradienis => 2....
        $penktadienis = false;

        if($diena == 5){
            $penktadienis = (date('H') >= 18);
        }

        if($diena == 6 || $diena == 7 || $penktadienis){
            $query = \common\models\User::find()
                ->select('info.iesko, user.*')
                ->joinWith('info')
                ->where(['user.id' => Yii::$app->user->id])
                ->andWhere(['info.iesko' => ['mv', 'mm']])
                ->all();

            foreach ($query as $model) {
                if($model->expires < $ends){
                    $model->expires = $ends;
                    $model->save(false);
                }
            }
        }
    }

    public function AllWeekendsFree()
    {
        $ends = strtotime ('next monday')-1;
        $diena = date("N", time()); //pirmadienis => 1, antradienis => 2....
        $penktadienis = false;

        if($diena == 5){
            $penktadienis = (date('H') >= 18);
        }

        if($diena == 6 || $diena == 7 || $penktadienis){
            $query = \common\models\User::find()->where(['user.id' => Yii::$app->user->id])->all();

            foreach ($query as $model) {
                if($model->expires < $ends){
                    $model->expires = $ends;
                    $model->save(false);
                }
            }
        }
    }

    public function EmailMsgNotification($user)
    {
        $save = false;

        if($user->msgEmailNot != ""){
            $user->msgEmailNot = "";
            $save = true;
        }
            

        if(date('D', time()) === 'Mon') {
            if($user->newDone == 0){
                $user->new = $user->new + rand(1, 5);
                $user->newDone = 1;
                $save = true;
            }
        }else{
            $user = User::find()->where(['id' => Yii::$app->user->id])->one();
            $user->newDone = 0;
            $save = true;
        }

        if($save)
            $user->save(false);
    }

    static public function StepsNotCompleted($user)
    {
        $reg_step = ($user->reg_step)? explode(' ', $user->reg_step) : [];

        $lack = false;
        for($i = 4; $i >= 0; $i--){
            if(array_search((string)$i, $reg_step) === false){
                $lack = $i;
            }
        }

        return $lack;
    }

    public function Expired($psl)
    {
        $expired = Expired::prevent();

        $notAllowed = [
            'addtofriends',
            'addtofavs',
            'mirkt',
            'cancelinvitation',
            'declineinvitation',
            'acceptinvitation',
        ];


        if($expired){
            if(array_search($psl, $notAllowed) !== false){
                return true;
            }
        }

    }

}

