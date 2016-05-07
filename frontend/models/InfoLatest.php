<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "info".
 *
 * @property integer $id
 * @property integer $u_id
 * @property string $amzius_tarp
 * @property string $iesko
 * @property string $suzinojo
 * @property string $gimtine
 * @property string $tautybe
 * @property string $religija
 * @property string $statusas
 * @property string $pareigos
 * @property string $uzdarbis
 * @property string $orentacija
 * @property string $tikslas
 * @property string $miestas
 * @property string $grajonas
 * @property string $drajonas
 * @property string $metai
 * @property string $menuo
 * @property string $diena
 * @property integer $gimimoTS
 * @property string $issilavinimas
 * @property string $ugis
 * @property string $svoris
 * @property string $sudejimas
 * @property string $plaukai
 * @property string $akys
 * @property string $stilius
 * @property string $zodis
 */



class InfoLatest extends \yii\db\ActiveRecord
{

    public $READ_ONLY = [
            'id',
            'u_id',
            'iesko', //sita reik padaryti veikianti
            'amzius_tarp',
            'suzinojo',
            'gimimoTS',
            'zodis',
            //'drajonas',
            //'grajonas'
        ];
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
            [['u_id', 'amzius_tarp', 'iesko', 'suzinojo', 'gimtine', 'tautybe', 'religija', 'statusas', 'pareigos', 'uzdarbis', 'orentacija', 'tikslas', 'miestas', 'grajonas', 'drajonas', 'metai', 'menuo', 'diena', 'gimimoTS', 'issilavinimas', 'ugis', 'svoris', 'sudejimas', 'plaukai', 'akys', 'stilius', 'zodis'], 'required'],
            [['u_id', 'gimimoTS'], 'integer'],
            [['amzius_tarp', 'grajonas', 'zodis'], 'string'],
            [['iesko', 'menuo', 'diena', 'issilavinimas'], 'string', 'max' => 2],
            [['suzinojo'], 'string', 'max' => 3],
            [['gimtine', 'tautybe', 'religija', 'statusas', 'pareigos', 'uzdarbis', 'orentacija', 'tikslas', 'miestas', 'drajonas', 'ugis', 'svoris', 'sudejimas', 'plaukai', 'akys', 'stilius'], 'string', 'max' => 20],
            [['metai'], 'string', 'max' => 4],
            [['u_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u_id' => 'U ID',
            'amzius_tarp' => 'Amzius Tarp',
            'iesko' => 'Iesko',
            'suzinojo' => 'Suzinojo',
            'gimtine' => 'Gimtine',
            'tautybe' => 'Tautybe',
            'religija' => 'Religija',
            'statusas' => 'Statusas',
            'pareigos' => 'Pareigos',
            'uzdarbis' => 'Uzdarbis',
            'orentacija' => 'Orentacija',
            'tikslas' => 'Tikslas',
            'miestas' => 'Miestas',
            'grajonas' => 'Grajonas',
            'drajonas' => 'Drajonas',
            'metai' => 'Metai',
            'menuo' => 'Menuo',
            'diena' => 'Diena',
            'gimimoTS' => 'Gimimo Ts',
            'issilavinimas' => 'Issilavinimas',
            'ugis' => 'Ugis',
            'svoris' => 'Svoris',
            'sudejimas' => 'Sudejimas',
            'plaukai' => 'Plaukai',
            'akys' => 'Akys',
            'stilius' => 'Stilius',
            'zodis' => 'Zodis',
        ];
    }

    public function getPercent(){
        $amount = 0;
        $completed = 0;


        foreach ($this->attributes as $k => $v){
            if(array_search($k, $this->READ_ONLY) === false){
                if(($k == 'drajonas' || $k == 'grajonas') && $this->miestas !== 0) {
                    continue;
                }

                $amount++;
                if($v != '') {
                    $completed++;
                }
            }
        }


        return round($completed / $amount, 2) * 100;
    }

    public function getQuestion()
    {
        foreach ($this->attributes as $k => $v)
            if(array_search($k, $this->READ_ONLY) === false)
                if($v == '') {
                    if (($k == 'drajonas' || $k == 'grajonas') && $this->miestas !== 0) {

                    } else {
                        return $k;
                    }
                }




        return -1;
    }
}
