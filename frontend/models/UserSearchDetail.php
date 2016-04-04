<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\User;
use frontend\models\InfoClear;
use yii\db\Query;

/**
 * UserSearch represents the model behind the search form about `frontend\models\User`.
 */
class UserSearchDetail extends User
{
    /**
     * @inheritdoc
     */
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
    public $drajonas;
    public $grajonas;
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

    public $isData;
    public $metai;
    public $menuo;
    public $diena;
    public $gimtine;
    public $tautybe;
    public $religija;
    public $statusas;
    public $issilavinimas;
    public $pareigos;
    public $uzdarbis;
    public $orentacija;
    public $tautybe2;
    public $religija2;
    public $pareigos2;
    public $tikslas;

    public $sudejimas;
    public $plaukai;
    public $plaukai2;
    public $akys;
    public $akys2;
    public $stilius;
    public $stilius2;

    public $religijacomplete;
    public $pareigoscomplete;
    public $plaukaicomplete;
    public $akyscomplete;
    public $stiliuscomplete;

    public function rules()
    {
        return [
            [['id', 'role', 'status', 'activated', 'created_at', 'updated_at', 'vip'], 'integer'],
            [['grajonas','drajonas','tu','ve','ve2','se','f','sl','stiliuscomplete','akyscomplete','plaukaicomplete','pareigoscomplete', 'religijacomplete', 'stilius2', 'stilius', 'sudejimas', 'akys', 'akys2', 'plaukai2', 'plaukai', 'sudejimas', 'tautybe2', 'pareigos2', 'religija2', 'metai', 'menuo', 'diena', 'issilavinimas', 'gimtine' , 'tautybe' , 'religija', 'statusas', 'pareigos', 'uzdarbis', 'orentacija', 'tikslas','i', 'l', 'rs', 'ts', 's', 'miestas', 'svoris1', 'svoris2', 'amzius1', 'amzius2', 'ugis1', 'ugis2', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'vyras', 'moteris', 'email', 'reg_step', 'avatar', 'lastOnline'], 'safe'],
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

    public function infosearch($select, $from, $what, $additional)
    {
        $queryInfo = InfoClear::find();

        $complete = array();

        $queryInfo->select($select)
                  ->andFilterWhere([$from => $what]);
        $command = $queryInfo->createCommand();
        $dataInfo = $command->queryAll();
        foreach ($dataInfo as $key) {
            foreach ($key as $stringValue) {
                $complete[] = $stringValue;
            }
        }

        $complete = ($complete)? $complete : "nera";
        return $complete;
    }

    public function infosearchtwo($select, $from, $what, $what2)
    {
        $queryInfo = InfoClear::find();

        $complete = array();

        $what = (int)$what;
        $what2 = (int)$what2;

        $queryInfo->select($select)
                  ->andFilterWhere(['between', $from, $what, $what2]);
        $command = $queryInfo->createCommand();
        $dataInfo = $command->queryAll();

        foreach ($dataInfo as $key) {
            foreach ($key as $stringValue) {
                $complete[] = $stringValue;
            }
        }
        $complete = ($complete)? $complete : "nera";
        return $complete;
    }

    public function infosearchamzius($y, $y2)
    {
        $queryInfo = InfoClear::find();

        $complete = array();

        $queryInfo->select('u_id')
                  ->andFilterWhere(['<=', 'gimimoTS', $y])
                  ->andFilterWhere(['>=', 'gimimoTS', $y2]);
        $command = $queryInfo->createCommand();
        $dataInfo = $command->queryAll();

       foreach ($dataInfo as $key) {
            foreach ($key as $stringValue) {
                $complete[] = $stringValue;
            }
        }

        $complete = ($complete)? $complete : "nera";
        return $complete;
    }

    public function which($index)
    {
        if($this->{$index."complete"}){
            $value = $this->{$index."complete"};
        }else{
            $value = $this->{$index."2"};
            $this->$index = "";
        }

        return $value;
    }

    public function quick($theneed)
    {
        $queryInfo = InfoClear::find();

        $complete = array();

        $religija = $this->which('religija');
        $pareigos = $this->which('pareigos');
        $plaukai = $this->which('plaukai');
        $akys = $this->which('akys');
        $stilius = $this->which('stilius');

        $queryInfo->select('u_id')
                  ->andFilterWhere(['metai' => $this->metai])
                  ->andFilterWhere(['diena' => $this->diena])
                  ->andFilterWhere(['menuo' => $this->menuo])
                  ->andFilterWhere(['gimtine' => $this->gimtine])
                  ->andFilterWhere(['tautybe' => $this->tautybe])
                  ->andFilterWhere(['religija' => $religija])
                  ->andFilterWhere(['statusas' => $this->statusas])
                  ->andFilterWhere(['issilavinimas' => $this->issilavinimas])
                  ->andFilterWhere(['pareigos' => $pareigos])
                  ->andFilterWhere(['uzdarbis' => $this->uzdarbis])
                  ->andFilterWhere(['orentacija' => $this->orentacija])
                  ->andFilterWhere(['sudejimas' => $this->sudejimas])
                  ->andFilterWhere(['plaukai' => $plaukai])
                  ->andFilterWhere(['akys' => $akys])
                  ->andFilterWhere(['stilius' => $stilius])
                  ->andFilterWhere(['tikslas' => $this->tikslas]);
        $command = $queryInfo->createCommand();
        $dataInfo = $command->queryAll();
        foreach ($dataInfo as $key) {
            foreach ($key as $stringValue) {
                $complete[] = $stringValue;
            }
        }

        return $complete;
    }

    public function search($params)
    {

        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 18,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        

        /* kairieji pasirinkimai */
        if($this->vyras == 1 && $this->moteris == 0){
            $values = $this->infosearch('u_id', 'iesko', ['vv', 'vm'], '');
            if($values){
                $query->andFilterWhere(['id'=> $values]);
            }
        }elseif($this->vyras == 0 && $this->moteris == 1){
            $values = $this->infosearch('u_id', 'iesko', ['mm', 'mv'], '');
            if($values){
                $query->andFilterWhere(['id'=> $values]);
            }
        }

        require_once('../views/site/form/_list.php');

        if($this->amzius1 && is_numeric($this->amzius1)){
            $minMetai = time() - ($this->amzius1 * 31556952);

            if($this->amzius2 && is_numeric($this->amzius2)){
                $maxMetai = time() - $this->amzius2 * 31556952 - 31556951;

                if($this->amzius1 < $this->amzius2){
                    $values = $this->infosearchamzius($minMetai, $maxMetai);
                    $query->andFilterWhere(['id'=> $values]);
                }else{
                    $values = $this->infosearchamzius($maxMetai, $minMetai);
                    $query->andFilterWhere(['id'=> $values]);
                }
            }else{
                $values = $this->infosearchamzius($minMetai, '0');
                $query->andFilterWhere(['id'=> $values]);
            }
        }elseif($this->amzius2 && is_numeric ($this->amzius2)){
            $maxMetai = time() - $this->amzius2 * 31556952 - 31556951;

            $values = $this->infosearchamzius(time(), $maxMetai);
            $query->andFilterWhere(['id'=> $values]);
        }

        if($this->ugis1 || $this->ugis1 == '0'){
            if($this->ugis2 || $this->ugis2 == '0'){
                if($this->ugis1 < $this->ugis2){
                    $values = $this->infosearchtwo('u_id', 'ugis', $this->ugis1, $this->ugis2);
                    $query->andFilterWhere(['id'=> $values]);
                }else{
                    $values = $this->infosearchtwo('u_id', 'ugis', $this->ugis2, $this->ugis1);
                    $query->andFilterWhere(['id'=> $values]);
                }
            }else{
                $values = $this->infosearchtwo('u_id', 'ugis', $this->ugis1, 300);
                $query->andFilterWhere(['id'=> $values]);
            }
        }elseif($this->ugis2 || $this->ugis2 == '0'){
            $values = $this->infosearchtwo('u_id', 'ugis', 0, $this->ugis1);
            $query->andFilterWhere(['id'=> $values]);
        }

        if($this->svoris1 || $this->svoris1 == '0'){
            if($this->svoris2 || $this->svoris2 == '0'){
                if($this->svoris1 < $this->svoris2){
                    $values = $this->infosearchtwo('u_id', 'svoris', $this->svoris1, $this->svoris2);
                    $query->andFilterWhere(['id'=> $values]);
                }else{
                    $values = $this->infosearchtwo('u_id', 'svoris', $this->svoris2, $this->svoris1);
                    $query->andFilterWhere(['id'=> $values]);
                }
            }else{
                $values = $this->infosearchtwo('u_id', 'svoris', $this->svoris1, 300);
                $query->andFilterWhere(['id'=> $values]);
            }
        }elseif($this->svoris2 || $this->svoris2 == '0'){
            $values = $this->infosearchtwo('u_id', 'svoris', 0, $this->svoris2);
            $query->andFilterWhere(['id'=> $values]);
        }

        if($this->miestas != '0'){
            $values = $this->infosearch('u_id', 'miestas', ($this->miestas - 1), '');
            $query->andFilterWhere(['id'=> $values]);
        }


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
        if($this->rs && $this->ts && $this->se && $this->f && $this->sl && $this->s){
            $tikslas[] = 6;
        }

        if($tikslas){
            $values = $this->infosearch('u_id', 'tikslas', $tikslas, '');
            $query->andFilterWhere(['id'=> $values]);
        }else{
            $values = $this->infosearch('u_id', 'tikslas', 'nera', '');
            $query->andFilterWhere(['id'=> $values]);
        }


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
        if($statusas){
            $values = $this->infosearch('u_id', 'statusas', $statusas, '');
            $query->andFilterWhere(['id'=> $values]);
        }else{
            $values = $this->infosearch('u_id', 'statusas', 'nera', '');
            $query->andFilterWhere(['id'=> $values]);
        }



        if($this->l){
            if($this->i){
                $values = $this->infosearch('u_id', 'statusas', [0, 1, 2, 3, 4], '');
                $query->andFilterWhere(['id'=> $values]);
            }else{
                $values = $this->infosearch('u_id', 'statusas',[0, 1], '');
                $query->andFilterWhere(['id'=> $values]);
            }
        }elseif($this->i){
            $values = $this->infosearch('u_id', 'statusas', [2 ,3 , 4], '');
            $query->andFilterWhere(['id'=> $values]);
        }

        /* virsutiniai mygtukai */
        if($this->avatar == 1){
            $query->andFilterWhere(['avatar'=>['jpg','png','gif']]);
        }        
        
        if($this->lastOnline == 1){
            $query->andFilterWhere(['>', 'lastOnline', time() - (15 * 60)]);
        }

        /* detali */

        $values = $this->quick('statusas');
        if(!$values){
            $query->andFilterWhere(['id'=> '-']);
        }else{
            $query->andFilterWhere(['id'=> $values]);
        }

        $values = $this->infosearch('u_id', 'drajonas', $this->drajonas, '');
        $query->andFilterWhere(['id'=> $values]);

        $values = $this->infosearch('u_id', 'grajonas', $this->grajonas, '');
        $query->andFilterWhere(['id'=> $values]);


        $query->andFilterWhere(['like', 'username', $this->username])
              ->andFilterWhere(['not',['id' => Yii::$app->user->identity->id]]);

        return $dataProvider;
    }
}
