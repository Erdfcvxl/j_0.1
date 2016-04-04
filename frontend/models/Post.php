<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $forum_id
 * @property integer $u_id
 * @property string $text
 * @property integer $timestamp
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['forum_id', 'text'], 'safe'],
            [['forum_id', 'timestamp'], 'integer'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'forum_id' => 'Forum ID',
            'u_id' => 'U ID',
            'text' => 'Text',
            'timestamp' => 'Timestamp',
        ];
    }

    public function atsakyti()
    {
        if($this->validate()){
            $model = new Post;
            $model->forum_id = $this->forum_id;
            $model->u_id = Yii::$app->user->id;
            $model->text = $this->text;
            $model->timestamp = time();
            $model->save();

            $forum = new Forum;

            $forumas = $forum->find()->where(['id' => $this->forum_id])->one();
            if($forumas->u_id != Yii::$app->user->id){
                $forumas->new++;
                $forumas->save(false);
            }
            


            return true;
        }else{
            return false;
        }
    }
}
