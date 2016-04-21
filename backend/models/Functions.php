<?php

namespace backend\models;

use frontend\models\UserPack;

class Functions 
{
    public $deletedIDS;

    static public function CleanAvatar()
    {
        $users = \frontend\models\User::find()->select(['id','avatar'])->where(['not', ['avatar' => '']])->all();

        foreach ($users as $user) {
            if(!file_exists('../../frontend/web/uploads/531B'.$user->id."Iav.".$user->avatar)){

                $user->avatar = "";
                $user->save(false);

            }
        }

        return true;
    }

    public function deleteAll($models)
    {
        foreach ($models as $model){
            $model->delete();
        }
    }

    public function CheckExistance($model)
    {
        $miss = null;


        if(!UserPack::find()->where(['id' => $model->sender])->one()) {
            $miss[] = $model->sender;

            if(array_search($model->sender, $this->deletedIDS) === false)
                $this->deletedIDS[] = $model->sender;
        }

        if(!UserPack::find()->where(['id' => $model->reciever])->one()) {
            $miss[] = $model->reciever;

            if(array_search($model->reciever, $this->deletedIDS) === false)
                $this->deletedIDS[] = $model->reciever;
        }

        return $miss;
    }

    /*
     * Galima kviesti funkcija tik tada kai $deletedIDS yra užpildytas
     * @$deletedIDS;
     * trina chatnot; chatters; pakvietimai;
     */
    public function CleanGroup()
    {
        session_write_close();
        $i = 0;

        if($this->deletedIDS)
            foreach ($this->deletedIDS as $v){
                $this->deleteChatnot($v);
                $this->deleteChatters($v);
                $this->deletePakvietimai($v);

                $i++;
                if($i > 50){
                    $i = 0;
                    sleep(2);
                }

            }

        $this->deletedIDS = null;
    }

    public function Proceed($model)
    {
        session_write_close();
        $i = 0;

        foreach ($model as $v){
            if(count($this->CheckExistance($v)) > 0) {
                $v->delete();
            }

            $i++;
            if($i > 50){
                $i = 0;
                sleep(2);
            }

        }

        if($this->deletedIDS)
            $this->deletedIDS = array_unique($this->deletedIDS);

        //ištrins kitus dalykus
        $this->CleanGroup();
    }

    /*
     * @time offset $_GET['o'] dienomis atgal nuo šiandien
     * @time limit $_GET['l'] dienomis į pirekį nuo time offset
     */
    public function CleanTrashTalk()
    {
        $o = (isset($_GET['o']))? time() - $_GET['o'] * 3600 * 24 : 0;
        $l = (isset($_GET['l']))? $o + $_GET['l'] * 3600 : time();
        $tso = (isset($_GET['tso']))? $o + $_GET['tso'] : 0;
        $tsl = (isset($_GET['tsl']))? $o + $_GET['tsl'] : 0;
        $between = ($tso && $tsl)? true : false;



        $offset = 0;
        $limit = 50;

        session_write_close();


        $i = 0;
        while(true){
            if($between) {
                $query = \frontend\models\Chat::find()->offset($offset)->limit($limit)->where(['between', 'timestamp', $tso, $tsl])->all();
            }else{
                $query = \frontend\models\Chat::find()->offset($offset)->limit($limit)->where(['>=', 'timestamp', $o])->andWhere(['<=', 'timestamp', $l])->all();
            }


            if($chat = $query){
                $this->Proceed($chat);
            }else{
                break;
            }

            $offset += 50;
            $limit += 50;

            if($i > 10) {
                sleep(1);
                $i = 0;
            }else{
                $i++;
            }

        }

        echo "done";


    }

    public function deleteChat($id)
    {
        \frontend\models\Chat::deleteAll(['or', 'sender = :id', 'reciever = :id'], [
            ':id' => $id
        ]);
    }

    public function deleteChatters($id)
    {
        \frontend\models\Chatters::deleteAll(['or', 'u1 = :id', 'u2 = :id'], [
            ':id' => $id
        ]);
    }

    public function deleteChatnot($id)
    {
        \frontend\models\Chatnot::deleteAll(['or', 'sender = :id', 'reciever = :id'], [
            ':id' => $id
        ]);
    }

    public function deletePakvietimai($id)
    {
        \frontend\models\Chatnot::deleteAll(['or', 'sender = :id', 'reciever = :id'], [
            ':id' => $id
        ]);
    }
}