<?php

namespace backend\models;

use Composer\Package\Loader\ValidatingArrayLoader;
use Yii;
use frontend\models\Chat;
use frontend\models\Statistics;
use frontend\models\Chatnot;

/**
 * This is the model class for table "welcome".
 *
 * @property integer $u_id
 * @property string $lytis
 * @property string $orentacija
 * @property integer $amzius
 * @property string $msg
 */

const CREATED_OFFSET = 1462210061;

class Welcome extends \yii\db\ActiveRecord
{

    public $players;
    public $run = [
        'tryFirst',
        'trySecond',
        'tryThird',
    ];
    public $ataskaita;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'welcome';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'lytis', 'orentacija', 'amzius'], 'required'],
            [['u_id', 'amzius'], 'integer'],
            [['msg'], 'string'],
            [['lytis'], 'string', 'max' => 1],
            [['orentacija'], 'string', 'max' => 225],
            [['u_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'u_id' => 'U ID',
            'lytis' => 'Lytis',
            'orentacija' => 'Orentacija',
            'amzius' => 'Amzius',
            'msg' => 'Msg',
        ];
    }
    
    public function addToGame($id)
    {
        $model = \frontend\models\UserPack::find()->where(['id' => $id])->one();

        if(!self::find()->where(['u_id' => $id])->one()) {
            $this->u_id = $model->id;
            $this->lytis = substr($model->info->iesko, 0, 1);
            $this->orentacija = $model->info->orentacija;
            $this->amzius = \frontend\models\Misc::getAmzius($model->info->diena, $model->info->menuo, $model->info->metai);

            if($this->save())
                return true;
        }else{
            Yii::$app->session->setFlash('warning', 'Šis narys jau pridėtas');

            return true;
        }

        $pretty = function($v='',$c="&nbsp;&nbsp;&nbsp;&nbsp;",$in=-1,$k=null)use(&$pretty){$r='';if(in_array(gettype($v),array('object','array'))){$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").'<br>';foreach($v as $sk=>$vl){$r.=$pretty($vl,$c,$in+1,$sk).'<br>';}}else{$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").(is_null($v)?'&lt;NULL&gt;':"<strong>$v</strong>");}return$r;};

        echo $pretty($this->getErrors());
        return false;

    }

    public function sendFfm($sender, $msg, $gavejas)
    {
        if($sender && $msg){

            $gavejas->firstFakeMsg += 1;
            if($gavejas->ffmSenders === ''){
                $gavejas->ffmSenders = $sender->id;
            }else{
                $gavejas->ffmSenders = $gavejas->ffmSenders.",".$sender->id;
            }

            if($gavejas->save(false)) {


                $chat = new Chat;
                $chat->tryEmail($sender, $gavejas, true);
                $chat->sendMsgGlobal($sender->id, $gavejas->id, $msg);

                Statistics::addRecieved($gavejas->id);

                $not = new Chatnot;
                $not->insertNotGlobal($sender->id, $gavejas->id);
            }else{
                Yii::$app->mailer->compose()
                    ->setFrom('cronjob@pazintyslietuviams.co.uk')
                    ->setTo('rokasr788@gmail.com')
                    ->setSubject('Klaida: sendFFM')
                    ->setHtmlBody('Neišsaugojo $gavejo Welcome->sendFfm(). UserPack modelio vardumpas: <br>'.var_dump($gavejas->getErrors()))
                    ->send();
            }

        }

    }

    public function getMsg($model)
    {
        $msgs = explode('||', $model->msg);

        $key = rand(0, count($msgs)-1);

        return $msgs[$key];
    }

    public function getSender($user)
    {
        $id = null;
        $msg = null;
        $skirtumas = 3000;

        //jei nera info table tam zmogui
        if(!$user->info)
            return null;



        $iesko = substr($user->info->iesko, 1);
        $used = explode(',',$user->ffmSenders);

        $amzius = \frontend\models\Misc::getAmzius($user->info->diena, $user->info->menuo, $user->info->metai);

        //isrenka labiausiai atitinkanti siunteja
        foreach ($this->players as $model) {

            //lytis turi atikti zmogaus paieska
            if ($model->lytis == $iesko) {

                //sis zaidejas dar nebuvo parases FFM zmogui
                if (array_search($model->u_id, $used) === false) {

                    //jei skirtumas yra mazesnis uz paskutini skirtuma
                    if (abs($model->amzius - $amzius) < $skirtumas) {

                        //patikrina ar toks zaidejas egzistuoja
                        if($sender = \frontend\models\UserPack::find()->where(['id' => $model->u_id])->one()) {

                            //zaidejas ir zmogus dar niekada nebuvo bendrave
                            if(!\frontend\models\Chat::find()->where(['and',['sender' => $model->u_id, 'reciever' => $user->id]])->orWhere(['and',['reciever' => $model->u_id, 'sender' => $user->id]])->one()){
                                $skirtumas = abs($model->amzius - $amzius);
                                $id = $sender;
                                $msg = $this->getMsg($model);
                            }
                        }else{
                            $model->delete();
                        }
                    }
                }
            }
        }

        //viskas gerai -> returnina siuntja
        if($id && $msg){
            $sender = [
                'id' => $id,
                'msg' => $msg
            ];

            return $sender;
        }



        return null;

    }

    public function proceedWithQuery($users, $name)
    {
        set_time_limit(false);
        session_write_close();

        $i = 0;

        foreach($users as $user){

            if($s = $this->getSender($user)) {
                $this->sendFfm($s['id'], $s['msg'], $user);
                $this->ataskaita[$name][] = ['siuntejas' => $s['id'], 'gavejas' => $user->username, 'msg' => $s['msg']];
            }

            $i++;

            if($i > 50){
                $i = 0;
                sleep(1);
            }
        }
    }

    public function tryFirst()
    {
        //pasirenka publika
        $users = \frontend\models\UserPack::find()
            ->where(['firstFakeMsg' => 0])
            ->andWhere(['<=', 'created_at', time() - 60 * 2])
            ->andWhere(['>=', 'created_at', CREATED_OFFSET])
            ->all();

        $this->proceedWithQuery($users, 'tryFirst');

    }

    public function trySecond()
    {
        //pasirenka publika
        $users = \frontend\models\UserPack::find()
            ->where(['firstFakeMsg' => 1])
            ->andWhere(['<=', 'created_at', time() - 60 * 10])
            ->andWhere(['>=', 'created_at', CREATED_OFFSET])
            ->all();

        $this->proceedWithQuery($users, 'trySecond');
    }

    public function tryThird()
    {
        //pasirenka publika
        $users = \frontend\models\UserPack::find()
            ->where(['firstFakeMsg' => 2])
            ->andWhere(['<=', 'created_at', time() - 60 * 60 * 27])
            ->andWhere(['>=', 'expires', time()])
            ->andWhere(['>=', 'created_at', CREATED_OFFSET])
            ->all();

        $this->proceedWithQuery($users, 'tryThird');
    }

    public function trySend()
    {
        //pupulates players
        $this->players = self::find()->all();

        foreach ($this->run as $v)
            $this->$v();

        
        $pretty = function($v='',$c="&nbsp;&nbsp;&nbsp;&nbsp;",$in=-1,$k=null)use(&$pretty){$r='';if(in_array(gettype($v),array('object','array'))){$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").'<br>';foreach($v as $sk=>$vl){$r.=$pretty($vl,$c,$in+1,$sk).'<br>';}}else{$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").(is_null($v)?'&lt;NULL&gt;':"<strong>$v</strong>");}return$r;};

        echo $pretty($this->ataskaita);

    }


}
