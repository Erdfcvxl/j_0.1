<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "friends".
 *
 * @property integer $id
 * @property integer $u_id
 * @property string $friends
 */
class Friends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'u_id', 'friends'], 'safe'],
            [['id', 'u_id'], 'integer']
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
            'friends' => 'Friends',
        ];
    }

    public static function arDraugas($id)
    {
        $friend = ($temp = Friends::find()->select('friends')->where(['u_id' => Yii::$app->user->id])->one())? $temp->friends : '';

        $friend_id = explode(' ', $friend);

        return array_search($id, $friend_id);
    }

    public static function isNew()
    {
        if($friends = Friends::find()->where(['u_id' => Yii::$app->user->id])->andWhere(['>','new',0])->one()){
            return $friends->new;
        }else{
            return null;
        }        
    }
}
