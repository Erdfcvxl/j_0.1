<?php
use yii\widgets\ListView;

?>
<h2>Tavo anketą žiūrėję žmonės</h2>

<div class="col-xs-4">
	
</div>

<div class="col-xs-8">
	<div class="frame">
		<?php Yii::$app->params['close'] = 0; ?>

		<?= ListView::widget( [
		    'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
		    'dataProvider' => $dataProvider,
		    'itemView' => '//member/statistika/_views',
		    'pager' =>[
		        'maxButtonCount'=>0,
		        'nextPageLabel'=>'Kitas &#9658;',
		        'nextPageCssClass' => 'removeStuff',
		        'prevPageLabel'=>'&#9668; Atgal',
		        'prevPageCssClass' => 'removeStuff',
		        'disabledPageCssClass' => 'off',
		    ]

		    ] ); 
		?>
	</div>
</div>

