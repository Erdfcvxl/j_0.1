<?php

namespace backend\models;

use Yii;
use frontend\models\Chat;
use frontend\models\Statistics;
use frontend\models\Chatnot;

/**
 * This is the model class for table "welcome".
 *
 * @property integer $u_id
 * @property string $lytis
 * @property string $orentacija
 * @property integer $amzius
 * @property string $msg
 */

const CREATED_OFFSET = 1460662210;

class Welcome extends \yii\db\ActiveRecord
{

    public $players;
    public $run = [
        'tryFirst',
        'trySecond',
        'tryThird',
    ];
    public $ataskaita;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'welcome';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'lytis', 'orentacija', 'amzius'], 'required'],
            [['u_id', 'amzius'], 'integer'],
            [['msg'], 'string'],
            [['lytis'], 'string', 'max' => 1],
            [['orentacija'], 'string', 'max' => 225],
            [['u_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'u_id' => 'U ID',
            'lytis' => 'Lytis',
            'orentacija' => 'Orentacija',
            'amzius' => 'Amzius',
            'msg' => 'Msg',
        ];
    }
    
    public function addToGame($id)
    {
        $model = \frontend\models\UserPack::find()->where(['id' => $id])->one();

        if(!self::find()->where(['u_id' => $id])->one()) {
            $this->u_id = $model->id;
            $this->lytis = substr($model->info->iesko, 0, 1);
            $this->orentacija = $model->info->orentacija;
            $this->amzius = \frontend\models\Misc::getAmzius($model->info->diena, $model->info->menuo, $model->info->metai);

            if($this->save())
                return true;
        }else{
            Yii::$app->session->setFlash('warning', 'Šis narys jau pridėtas');

            return true;
        }

        var_dump($this->getErrors());
        return false;

    }

    public function sendFfm($id, $msg, $gavejas)
    {
        if($id && $msg){
            $sender = \frontend\models\UserPack::find()->where(['id' => $id])->one();

            $chat = new Chat;
            $chat->tryEmail($sender, $gavejas, true);
            $chat->sendMsgGlobal($sender->id, $gavejas->id, $msg);

            Statistics::addRecieved($gavejas->id);

            $not = new Chatnot;
            $not->insertNotGlobal($sender->id, $gavejas->id);

            $gavejas->firstFakeMsg += 1;
            if(empty($gavejas->ffmSenders)){
                $gavejas->ffmSenders = $sender->id;
            }else{
                $gavejas->ffmSenders .= ",".$sender->id;
            }

            $gavejas->save();
        }

    }

    public function getMsg($model)
    {
        $msgs = explode('||', $model->msg);

        $key = rand(0, count($msgs)-1);

        return $msgs[$key];
    }

    public function getSender($user)
    {
        $id = null;
        $msg = null;
        $skirtumas = 3000;

        //jei nera info table tam zmogui
        if(!$user->info)
            return null;

        $iesko = substr($user->info->iesko, 1);
        $used = explode(',',$user->ffmSenders);

        $amzius = \frontend\models\Misc::getAmzius($user->info->diena, $user->info->menuo, $user->info->metai);

        //jeigu dar neuzpilde anketos ir nenustate gimimo datos, zinutes jam nesius
        if($amzius < 18)
            return null;

        //isrenka labiausiai atitinkanti siunteja
        foreach ($this->players as $model) {
            if ($model->lytis == $iesko) {
                if (array_search($model->u_id, $used) === false) {
                    if (abs($model->amzius - $amzius) < $skirtumas) {
                        $skirtumas = abs($model->amzius - $amzius);
                        $id = $model->u_id;
                        $msg = $this->getMsg($model);
                    }
                }
            }
        }

        //viskas gerai -> returnina siuntja
        if($id && $msg){
            $sender = [
                'id' => $id,
                'msg' => $msg
            ];

            return $sender;
        }

        return null;

    }

    public function proceedWithQuery($users, $name)
    {
        foreach($users as $user){
            if($s = $this->getSender($user)) {
                $this->sendFfm($s['id'], $s['msg'], $user);
                $this->ataskaita[$name][] = ['siuntejas' => $s['id'], 'gavejas' => $user->username, 'msg' => $s['msg']];
            }
        }
    }

    public function tryFirst()
    {
        //pasirenka publika
        $users = \frontend\models\UserPack::find()
            ->where(['firstFakeMsg' => 0])
            ->andWhere(['>=', 'created_at', 60 * 2])
            ->andWhere(['>=', 'created_at', CREATED_OFFSET])
            ->all();

        $this->proceedWithQuery($users, 'tryFirst');

    }

    public function trySecond()
    {
        //pasirenka publika
        $users = \frontend\models\UserPack::find()
            ->where(['firstFakeMsg' => 1])
            ->andWhere(['>=', 'created_at', 60 * 10])
            ->andWhere(['>=', 'created_at', CREATED_OFFSET])
            ->all();

        $this->proceedWithQuery($users, 'trySecond');
    }

    public function tryThird()
    {
        //pasirenka publika
        $users = \frontend\models\UserPack::find()
            ->where(['firstFakeMsg' => 1])
            ->andWhere(['>=', 'created_at', 60 * 60 * 27])
            ->andWhere(['>=', 'expires', time()])
            ->andWhere(['>=', 'created_at', CREATED_OFFSET])
            ->all();

        $this->proceedWithQuery($users, 'tryThird');
    }

    public function trySend()
    {
        //pupulates players
        $this->players = self::find()->all();

        foreach ($this->run as $v){
            $this->$v();

        }

        var_dump($this->ataskaita);

    }


}
