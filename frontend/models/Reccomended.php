<?php

namespace frontend\models;

use Yii;
use yii\data\ArrayDataProvider;

Class Reccomended {

	public $dontCompare = [
		'amzius_tarp',
		'suzinojo',
		'zodis',
		'iesko',
		'gimimoTS',
		'miestas',
		'grajonas',
		'drajonas',
	];

	public $scores = [
		'iesko' => 99,
		'amzius' => 15,
		'miestas' => 15,
		'orentacija' => 70,
		'statusas' => 4,
		'tikslas' => 3,
		'issilavinimas' => 1,
		'religija' => 1,
		'uzdarbis' => 1,
		'grajonas' => 12,
		'drajonas' => 12,
	];

	static public function LabelChange($attribute)
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
            'u_id' => 'id',
            'iesko' => 'lytis'
        ];

        $key = $label[$attribute];

        return $key;
    }

	static public function getYears($d,$m,$me)
	{
		$d1 = new \DateTime($d.'.'.$m.'.'.$me);
        $d2 = new \DateTime();
        $diff = $d2->diff($d1);

        return $diff->y;
	}

	static public function getAmzius($at, $ma)
	{
		$parts = explode("-", $at);

		if(!empty($parts[0]) && !empty($parts[1]))
			return $parts;
		else{
			$parts[0] = $ma - 2;
			$parts[1] = $ma + 2;
			return $parts;
		}

	}

	static public function getProvider($models)
	{
		$model = new self;
		require('../views/site/form/_list.php');

		$user = Yii::$app->user->identity;
		$info = Info::find()->where(['u_id' => Yii::$app->user->id])->one();
		$result = [];

		if($info->diena != '' && $info->menuo != '' && $info->metai != '' && $info->iesko != '' && $info->amzius_tarp != ''){

			$manoAmzius = self::getYears($info->diena,$info->menuo,$info->metai);
			$ieskau = substr($info->iesko, -1);
			$tAmazius = self::getAmzius($info->amzius_tarp, $manoAmzius);

			foreach ($models as $value) {
				$sitas = ['points' => 0];
				$other = Info::find()->where(['u_id' => $value->id])->one();

				if($other){

					$lytis = substr((isset($other->iesko))? $other->iesko : 'n', 0,1);
					$diena = (isset($other->diena))? $other->diena : 0;
					$menuo = (isset($other->menuo))? $other->menuo : 0;
					$metai = (isset($other->metai))? $other->metai : 0;
					$amzius = self::getYears($diena,$menuo,$metai);
					
					$sitas['aititikimai'] = [];


					$sitas['aititikimai'][] = '<b>Amžius</b>: '.$amzius;

					if(isset($other->miestas) && $other->miestas != '')
						$sitas['aititikimai'][] = '<b>Miestas</b>: '.$list[$other->miestas];

					if($ieskau == $lytis)
						$sitas['points'] += $model->scores['iesko'];
					
					if($amzius > $tAmazius[0] && $amzius < $tAmazius[1])
						$sitas['points'] += $model->scores['amzius'];
					

					//atititkimu foreachas
					foreach ($other as $k => $v) {
						if(array_search($k, $model->dontCompare) === false){
							if(isset($other->$k) && $info->$k == $other->$k && $other->$k != ''){
								if(array_key_exists($k, $model->scores)){
									$sitas['points'] += $model->scores[$k];
								}else{
									$sitas['points'] += 1;
								}
							}
						}
					}


					if($info->miestas == $other->miestas && isset($other->miestas)){
						$sitas['points'] += $model->scores['miestas'];
						if($other->miestas == 0){
							if($info->grajonas == $other->grajonas && isset($other->grajonas) && $other->grajonas != ''){
								$sitas['aititikimai'][] = '<b>Gyvenamasis rajonas</b>: '.$rajonai[$other->grajonas];
								$sitas['points'] += $model->scores['grajonas'];
							}
							if($info->drajonas == $other->drajonas && isset($other->drajonas) && $other->drajonas != ''){
								$sitas['aititikimai'][] = '<b>Darbovietės rajonas</b>: '.$rajonai[$other->drajonas];
								$sitas['points'] += $model->scores['drajonas'];
							}
						}

					}

					if(isset($other->statusas) && $other->statusas != '')
						$sitas['aititikimai'][] = '<b>Statusas</b>: '.$statusas[$other->statusas];

					if(isset($other->tikslas) && $other->tikslas != '')
						$sitas['aititikimai'][] = '<b>Tikslas</b>: '.$tikslas[$other->tikslas];




					//suraso gautus rezultatus
					$sitas['id'] = $other->u_id;
					$sitas['vardas'] = $value->username;
					$sitas['metai'] = $amzius;
					$sitas['miestas'] = (isset($other['miestas']) && $other['miestas'] !== '')? $list[$other['miestas']] : 'nenustatyta';
					$sitas['avatar'] = $value->avatar;
					$sitas['lastOnline'] = $value->lastOnline;
					$sitas['vip'] = $value->vip;

					if($sitas['points'] > 0)
						$result[] = $sitas;

				}
			}

			usort($result, function($a, $b) {
			    return $b['points'] - $a['points'];
			});
		}

		$provider = new ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);


		return $provider;
	}

}

?>