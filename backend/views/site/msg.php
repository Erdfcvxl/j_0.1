<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


require(__DIR__ ."/../../../frontend/views/site/form/_list.php");

Yii::$app->params['list'] = $list;


?>

<?php

$datepicker2 = DateRangePicker::widget([
	'name'=>'sent',
	'convertFormat'=>true,
	'pluginOptions'=>[
		'locale'=>[
			'format'=>'Y-m-d',
			'separator'=>' - ',
		],
	],
	'hideInput' => true,
	'containerTemplate' => '
        <span class="input-group-addon">
            <i class="glyphicon glyphicon-calendar"></i>
        </span>
        <span class="form-control text-right">
            <span class="pull-left">
                <span class="range-value">{value}</span>
            </span>
            {input}
        </span>
    ',
]);


$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute'=>'username',
        'label' => 'Vardas',
		'format' => 'raw'
    ],
	['class' => 'kartik\grid\DataColumn',
		'attribute'=> 'username',
		'label' => 'Į žinutes',
		'format' => 'html',
		'value' => function($model){
			$url = Url::to(['site/godmode', 'loginTo' => $model['sender'], 'redirectTo' => 'member/msg']);
			return "<a href='".$url."' class='btn btn-primary' style='padding: 0 5px;'>Prisijungti </a>";
		}
	],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'sent_messages',
        'label' => 'Išsiųstos žinutės',
    ],
];

?>

<a href="<?= Url::to(['site/users'])?>" class="btn btn-info" style="margin-bottom: 10px;">Išvalyti filtrus</a>


<?php $form = ActiveForm::begin(['method' => 'GET']); ?>
<div class="row">
	<div class="col-xs-12">Filtruoti pagal susirašinėjimo laiką</div>
</div>

<div class="row">
	<div class="col-xs-5">
		 <?= $datepicker2; ?>
	</div>
	<div class="col-xs-7" style="padding-left:0">
		<?= Html::submitButton('Filtruoti', ['class' => 'btn btn-primary']) ?>
	</div>
</div>
<?php ActiveForm::end(); ?>

<Br>

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
        'type'=>'primary',
        'heading'=>'Išsiųstų žinučių skaičius'
    ],
    'resizableColumns'=>true,
    'persistResize' => true,
    'resizeStorageKey'=>Yii::$app->session['admin']."msg"

]);

?>

