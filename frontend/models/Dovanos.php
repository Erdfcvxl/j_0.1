<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "dovanos".
 *
 * @property integer $id
 * @property integer $sender
 * @property integer $reciever
 * @property string $object
 * @property integer $object_id
 * @property integer $opened
 * @property integer $time
 */
class Dovanos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dovanos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender', 'reciever', 'object', 'object_id', 'opened', 'time'], 'required'],
            [['sender', 'reciever', 'object_id', 'opened', 'time'], 'integer'],
            [['object'], 'string', 'max' => 225]
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
            'object' => 'Object',
            'object_id' => 'Object ID',
            'opened' => 'Opened',
            'time' => 'Time',
        ];
    }
}
