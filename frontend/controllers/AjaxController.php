<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;

class AjaxController extends \yii\web\Controller
{
    public function actionPasimatymai()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();


            if ($data['going'] > 0 && $data['going'] <= 2 && $data['pasimatymu_vartotojo_id'] > 0) {
                $pasimatymas = new \frontend\models\Pasimatymai;
                $pasimatymas->sender = Yii::$app->user->id;
                $pasimatymas->receiver = $data['pasimatymu_vartotojo_id'];
                $pasimatymas->created_timestamp = time();
                if ($data['going'] == 1)
                    $pasimatymas->going = 1;
                else if ($data['going'] == 2)
                    $pasimatymas->going = 0;

                $pasimatymas->save();
            }

            if (\frontend\models\Info::find()->where(['u_id' => Yii::$app->user->identity->id])->one()->miestas != '')
                $miestas_temp = \frontend\models\Info::find()->where(['u_id' => Yii::$app->user->identity->id])->one()->miestas;
            else
                $miestas_temp = 0;

            $zmogaus_miestas = \frontend\models\City::findOne($miestas_temp);
            $miestu_id = yii\helpers\ArrayHelper::getColumn(\frontend\models\City::find()->select(['id', '(6371 * 2 * ASIN(SQRT( POWER(SIN((' . $zmogaus_miestas->latitude . ' - [[latitude]]) * pi()/180 / 2), 2) + COS(' . $zmogaus_miestas->latitude . ' * pi()/180) * COS([[latitude]] * pi()/180) *POWER(SIN((' . $zmogaus_miestas->longitude . ' - [[longitude]]) * pi()/180 / 2), 2) ))) AS distance'])
                ->orderBy('distance ASC')
                ->all(), 'id');

            $miestu_id = array_map('strval', $miestu_id);

            $buve_pasimatymuose = yii\helpers\ArrayHelper::getColumn(\frontend\models\Pasimatymai::find()
                ->select('receiver')
                ->where(['sender' => Yii::$app->user->id])
                //->andWhere(['!=', 'receiver', 0])
                ->all(), 'receiver');

            $buve_pasimatymuose = array_map('strval', $buve_pasimatymuose);

            $query = \frontend\models\Info::find()->select(['u_id'])
                ->andWhere(['not', ['miestas' => null]])
                ->andWhere(['not', ['miestas' => '']])
                ->andwhere(['miestas' => $miestu_id])
                ->andWhere(['not in', 'u_id', $buve_pasimatymuose])
                //->limit(1)
                ->orderBy([new \yii\db\Expression('FIELD (miestas, ' . implode(',', $miestu_id) . ')')]);

            $user = \common\models\User::findOne($query->one()->u_id);
            $user_info = \frontend\models\Info::find()->select('miestas')->where(['u_id' => $query->one()->u_id])->one();
            $user_miestas = \frontend\models\City::findOne($user_info->miestas);

            $foto = \frontend\models\Misc::getAvatar($user);


            if (\frontend\models\Pasimatymai::find()->where(['sender' => Yii::$app->user->identity->id])->andWhere(['>', 'created_timestamp', time() - 24 * 60 * 60])->count() >= 12)
                $hide_pasimatymai = 1;
            else
                $hide_pasimatymai = 0;


            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'id' => $user->id,
                'foto' => $foto,
                'vardas' => $user->username,
                'miestas' => $user_miestas->title,
                'hide_pasimatymai' => $hide_pasimatymai,
            ];
        }
    }


//    public function actionProfilio_perziuros()
//    {
//        /*
//                $profili_perziurejo = \frontend\models\Profileview::find()
//                    ->select(['ziuretojas', 'timestamp'])
//                    ->where(['ziurimasis' => Yii::$app->user->identity->id])
//                    ->orderBy('timestamp DESC')
//                    ->limit(5)
//                    ->all();
//
//                foreach ($profili_perziurejo as $profilis)
//                {
//                    $profilio_useris = \common\models\User::findOne($profilis->ziuretojas);
//                    $profilis->vardas = $profilio_useris->username;
//                    $profilis->avataras = \frontend\models\Misc::getAvatar($profilio_useris);
//                }
//
//                var_dump($profili_perziurejo);*/
//
//        if (Yii::$app->request->isAjax) {
//            //$data = Yii::$app->request->post();
//
//
//            $profili_perziurejo = \frontend\models\Profileview::find()
//                ->select(['ziuretojas', 'timestamp'])
//                ->where(['ziurimasis' => Yii::$app->user->identity->id])
//                ->orderBy('timestamp DESC')
//                ->limit(5)
//                ->all();
//
//            $avatarai = [];
//            $vardai = [];
//
//            foreach ($profili_perziurejo as $profilis)
//            {
//                $profilio_useris = \common\models\User::findOne($profilis->ziuretojas);
//                $vardai[] = $profilio_useris->username;
//                $avatarai[] = \frontend\models\Misc::getAvatar($profilio_useris);
//            }
//
//
//            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//            return [
//                'profili_perziurejo' => $profili_perziurejo,
//                'vardai' => $vardai,
//                'avatarai' => $avatarai,
//            ];
//        }
//    }

    public function actionPakvietimai()
    {
        if (Yii::$app->request->isAjax) {


        if (isset(Yii::$app->request->post()['Mail']))
            $data = Yii::$app->request->post()['Mail'];
        else
        {
            $data = [];
            $data['reciever'] = '';
        }

            //$data['gavejo_email'] = 'evaldas.alcauskis@gmail.com';

        if ($data['reciever'] != '')
        {
            $user = Yii::$app->user->identity;

            $mail = new \common\models\Mail;
            $mail->sender = 'no-reply@pazintyslietuviams.co.uk';
            $mail->reciever = $data['reciever'];
            $mail->subject = 'Pakvietimas';
            //$mail->vars = 'logo=>css/img/icons/logo2.jpg|,|avatars=>css/img/icons/avatarSectionEmail.jpg|,|link=>css/img/icons/link.jpg|,|user=>' . $user->username;
            $mail->vars = 'logo=>css/img/icons/logo2.jpg|,|avatars=>css/img/icons/avatarSectionEmail.jpg|,|link=>css/img/icons/link.jpg|,|user=>' . $user->username .'|,|invitecode=>' . \frontend\models\Invite::find()->select('code')->where(['sender' => Yii::$app->user->id])->orderBy('id DESC')->one()->code;
            $mail->view = '_pakvietimas';
            $mail->timestamp = time();

            if ($mail->trySend())
                $atsakymas = 'Pakvietimas ('.$data['reciever'].') sėkmingai išsiųstas';
            else
                $atsakymas = 'Išsiųsti nepavyko.';
        }
        else
            $atsakymas = 'Blogai įvestas el.paštas';



            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'atsakymas' => $atsakymas,
            ];
        }
    }

}
