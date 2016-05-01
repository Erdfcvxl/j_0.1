<?php
use frontend\models\Post;
use yii\helpers\Url;

$post = Post::find()->where(['forum_id' => $model->id])->count();
?>

<div class="row" style="margin-top: 10px;">
    <div class="col-xs-12">
        <a class="a-primary" href="<?= Url::to(['member/post', 'id' => $model->id])?>"><b><?= $model->name;?></b></a>
    </div>
</div>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-xs-12">
        Atsakymų: <?= $post; ?>&nbsp &nbsp &nbsp
        Peržiūrų: <?= $model->views; ?>
    </div>
</div>



