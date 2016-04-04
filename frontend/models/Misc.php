<?php

namespace frontend\models;

use Yii;

Class Misc
{
	static public function getMyAvatar()
	{
		$dbAvatar = Yii::$app->user->identity['avatar'];
		$id = Yii::$app->user->id;

		if(isset($dbAvatar) && $dbAvatar != ''){
			return "/uploads/531B".$id."Iav.".$dbAvatar;
		}else{
			$lytis = Yii::$app->session['lytis'];

			if(isset($lytis) && $lytis != ''){
				$lytis = substr($info->iesko, 0, 1);
			}else{
				$lytis = 'na';
			}

			return "/css/img/".$lytis.".jpg";
		}
	}

	static public function getAvatar($user)
	{

		if(isset($user->avatar) && $user->avatar != ''){
			return "/uploads/531B".$user->id."Iav.".$user->avatar;
		}else{
			$info = Info::find()->where(['u_id' => $user->id])->one();

			if(isset($info->iesko) && $info->iesko != ''){
				$lytis = substr($info->iesko, 0, 1);
			}else{
				$lytis = 'na';
			}

			return "/css/img/".$lytis.".jpg";
		}
	}

	static public function getAvatarADP($user, $lytis = false)
	{

		if(isset($user['avatar']) && $user['avatar'] != ''){
			return "/uploads/531B".$user['id']."Iav.".$user['avatar'];
		}else{
			if($lytis){
				return "/css/img/".$lytis.".jpg";
			}else{
				$info = Info::find()->where(['u_id' => $user['id']])->one();

				if(isset($info->iesko) && $info->iesko != ''){
					$lytis = substr($info->iesko, 0, 1);
				}else{
					$lytis = 'na';
				}

				return "/css/img/".$lytis.".jpg";
			}
			
		}
	}

	static public function vip($u, $c = null)
	{
		$color = ($c) ? '#'.$c : '#93c502';

		if(isset($u->vip)){
			if($u->vip){
				return '<span style="color: '.$color.' ">VIP</span>';
			}else{
				return '';
			}
		}else{
			if($u['vip']){
				return '<span style="color: '.$color.' ">VIP</span>';
			}else{
				return '';
			}
		}
	}

	static public function getAmzius($diena, $menuo, $metai)
	{
		$d1 = new \DateTime($diena.'.'.$menuo.'.'.$metai);
		$d2 = new \DateTime();

		$diff = $d2->diff($d1);

		return $diff->y;
	}


    /**
     * pagamina id masyvą, naudija $ids gautus iš all()
     * @param $ids
     * @return mixed
     */
    static public function getByu_id($ids)
	{
		foreach($ids as $v){
			$id[] = $v->u_id;
		}

		return $id;
	}
}

?>