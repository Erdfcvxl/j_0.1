<?php
use yii\helpers\Url;

if(frontend\models\Misc::iga()):
?>

<a href="<?= Url::to(['member/delete', 'class' => '\frontend\models\Post', 'k' => 'id', 'v' => $id]); ?>" class="glyphicon glyphicon-trash"></a>

<?php endif; ?>