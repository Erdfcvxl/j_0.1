<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $password
 * @property integer $createdAt
 * @property integer $role
 */
class Users extends \yii\db\ActiveRecord
{
    public $password2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password'], 'required'],
            [['createdAt', 'role'], 'integer'],
            [['password'], 'string', 'max' => 225],
            [['firstFour'], 'string', 'max' => 4],
            [['password2'], 'string', 'length' => [4, 40]],
            ['password2', 'compare', 'compareAttribute'=>'password'],
            ['password2', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'password' => 'Password',
            'createdAt' => 'Created At',
            'role' => 'Role',
        ];
    }
}
