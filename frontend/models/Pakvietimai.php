<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pakvietimai".
 *
 * @property integer $id
 * @property integer $sender
 * @property integer $reciever
 * @property integer $timestamp
 */
class Pakvietimai extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pakvietimai';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender', 'reciever', 'timestamp'], 'required'],
            [['sender', 'reciever', 'timestamp'], 'integer']
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
            'timestamp' => 'Timestamp',
        ];
    }
}
