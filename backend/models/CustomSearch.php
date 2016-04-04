<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\UserPack;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class CustomSearch extends UserPack
{

    public function CustomSearch($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 24,
            ]
        ]);

        $this->load($params);

        $query->andFilterWhere(['username' => $this->username]);

        return $dataProvider;
    }
    
}
