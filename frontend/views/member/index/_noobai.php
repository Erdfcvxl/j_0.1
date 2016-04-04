<?php
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;
?>

<div class="col-xs-3" style="padding-left: 5px;">
    Naujos anketos
</div>

<div class="col-xs-9" style="padding-right: 5px; text-align: right;">
    <?php 
        $filtras['vip'] = (isset($_GET['vip']) && $_GET['vip'])? 0 : 1;
        $filtras['on'] = (isset($_GET['on']) && $_GET['on'])? 0 : 1;
    ?>
    <a href="<?= Url::current(['on' => $filtras['on']]);?>" class="btn btn-default"><span class="indicator <?= (!$filtras['on'])? 'on' : ''; ?>"></span>Prisijungę nariai</a>
    <a href="<?= Url::current(['vip' => $filtras['vip']]);?>" class="btn btn-default"><span class="indicator <?= (!$filtras['vip'])? 'on' : ''; ?>"></span>VIP nariai</a>
</div>


<br><br>


<?php Yii::$app->params['close'] = 0; ?>
<?php Pjax::begin();?>
<?= ListView::widget( [
    'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
    'dataProvider' => $dataNoobies,
    'itemView' => '//member/_searchResult',
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
<script type="text/javascript">
    $(".recentImgHolder img.cntrm").fakecrop({wrapperWidth: $('.recentImgHolder').width(),wrapperHeight: $('.recentImgHolder').width(), center: true });
</script>
        

<?php Pjax::end(); ?>
