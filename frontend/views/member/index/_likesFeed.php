<?php
use yii\widgets\ListView;
?>

<?= ListView::widget( [
    'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
    'dataProvider' => $dataProviderLikesFeed,
    'itemView' => '//member/_Likesfeed',
    'emptyText' => '',
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