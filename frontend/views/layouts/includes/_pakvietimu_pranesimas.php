<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJs("$('<div class=\"curtains\" id=\"curtains\"></div>').prependTo('.wrap');");
$invite = \frontend\models\Invite::find()
    ->where(['sender' => Yii::$app->user->id])
    ->andWhere(['points_added' => 1])
    ->andWhere(['<>', 'receiver', '0'])
    ->andWhere(['seen' => 0])
    ->one();

$user = \common\models\User::findOne($invite->receiver);
//var_dump($invite);


?>
    <div class="pakvietimuInfoBox">
        <h4><span style="color: #56adfa; text-shadow: 1px 1px 1px #c5c5c5;">Pakvietėte draugą, gavote <b>10</b> širdelių</span></h4>

        <div class="container-fluid">Sveikiname pakvietus draugą <?php if (isset($user) && $user != null) echo '(<i>' . $user->username . '</i>) '; ?>bei gavus <b>10</b> širdelių, kurias išleisti galėsite dovanodami dovanėles pazintyslietuviams.co.uk portale.</div>
        <br>
        <?php $form = ActiveForm::begin([]); ?>
        <?= Html::submitButton('Gerai', ['class' => 'btn btn-reg', 'style' => ' font-size: 16px;', 'name' => 'perskaiciau-pakvietimo-info', 'value' => $invite->id]) ?>
        <?php ActiveForm::end() ?>
    </div>