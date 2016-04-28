<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "fake_msg".
 *
 * @property string $gavejas
 * @property string $zinuciu_skc
 * @property integer $gavejo_id
 */
class FakeMsg extends \yii\db\ActiveRecord
{

    public $username;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fake_msg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gavejas', 'gavejo_id'], 'safe'],
            [['zinuciu_skc', 'gavejo_id'], 'integer'],
            [['gavejas'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gavejas' => 'Gavejas',
            'zinuciu_skc' => 'Zinuciu Skc',
            'gavejo_id' => 'Gavejo ID',
        ];
    }

    public function populate()
    {
        if(isset($_GET['username']))
            $this->username = $_GET['username'];
    }

    public function search($params)
    {
        $this->populate();

        $select = ['c.reciever as gavejas', 'c.sVip' ,'u.username as username', 'count(u.id) as sent_messages'];

        $query = new Query;
        $query->select($select)
            ->from('chat AS c')
            ->join('LEFT JOIN', 'user AS u', 'c.reciever = u.id')
            ->where(['u.f' => 1])
            ->andWhere(['not', ['newID' => 0]])
            ->orderBy(['sent_messages'=>SORT_DESC])
            ->groupBy(['u.id'])
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'u.username', $this->username]);

        if(isset($_GET['svip'])) {
            $query->andFilterWhere(['c.sVip' => 1]);
        }else{
            $query->andFilterWhere(['c.sVip' => 0]);
        }

        if(isset($_GET['sent'])) {
            $created_at = explode(" - ", $_GET['sent']);

            if(count($created_at) == 2) {
                $created_at_start = strtotime($created_at[0]);
                $created_at_end = strtotime($created_at[1]);

                $query->andFilterWhere(['between', 'c.timestamp', $created_at_start, $created_at_end]);
            }
        }

        return $dataProvider;
    }
}
