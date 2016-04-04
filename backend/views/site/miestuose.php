<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

require(__DIR__ ."/../../../frontend/views/site/form/_list.php");

Yii::$app->params['list'] = $list;


?>

<?php 


$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute'=>'miestas',
        'label' => 'Miestas', 
        'value' => function ($model, $key, $index, $widget){
            return Yii::$app->params['list'][$model->miestas];
        },
        'format' => 'raw',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'num_of_users',
        'label' => 'Narių skaičius',
    ],
];

?>

<a href="<?= Url::to(['site/users'])?>" class="btn btn-info" style="margin-bottom: 10px;">Išvalyti filtrus</a>

<?= \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'filterModel' => $searchModel,
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
        'type'=>'primary',
        'heading'=>'Prisiregistravusių narių miestuose'
    ],
    'resizableColumns'=>true,
    'persistResize' => true,
    'resizeStorageKey'=>Yii::$app->session['admin']."miestuose"

]);

?>
