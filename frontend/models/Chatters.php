<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "chatters".
 *
 * @property integer $id
 * @property integer $u1
 * @property integer $u2
 * @property integer $lastMsg
 */
class Chatters extends \yii\db\ActiveRecord
{
    public $username;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chatters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u1', 'u2', 'timestamp'], 'safe'],
            [['u1', 'u2', 'timestamp'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u1' => 'U1',
            'u2' => 'U2',
            'lastMsg' => 'Last Msg',
        ];
    }


    public function searchPokalbiai($params)
    {

        $query = self::find()->where(['u1' => Yii::$app->user->id])->orWhere(['u2' => Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 7,
            ],
            'sort' => [
                'defaultOrder' => [
                    'timestamp' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        $query->filterWhere(['like', 'username1', $this->username])->orFilterWhere(['like', 'username2', $this->username]);

        return $dataProvider;

    }
}
