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
        $ids = null;

        if($this->username){
            $users = User::find()->select('id')->where(['like', 'username', $this->username])->all();

            foreach ($users as $user){
                $ids['user'][] = $user->id;
            }

            $array_diff = $ids['user'];

        }

        if(isset($_GET['f']) && isset($_GET['f']) == 'new' ){
            $chatnot = Chatnot::find()->where(['reciever' => Yii::$app->user->id])->andWhere(['newID' => Yii::$app->user->id])->all();

            foreach ($chatnot as $v){
                $ids['chatnot'][] = $v->sender;

                $array_diff = $ids['chatnot'];
            }
        }

        if(isset($ids['chatnot']) && isset($ids['user'])){
            $full_array = array_merge($ids['user'], $ids['chatnot']);
            $array_unique = array_unique($full_array);
            $array_diff = array_diff_assoc($full_array, $array_unique);
        }




        if($ids)
            $query->andFilterWhere(['and', ['u1' => $array_diff, 'u2' => Yii::$app->user->id]])
                ->orFilterWhere(['and', ['u1' => Yii::$app->user->id, 'u2' => $array_diff]]);
        
        return $dataProvider;

    }
}
