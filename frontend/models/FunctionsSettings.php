<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "functions".
 *
 * @property integer $id
 * @property string $name
 * @property integer $on
 */
class FunctionsSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'functions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'on'], 'required'],
            [['name'], 'string'],
            [['on'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'on' => 'On',
        ];
    }
}
