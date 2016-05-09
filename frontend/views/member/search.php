<?php

use yii\helpers\Url;

$psl = (isset($_GET['psl']))? $_GET['psl'] : "index";

/*$info = \frontend\models\Info2::find()->select(['miestas','metai','menuo','diena'])->where(['u_id' => Yii::$app->user->identity->id])->one();

if ($info->miestas == null || $info->metai == null || $info->menuo == null || $info->diena == null)
{
    $this->registerJs("$('<div class=\"curtains\" id=\"curtains\"></div>').prependTo('.wrap');");
    echo Yii::$app->controller->renderPartial('//member/search/_reikalavimas_trukstamos_info');
}*/

if($psl == "index"){
    echo $this->render('search/detail.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
}elseif($psl == "detail"){
    echo $this->render('search/detail.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
}elseif($psl == "new"){
    echo $this->render('search/new.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
}elseif($psl == "top"){
    echo $this->render('search/top.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
}elseif($psl == "topF"){
    echo $this->render('search/topF.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
}elseif($psl == "recommended"){
    echo $this->render('search/recommended.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
}
?>

<div style="height: 40px;"></div>