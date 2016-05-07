<?php

namespace frontend\models;

use Yii;
use frontend\models\User;
use common\models\Mail;


/**
 * This is the model class for table "chat".
 *
 * @property string $id
 * @property integer $u1
 * @property integer $u2
 * @property string $message1
 * @property string $message2
 * @property integer $timestamp
 * @property mixed reciever
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u1', 'u2', 'message1', 'message2', 'timestamp'], 'required'],
            [['u1', 'u2', 'timestamp'], 'integer'],
            [['message1', 'message2'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u1' => 'U1',
            'u2' => 'U2',
            'message1' => 'Message1',
            'message2' => 'Message2',
            'timestamp' => 'Timestamp',
        ];
    }

    public function tryEmail($user, $gavejoUser, $send = true)
    {
        if(time() - $gavejoUser->lastOnline > 600){//jeigu nera online

            $alredyInformedAbout = explode(" ", $gavejoUser->msgEmailNot);

            if(array_search($user->id, $alredyInformedAbout) === false){//jeigu dar neinformuotas apie zinute is manes
                $mail = new Mail;
                $mail->sender = 'pazintys@pazintyslietuviams.co.uk';
                $mail->reciever = $gavejoUser->email;
                $mail->subject = 'Gavote asmeninę žinutę';
                $mail->vars = 'logo=>css/img/icons/logo2.jpg|,|avatars=>css/img/icons/avatarSectionEmail.jpg|,|link=>css/img/icons/link.jpg|,|user=>'.$user->username;
                $mail->f = '_gavoteZinute';
                $mail->timestamp = time();

                if($send) {
                    $mail->trySend();
                }else{
                    $mail->save();
                }

                $gavejoUser->msgEmailNot .= " ".$user->id;
                $gavejoUser->save(false);
            }
            
            
        }
    }

    public function updateChatters($r)
    {
        $me = Yii::$app->user->id;

        $model = Chatters::find()->where(['and', ['u1' => $r, 'u2' => $me]])->orWhere(['and', ['u2' => $r, 'u1' => $me]])->one();

        if(!$model){
            $model = new Chatters;
            $model->u1 = $me;
            $model->u2 = $r;
            $model->timestamp = time();
            $model->save();
        }else{
            $model->timestamp = time();
            $model->save();
        }
    }

    public function updateChattersIndependent($s, $r)
    {
        $me = $s;

        $model = Chatters::find()->where(['and', ['u1' => $r, 'u2' => $me]])->orWhere(['and', ['u2' => $r, 'u1' => $me]])->one();

        if(!$model){
            $model = new Chatters;
            $model->u1 = $me;
            $model->u2 = $r;
            $model->timestamp = time();
            $model->save();
        }else{
            $model->timestamp = time();
            $model->save();
        }
    }

    public function sendMsg($reciever, $content)
    {
        if($content != '') {
            $this->updateChatters($reciever);

            $this->sender = Yii::$app->user->id;
            $this->reciever = $reciever;
            $this->message = $content;
            $this->timestamp = time();
            $this->sVip = Yii::$app->user->identity->vip;
            $this->newID = $reciever;
            $this->save(false);
        }
    }

    public function updateChattersGlobal($s, $r)
    {
        $me = $s;

        $model = Chatters::find()->where(['and', ['u1' => $r, 'u2' => $me]])->orWhere(['and', ['u2' => $r, 'u1' => $me]])->one();

        if(!$model){
            $model = new Chatters;
            $model->u1 = $me;
            $model->u2 = $r;
            $model->timestamp = time();
            $model->save();
        }else{
            $model->timestamp = time();
            $model->save();
        }

        if($er = $model->getErrors())
            var_dump($er);
    }

    public function sendMsgGlobal($sender, $reciever, $content)
    {
        $this->updateChattersGlobal($sender, $reciever);

        $model = new self;

        $model->sender = $sender;
        $model->reciever = $reciever;
        $model->message = $content;
        $model->timestamp = time();
        $model->newID = $reciever;
        $model->save(false);
    }

    public static function whochats()
    {
        //su šiais žmonėmis žmogus čatina
        $chatters = Chat::find()->select('sender, reciever')->where(['or', 'sender =' .Yii::$app->user->id, 'reciever =' .Yii::$app->user->id])->orderBy(['timestamp'=>SORT_DESC])->all();
        $ids = [];

        foreach($chatters as $chat){

            if($chat->sender == Yii::$app->user->id){
                if($chat->reciever != Yii::$app->user->id)
                    $ids[] = $chat->reciever;
            }else{
                if($chat->sender != Yii::$app->user->id)
                    $ids[] = $chat->sender;
            }
        }

        return array_unique($ids);
    }

    public static function isNew()
    {
        $chatters = array(0);

        $model = Chatnot::find()->where(['newID' => Yii::$app->user->id])->all();

        foreach($model as $chat){

            if($chat->sender == Yii::$app->user->id){

                if(!array_search($chat->reciever, $chatters)){
                    $chatters[] = $chat->reciever;

                }

            }else{

                if(!array_search($chat->sender, $chatters)){
                    $chatters[] = $chat->sender;
                }

            }
        }

        array_splice($chatters, 0, 1);

        return $chatters;
    }

}
