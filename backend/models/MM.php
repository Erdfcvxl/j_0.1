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

    public function populate($params)
    {
        $this->sender = $params['id'];
        $this->lytis = $params['lytis'];
        $this->method = $params['ivestis'];

        $query = UserPack::find()->select('user.id')->joinWith(['info']);

        if($this->method == 'auto'){

            if(!isset($params['mass']))
                return 'Nepasirinkti gavėjai';

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
                $this->publika = 'Visi';
            }

            $this->msg = $params['msg'];

        }else{
            $recievers = explode(',', $params['recievers']);


            foreach ($recievers as $v) {
                $query->orFilterWhere(['username' => $v]);
            }

            $this->msg = $params['msg'];

            $this->publika = implode(',', $recievers)." <small>(viso: <b>".count($recievers)."</b>)</small>";

        }

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
