<?php

namespace frontend\models;

use Yii;
use common\models\UserSafe;

/**
 * This is the model class for table "info".
 *
 * @property integer $u_id
 * @property string $kalba
 */
class Info extends \yii\db\ActiveRecord
{
    public function scenarios()
    {
        return [
            'signup' => ['iesko', 'amzius_tarp', 'suzinojo'],
            'pirmas' => ['tautybe2', 'pareigos2', 'metai', 'menuo', 'diena', 'issilavinimas', 'gimtine' , 'tautybe' , 'religija', 'statusas', 'pareigos', 'uzdarbis', 'orentacija', 'tikslas'],
            'antras' => ['ugis', 'svoris', 'sudejimas', 'plaukai', 'akys', 'stilius'],
            'trecias' => ['miestas', 'grajonas', 'drajonas'],
            'penktas' => ['zodis'],
            'iLookFor' => ['ugis', 'svoris', 'sudejimas', 'plaukai', 'akys', 'iesko','stilius', 'miestas', 'grajonas', 'drajonas','tautybe2', 'pareigos2', 'metai', 'menuo', 'diena', 'issilavinimas', 'gimtine' , 'tautybe' , 'religija', 'religija2', 'statusas', 'pareigos', 'uzdarbis', 'orentacija', 'tikslas']
        ];
    }

    public $file;
    public $tautybe2;
    public $pareigos2;
    public $religija2;
    public $plaukai2;
    public $akys2;
    public $stilius2;
    public $religijacomplete;
    public $pareigoscomplete;
    public $plaukaicomplete;
    public $akyscomplete;
    public $stiliuscomplete;
    public $tautybecomplete;
    public $taisykles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id'], 'integer'],
            [['iesko', 'amzius_tarp', 'suzinojo', 'grajonas', 'drajonas', 'zodis'], 'safe'],
            [['kalba'], 'string', 'max' => 225],
            [['metai', 'menuo', 'diena', 'issilavinimas', 'miestas', 'statusas', 'uzdarbis', 'orentacija', 'tikslas', 'ugis', 'svoris', 'sudejimas'], 'required', 'message' => 'Šis laukelis yra privalomas'],
            
            [['religija', 'gimtine' ,'pareigos', 'plaukai', 'akys', 'stilius'], 'my_valid', 'skipOnEmpty' => false],

            [['taisykles'] , 'required']
        ];
    }

    public function getLikes()
    {
        return $this->hasMany(Likes::className(), ['user_id' => 'user_id']);
    }

    public function my_valid($attribute)
    {

        if($attribute == 'pareigos'){
            if($this->$attribute == 25){
                if($this->pareigos2 == ""){
                    $this->addError('pareigos', 'Šis laukelis yra privalomas');
                    $this->addError('pareigos2', 'Šis laukelis yra privalomas');  
                }
            }else{
                if($this->pareigos == ""){
                    $this->addError('pareigos', 'Šis laukelis yra privalomas');
                    $this->addError('pareigos2', 'Šis laukelis yra privalomas');  
                }
            }
        }
        if($attribute == "gimtine"){
            if($this->$attribute == 126){
                if($this->tautybe == ""){
                    $this->addError('tautybe', 'Šis laukelis yra privalomas');
                    $this->addError('tautybe2', 'Šis laukelis yra privalomas');  
                }
            }else{
               if($this->tautybe != ""){
                    return true;
               }else{
                    $this->addError('tautybe', 'Šis laukelis yra privalomas');
                    $this->addError('tautybe2', 'Šis laukelis yra privalomas');  
                } 
            }
        }
        if($attribute == 'religija'){
            if($this->$attribute == 9){
                if($this->religija2 == ""){
                    $this->addError('religija', 'Šis laukelis yra privalomas');
                    $this->addError('religija2', 'Šis laukelis yra privalomas');  
                }
            }else{
                if($this->religija == ""){
                    $this->addError('religija', 'Šis laukelis yra privalomas');
                    $this->addError('religija2', 'Šis laukelis yra privalomas');  
                }
            }
        }
        if($attribute == 'plaukai'){
            if($this->$attribute == 9){
                if($this->plaukai2 == ""){
                    $this->addError('plaukai', 'Šis laukelis yra privalomas');
                    $this->addError('plaukai2', 'Šis laukelis yra privalomas');  
                }
            }else{
                if($this->plaukai == ""){
                    $this->addError('plaukai', 'Šis laukelis yra privalomas');
                    $this->addError('plaukai2', 'Šis laukelis yra privalomas');  
                }
            }
        }
        if($attribute == 'akys'){
            if($this->$attribute == 9){
                if($this->akys2 == ""){
                    $this->addError('akys', 'Šis laukelis yra privalomas');
                    $this->addError('akys2', 'Šis laukelis yra privalomas');  
                }
            }else{
                if($this->akys == ""){
                    $this->addError('akys', 'Šis laukelis yra privalomas');
                    $this->addError('akys2', 'Šis laukelis yra privalomas');  
                }
            }
        }
        if($attribute == 'stilius'){
            if($this->$attribute == 17){
                if($this->stilius2 == ""){
                    $this->addError('stilius', 'Šis laukelis yra privalomas');
                    $this->addError('stilius2', 'Šis laukelis yra privalomas');  
                }
            }else{
                if($this->stilius == ""){
                    $this->addError('stilius', 'Šis laukelis yra privalomas');
                    $this->addError('stilius2', 'Šis laukelis yra privalomas');  
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'u_id' => 'U ID',
            'kalba' => 'Kalba',
            'metai' => 'Metai',
            'menuo' => 'Menuo',
            'diena' => 'Diena',
            'issilavinimas' => 'Išsilavvinimas',
            'gimtine' => 'Gimtinė', 
            'tautybe' => 'Tautybė', 
            'religija' => 'Religija', 
            'statusas' => 'Statusas', 
            'pareigos' => 'Pareigos', 
            'uzdarbis' => 'Uždarbis', 
            'orentacija' => 'Orentacija', 
            'tikslas' => 'Tikslas'
        ];
    }

    public function SignUpInfo()
    {
        $this->save();

        return $this;
    }

    public function NextStep()
    {
        $user = User::find()->where(['id' => $_GET['id']])->one();
        $info = Info::find()->where(['u_id' => $_GET['id']])->one();
        $re = (isset($_GET['re']) ? $_GET['re'] : "");

        $c_steps = explode(" ", $user->reg_step);

        $user->firstMsg = 1;
        $user->save(false);

    
        if($re == 0){
            $info->scenario = 'pirmas';
            $info->metai = $this->metai;
            $info->menuo = $this->menuo;
            $info->diena = $this->diena;
            $info->gimimoTS = mktime(0, 0, 0, (int) $this->menuo, (int) $this->diena, (int) $this->metai);
            $info->issilavinimas = $this->issilavinimas;
            $info->gimtine = $this->gimtine;
            $info->tautybe = $this->tautybe;
            $info->religija = $this->religija;
            $info->statusas = $this->statusas;
            $info->pareigos = $this->pareigos;
            $info->uzdarbis = $this->uzdarbis;
            $info->orentacija = $this->orentacija;
            $info->tikslas = $this->tikslas;
            $info->save();

            if($this->validate()){
                if(!array_search('0', $c_steps)){
                    $user->reg_step = $user->reg_step." 0";
                    $user->save();
                }
            }

            return $info;
        }
        elseif($re == 1){
            $info->scenario = 'antras';
            $info->ugis = $this->ugis;
            $info->svoris = $this->svoris;
            $info->sudejimas = $this->sudejimas;
            $info->plaukai = $this->plaukai;
            $info->akys = $this->akys;
            $info->stilius = $this->stilius;
            $info->save();

            if($this->validate()){
                if(!array_search('1', $c_steps)){
                    $user->reg_step = $user->reg_step." 1";
                    $user->save();
                }
            }

            return $info;
        }
        elseif($re == 2){
            $info->scenario = 'trecias';
            $info->miestas = $this->miestas;
            $info->grajonas = $this->grajonas;
            $info->drajonas = $this->drajonas;
            $info->save();

            if($this->validate()){  
                if(!array_search('2', $c_steps)){
                    $user->reg_step = $user->reg_step." 2";
                    $user->save();
                }
            }

            return $info;
        }
        elseif($re == 4){
            $info->scenario = 'penktas';
            
            $info->zodis = $this->zodis;
            $info->save();

            if($this->validate()){
                if(!array_search('4', $c_steps)){
                    $user->reg_step = $user->reg_step." 4";
                    $user->save();
                }
            }

            return $info;
        }
    }
}
