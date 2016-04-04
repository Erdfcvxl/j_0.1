<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\helpers\Url;
use yii\helpers\BaseFileHelper;
use frontend\models\User;

class Smscallback extends Model
{
    public function proceed() {

        $params = array();
        parse_str(base64_decode(strtr($_GET['data'], array('-' => '+', '_' => '/'))), $params);
        //var_dump($params);
/*
        try {
            $response = \frontend\components\WebToPay::checkResponse($_GET, array(
                'projectid'     => 80318,
                'sign_password' => '1c6e02b62a98d8d9341a81521edd3426'
                //'log' => 'mokejimai.log',
            ));
            if ($response['test'] != 'test') {
                throw new Exception('Test value is not as expected');
            }
            if ($response['type'] !== 'sms') {
                    throw new Exception('Only macro sms callbacks are accepted');
                }

            /*$params = array();
            parse_str(base64_decode(strtr($response['data'], array('-' => '+', '_' => '/'))), $params);*/
            //var_dump($params);
            /*var_dump($_GET['ss1']);
            var_dump(md5($_GET['data'] + '75f1898c7364e38f49dcb0382d54aeec'));*/
        /*if ($_GET['ss1'] == md5($_GET['data'] + '1c6e02b62a98d8d9341a81521edd3426'))
        {*/

            if(!$order = \frontend\models\SmsOrders::find()->where(['smsid' => $params['id']])->one())
            {

                $tekstas = explode(' ',$params['sms']);
                $uid = $tekstas[2];

                $order = new \frontend\models\SmsOrders;
                $order->smsid = $params['id'];
                $order->u_id = $uid;
                $order->params = $params['amount'];
                $order->action = "abonementopirkimas";
                $order->time = time();

                $vartotojas = \common\models\User::find()->where(['id' => $uid])->one();

                $menesiuNr = 1;
                $savaite = 7 * 24 * 60 * 60;
                $addTime = $menesiuNr * 4 * $savaite;

                if($vartotojas->expires < time()){
                    $vartotojas->expires = time() + $addTime;
                }else{
                    $vartotojas->expires = $vartotojas->expires + $addTime;
                }

                if ($vartotojas->save())
                {
                    echo 'OK '. $vartotojas->username .' abonementas pratestas iki: '. date ("Y-m-d H:i", $vartotojas->expires);
                    $order->done = 1;
                }
                else
                {
                    echo 'FAIL Klaida pratesiant abonementa vartotojui'. $vartotojas->username;
                    $order->done = 0;
                }

                $order->save();

            }
            else if ($order = \frontend\models\SmsOrders::find()->where(['smsid' => $params['id']])->andWhere(['done' => 0])->one())
            {
                $tekstas = explode(' ',$params['sms']);
                $uid = $tekstas[2];

                $vartotojas = \common\models\User::find()->where(['id' => $uid])->one();

                $menesiuNr = 1;
                $savaite = 7 * 24 * 60 * 60;
                $addTime = $menesiuNr * 4 * $savaite;

                if($vartotojas->expires < time()){
                    $vartotojas->expires = time() + $addTime;
                }else{
                    $vartotojas->expires = $vartotojas->expires + $addTime;
                }

                if ($vartotojas->save())
                {
                    echo 'OK '. $vartotojas->username .' abonementas pratestas iki: '. date ("Y-m-d H:i", $vartotojas->expires);
                    $order->done = 1;
                }
                else
                {
                    echo 'FAIL Klaida pratesiant abonementa vartotojui'. $vartotojas->username;
                    $order->done = 0;
                }

                $order->save();
            }
            else
                echo 'OK Abonementas jau buvo pratestas';

        //}
            /*
        }
        catch (Exception $e) {
            echo get_class($e).': '.$e->getMessage();
        }*/
    }

}

?>