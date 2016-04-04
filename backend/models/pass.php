<?php

namespace backend\models;

class pass extends \yii\base\Model
{
    public $password;
    public $days;

    public function rules()
    {
        return [
            ['password', 'check', 'skipOnEmpty' => false, ],
            ['days', 'safe']
        ];
    }

    public function check($attribute, $params)
    { 
        if ($this->$attribute != "pridedu") {
            $this->addError(false, 'wrong pass');
        }
    }
}