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

class Payseracallback extends Model
{
    public function proceed() {

            /*
            $meta = array(
                'time'      => date('Y-m-d H:i:s'),
                'verified'  => 'none',
            );*/

            try {
                $response = \frontend\components\WebToPay::checkResponse($_GET, array(
                    'projectid'     => 80318,
                    'sign_password' => '75f1898c7364e38f49dcb0382d54aeec',
                ));

                /*if ($response['test'] !== '0') {
                    throw new Exception('Testing, real payment was not made');
                }*/
                if ($response['type'] !== 'macro') {
                    throw new Exception('Only macro payment callbacks are accepted');
                }

                $orderId = $response['orderid'];
                $amount = $response['amount'];
                $currency = $response['currency'];


                if($order = \frontend\models\Orders::find()->where(['id' => $orderId])->one())
                    if($order->params == $amount){
                        $user = \common\models\User::find()->where(['id' => $order->u_id])->one();

                        if($order->done == 0){
                            $savaite = 7 * 24 * 60 * 60;

                            if($amount == 700){
                                $menesiuNr = 1;
                                $addTime = $menesiuNr * 4 * $savaite;
                            }elseif($amount == 1400){
                                $menesiuNr = 2;
                                $addTime = $menesiuNr * 4 * $savaite;
                            }elseif($amount == 2100){
                                $menesiuNr = 3;
                                $addTime = $menesiuNr * 4 * $savaite;
                            }elseif($amount == 2800){
                                $menesiuNr = 4;
                                $addTime = $menesiuNr * 4 * $savaite;
                            }else{
                                $addTime = 0;
                            }

                            $user = \common\models\User::find()->where(['id' => $order->u_id])->one();

                            if($user->expires < time()){
                                $user->expires = time() + $addTime;
                            }else{
                                $user->expires = $user->expires + $addTime;
                            }

                            $user->save();

                            $order->done = 1;
                            $order->save();

                            echo 'OK abonementas vartototojui '. Yii::$app->user->identity->username .' sėkmingai pratęstas.';
                        }
                        else
                            echo 'OK abonementas vartototojui '. Yii::$app->user->identity->username .' sėkmingai pratęstas';
                    }

            }
            catch (Exception $e) {
                $meta['status'] = get_class($e).': '.$e->getMessage();
                echo 'FAIL ' . $meta['status'];
            }
        }
}

?>