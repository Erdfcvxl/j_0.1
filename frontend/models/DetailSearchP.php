<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;
use frontend\models\UserPack;
use yii\db\Query;

class DetailSearchP extends UserPack
{
    //left filters
    public $username;
    public $vyras;
    public $moteris;
    public $amzius1;
    public $amzius2;
    public $ugis1;
    public $ugis2;
    public $svoris1;
    public $svoris2;
    public $miestas;
    public $rs;
    public $ts;
    public $se;
    public $f;
    public $sl;
    public $s;
    public $i;
    public $l;
    public $tu;
    public $ve;
    public $ve2;
    public $is;
    public $na;

    public $lastOnline;
    public $avatar;

    public $metai;
    public $menuo;
    public $diena;
    public $gimtine;
    public $tautybe;
    public $tautybe2;
    public $religija;
    public $religija2;
    public $statusas;
    public $orentacija;
    public $grajonas;
    public $drajonas;
    public $issilavinimas;
    public $pareigos;
    public $pareigos2;
    public $uzdarbis;
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


    public $search;
    public $atgal;

    public function rules()
    {
        return [
            [['username', 'vip', 'lastOnline', 'avatar', 'amzius1','amzius2','ugis1','ugis2','svoris1','svoris2','miestas','rs','ts','se','f','sl','s','i','l','tu','ve','ve2','is','na','vyras','moteris','metai','menuo','diena','gimtine','tautybe','tautybe2','religija','religija2','statusas','orentacija','grajonas','drajonas','issilavinimas','pareigos','pareigos2','uzdarbis','tikslas','sudejimas','plaukai','plaukai2','akys','akys2','stilius','stilius2','religijacomplete','pareigoscomplete','plaukaicomplete','akyscomplete','stiliuscomplete','search','atgal',], 'safe'],
        ];
    }

    public function preLoad()
    {
        $user = Yii::$app->user->identity;
        $info = $user->info;
        $lytis = substr($info->iesko, 0, 1);

        /*
         *Orentacija
         *0-Bi
         *1-Hetero
         *2-Homo
         */

        if($info->orentacija == 1){
            if($lytis == "v"){
                $this->moteris = 1;
            }else{
                $this->vyras = 1;
            }
        }elseif ($info->orentacija == 2) {
            if($lytis == "m"){
                $this->vyras = 1;
            }else{
                $this->moteris = 1;
            }
        }
    }

    public function getTikslas()
    {
        $tikslas = [];

        if($this->rs)
            $tikslas[] = 0;
        if($this->ts)
            $tikslas[] = 1;
        if($this->se)
            $tikslas[] = 2;
        if($this->f)
            $tikslas[] = 3;
        if($this->sl)
            $tikslas[] = 4;
        if($this->s)
            $tikslas[] = 5;
        if(count($tikslas) == 6)
            $tikslas[] = 6;

        return $tikslas;
    }

    public function getStatusas()
    {
        $statusas = [];

        if($this->i)
            $statusas[] = 2;
        if($this->l)
            $statusas[] = 0;
        if($this->tu)
            $statusas[] = 1;
        if($this->ve)
            $statusas[] = 3;
        if($this->ve2)
            $statusas[] = 4;
        if($this->is)
            $statusas[] = 5;
        if($this->na)
            $statusas[] = 6;

        return $statusas;
    }

    public function leftFilters($query)
    {
        $query->filterWhere(['like', 'username', $this->username]);

        if(!($this->vyras && $this->moteris)){
            if($this->vyras)
                $query->andFilterWhere(['info.iesko' => ['vv', 'vm']]);

            if($this->moteris)
                $query->andFilterWhere(['info.iesko' => ['mm', 'mv']]);
        }

        if($this->amzius1 && $this->amzius2){
            $a1 = time() - $this->amzius1 * 8760 * 3600;
            $a2 = time() - ($this->amzius2 + 1) * 8760 * 3600;
            $query->andFilterWhere(['between', 'info.gimimoTS', $a2, $a1]);
        }elseif($this->amzius1){
            $a1 = time() - $this->amzius1 * 8760 * 3600;
            $query->andFilterWhere(['<=', 'info.gimimoTS', $a1]);
        }elseif($this->amzius2){
            $a2 = time() - $this->amzius2 * 8760 * 3600;
            $query->andFilterWhere(['>=', 'info.gimimoTS', $a2]);
        }

        $query->andFilterWhere(['between', 'info.ugis', (int)$this->ugis1, (int)$this->ugis2])
            ->andFilterWhere(['between', 'info.svoris', (int)$this->svoris1, (int)$this->svoris2]);

        if($this->miestas - 1 >= 0)
            $query->andFilterWhere(['info.miestas' => $this->miestas - 1]);


        $query->andFilterWhere(['info.tikslas' => $this->getTikslas()]);

        $query->andFilterWhere(['info.statusas' => $this->getStatusas()]);

        if($this->lastOnline)
            $query->andFilterWhere(['>=', 'lastOnline', time() - 600]);

        if($this->avatar)
            $query->andFilterWhere(['avatar' => ['jpg', 'jpeg', 'gif', 'png', 'raw', 'tif']]);

        if($this->vip)
            $query->andFilterWhere(['vip' => 1]);



        $query->andFilterWhere(['not', ['user.id' => Yii::$app->user->id]]);

        return $query;
    }

    public function detailFilters($query)
    {

        if($this->diena || $this->menuo || $this->metai)
            $query->andFilterWhere(['diena' => $this->diena])
                ->andFilterWhere(['menuo' => $this->menuo])
                ->andFilterWhere(['metai' => $this->metai]);

        $query->andFilterWhere(['gimtine' => $this->gimtine]);

        if($this->gimtine == 126){
            $query->andFilterWhere(['tautybe' => $this->tautybe]);
        }else{
            $query->andFilterWhere(['like', 'tautybe', $this->tautybe2]);
        }

        if($this->religija == 9 || $this->religija2 != ''){
            $query->andFilterWhere(['like', 'religija', $this->religija2]);
        }else{
            $query->andFilterWhere(['religija' => $this->religija]);
        }

        $query->andFilterWhere(['statusas' => $this->statusas]);
        $query->andFilterWhere(['issilavinimas' => $this->issilavinimas]);

        if($this->pareigos == 25 && $this->pareigos2 != ''){
            $query->andFilterWhere(['like', 'pareigos', $this->pareigos2]);
        }else{
            $query->andFilterWhere(['pareigos' => $this->pareigos]);
        }

        $query->andFilterWhere(['uzdarbis' => $this->uzdarbis]);
        $query->andFilterWhere(['orentacija' => $this->orentacija]);
        $query->andFilterWhere(['tikslas' => $this->tikslas]);

        $query->andFilterWhere(['sudejimas' => $this->sudejimas]);

        if($this->plaukai == 9 && $this->plaukai2 != ''){
            $query->andFilterWhere(['like', 'plaukai', $this->plaukai2]);
        }else{
            $query->andFilterWhere(['plaukai' => $this->plaukai]);
        }

        if($this->akys == 9 && $this->akys2 != ''){
            $query->andFilterWhere(['like', 'akys', $this->akys2]);
        }else{
            $query->andFilterWhere(['akys' => $this->akys]);
        }
        
        if($this->stilius == 17 && $this->stilius2 != ''){
            $query->andFilterWhere(['like', 'stilius', $this->stilius2]);
        }else{
            $query->andFilterWhere(['stilius' => $this->stilius]);
        }



        return $query;
    }

    public function search($params)
    {
        $this->load($params);
        
        $query = UserPack::find()->joinWith(['info']);;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 18,
            ],
        ]);

        $this->leftFilters($query);
        $this->detailFilters($query);

        return $dataProvider;
                
    }


}
