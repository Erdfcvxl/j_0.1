<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;
use yii\helpers\Url;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $pilnametis;
    public $password2;
    public function scenarios()
    {
        return [
            'default'=>['username', 'email', 'password', 'password2', 'pilnametis'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => 'Slapyvardžio laukelis yra privalomas.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Šis slapyvardis jau naudojamas.'],
            ['username', 'string', 'min' => 4, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => 'E-pašto laukelis laukelis yra privalomas.'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Šis el. pašto adresas jau naudojamas.'],

            ['password', 'required', 'message' => 'Slaptažodžio laukelis yra privalomas.'],
            ['password', 'string', 'min' => 6],

            [['password2'], 'validateSame', 'skipOnEmpty' => false],

            ['pilnametis', 'required', 'requiredValue' => 1, 'message' => 'Registruotis gali tik pilnamečiai'],
        ];
    }

    public function validateSame($attribute, $params)
    {
        if($this->password != $this->password2)
            return $this->addError('password2', 'Slaptažodžiai nesutampa');
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Slapyvardis',
            'password' => 'Slaptažodis',
            'email' => 'E-paštas'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->activated = 0;
            $user->save();

            $to = $this->email;
            $subject = "Registracija";

            $url = Url::to([
                'site/verifyemail', 
                're' => 0,
                'arl' => Yii::$app->Security->generateRandomString(32),
                'sk' => Yii::$app->Security->generateRandomString(64),
                'gyp' => 'Yc7rmURCN23G',
                'ra' => $user->auth_key,
                'id' => $user->id,
            ], true);

            $message = "Kad patvirtintumėte registraciją spauskite šią nuorodą: 
                        <a href='".$url."'>Spausti čia</a>";

            Yii::$app->mailer->compose()
                ->setFrom('pazintys@pazintyslietuviams.co.uk')
                ->setTo($to)
                ->setSubject($subject)
                ->setHtmlBody($message)
                ->send();

            return $user;

        }
        Yii::$app->session->setFlash('error', '1');
        return null;
    }
}
