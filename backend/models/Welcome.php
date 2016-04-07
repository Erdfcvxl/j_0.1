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
class Welcome extends \yii\db\ActiveRecord
{
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

            $gavejas->firstFakeMsg = 1;
            $gavejas->save();
        }



    }

    public function trySend()
    {
        $users = \frontend\models\UserPack::find()->where(['firstFakeMsg' => 0])->andWhere(['>=', 'created_at', 60 * 2])->all();
        $models = self::find()->all();
        $skirtumas = 10000;
        $id = null;
        $msg = null;
        $issiusta = [];

        foreach($users as $user){
            $amzius = \frontend\models\Misc::getAmzius($user->info->diena, $user->info->menuo, $user->info->metai);
            $iesko = substr($user->info->iesko, 1);

            foreach ($models as $model)
                if($model->lytis == $iesko)
                    if(abs($model->amzius - $amzius) < $skirtumas){
                        $skirtumas = abs($model->amzius - $amzius);
                        $id = $model->u_id;
                        $msg = $model->msg;
                    }

            $this->sendFfm($id, $msg, $user);
            $issiusta[] = [
                'siuntejas' => $id,
                'gavejas' => $user->username,
                'zinute' => $msg
            ];
        }

        echo "issiusta: <br>";
        foreach ($issiusta as $v){
            echo "siuntejas: ".$v['siuntejas']."; gavejas: ".$v['gavejas']."; zinute: ".$v['zinute'];
        }

    }


}
