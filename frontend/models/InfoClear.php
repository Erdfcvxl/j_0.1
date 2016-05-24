<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "info".
 *
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
 * @property string $kalba
 * @property string $metai
 * @property string $menuo
 * @property string $diena
 * @property string $issilavinimas
 * @property string $ugis
 * @property string $svoris
 * @property string $sudejimas
 * @property string $plaukai
 * @property string $akys
 * @property string $stilius
 * @property string $zodis
 *
 * @property User $u
 * @property User $user
 */
class InfoClear extends \yii\db\ActiveRecord
{
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
            [['u_id', 'amzius_tarp', 'iesko', 'suzinojo', 'gimtine', 'tautybe', 'religija', 'statusas', 'pareigos', 'uzdarbis', 'orentacija', 'tikslas', 'miestas', 'grajonas', 'drajonas', 'metai', 'menuo', 'diena', 'issilavinimas', 'ugis', 'svoris', 'sudejimas', 'plaukai', 'akys', 'stilius'], 'required'],
            [['u_id'], 'integer'],
            [['amzius_tarp', 'grajonas', 'zodis'], 'string'],
            [['iesko', 'menuo', 'diena', 'issilavinimas'], 'string', 'max' => 2],
            [['suzinojo'], 'string', 'max' => 3],
            [['gimtine', 'tautybe', 'religija', 'statusas', 'pareigos', 'uzdarbis', 'orentacija', 'tikslas', 'miestas', 'drajonas', 'ugis', 'svoris', 'sudejimas', 'plaukai', 'akys', 'stilius'], 'string', 'max' => 20],
            [['metai'], 'string', 'max' => 4],
            [['zodis'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
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
            'kalba' => 'Kalba',
            'metai' => 'Metai',
            'menuo' => 'Menuo',
            'diena' => 'Diena',
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

    

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'u_id']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'u_id']);
    }
}
