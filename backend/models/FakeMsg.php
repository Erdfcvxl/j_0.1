<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "fake_msg".
 *
 * @property string $gavejas
 * @property string $zinuciu_skc
 * @property integer $gavejo_id
 */
class FakeMsg extends \yii\db\ActiveRecord
{
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

    public function search($params)
    {
        $query = FakeMsg::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'gavejas', $this->gavejas]);

        return $dataProvider;
    }
}
