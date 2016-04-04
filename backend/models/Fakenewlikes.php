<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "fakenewlikes".
 *
 * @property string $username
 * @property string $new_likes
 * @property string $o_info
 */
class Fakenewlikes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fakenewlikes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'o_info'], 'safe'],
            [['new_likes'], 'integer'],
            [['o_info'], 'string'],
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
            'new_likes' => 'New Likes',
            'o_info' => 'O Info',
        ];
    }

    public function search($params)
    {
        $query = Fakenewlikes::find();

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
