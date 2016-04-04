<?php

use yii\widgets\ListView;
use frontend\models\Feed;
use yii\widgets\Pjax;

?>

<div class="container-fluid">
	<?= ListView::widget( [
	    'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
	    'dataProvider' => $dataProvider,
	    'itemView' => '//member/_feed',
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

