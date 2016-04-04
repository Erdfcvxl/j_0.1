<?php
/*
 * @$model->id
 * @$model->username
 * @$model->lastOnline
 * @$model->lastOnline
 *
 * INFO
 * @diena
 * @menuo
 * @metai
 * @miestas
 */
use yii\helpers\Url;

require(__DIR__ ."/../../../../frontend/views/site/form/_list.php");

$dataInfo = $model->info;
$welcome = \backend\models\Welcome::find()->where(['u_id' => $model->id])->one();

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

<div class="row">

    <div class="col-xs-5">

            <!-- Avataras -->
            <div id="a<?= $model->id; ?>" class="recentImgHolder2">
                <img id="imga<?= $model->id; ?>" class="cntrm2" src="<?= \frontend\models\Misc::getAvatar($model); ?>" width="100%" />
            </div>

            <!-- Info -->
            <div class="col-xs-12" style="text-align: center; padding: 0px 2px;background-color: #fff;">
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

    </div>

    <div class="col-xs-7">
        <a href="<?= Url::to(['site/removefromwelcome', 'id' => $model->id]); ?>" class="glyphicon glyphicon-remove" title="Išjungti"></a>

        <div class="row">
            <div class="col-xs-12">
                <textarea id="msg_<?= $model->id;?>" u_id="<?= $model->id;?>" placeholder="Žinutė kurią siųs automatiškai" style="width:100%;"><?= $welcome->msg; ?></textarea>
            </div>
        </div>

        <span u_id="<?= $model->id;?>" class="submit btn btn-primary">Atnaujinti žinutę</span>
    </div>

</div>

<hr>








