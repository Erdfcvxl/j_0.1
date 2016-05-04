<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserPack extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'email', 'message' => 'El. pašto adresas netinkamas.'],
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'safe'],
            [['role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Slapyvardis',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'El. paštas',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getInfo()
    {
        return $this->hasOne(InfoClear::className(), ['u_id' => 'id']);
    }

    public function getParams()
    {
        if(!\frontend\models\UserParams::find()->where(['u_id' => $this->id])->one()){
            $model = new \frontend\models\UserParams;
            $model->u_id = $this->id;
            $model->save();
        }

        return $this->hasOne(\frontend\models\UserParams::className(), ['u_id' => 'id']);
    }
}
