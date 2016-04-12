<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "chatnot".
 *
 * @property integer $id
 * @property integer $sender
 * @property integer $reciever
 * @property integer $newID
 * @property integer $time
 */
class Chatnot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chatnot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender', 'reciever', 'newID', 'time'], 'required'],
            [['sender', 'reciever', 'newID', 'time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender' => 'Sender',
            'reciever' => 'Reciever',
            'newID' => 'New ID',
            'time' => 'Time',
        ];
    }

    static public function insertNot($r)
    {
        $model = new self;

        $model->sender = Yii::$app->user->id;
        $model->reciever = $r;
        $model->newID = $r;
        $model->time = time();
        $model->insert();
    }

    static public function insertNotGlobal($s, $r)
    {
        $model = new self;

        $model->sender = $s;
        $model->reciever = $r;
        $model->newID = $r;
        $model->time = time();
        $model->insert();
    }

    static public function remove($sender)
    {
        self::deleteAll('newID = :me AND sender = :sender', [':me' => Yii::$app->user->id, ':sender' => $sender]);

    }


}
