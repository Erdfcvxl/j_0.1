<?php
use yii\widgets\ListView;

?>

<h2>Tavo veikla forume</h2>
    
<div class="row">
    <div class="col-xs-6">

        <div class="frame" style="font-size: 18px;">
            <p style="padding: 15px 5px;margin: 0; display: inline-block">Sukurti forumai</p>

            <div class="hKvadratas gSquare" style="float: right"><?= $dataProvider[0]->getCount(); ?></div>
        </div>

        <div class="arrow-down" style="margin: auto auto;"></div>


        <div class="frame" style="padding: 0px 10px; margin-top: 15px;">
            <?= ListView::widget( [
                'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
                'dataProvider' => $dataProvider[0],
                'itemView' => '//member/statistika/_openedForums',
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



    <div class="col-xs-6">

        <div class="frame" style="font-size: 18px;">
            <p style="padding: 15px 5px;margin: 0; display: inline-block">Atsakymų forumuose</p>

            <div class="hKvadratas gSquare" style="float: right"><?= $model->postForum(); ?></div>
        </div>

        <div class="arrow-down" style="margin: auto auto;"></div>


        <div class="frame" style="padding: 0px 10px; margin-top: 15px;">
            <?= ListView::widget( [
                'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
                'dataProvider' => $dataProvider[1],
                'itemView' => '//member/statistika/_atsForums',
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


</div>
