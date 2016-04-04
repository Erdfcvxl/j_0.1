<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
?>

<?php 
$left = (isset($_GET['l']))? $_GET['l']: 3;

$gridColumns = [
['class' => 'yii\grid\SerialColumn'],
    // the name column configuration
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'username',
        'label' => 'Slapyvardis',
        'format' => 'html',
        'value' => function ($model){
            return "<a href='".Url::to(['site/useredit', 'id' => $model->id])."''>".$model->username."</a>";
        },
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute'=>'email',
        'label' => 'El. paštas', 
        'format'=>'email',
    ],

    [
        'class' => 'kartik\grid\DataColumn',
        'attribute'=>'lastOnline',
        'label' => 'Prisijungęs', 
        'value' => function ($model){
            if($model->lastOnline == 0){ return "Dar neprisijungė"; }

            $ago = new \frontend\models\Ago;
            return $ago->timeAgo($model->lastOnline);
        },
        'format'=>'raw',
        'filter' => '<center><span style="color: grey">-</span></center>'
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute'=>'facebook',
        'label' => 'Registracija', 
        'value' => function ($model){
            return ($model->facebook)? "Per facebook" : "Paprasta";
        },
        'filter' => '<center><span style="color: grey">-</span></center>'
    ],

];

?>

<?php $form = ActiveForm::begin(['action' => Url::to(['site/soondead']), 'method' => 'GET']);?>
	
	<div class="row">
		<div class="col-xs-1" style="width: 50px; padding-right: 0"><?= Html::input('text', 'l', $left, ['style' => 'width : 50px; text-align:center;', 'class' => 'form-control']); ?></div>
		<div class="col-xs-2"><?= Html::submitButton('Nustatyti dienas',['class' => 'btn btn-default']); ?></div>
	</div>
	
	<br>

<?php ActiveForm::end(); ?>

<?= \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'autoXlFormat'=>true,
    'export'=>[
        'fontAwesome'=>true,
        'showConfirmAlert'=>false,
        'target'=>GridView::TARGET_BLANK
    ],
    'exportConfig' => [
	    GridView::EXCEL  => ['label' => 'Parsiųsti Excel failą'],
	    GridView::PDF   => ['label' => 'Parsiųsti PDF failą'],
	    GridView::TEXT => ['label' => 'Parsiųsti tekstinį failą'],
	],
	'toggleDataOptions' => [
		'showConfirmAlert' => false,
		'all' => [
	        'icon' => 'resize-full',
	        'class' => 'btn btn-default',
	        'title' => 'Rodyti visus įrašus',
	    ],
    ],
    'toolbar' => [
		'{toggleData}',
		'{export}',
	],
    'panel'=>[
        'type'=>'success',
        'heading'=> 'Vip nariai kurių galiojimas baigsis po <b>'.$left.'</b> dienų',
    ],
    'resizableColumns'=>true,
    'persistResize' => true,
    'resizeStorageKey'=>Yii::$app->session['admin']."msg"

]);
?>
