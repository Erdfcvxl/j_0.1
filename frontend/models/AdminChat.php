<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "adminchat".
 *
 * @property integer $id
 * @property integer $u_id
 * @property string $msg
 * @property integer $timestamp
 */
class AdminChat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adminchat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'msg', 'timestamp'], 'required'],
            [['u_id', 'timestamp'], 'integer'],
            [['msg'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u_id' => 'U ID',
            'msg' => 'Msg',
            'timestamp' => 'Timestamp',
        ];
    }
}
