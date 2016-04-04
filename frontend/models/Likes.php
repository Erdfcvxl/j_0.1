<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $photo_name
 * @property integer $givenBy
 * @property integer $timesstamp
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'likes';
    }

    public $username;
    public $gimimoTS;
    public $miestas;
    public $u_id;
    public $lastOnline;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'photo_name', 'givenBy', 'timestamp', 'username'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'photo_name' => 'Photo Name',
            'givenBy' => 'Given By',
            'timestamp' => 'Timestamp',
        ];
    }

    public function getInfo2()
    {
        return $this->hasMany(Info::className(), ['u_id' => 'user_id']);
    }

    public function getUser()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id']);
    }

    

    public static function getLikes($Flname, $Thname)
    {
        if($Flname){
            $likes = Likes::find()->where(['photo_name' => $Flname])->all();
        }else{
            $likes = Likes::find()->where(['photo_name' => $Thname])->all();
        }
        
        return $likes;
    }

    public static function arMegstu($Flname, $Thname)
    {
        if($Flname){
            $likes = Likes::find()->where(['photo_name' => $Flname])->andWhere(['givenBy' => Yii::$app->user->id])->all();
        }else{
            $likes = Likes::find()->where(['photo_name' => $Thname])->andWhere(['givenBy' => Yii::$app->user->id])->all();
        }
        
        return ($likes)? true : false;
    }


}

