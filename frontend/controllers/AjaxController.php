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

//        $data = ['going' => 1, 'pasimatymu_vartotojo_id' => 2654];

        if ($data['going'] > 0 && $data['going'] <= 2 && $data['pasimatymu_vartotojo_id'] > 0) {
            $pasimatymas = new \frontend\models\Pasimatymai;
            $pasimatymas->sender = Yii::$app->user->id;
            $pasimatymas->receiver = $data['pasimatymu_vartotojo_id'];
            $pasimatymas->created_timestamp = time();
            if ($data['going'] == 1)
                $pasimatymas->going = 1;
            else if ($data['going'] == 2)
                $pasimatymas->going = 0;

            if ($abipusis = \frontend\models\Pasimatymai::find()->where(['receiver' => Yii::$app->user->id])->andWhere(['sender' => $data['pasimatymu_vartotojo_id']])->andWhere(['going' => 1])->one())
                $pasimatymas->abipusis = 1;

            $pasimatymas->save(false);

            if (isset($abipusis) && $abipusis != null)
            {
                $pirmasis_zmogus = \frontend\models\Pasimatymai::findOne($abipusis->id);
                $pirmasis_zmogus->abipusis = 1;
                $pirmasis_zmogus->receiver_read = 0;
                $pirmasis_zmogus->save(false);
            }

        }


        $vartotojo_info = Yii::$app->user->identity->info;
        $lytis = substr($vartotojo_info->iesko, 0, 1);

        if ($vartotojo_info->miestas != '')
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
            ->all(), 'receiver');

        $buve_pasimatymuose = array_map('strval', $buve_pasimatymuose);

        $query = \frontend\models\InfoClear::find()->select(['info.u_id', 'info.miestas', 'info.metai', 'info.menuo', 'info.diena'])
            ->andWhere(['not', ['info.miestas' => null]])
            ->andWhere(['not', ['info.miestas' => '']])
            ->andwhere(['miestas' => $miestu_id])
            ->andWhere(['not in', 'info.u_id', $buve_pasimatymuose])
            ->orderBy([new \yii\db\Expression('FIELD (info.miestas, ' . implode(',', $miestu_id) . ')')])
            ->limit(1)
            ->joinWith('user')
            ->andwhere(['not', ['avatar' => '']]);

        if ($query->one()) {

            if ((string)$vartotojo_info->orentacija == '') {
                if ($vartotojo_info->iesko == "vm" || $vartotojo_info->iesko == "mm")
                    $query->andwhere(['iesko' => ['mv', 'mm']]);
                else
                    $query->andwhere(['iesko' => ['vm', 'vv']]);
            } else {
//                if ($vartotojo_info->orentacija == 0) {
//                    if ($lytis == "v") {
//                        //$query->andwhere(['iesko' => ['vv', 'vm']]);
//                        $query->addorderBy([new \yii\db\Expression('FIELD (info.iesko, \'vv\')')]);
//                        die('c');
//                    } else {
//                        $query->andwhere(['iesko' => ['mm', 'mv']]);
//                    }
//                }
                if ($vartotojo_info->orentacija == 1) {
                    if ($lytis == "v") {
                        $query->andwhere(['iesko' => ['mv', 'mm']]);
                    } else {
                        $query->andwhere(['iesko' => ['vm', 'vv']]);
                    }
                } elseif ($vartotojo_info->orentacija == 2) {
                    if ($lytis == "m") {
                        $query->andwhere(['iesko' => ['mm', 'mv']]);
                    } else {
                        $query->andwhere(['iesko' => ['vv', 'vm']]);
                    }
                }
            }

            $query = $query->one();
//                $user = \common\models\User::findOne($query->one()->id);
//                $user_info = \frontend\models\Info::find()->select('miestas')->where(['id' => $query->one()->u_id])->one();

            $user_miestas = \frontend\models\City::findOne($query->miestas);
            $foto = \frontend\models\Misc::getAvatar($query->user);

//            if (\frontend\models\Pasimatymai::find()->where(['sender' => Yii::$app->user->identity->id])->andWhere(['>', 'created_timestamp', time() - 24 * 60 * 60])->count() >= 12)
//                $hide_pasimatymai = 1;
//            else
            $hide_pasimatymai = 0;

            if (isset($query->gimimoTS))
                $metai = $query->gimimoTS . ', ';
            else
                $metai = '';

            if($query->diena != '' && $query->menuo != '' && $query->metai != ''){
                $d1 = new \DateTime($query->diena.'.'.$query->menuo.'.'.$query->metai);
                $d2 = new \DateTime();
                $metai = $d2->diff($d1)->y . ', ';
            }else{
                $metai = '';
            }

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'id' => $query->user->id,
                'foto' => $foto,
                'vardas' => $query->user->username,
                'miestas' => $metai . $user_miestas->title,
                'hide_pasimatymai' => $hide_pasimatymai,
                //'data' => $buve_pasimatymuose,
            ];
        } else {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'hide_pasimatymai' => 1,
            ];
        }

        }
    }


    public function actionProfilio_perziuros()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            if (isset($data['page_movement']) && isset($data['page_number']))
            {
                if ($data['page_movement'] == 1)
                    $data['page_movement'] = -1;
                else if ($data['page_movement'] == 2)
                    $data['page_movement'] = 1;
                else
                    $data['page_movement'] = 0;

//                $data['page_number'] = 6;


                if (($data['page_number'] +  $data['page_movement']) >= 1)
                    $data['page_number'] +=  $data['page_movement'];
                else
                    $data['page_number'] = 1;

                if ($query = \frontend\models\Profileview::find()
                    ->select('profileview.ziuretojas, profileview.timestamp, profileview.firstTimestamp, user.username as vardas, user.id, user.avatar, user.lastOnline, user.vip as vip, info.gimimoTS, info.miestas')
                    ->joinWith('user')
                    ->joinWith('info2')
                    ->where(['ziurimasis' => Yii::$app->user->id])
                    ->groupBy('profileview.ziuretojas')
                    ->andWhere(['not', ['ziuretojas' => Yii::$app->user->id]])
                    ->orderBy('profileview.timestamp DESC')
                    ->limit(1)
                    ->offset($data['page_number']-1)
                    ->one())
                {
                    $foto = \frontend\models\Misc::getAvatar($query->user);
                    $user_miestas = \frontend\models\City::findOne($query->miestas);


                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//                return $data['page_number'];

                    return [
                        'id' => $query->user->id,
                        'foto' => $foto,
                        'vardas' => $query->user->username,
                        'miestas' => $user_miestas->title,
                        'page_movement' => $data['page_movement'],
                        'page_number' => $data['page_number'],
                    ];
                }


            }
            

        }
    }

    public function actionPakvietimai()
    {
        if (Yii::$app->request->isAjax) {


            if (isset(Yii::$app->request->post()['Mail']))
                $data = Yii::$app->request->post()['Mail'];
            else {
                $data = [];
                $data['reciever'] = '';
            }

            //$data['gavejo_email'] = 'evaldas.alcauskis@gmail.com';

            if ($data['reciever'] != '') {
                $user = Yii::$app->user->identity;

                $mail = new \common\models\Mail;

                $mail->sender = 'pakvietimai@pazintyslietuviams.co.uk';

                $mail->reciever = $data['reciever'];

                $mail->subject = 'Pakvietimas';

                $url = Url::to([

                    'site/invite',

                    'id' => \frontend\models\Invite::find()->select('code')->where(['sender' => Yii::$app->user->id])->orderBy('id DESC')->one()->code,

                ], true);

                $message = "Kad užsiregistuotumėte spauskite šią nuorodą:
                        <a href='" . $url . "'>Spausti čia</a>";

                //$mail->content = $message;

                $mail->vars = 'logo=>css/img/icons/logo2.jpg|,|avatars=>css/img/icons/avatarSectionEmail.jpg|,|link=>css/img/icons/link.jpg|,|user=>' . $user->username . '|,|invitecode=>' . \frontend\models\Invite::find()->select('code')->where(['sender' => Yii::$app->user->id])->orderBy('id DESC')->one()->code;


                $mail->view = '_pakvietimas';

                $mail->timestamp = time();

                if ($mail->trySend())
                    $atsakymas = 'Pakvietimas (' . $data['reciever'] . ') sėkmingai išsiųstas';
                else
                    $atsakymas = 'Išsiųsti nepavyko.';
            } else
                $atsakymas = 'Blogai įvestas el.paštas';


            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'atsakymas' => $atsakymas,
            ];
        }
    }

}
