<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parametres".
 *
 * @property integer $id
 * @property integer $MailRegen
 * @property integer $MailLeft
 */
class Parametres extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parametres';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MailRegen', 'MailLeft'], 'required'],
            [['MailRegen', 'MailLeft'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'MailRegen' => 'Mail Regen',
            'MailLeft' => 'Mail Left',
        ];
    }
}
