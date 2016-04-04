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
        'attribute'=>'username',
        'label' => 'Vardas', 
        'format' => 'raw',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'new_friends',
        'label' => 'Nauju žinuciu',
    ],
];

?>


<?php if($dataProvider->totalCount > 0): ?> 

    <a href="<?= Url::to(['site/users'])?>" class="btn btn-info" style="margin-bottom: 10px;">Išvalyti filtrus</a>
    
<?= \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
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
        'heading'=>'Fake nariai kurie turi neperskaitytų žinučių'
    ],
    'resizableColumns'=>true,
    'persistResize' => true,
    'resizeStorageKey'=>Yii::$app->session['admin']."msg"

]);
?>
<?php else: ?>

    <div class="alert alert-info">Naujų žinučių nėra</div>
<?php endif; ?>

