<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\InfoClear;
use yii\db\Query;

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
class Atitikimai extends Info2
{
    public function LabelChange($attribute)
    {
        $label = [
            'gimtine' => 'Gimtinė',
            'tautybe' => 'Tautybė',
            'religija' => 'Religija',
            'statusas' => 'Statusas',
            'pareigos' => 'Pareigos',
            'uzdarbis' => 'Uždarbis',
            'orentacija' => 'Orentacija',
            'tikslas' => 'Tikslas šiame portale',
            'miestas' => 'Miestas',
            'grajonas' => 'Gyvenamasis rajonas',
            'drajonas' => 'Darbovietės rajonas',
            'kalba' => 'Kalba',
            'metai' => 'Gimimo metai',
            'menuo' => 'Gimimo mėnuo',
            'diena' => 'Gimimo diena',
            'issilavinimas' => 'Išsilavinimas',
            'ugis' => 'Ūgis',
            'svoris' => 'Svoris',
            'sudejimas' => 'Sudėjimas',
            'plaukai' => 'Plaukų spalva',
            'akys' => 'Akių spalva',
            'stilius' => 'Stilius',
            'u_id' => 'id'
        ];

        $key = $label[$attribute];

        return $key;
    }

    public static function LabelChangeIesko($attribute)
    {
        $label = [
            'gimtine' => 'Gimtoji šalis',
            'tautybe' => 'Gimtoji vieta',
            'religija' => 'Religija',
            'statusas' => 'Statusas',
            'pareigos' => 'Pareigos',
            'uzdarbis' => 'Uždarbis',
            'orentacija' => 'Orentacija',
            'tikslas' => 'Tikslas šiame portale',
            'miestas' => 'Miestas',
            'grajonas' => 'Gyvenamasis rajonas',
            'drajonas' => 'Darbovietės rajonas',
            'kalba' => 'Kalba',
            'metai' => 'Gimimo metai',
            'menuo' => 'Gimimo mėnuo',
            'diena' => 'Gimimo diena',
            'issilavinimas' => 'Išsilavinimas',
            'ugis' => 'Ūgis',
            'svoris' => 'Svoris',
            'sudejimas' => 'Sudėjimas',
            'plaukai' => 'Plaukų spalva',
            'akys' => 'Akių spalva',
            'stilius' => 'Stilius',
            'u_id' => 'id',
            'id' => 'id',
            'amzius_tarp' => 'Ieško amžius tarp',
            'iesko' => 'Ieško',
            'zodis' => 'Žodis apie save'
        ];

        $key = $label[$attribute];

        return $key;
    }
    public function main($model)
    {


        if($info = Info2::find()->where(['u_id' => $model->id])->one()){

            $infoMy = Info2::find()->where(['u_id' => Yii::$app->user->identity->id])->one();

            $keys = array_keys($info->attributes);
            $i = 0;

            $bendri = array();
            $bendri2 = array();

            foreach($info->attributes as $attribute){
                if($infoMy->$keys[$i] == $attribute && $attribute != '' && $keys[$i] != 'amzius_tarp' && $keys[$i] != 'suzinojo' && $keys[$i] != 'zodis' && $keys[$i] != 'iesko' && $keys[$i] != 'gimimoTS'){

                    $bendri[] = $this->LabelChange($keys[$i]);
                }
                $i++;
            }

            return $bendri;  
        }else{
            return false;
        }
    }


}

