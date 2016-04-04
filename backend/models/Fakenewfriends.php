<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "fakenewfriends".
 *
 * @property string $username
 * @property integer $new_friends
 */
class Fakenewfriends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fakenewfriends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'new_friends'], 'safe'],
            [['new_friends'], 'integer'],
            [['username'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'new_friends' => 'New Friends',
        ];
    }

    public function search($params)
    {
        $query = Fakenewfriends::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
