<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "welcome".
 *
 * @property integer $u_id
 * @property string $lytis
 * @property string $orentacija
 * @property integer $amzius
 * @property string $msg
 */
class Welcome extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'welcome';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'lytis', 'orentacija', 'amzius'], 'required'],
            [['u_id', 'amzius'], 'integer'],
            [['msg'], 'string'],
            [['lytis'], 'string', 'max' => 1],
            [['orentacija'], 'string', 'max' => 225],
            [['u_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'u_id' => 'U ID',
            'lytis' => 'Lytis',
            'orentacija' => 'Orentacija',
            'amzius' => 'Amzius',
            'msg' => 'Msg',
        ];
    }
    
    public function addToGame($id)
    {
        $model = \frontend\models\UserPack::find()->where(['id' => $id])->one();

        if(!self::find()->where(['u_id' => $id])->one()) {
            $this->u_id = $model->id;
            $this->lytis = substr($model->info->iesko, 0, 1);
            $this->orentacija = $model->info->orentacija;
            $this->amzius = \frontend\models\Misc::getAmzius($model->info->diena, $model->info->menuo, $model->info->metai);

            if($this->save())
                return true;
        }else{
            Yii::$app->session->setFlash('warning', 'Šis narys jau pridėtas');

            return true;
        }

        var_dump($this->getErrors());
        return false;

    }
}
