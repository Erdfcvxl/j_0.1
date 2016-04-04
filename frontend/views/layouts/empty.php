<?php
/* @var $this yii\web\View */
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;


AppAsset::register($this);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>

    <?php $this->head() ?>


    <?php $this->beginBody() ?>

                
                <?= $content ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

