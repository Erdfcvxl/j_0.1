<?php
namespace frontend\models;

use Yii;
use yii\helpers\Url;

class Paysera
{

    public function makeOrder($amount)
    {
        $model = new \frontend\models\Orders;

        $amount = $amount.'00';

        $model->u_id = Yii::$app->user->id;
        $model->action = "abonementopirkimas";
        $model->params = $amount;
        $model->time = time();
        $model->done = 0;
        $model->save();

        return $model->id;
    }

    public function buyCoins($amount)
    {
        $orderId = $this->makeOrder($amount);
         
        try {
            $request = \frontend\components\WebToPay::buildRequest(array(
                'projectid'     => 80318,
                'sign_password' => '75f1898c7364e38f49dcb0382d54aeec',
                'orderid'       => $orderId,
                'amount'        => $amount * 100,
                'paytext'       => 'Abonemento pratęsimas vartotojui (' . Yii::$app->user->identity->email . ') puslapyje [site_name]',
                'currency'      => 'GBP',
                'country'       => 'GB',
                'p_email'       => Yii::$app->user->identity->email,

                'accepturl'     => Url::to(['member/succesful_payment'], true),
                'cancelurl'     => Url::to(['member/cancelled_payment'], true),
                'callbackurl'   => Url::to(['site/payseracallback'], true),

                'test'          => 1,
                //'user_id'		=> Yii::$app->user->id,
            ));

            $result = 'https://www.paysera.com/pay/?data='.$request['data'].'&sign='.$request['sign'];

            return $result;
        } catch (WebToPayException $e) {
            // handle exception

        } 

        return false;
    }


}
