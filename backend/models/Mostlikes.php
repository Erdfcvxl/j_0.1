<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mostlikes".
 *
 * @property integer $user_id
 * @property string $num_of_likes
 * @property string $photo_name
 */
class Mostlikes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mostlikes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'photo_name'], 'required'],
            [['user_id', 'num_of_likes'], 'integer'],
            [['photo_name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'num_of_likes' => 'Num Of Likes',
            'photo_name' => 'Photo Name',
        ];
    }
}
