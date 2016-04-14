<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 4/14/2016
 * Time: 4:41 PM
 */

namespace backend\models;

use frontend\models\UserPack;


class Mass
{
    public $agent;
    public $lytis;
    public $recievers;
    public $publika;

    public function getFriends($u_id)
    {
        $result = [];
        $part['friends'] = [];
        $part['pakvietimai'] = [];


        $model = \frontend\models\Friends::find()->where(['u_id' => $u_id])->one();
        $friends = explode(' ', $model->friends);
        foreach ($friends as $v){
            $part['friends'][] = $v;
        }

        $models = \frontend\models\Pakvietimai::find()->where(['sender' => $u_id])->orWhere(['reciever' => $u_id])->all();
        foreach ($models as $model) {
            $part['pakvietimai'][] = ($model->reciever == $u_id)? $model->sender : $model->reciever;
        }

        if($part['friends'] && $part['pakvietimai']){
            $merge = array_merge($part['friends'], $part['pakvietimai']);
            $result = array_unique($merge);
        }else{
            if($part['friends'])
                $result = $part['friends'];

            if($part['pakvietimai'])
                $result = $part['pakvietimai'];
        }

        $result = array_slice($result, 1);

        return $result;

    }

    public function populate($params)
    {
        $query = null;

        $this->agent = $params['id'];
        $this->lytis = $params['lytis'];

        $publika = (isset($params['mass']))? $params['mass'] : '';

        //$Tlytis = ($this->lytis == 'm')? ['mm', 'mv'] : ['vv', 'vm'];
        $Plytis = ($this->lytis == 'm')? ['vv', 'vm'] : ['mm', 'mv'];

        if($publika)
            $query = UserPack::find()->select('user.id')->joinWith(['info']);

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

        if($query) {
            $friends = $this->getFriends($this->agent);

            $query->andFilterWhere(['not', ['user.id' => $this->agent]]);
            $query->andFilterWhere(['not', ['user.id' => $friends]]);

            foreach ($query->all() as $v) {
                $this->recievers[] = $v->id;
            }
        }

    }

}