<?php
use frontend\models\Forum;
use yii\helpers\Url;

$forum = Forum::find()->where(['id' => $model->forum_id])->one();
?>

<div class="row" style="margin-top: 10px;">
    <div class="col-xs-12">
        <a class="a-primary" href="<?= Url::to(['member/post', 'id' => $model->forum_id])?>"><b><?= $forum->name;?></b></a>
    </div>
</div>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-xs-12">
        Tavo atsakymų: <?= $model->count; ?>&nbsp &nbsp &nbsp
        Forumo peržiūrų: <?= $forum->views; ?>
    </div>
</div>



