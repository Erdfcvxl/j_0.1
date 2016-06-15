<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\InfoClear;
use yii\db\Query;

/**
 * UserSearch represents the model behind the search form about `frontend\models\User`.
 */
class RecommendedSearch extends User
{
    /**
     * @inheritdoc
     */
    public $is;
    public $na;
    public $vip;

    public $username;
    public $vyras;
    public $moteris;
    public $ugis1;
    public $ugis2;
    public $amzius1;
    public $amzius2;
    public $svoris1;
    public $svoris2;
    public $miestas;
    public $rs;
    public $ts;
    public $s;
    public $i;
    public $l;
    public $se;
    public $f;
    public $sl;
    public $tu;
    public $ve;
    public $ve2;

    public function rules()
    {
        return [
            [['id', 'role', 'status', 'activated', 'created_at', 'updated_at'], 'integer'],
            [['vip', 'tu','ve','ve2','se','f','sl','i', 'l', 'rs', 'ts', 's', 'miestas', 'svoris1', 'svoris2', 'amzius1', 'amzius2', 'ugis1', 'ugis2', 'moteris', 'vyras', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'vyras', 'moteris', 'email', 'reg_step', 'avatar', 'lastOnline'], 'safe'],
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
     */

    public function preLoad()
    {
        $this->avatar = 1;

        $user = Yii::$app->user->identity;
        $info = $user->info;
        $lytis = substr($info->iesko, 0, 1);

        /*
         *Orentacija
         *0-Bi
         *1-Hetero
         *2-Homo
         */
        if ($info->orentacija == null) {
            if ($info->iesko == "vm" || $info->iesko == "mm")
                $this->moteris = 1;
            else
                $this->vyras = 1;
        } else {
            if ($info->orentacija == 0) {
                if ($info->iesko == "vm" || $info->iesko == "mm")
                    $this->moteris = 1;
                else
                    $this->vyras = 1;
            }
            elseif ($info->orentacija == 1) {
                if ($lytis == "v") {
                    $this->moteris = 1;
                } else {
                    $this->vyras = 1;
                }
            } elseif ($info->orentacija == 2) {
                if ($lytis == "m") {
                    $this->moteris = 1;
                } else {
                    $this->vyras = 1;
                }
            }
        }

    }


    public function visokiefiltrai($query)
    {
        if($this->miestas != NULL){
            $query->andFilterWhere(['info.miestas' => $this->miestas-1]);
        }

        if($this->vyras == 1){
            $query->orFilterWhere(['IN', 'info.iesko', ['vv', 'vm']]);
        }

        if($this->moteris == 1){
            $query->orFilterWhere(['IN', 'info.iesko', ['mm', 'mv']]);
        }

        ///////////////////////////////////////////////////////////

        if (Yii::$app->user->identity->info->gimimoTS != 0)
            $query->OrderBy([new \yii\db\Expression('abs(info.gimimoTS - ' . Yii::$app->user->identity->info->gimimoTS . ') ASC')]);
        else
            $query->OrderBy([new \yii\db\Expression('abs(info.gimimoTS - 0) ASC')]);

        $query->andFilterWhere(['not', ['info.gimimoTS' => '0']]);



        if (\frontend\models\Info::find()->where(['u_id' => Yii::$app->user->identity->id])->one()->miestas != '')
            $zmogaus_miesto_id = \frontend\models\Info::find()->where(['u_id' => Yii::$app->user->identity->id])->one()->miestas;
        else
            $zmogaus_miesto_id = 0;

        $spindulys = 200;

        $zmogaus_miestas = \frontend\models\City::findOne($zmogaus_miesto_id);
        $miestu_query = yii\helpers\ArrayHelper::getColumn(\frontend\models\City::find()
            ->select(['id', '(6371 * 2 * ASIN(SQRT( POWER(SIN((' . $zmogaus_miestas->latitude . ' - [[latitude]]) * pi()/180 / 2), 2) + COS(' . $zmogaus_miestas->latitude . ' * pi()/180) * COS([[latitude]] * pi()/180) *POWER(SIN((' . $zmogaus_miestas->longitude . ' - [[longitude]]) * pi()/180 / 2), 2) ))) AS distance'])
            ->having('distance <= ' . $spindulys . '')
            ->orderBy('distance ASC')
            ->all(), 'id');

        $miestu_id = array_map('strval', $miestu_query);

        $query->andFilterWhere(['info.miestas' => $miestu_id]);
        $query->addorderBy([new \yii\db\Expression('FIELD (info.miestas, ' . implode(',', $miestu_id) . ')')]);



        $statusas = array();
        if($this->l){
            $statusas[] = 0;
        }
        if($this->tu){
            $statusas[] = 1;
        }
        if($this->i){
            $statusas[] = 2;
        }
        if($this->ve){
            $statusas[] = 3;
        }
        if($this->ve2){
            $statusas[] = 4;
        }

        if($statusas) {
//            $query->andFilterWhere(['IN', 'info.statusas', $statusas]);

            $statusu_id = array_map('strval', $statusas);

            $query->andFilterWhere(['info.statusas' => $statusu_id]);
            $query->addOrderBy([new \yii\db\Expression('FIELD (info.statusas, ' . implode(',', $statusu_id) . ')')]);

        }

        ////////////////////////////////////////////////////////////////


        $tikslas = array();

        if($this->rs){
            $tikslas[] = 0;
        }
        if($this->ts){
            $tikslas[] = 1;
        }
        if($this->se){
            $tikslas[] = 2;
        }
        if($this->f){
            $tikslas[] = 3;
        }
        if($this->sl){
            $tikslas[] = 4;
        }
        if($this->s){
            $tikslas[] = 5;
        }

        $tikslas[] = 6;

        if($tikslas) {
//            $query->andFilterWhere(['IN', 'info.tikslas', $tikslas]);

            $tikslu_id = array_map('strval', $tikslas);

            $query->andFilterWhere(['info.tikslas' => $tikslu_id]);
            $query->addOrderBy([new \yii\db\Expression('FIELD (info.tikslas, ' . implode(',', $tikslu_id) . ')')]);

        }


        if($this->avatar == 1){
        $query->andFilterWhere(['user.avatar'=>['jpg','png','gif']]);
    }

        if($this->lastOnline == 1){
            $query->andFilterWhere(['>', 'user.lastOnline', time() - (15 * 60)]);
        }

        if($this->vip == 1){
            $query->andFilterWhere(['user.vip'=> 1]);
        }


        $query->andFilterWhere(['not', ['user.id' => Yii::$app->user->id]]);

        return $query;

    }

    public function search($params)
    {
        $this->load($params);

        $query = UserPack::find()->joinWith(['info']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        $this->visokiefiltrai($query);


        return $dataProvider;

    }


}
