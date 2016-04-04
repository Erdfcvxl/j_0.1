<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "checkedforums".
 *
 * @property integer $id
 * @property integer $u_id
 * @property integer $forum_ids
 */
class CheckedForums extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'checkedforums';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'u_id', 'forum_ids'], 'required'],
            [['id', 'u_id', 'forum_ids'], 'integer']
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
            'forum_ids' => 'Forum Ids',
        ];
    }

    static public function isChecked($id)
    {
        if($check = CheckedForums::find()->where(['u_id' => Yii::$app->user->id])->one()):
            $ids = explode(' ', $check->forum_ids);

            if(array_search($id, $ids) !== false){
                return true;
            }else{
                return false;
            }

        else: 

            return false;

        endif;
    }
}
