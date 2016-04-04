<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "most_messsages_sent".
 *
 * @property integer $user_id
 * @property string $sent_messages
 */
class MostMesssagesSent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'most_messsages_sent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'username'], 'safe'],
            [['user_id', 'sent_messages'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'sent_messages' => 'Sent Messages',
        ];
    }

    public function search($params)
    {
        $query = MostMesssagesSent::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'username' => $this->username,
        ]);

        $query->andFilterWhere([">=", 'sent_messages', $this->sent_messages]);

        return $dataProvider;

    }
}
