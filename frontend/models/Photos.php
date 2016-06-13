<?php

namespace frontend\models;

use Yii;
use yii\helpers\BaseFileHelper;
use Imagine\Gd\Imagine;

/**
 * This is the model class for table "photos".
 *
 * @property integer $id
 * @property integer $u_id
 * @property integer $pureName
 * @property integer $friendsOnly
 * @property integer $timestamp
 */
class Photos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'pureName', 'friendsOnly', 'profile', 'timestamp'], 'required'],
            [['u_id', 'friendsOnly', 'timestamp'], 'integer'],
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
            'pureName' => 'Pure Name',
            'friendsOnly' => 'Friends Only',
            'timestamp' => 'Timestamp',
        ];
    }

    public static function deleteProfileDir($id)
    {
        if(is_dir('uploads/'.$id.'/profile')) {
            BaseFileHelper::copyDirectory('uploads/' . $id . '/profile', 'uploads/' . $id);
            BaseFileHelper::removeDirectory('uploads/' . $id . '/profile');
            //fixas del erroro
            if (is_dir('uploads/' . $id . '/profile')) {
               unlink('uploads/' . $id . '/profile');
            }

        }
    }

    public static function getPhoto($pureName, $id)
    {
        if($model = self::find()->where(['pureName' => $pureName])->andWhere(['u_id' => $id])->one())
            return $model;
        else{
            $model = new self;
            $model->u_id = $id;
            $model->pureName = $pureName;
            $model->friendsOnly = 0;
            $model->timestamp = time();
            $model->save();

            return $model;
        }
    }

    public function lock($pureName)
    {

        if($model = self::find()->where(['pureName' => $pureName])->one()){
            $model->friendsOnly = ($model->friendsOnly) ? 0 : 1;

            $model->save();

            return true;
        }else{
            $this->u_id = Yii::$app->user->id;
            $this->pureName = $pureName;
            $this->friendsOnly = 1;
            $this->timestamp = time();
            $this->save();

            return true;
        }
    }

    public function rotate($pureName)
    {
        if($model = self::find()->where(['pureName' => $pureName])->one()) {
            echo "dirba na";

            $imagine = new Imagine();

            $fulllink = 'uploads/' . Yii::$app->user->id . '/BFl' . $model->pureName . 'EFl' . Yii::$app->user->id . '.' . $model->ext;

            $imagine->open($fulllink)
                ->rotate(90)
                ->save($fulllink);

            $fulllink = 'uploads/' . Yii::$app->user->id . '/BTh' . $model->pureName . 'ETh' . Yii::$app->user->id . '.' . $model->ext;

            $imagine->open($fulllink)
                ->rotate(90)
                ->save($fulllink);

            return true;
        }
    }

    public function deletePhoto($pureName, $id)
    {
        $filter = new FilterFileName;
        $filter->extract($pureName, $id);
        $Fl = $filter->getFullFl();
        $Th = $filter->getFullTh();

        if($Fl)
            unlink('uploads/'.$id.'/'.$Fl);

        if($Th)
            unlink('uploads/'.$id.'/'.$Th);

        $model = self::getPhoto($pureName, $id);
        $model->delete();

    }


}
