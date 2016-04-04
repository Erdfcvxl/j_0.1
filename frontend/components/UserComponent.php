<?php
namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\helpers\Html;
use frontend\models\User;
use frontend\models\Info2;

class UserComponent extends Component{
	public $content;
	
	public function init(){
		parent::init();
		$user = User::find()->where(['id' => Yii::$app->user->id])->one();
		$info = Info2::find()->where(['u_id' => Yii::$app->user->id])->one();
	}
	
	public function display($content=null){
		if($content!=null){
			$this->content= $content;
		}
		echo Html::encode($this->content);
	}
	
}
?>