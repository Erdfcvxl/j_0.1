<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ilookfor".
 *
 * @property integer $id
 * @property integer $u_id
 * @property integer $amzius_tarp
 * @property integer $iesko
 * @property integer $gimtine
 * @property integer $tautybe
 * @property integer $religija
 * @property integer $statusas
 * @property integer $pareigos
 * @property integer $uzdarbis
 * @property integer $orentacija
 * @property integer $tikslas
 * @property integer $miestas
 * @property integer $grajonas
 * @property integer $drajonas
 * @property integer $issilavinimas
 * @property integer $ugis
 * @property integer $svoris
 * @property integer $sudejimas
 * @property integer $plaukai
 * @property integer $akys
 * @property integer $stilius
 */
class Ilookfor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

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


    public static function tableName()
    {
        return 'ilookfor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'amzius_tarp', 'iesko', 'gimtine', 'tautybe', 'religija', 'statusas', 'pareigos', 'uzdarbis', 'orentacija', 'tikslas', 'miestas', 'grajonas', 'drajonas', 'issilavinimas', 'ugis', 'svoris', 'sudejimas', 'plaukai', 'akys', 'stilius'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */

}
