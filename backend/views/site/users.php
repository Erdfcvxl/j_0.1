<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;


require(__DIR__ ."/../../../frontend/views/site/form/_list.php");
Yii::$app->params['orentacija'] = $orentacija;

?>

<?php 
$datepicker = DateRangePicker::widget([
	'name'=>'expires',
	'value' => $searchModel->expires,
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

$datepicker2 = DateRangePicker::widget([
	'name'=>'created_at',
	'value' => $searchModel->created_at,
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
    [
        'class' => 'kartik\grid\DataColumn',
        'label' => '#',
        'value' => function ($model, $key, $index, $column) {
            return $column->grid->dataProvider->totalCount - $index + 1;
        }
    ],
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
        'attribute'=>'iesko',
        'label' => 'Lytis', 
        'value' => function ($model){
            if(substr($model->iesko, 0,1) == "v"){ return "Vyras"; }
            else{return "Moteris";}
        },
        'format'=>'raw',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute'=>'orentacija',
        'label' => 'Orentacija', 
        'value' => function ($model){
            return ($model->orentacija)?Yii::$app->params['orentacija'][$model->orentacija] : '<span class="not-set">(Nenustatyta)</span>';
        },
        'format'=>'raw',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute'=>'gimimoTS',
        'label' => 'Amžius', 
        'value' => function ($model){
            $d1 = new DateTime();
            $d1->setTimestamp($model->gimimoTS);
            $d2 = new DateTime();

            $diff = $d2->diff($d1);
            return $diff->y;
        },
        'format'=>'raw',
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
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute'=>'expires',
        'label' => 'Galioja iki', 
        'format' => ['date', 'php:Y-m-d'],
        'filter' => $datepicker,
 
        'contentOptions' =>function ($model, $key, $index, $column){
                return ['class' => 'expires'];
        },
        'content'=>function($data){
            return ($data->expires == 0)? "Dar neprasidėjo nemokama para" : date('Y-m-d', $data->expires);
        },
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute'=>'created_at',
        'label' => 'Užsiregistravo', 
        'format' => ['date', 'php:Y-m-d'],
        'filter' => $datepicker2,
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute'=>'f',
        'label' => 'Fake', 
        'value' => function ($model){
            return ($model->f == 1)? "Taip" : "Ne";
        },
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute'=>'vip',
        'label' => 'Vip', 
        'value' => function ($model){
            return ($model->vip == 1)? "Taip" : "Ne";
        },
    ],
];

?>

<div class="row">
    <div class="col-xs-2">
        <a href="<?= Url::to(['site/users'])?>" class="btn btn-info" style="margin-bottom: 10px;">Išvalyti filtrus</a>
    </div>
    <div class="col-xs-10" style="text-align: right;">
        <?= \yii\bootstrap\ButtonDropdown::widget([
            'label' => 'Narių per puslapį',
            'dropdown' => [
                'items' => [
                    ['label' => '20', 'url' => Url::current(['ps' => 20])],
                    ['label' => '50', 'url' => Url::current(['ps' => 50])],
                    ['label' => '100', 'url' => Url::current(['ps' => 100])],
                    ['label' => '200', 'url' => Url::current(['ps' => 200])],
                    ['label' => '300', 'url' => Url::current(['ps' => 300])],
                    ['label' => '500', 'url' => Url::current(['ps' => 500])],
                    ['label' => '1000', 'url' => Url::current(['ps' => 1000])],
                ],
            ],
        ]); ?>    
    </div>
</div>





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
        'heading'=>'Kadanors prisijungę nariai'
    ],
    'resizableColumns'=>true,
    'persistResize' => true,
    'resizeStorageKey'=>Yii::$app->session['admin']."users"

]);

?>

<?php
/* GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
    	['class' => 'yii\grid\SerialColumn'],


    	'username:text:Slapyvardis',
    	'email:email:El. paštas',
    	[
    		'label' => "Galiojimo pabaiga",
    		'class' => 'kartik\daterange\DateRangePicker',
    		'attribute' => 'expires',
    		'format' => 'datetime',
    		
    		//':datetime:Galiojimo pabaiga'
    	],
    	[
    		'label' => "Galiojimo pabaiga",
    		'attribute' => 'expires_end',
    		'format' => 'raw',
    	],
    	'created_at:datetime:Registracijos data',

    ],


]);*/
 ?>