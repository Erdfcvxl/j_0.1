<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mail".
 *
 * @property integer $id
 * @property string $sender
 * @property string $reciever
 * @property string $subject
 * @property string $content
 * @property integer $timestamp
 */
class Mail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender', 'reciever', 'subject'], 'required'],
            [['subject', 'content', 'vars'], 'string'],
            [['timestamp'], 'integer'],
            [['reciever', 'sender'], 'email'],
            [['timestamp', 'content', 'vars', 'view'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender' => 'Sender',
            'reciever' => 'Reciever',
            'subject' => 'Subject',
            'content' => 'Content',
            'timestamp' => 'Timestamp',
        ];
    }

    static public function makeVarsArray($string)
    {
        $elements = explode(',', $string);

        $result = [];

        foreach ($elements as $v) {
            $el = explode('=>', $v);

            if(count($el) > 1)
                $result[$el[0]] = $el[1];

        }



        return $result;
    }

    public function trySend()
    {
        $params = Parametres::find()->one();

        if($params->MailLeft > 0) {
            if ($this->sendThis($params))
                return true;
        }else{
            $this->save();
        }




        return false;
    }

    public function sendThis($params)
    {
        if($this->validate()) {
            if ($this->content) {
                Yii::$app->mailer->compose()
                    ->setFrom($this->sender)
                    ->setTo($this->reciever)
                    ->setSubject($this->subject)
                    ->setHtmlBody($this->content)
                    ->send();
            } else {
                $vars = $this::makeVarsArray($this->vars);

                Yii::$app->mailer->compose($this->view, $vars)
                    ->setFrom($this->sender)
                    ->setTo($this->reciever)
                    ->setSubject($this->subject)
                    ->send();
            }


            $params->MailLeft -= 1;
            $params->save();
        }

        return true;
    }

    static public function sendEmails()
    {
        $params = Parametres::find()->one();

        set_time_limit(false);
        session_write_close();

        $c = 0;

        while(true){
            $limit = ($params->MailLeft > 50)? 50 : $params->MailLeft;
            $count = 0;

            $model = self::find()->orderBy('timestamp')->limit($limit)->all();

            foreach($model as $mail){

                if($params->MailLeft > 0) {
                    $vars = self::makeVarsArray($mail->vars);

                    if($mail->validate()) {
                        if ($mail->content) {
                            Yii::$app->mailer->compose()
                                ->setFrom($mail->sender)
                                ->setTo($mail->reciever)
                                ->setSubject($mail->subject)
                                ->setHtmlBody($mail->content)
                                ->send();
                        } else {
                            Yii::$app->mailer->compose($mail->view, $vars)
                                ->setFrom($mail->sender)
                                ->setTo($mail->reciever)
                                ->setSubject($mail->subject)
                                ->send();
                        }
                    }

                    $mail->delete();

                    $count++;
                    $c++;
                }

            }

            $params->MailLeft -= $count;
            $params->save();

            if($limit < 50 || !$model || $params->MailLeft <= 0)
                break;

            sleep(1);
        }



        echo "Išsiųsta: ".$c." laiškų<br>";



        echo "Dabartinis limitas: ".$params->MailLeft;
    }
}
