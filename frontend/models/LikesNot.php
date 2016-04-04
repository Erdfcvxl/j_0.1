<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "likesnot".
 *
 * @property integer $id
 * @property integer $u_id
 * @property integer $giver_id
 * @property string $object
 * @property integer $o_info
 * @property integer $timestamp
 */
class LikesNot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'likesnot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'giver_id', 'object', 'o_info', 'timestamp'], 'required'],
            [['u_id', 'giver_id', 'timestamp'], 'integer'],
            [['object', 'o_info'], 'string']
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
            'giver_id' => 'Giver ID',
            'object' => 'Object',
            'o_info' => 'O Info',
            'timestamp' => 'Timestamp',
        ];
    }

    static public function notification()
    {
        $not = LikesNot::find()->where(['u_id' => Yii::$app->user->id])->andWhere(['new' => 1])->all();

        return count($not);
    }
}
