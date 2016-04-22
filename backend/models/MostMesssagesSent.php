<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

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
            [['user_id'], 'integer']
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
        $select = ['c.sender', 'u.username', 'count(u.id) as sent_messages'];

        $query = new Query;
        $query->select($select)
            ->from('chat AS c')
            ->join('LEFT JOIN', 'user AS u', 'c.sender = u.id')
            ->orderBy(['sent_messages'=>SORT_DESC])
            ->groupBy(['c.sender'])
        ;

        //$query = MostMesssagesSent::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->username,]);

        if(isset($_GET['sent'])) {
            $created_at = explode(" - ", $_GET['sent']);
            $created_at_start = strtotime($created_at[0]);
            $created_at_end = strtotime($created_at[1]);

            $query->andFilterWhere(['between', 'c.timestamp', $created_at_start, $created_at_end]);
        }

        return $dataProvider;

    }
}
