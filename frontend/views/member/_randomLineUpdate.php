<?php

use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\widgets\ActiveForm;

use yii\widgets\ListView;


?>


<?= ListView::widget( [
    'layout' => '
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                {items}                    
            </div>
        ',
    'dataProvider' => $dataProvider,
    'itemView' => '//member/_LWforrandomLineUpdate',

    ] ); 

?>

<?php if($dataProvider->getTotalCount() > 8): ?>
    <div class="goRight">
        <a href="<?= Url::to(['member/msg', 'additional' => $username]); ?>">&#x25BC;</a>
    </div>
<?php endif; ?>
   