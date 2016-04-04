<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "nariai_miestuose".
 *
 * @property string $num_of_users
 * @property string $miestas
 */

//SQL
//CREATE VIEW nariai_miestuose AS SELECT count(u_id) as num_of_users, miestas FROM info WHERE miestas<>'' GROUP BY miestas
class NariaiMiestuose extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nariai_miestuose';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num_of_users'], 'safe'],
            [['miestas'], 'safe'],
            [['miestas'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'num_of_users' => 'Num Of Users',
            'miestas' => 'Miestas',
        ];
    }

    public function search($params)
    {
        $query = NariaiMiestuose::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        require(__DIR__ ."/../../frontend/views/site/form/_list.php");

        if(array_search($this->miestas, $list) !== false){
            $key = array_search($this->miestas, $list);
            $query->andFilterWhere(['miestas' => $key]);
        }else{
            $this->miestas = null;
        }
        
        if($this->num_of_users){
            $between = explode("-", $this->num_of_users);
            $query->andFilterWhere(['between', 'num_of_users', $between[0], $between[1]]);
        }

        return $dataProvider;
    }

}
