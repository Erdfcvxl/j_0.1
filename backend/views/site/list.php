<?php
use yii\widgets\ListView;
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?= ListView::widget( [
                'layout' => '<div style="float: left; width: 100%; ">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
                'dataProvider' => $dataProvider,
                'itemView' => '//site/_users',
            ] );
            ?>
        </div>
        <script type="text/javascript">
            $(".recentImgHolder img.cntrm").fakecrop({wrapperWidth: $('.recentImgHolder').width(),wrapperHeight: $('.recentImgHolder').width(), center: true });
        </script>
    </div>
</div>
