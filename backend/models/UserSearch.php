<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{

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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     *  SELECT chat.sender AS user_id, count(user.id) AS sent_messages FROM chat, user WHERE chat.sender = user.id GROUP BY chat.sender ORDER BY sent_messages DESC 
     */


    public function boolas($query, $attr, $mysql)
    {
         if($this->$attr){
            if(strtolower($this->$attr) == 'taip'){
                $query->andFilterWhere([$mysql => 1]);
            }elseif(strtolower($this->$attr) == 'ne'){
                $query->andFilterWhere([$mysql => 0]);
            }
        }
    }

    public function search($params)
    {

        require(__DIR__ ."/../../frontend/views/site/form/_list.php");
        $query = User::find()
            ->select('user.*, info.miestas, info.gimimoTS, info.orentacija, info.iesko')
            ->joinWith('info2');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => (isset($_GET['ps']))? $_GET['ps'] : 30,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                    'username' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'valiuta' => $this->valiuta,
            'role' => $this->role,
            'status' => $this->status,
            'profileVisits' => $this->profileVisits,
            'activated' => $this->activated,
            'updated_at' => $this->updated_at,
            'lastOnline' => $this->lastOnline,
            'new' => $this->new,
            'newDone' => $this->newDone,
            'adminChat' => $this->adminChat,
            'facebook' => $this->facebook,
            'photoLimit' => $this->photoLimit,
            'firstMsg' => $this->firstMsg,
        ]);

        $this->boolas($query, 'f', 'f');
        $this->boolas($query, 'vip', 'vip');




        //Amzius iki filtras
        if($this->gimimoTS){
        $gimimoTS = time() - ($this->gimimoTS + 1) * 31556952;
            $gimimoTS_end = time() - ($this->gimimoTS) * 31556952;

            $query->andFilterWhere(['between', 'gimimoTS', $gimimoTS, $gimimoTS_end]);
        }


        //Lytis iki filtras
        $array = [
            'moteris' => ['mm', 'mv'],
            'vyras' => ['vv', 'vm'],
            'Moteris' => ['mm', 'mv'],
            'Vyras' => ['vv', 'vm'],
        ];

        $lytis = array_key_exists($this->iesko, $array);

        if(array_key_exists($this->iesko, $array)){
            $query->andFilterWhere(['iesko' => $array[$this->iesko]]);
        }else{
            $this->iesko = null;
        }

        //Orentacija filtras
        if(array_search($this->orentacija, $orentacija) !== false){
            $key = array_search($this->orentacija, $orentacija);
            $query->andFilterWhere(['orentacija' => $key]);
        }else{
            $this->orentacija = null;
        }

        //fake filtras
        if($this->f == "taip"){
            $query->andFilterWhere(['f' => 1]);
        }elseif($this->f == "taip"){
            $query->andFilterWhere(['f' => 0]);
        }
        
        /*
        if(array_key_exists($this->iesko, $array)){
            $query->andFilterWhere(['iesko' => $array[$this->iesko]]);
        }else{
            $this->iesko = null;
        }*/


        //Galioja iki filtras
        if(!empty($this->expires)){
            $expires = explode(" - ", $this->expires);
            $expires_start = strtotime($expires[0]);
            $expires_end = strtotime($expires[1]);

            $query->andFilterWhere(['between', 'expires', $expires_start, $expires_end]);
        }

        //Uzsiregistravo filtras
        if(!empty($this->created_at)){
            $created_at = explode(" - ", $this->created_at);
            $created_at_start = strtotime($created_at[0]);
            $created_at_end = strtotime($created_at[1]);

            $query->andFilterWhere(['between', 'created_at', $created_at_start, $created_at_end]);
        }

        

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'reg_step', $this->reg_step])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'fb_id', $this->fb_id])
            ->andFilterWhere(['like', 'msgEmailNot', $this->msgEmailNot]);

        return $dataProvider;
    }
}
