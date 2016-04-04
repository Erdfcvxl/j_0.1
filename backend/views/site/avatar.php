<?php

use yii\helpers\Url;

require(__DIR__ ."/../../../frontend/views/site/form/_list.php");

$dataInfo = $model->info;  

$timeDiff = time() - $model->lastOnline;

if($timeDiff <= 600){
    $online = 1;
}else{
    $online = 0;
}

?>

<?php

$d1 = new DateTime($dataInfo['diena'].'.'.$dataInfo['menuo'].'.'.$dataInfo['metai']);
$d2 = new DateTime();

$diff = $d2->diff($d1);

?>

<!-- Avataras -->
<div class="manualAvatar">
   <img class="cntrm" src="<?= \frontend\models\Misc::getAvatar($model); ?>"/>
</div>

<!-- Info -->
<div style="text-align: center; padding: 0px 2px;background-color: #fff; width: 100%;">
    <?php 
        $timeDiff = time() - $model->lastOnline;

        if($timeDiff <= 600){
            $online = 1;
        }else{
            $online = 0;
        }
        if($online):
    ?>
        <img src="/css/img/online.png" title="Prisijungęs" style="position: absolute; z-index: 1; margin-top: -14px; left: 0; margin-left: 1px;">
    <?php endif; ?>
    <span class="ProfName" style="font-size: 13px;"><?= $model->username; ?></span><br>

    <span class="ProfInfo" style="color: #5b5b5b; font-size: 11px; position: relative; top: -3px;"><?= $diff->y; ?>, <?= ($dataInfo['miestas'] !== '')? $list[$dataInfo['miestas']] : "Nenurodyta"; ?></span>
</div>

