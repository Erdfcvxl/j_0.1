<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "userparams".
 *
 * @property integer $u_id
 * @property integer $profileview_check
 */
class UserParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userparams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id'], 'required'],
            [['u_id', 'profileview_check'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'u_id' => 'U ID',
            'profileview_check' => 'Profileview Check',
        ];
    }
}
