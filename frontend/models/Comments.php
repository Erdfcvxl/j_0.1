<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $u_id
 * @property integer $commented_on
 * @property integer $commented_by
 * @property string $comment
 * @property integer $timestamp
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment'] , 'required', 'message' => ''],
            [['u_id', 'commented_on', 'commented_by', 'timestamp'], 'safe'],
            [['comment'], 'string']
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
            'commented_on' => 'Commented On',
            'commented_by' => 'Commented By',
            'comment' => 'Comment',
            'timestamp' => 'Timestamp',
        ];
    }
}
