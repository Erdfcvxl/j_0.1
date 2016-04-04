<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "statistics".
 *
 * @property integer $u_id
 * @property integer $likes
 * @property integer $msg_sent
 * @property integer $msg_recieved
 * @property integer $actions
 * @property integer $forum
 */
class Statistics extends \yii\db\ActiveRecord
{
    public $record;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statistics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'likes', 'msg_sent', 'msg_recieved', 'actions', 'forum', 'p'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'u_id' => 'U ID',
            'likes' => 'Likes',
            'msg_sent' => 'Msg Sent',
            'msg_recieved' => 'Msg Recieved',
            'actions' => 'Actions',
            'forum' => 'Forum',
        ];
    }

    public function findRecord($u)
    {
        if($record = self::find()->where(['u_id' => $u])->one())
            return $this->record = $record;
        

        $model = new self;
        $model->u_id = $u;
        $model->insert(false);
        
        return $this->record = $model;
    }

    static public function addView($u)
    {
        $model = new self;
        $model->findRecord($u);

        $model->record->profile_visits += 1;
        $model->record->p += 1;
        $model->record->save(false);

        self::addAction();
    }

    static public function addLike($u)
    {
        $model = new self;
        $model->findRecord($u);

        $model->record->likes += 1;
        $model->record->p += 1;
        $model->record->save(false);

        self::addAction();

    }

    static public function addSent()
    {
        $model = new self;
        $model->findRecord(Yii::$app->user->id);

        $model->record->msg_sent += 1;
        $model->record->save(false);

    }

    static public function addRecieved($u)
    {
        $model = new self;
        $model->findRecord($u);

        $model->record->msg_recieved += 1;
        $model->record->p += 1;
        $model->record->save(false);

    }

    static public function addAction()
    {
        $model = new self;
        $model->findRecord(Yii::$app->user->id);

        $model->record->actions += 1;
        $model->record->save(false);

    }
}
