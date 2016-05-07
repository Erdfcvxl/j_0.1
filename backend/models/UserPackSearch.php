<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\UserPack;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserPackSearch extends UserPack
{
    public $lytis;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'valiuta', 'role', 'status', 'profileVisits', 'activated', 'updated_at', 'lastOnline', 'new', 'newDone', 'adminChat', 'facebook', 'photoLimit', 'firstMsg'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'reg_step', 'avatar', 'fb_id', 'msgEmailNot'], 'safe'],
            [['expires', 'vip', 'created_at', 'gimimoTS', 'iesko', 'orentacija', 'f'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function VipSD()
    {
        $left = (isset($_GET['l']))? $_GET['l']: 3;


        $query = UserPack::find()->where(['vip' => 1])->andWhere(['<=', 'expires', time() + $left * 24 * 60 * 60]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => (isset($_GET['ps']))? $_GET['ps'] : 30,
            ],
            'sort'=> ['defaultOrder' => ['expires'=>SORT_ASC]],
        ]);

        return $dataProvider;
;    }
    
    public function getUsers($params)
    {
        var_dump($params);
    }

}
