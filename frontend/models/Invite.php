<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "invite".
 *
 * @property integer $id
 * @property string $code
 * @property integer $sender
 * @property integer $receiver
 * @property integer $created_timestamp
 * @property integer $registered_timestamp
 * @property integer $points_added
 * @property integer $points_spent
 */
class Invite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'sender', 'created_timestamp'], 'required'],
            [['sender', 'created_timestamp', 'points_added', 'points_spent'], 'integer'],
            [['code'], 'string', 'max' => 225]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'sender' => 'Sender',
            'receiver' => 'Receiver',
            'created_timestamp' => 'Created Timestamp',
            'registered_timestamp' => 'Registered Timestamp',
            'points_added' => 'Points Added',
            'points_spent' => 'Points Spent',
        ];
    }
}
