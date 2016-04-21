<?php

namespace backend\controllers;

//set_time_limit(0);
//ini_set('memory_limit', '128M');

use Yii;

class CronController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    private function convertToSeconds($time)
    {
        $parts = explode(':', $time);
        $hours = $parts[0];
        $minutes = $parts[1];

        $result = ($hours * 60) + $minutes;

        return $result;
    }

    public function actionOnline()
    {
        $models = \common\models\User::find()->select('id')->where(['f' => 1])->all();

        foreach ($models as $model) {
            $ids[] = $model->id;
        }

        $f1_t4 = [  
            ['start' => '06:00', 'end' => '12:00', 'users' => '2,4'],
            ['start' => '12:00', 'end' => '13:30', 'users' => '4,6'],
            ['start' => '13:30', 'end' => '17:00', 'users' => '2,4'],
            ['start' => '17:00', 'end' => '25:30', 'users' => '4,8'],
            ['start' => '01:30', 'end' => '06:00', 'users' => '0,1'],
        ];

        $penkt = [  
            ['start' => '06:00', 'end' => '12:00', 'users' => '2,4'],
            ['start' => '12:00', 'end' => '13:30', 'users' => '4,6'],
            ['start' => '13:30', 'end' => '17:00', 'users' => '2,4'],
            ['start' => '17:00', 'end' => '26:30', 'users' => '7,12'],
            ['start' => '02:30', 'end' => '06:00', 'users' => '0,1'],
        ];

        $f6_t7 = [  
            ['start' => '11:00', 'end' => '26:30', 'users' => '7,12'],
        ];

        //savaites dienos ir ju taisykles
        $usersOnline = [
            1 => $f1_t4,
            2 => $f1_t4,
            3 => $f1_t4,
            4 => $f1_t4,
            5 => $penkt,
            6 => $f6_t7,
            7 => $f6_t7,
        ];



        $rules = $usersOnline[date('N', time())]; //issirenka taisykle palei diena
        $now = $this->convertToSeconds(date('G:i', time()));

        foreach ($rules as $rule) {
            $lower = $this->convertToSeconds($rule['end']);
            $higher = $this->convertToSeconds($rule['start']);

            if($now < $lower && $now > $higher){
                $users = $rule['users'];
            }
        }

        $userP = explode(',', $users);

        $randUsers = rand((int)$userP[0], (int)$userP[1]);



        for($i = 0; $i < $randUsers; $i++) {
            $randID = rand(0, count($ids)-1);

            $user = \common\models\User::find()->where(['id' => $ids[$randID]])->one();
            $user->lastOnline = time();
            $user->save(false);

            $prijungta[] = $user->username;
        }


        $useriaiPrijungti = implode(", ", $prijungta);

        var_dump($useriaiPrijungti);

        /*Yii::$app->mailer->compose('_sablonas', [
                        'logo' => 'css/img/icons/logoEmpty.jpg', 
                        'avatars' => 'css/img/icons/avatarSectionEmail.jpg', 
                        'link' => 'css/img/icons/link.jpg', 
                        'body' => $useriaiPrijungti
                    ])
                    ->setFrom('rokasr788@gmail.com')
                    ->setTo('cron@pazintyslietuviams.co.uk')
                    ->setSubject('Robotas');*/
                    //->send();

    }

    public function actionPupulatevip()
    {
        @extract($_GET);

        $l = (isset($l))? $l : 50;

        $model = \common\models\User::find()->where(['>=', 'expires', time() + 60*60*24*2])->andWhere(['not', ['vip' => 1]])->offset($l-50)->limit($l)->all();

        if(count($model) >= 50){
            echo "<a href='".\yii\helpers\Url::current(['l' => $l + 50])."'>Toliau</a>";
        }else{
            echo "viskas";
        }

        echo "<br>";

        foreach ($model as $v) {
            echo $v->username. "<br>";
            $v->vip = 1;
            $v->save();
        }
        
    }

    public function actionValidatevip()
    {
        $model = \common\models\User::find()->where(['<=', 'expires', time()])->andWhere(['vip' => 1])->all();

        foreach ($model as $v) {
            echo $v->username. "<br>";
            $v->vip = 0;
            $v->save();
        }

        if(!$model){
            echo "nera";
        }

    }

    public function actionUpdatelimits()
    {
        $params = \common\models\Parametres::find()->one();
        $date = new \DateTime;

        $currentH = date('H', time());
        $updatedH = date('H', $params->updatedAt);

        echo "dabartinis lmitas: ".$params->MailLeft;

        echo "<br><br>dabartine valanda: ".$currentH;
        echo "<br> regeno valanda: ".$updatedH;

        if($params->updatedAt < time() && $currentH != $updatedH){
            $params->MailLeft = $params->MailRegen;
            $params->updatedAt = time();
            $params->save();

            echo "<br><br>atnaujinama";
        }else{
            echo "<br><br>atnaujinimo laikas:".date('Y-m-d H:i:s', $params->updatedAt) ;
        }

        echo "<br><br><br>Duomenys iš duombazės:";

        var_dump($params);
    }

    public function actionSendmails()
    {
        $model = new \backend\models\Mail;

        $model->sendEmails();
    }

    public function actionFfm()
    {
        $welcome = new \backend\models\Welcome;

        $welcome->trySend();
    }

    public function actionTest()
    {
        $users = \frontend\models\Misc::getAmzius('', '', '');

        var_dump($users);
    }

    /*
     *Išvalo pokalbius su neegzistuojančiais nariais
     */
    public function actionClear()
    {
        $model = new \backend\models\Functions;
        $model->CleanTrashTalk();
        //$model->CleanTrashNot();
    }

    public  function actionFuck()
    {

        $model = new \backend\models\Functions;

        $array = [
            782
        ];

        foreach ($array as $id){
            $nots = \frontend\models\Chatnot::find()->where(['sender' => $id])->orWhere(['reciever' => $id])->all();
            $model->deleteAll($nots);

            $chatters = \frontend\models\Chatters::find()->where(['u1' => $id])->orWhere(['u2' => $id])->all();
            $model->deleteAll($chatters);

            $invites = \frontend\models\Pakvietimai::find()->where(['sender' => $id])->orWhere(['reciever' => $id])->all();
            $model->deleteAll($invites);
        }
    }

}
