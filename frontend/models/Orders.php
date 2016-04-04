<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $u_id
 * @property string $action
 * @property string $params
 * @property integer $time
 * @property integer $done
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'action', 'params', 'time'], 'required'],
            [['u_id', 'time', 'done'], 'integer'],
            [['action', 'params'], 'string', 'max' => 225],
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
            'action' => 'Action',
            'params' => 'Params',
            'time' => 'Time',
            'done' => 'Done',
        ];
    }
}
