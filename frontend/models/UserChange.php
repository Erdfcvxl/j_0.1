<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $role
 * @property integer $status
 * @property string $reg_step
 * @property string $avatar
 * @property integer $activated
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $lastOnline
 */
class UserChange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $passwordOld;
    public $passwordNew;
    public $passwordNew2;
    public $emailOld;
    public $emailNew;
    public $emailNew2;

    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['passwordOld', 'passwordNew', 'passwordNew2'],
            'pass' => ['passwordOld', 'passwordNew', 'passwordNew2'],
            'email' => ['emailOld', 'emailNew', 'emailNew2'],
        ];
    }

    public function rules()
    {
        return [
            [['passwordNew', 'passwordNew2'], 'string', 'min' => 4, 'tooShort' => 'Slaptažodis per trumpas'],
            [['passwordOld' , 'passwordNew', 'passwordNew2'],'required', 'message'=> 'Šis laukelis negali būti tuščias'],
            ['passwordOld', 'passpatikra'],
            [['passwordNew', 'passwordNew2'], 'passlygus'],

            [['emailNew', 'emailNew2'], 'email', 'message'=> 'Tai nėra tinkamas el. paštas'],
            [['emailOld' , 'emailNew', 'emailNew2'],'required', 'message'=> 'Šis laukelis negali būti tuščias'],
            ['emailOld', 'elpatikra'],
            [['emailNew', 'emailNew2'], 'ellygus']
        ];
    }

    public function passpatikra()
    {
        $user = $this->find()->where(['id' => Yii::$app->user->id])->one();

        if(!Yii::$app->getSecurity()->validatePassword($this->passwordOld , $user->password_hash)){
            $this->addError('passwordOld', 'Neteisingas slaptažodis');
        }
    }

    public function passlygus()
    {
        if($this->passwordNew != $this->passwordNew2){
            $this->addError('passwordNew2', 'Slaptažodžiai nesutampa');
        }
    }

    public function elpatikra()
    {
        $user = $this->find()->where(['id' => Yii::$app->user->id])->one();

        if($user->email != $this->emailOld){
            $this->addError('emailOld', 'Neteisingas el. paštas');
        }
    }

    public function ellygus()
    {
        if($this->emailNew != $this->emailNew2){
            $this->addError('passwordNew2', 'El. paštai nesutampa');
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
            'reg_step' => 'Reg Step',
            'avatar' => 'Avatar',
            'activated' => 'Activated',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function PasswordChange($params)
    {
        $model = new \frontend\models\User;
        $user = $model->find()->where(['id' => Yii::$app->user->identity->id])->one();

        $this->load($params);

        if($this->validate()){
            $hash = Yii::$app->getSecurity()->generatePasswordHash($this->passwordNew);

            $user->password_hash = $hash;
            $user->save();

            Yii::$app->getSession()->setFlash('success', 'Slaptažodis pakeistas sėkmingai');

            Yii::$app->mailer->compose('_passChange', ['logo' => 'css/img/icons/logo2.jpg', 'avatars' => 'css/img/icons/avatarSectionEmail.jpg', 'link' => 'css/img/icons/link.jpg'])
                    ->setFrom('admin@pazintyslietuviams.co.uk')
                    ->setTo($user->email)
                    ->setSubject('Slaptažodio keitimas')
                    ->send();

            return true;
        }else{
            return false;
        }

    }

    public function EmailChange($params)
    {
        $model = new \frontend\models\User;
        $user = $model->find()->where(['id' => Yii::$app->user->identity->id])->one();

        $this->load($params);

        if($this->validate()){

            Yii::$app->mailer->compose('_emailChangeToOld', ['logo' => 'css/img/icons/logo2.jpg', 'avatars' => 'css/img/icons/avatarSectionEmail.jpg', 'link' => 'css/img/icons/link.jpg'])
                    ->setFrom('admin@pazintyslietuviams.co.uk')
                    ->setTo($user->email)
                    ->setSubject('El. pašto keitimas')
                    ->send();

            $user->email = $this->emailNew;
            $user->save();

            Yii::$app->getSession()->setFlash('success', 'El paštas pakeistas sėkmingai');

            Yii::$app->mailer->compose('_emailChange', ['logo' => 'css/img/icons/logo2.jpg', 'avatars' => 'css/img/icons/avatarSectionEmail.jpg', 'link' => 'css/img/icons/link.jpg'])
                    ->setFrom('admin@pazintyslietuviams.co.uk')
                    ->setTo($user->email)
                    ->setSubject('El. pašto keitimas')
                    ->send();

            return true;
        }else{
            return false;
        }

    }
}
