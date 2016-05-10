<?php

use yii\helpers\Url;

$toDo = (9 - $photos > 0) ? 9 - $photos : (9 + ceil(($photos+0.1) / 3 - 3) * 3) - $photos;


?>

<?php for($i = 0; $i < $toDo; $i++): ?>
    <a href="<?= Url::to(['member/uploadfoto']); ?>">
        <div class="col-xs-4 emptyPhoto kvadratas">
            <span class="glyphicon glyphicon-plus" style="font-size: 24px;"></span>
        </div>
    </a>
<?php endfor; ?>



