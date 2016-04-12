<?php

namespace backend\models;

use Yii;
use frontend\models\Chat;
use frontend\models\UserPack;
use frontend\models\User;
use frontend\models\Statistics;
use frontend\models\Chatnot;


class MM
{

    public $sender;//
    public $lytis;
    public $method;
    public $recievers;//
    public $msg;//
    public $publika;

    public function convertToKeys($n, $list)
    {
        $newGroup = null;

        foreach ($n as $name)
            foreach ($list as $k => $v)
                if($name == $v){
                    $newGroup[] = $k;
                    break;
                }

        return $newGroup;

    }

    public function populate($params)
    {
        require(__DIR__ . '/../../frontend/views/site/form/_list.php');

        $this->sender = $params['id'];
        $this->lytis = $params['lytis'];
        $this->method = $params['ivestis'];

        $query = UserPack::find()->select('user.id')->joinWith(['info']);

        if($this->method == 'auto'){

            if(!isset($params['mass']))
                return 'Nepasirinkti gavėjai';

            $this->msg = $params['msg'];
            $publika = $params['mass'];



            $Tlytis = ($this->lytis == 'm')? ['mm', 'mv'] : ['vv', 'vm'];
            $Plytis = ($this->lytis == 'm')? ['vv', 'vm'] : ['mm', 'mv'];

            //visiems visiems
            if(!isset($publika['pla']) || !isset($publika['plaV']) || !isset($publika['tpla']) || !isset($publika['tplaV'])){
                //visiems priesingos lyties atstovams
                if(isset($publika['pla']) && isset($publika['plaV'])){
                    $query->filterWhere(['info.iesko' => $Plytis]);

                    $this->publika = 'Priešingos lyties visi nariai';
                }else{
                    if(isset($publika['pla'])){
                        $query->filterWhere(['info.iesko' => $Plytis])
                            ->andFilterWhere(['not', ['vip' => 1]]);

                        $this->publika = 'Priešingos lyties ne Vip nariai';
                    }elseif(isset($publika['plaV'])){
                        $query->filterWhere(['info.iesko' => $Plytis])
                            ->andFilterWhere(['vip' => 1]);

                        $this->publika = 'Priešingos lyties Vip nariai';
                    }
                }

                //visiems tos pacios lyties atstovams
                if(isset($publika['tpla']) && isset($publika['tplaV'])){
                    $query->filterWhere(['info.iesko' => $Tlytis]);

                    $this->publika = 'Tos pačios lyties visi nariai';
                }else{
                    if(isset($publika['tpla'])){
                        $query->filterWhere(['info.iesko' => $Tlytis])
                            ->andFilterWhere(['not', ['vip' => 1]]);
                        $this->publika = 'Tos pačios lyties ne Vip nariai';
                    }elseif(isset($publika['tplaV'])){
                        $query->filterWhere(['info.iesko' => $Tlytis])
                            ->andFilterWhere(['vip' => 1]);

                        $this->publika = 'Tos pačios lyties Vip nariai';
                    }
                }
            }else {
                $this->publika = 'Visi pagal lyti ir Vip';
            }

            //miesto filtrai
            if(isset($publika['miestai'])){
                if(isset($params['miestai'])) {

                    $this->publika .= ' Miestai: ';

                    $pasirinkimai = $params['miestai'];
                    $pavieniai = [];
                    $grupes = [];
                    
                    /*
                     * $grupes          siame array'juje sedi tekstinis grupes pavadinimas
                     * $pasirinkimai    siame array'juje sedi visi miestu id is saraso
                     */
                    foreach ($pasirinkimai as $k => $v) {

                        if (!is_numeric($v)) {
                            $this->publika .= ' ' . $v . ';';

                            if($v == 'Anglija'){
                                $grupes = array_merge($grupes, $anglija);
                            }

                            if($v == 'Airija'){
                                $grupes = array_merge($grupes, $airija);
                            }

                        } else {
                            $this->publika .= ' ' . $list[$v] . ';';
                            $pavieniai[] = $v;
                            unset($pasirinkimai[$k]);
                        }
                    }

                    $grupesComplete = $this->convertToKeys($grupes, $list);
                    $filter = array_merge($grupesComplete, $pavieniai);

                    if (count($filter) > 0)
                        $query->andFilterWhere(['miestas' => $filter]);

                }

            }

            //amziaus filtrai
            if(isset($publika['amzius'])){
                $nuo = (isset($params['amzius']['nuo']))? $params['amzius']['nuo'] : 18;
                $iki = (isset($params['amzius']['nuo']))? $params['amzius']['iki'] : 100;

                //nuoTs > ikiTs
                $nuoTs = time() - $nuo * 31556926;
                $ikiTs = time() - ($iki + 1) * 31556926 - 1;

                $query->andFilterWhere(['between', 'info.gimimoTS', $ikiTs, $nuoTs]);

                $this->publika .= ' Amžiaus filtras: nuo '.$nuo.' iki '.$iki.' metų;';
            }

            //tikslo filtrai
            if(isset($publika['tikslas'])) {
                if(isset($params['tikslas'])) {

                    $paruostukas = '';

                    foreach ($params['tikslas'] as $k => $v) {
                        $temp[] = $v;
                        $paruostukas .= $tikslas[$k]." ";
                    }

                    $this->publika .= ' Tikslo filtras: '.$paruostukas.';';

                    $query->andFilterWhere(['info.tikslas' => $temp]);
                }
            }

            //orentacijos filtrai
            if(isset($publika['orentacija'])) {
                if(isset($params['orentacija'])) {

                    $paruostukas = '';

                    foreach ($params['orentacija'] as $k => $v){
                        $temp[] = $k;
                        $paruostukas .= $orentacija[$k]." ";
                    }

                    $this->publika .= ' Orentacijos filtras: '.$paruostukas.';';

                    $query->andFilterWhere(['info.orentacija' => $temp]);
                }
            }

            //foto filtrai
            if(isset($publika['foto'])){
                $query->andFilterWhere(['avatar'=>['jpg','png','gif']]);

                $this->publika .= ' Nariai su nuotrauka;';
            }

            //fake filtrai
            if(isset($publika['fake'])){
                $query->andFilterWhere(['user.f' => 1]);

                $this->publika .= ' Fake nariai;';
            }

            //registracijos filtrai
            if(isset($publika['registracija'])){
                if(isset($params['created_at'])){
                    $ca = $params['created_at'];
                    $created_at = explode(" - ", $ca);
                    $created_at_start = strtotime($created_at[0]);
                    $created_at_end = strtotime($created_at[1]);

                    $query->andFilterWhere(['between', 'created_at', $created_at_start, $created_at_end]);
                }
            }



        }else{
            $recievers = explode(',', $params['recievers']);


            foreach ($recievers as $v) {
                $query->orFilterWhere(['username' => $v]);
            }

            $this->msg = $params['msg'];

            $this->publika = implode(',', $recievers)." <small>(viso: <b>".count($recievers)."</b>)</small>";

        }

        $query->andFilterWhere(['not', ['user.id' => $_GET['id']]]);

        foreach ($query->all() as $v) {
            $this->recievers[] = $v->id;
        }

    }

    /**
     *
     */
    public function sendMM()
    {
        $chat = new Chat;
        $stop = false;

        $user = User::find()->where(['id' => $this->sender])->one();

        set_time_limit(false);
        session_write_close();

        while(true){

            for($i = 0; $i < 50; $i++){

                if(isset($this->recievers[0]) && count($this->recievers) > 0){

                    $r = $this->recievers[0];

                    $gavejoUser = User::find()->where(['id' => $r])->one();

                    if($gavejoUser) {
                        $chat->tryEmail($user, $gavejoUser, true);
                        $chat->sendMsgGlobal($this->sender, $r, $this->msg);

                        Statistics::addRecieved($r);

                        $not = new Chatnot;
                        $not->insertNotGlobal($this->sender, $r);

                        echo $r . " ";

                        array_shift($this->recievers);
                    }
                }else{
                    $stop = true;
                    break;
                }

            }


            if($stop)
                break;

            sleep(1);
        }

        echo ".....done";

    }

}
