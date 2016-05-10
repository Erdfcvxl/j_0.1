<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

use yii\widgets\Pjax;
use yii\widgets\ListView;
use frontend\models\UserSearch;

use frontend\models\Chat;
use frontend\models\User;

?>


<div class="container index-container">
    <div class="container-fluid rowme">

        <div class="row" style="padding: 15px 0">
            <?= $this->render('//member/index/zinutes'); ?>
        </div>


        <div class="row" style="padding-top:0;">
            <?= $this->render('//member/index/_pakvietimai'); ?>
        </div>


        <div class="row">
            <?= $this->render('//member/index/_likesFeed', ['dataProviderLikesFeed' => $dataProviderLikesFeed]);?>
        </div>


        <div class="row">
            <?= $this->render('//member/index/_noobai', ['dataNoobies' => $dataNoobies]); ?>
        </div>


        <div class="row">
            <?= $this->render('//member/index/_forum'); ?>
        </div>


        <div class="row">
            <?= $this->render('//member/index/_feed', ['dataProviderFeed' => $dataProviderFeed]); ?>
        </div>


    </div>
</div>


<script type="text/javascript">
    $(function(){
        $("#img").attr('src','');
    });
</script>
