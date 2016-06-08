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

require(__DIR__ . "/../site/form/_list.php");

$dataInfo = $model->info;

$timeDiff = time() - $model->lastOnline;

if ($timeDiff <= 600) {
    $online = 1;
} else {
    $online = 0;
}

?>

<?php
if ($dataInfo['diena'] != NULL && $dataInfo['menuo'] != NULL && $dataInfo['metai'] != NULL)
{
    $d1 = new DateTime($dataInfo['diena'] . '.' . $dataInfo['menuo'] . '.' . $dataInfo['metai']);
    $d2 = new DateTime();

    $diff = $d2->diff($d1);
}


if (isset(Yii::$app->params['close'])) {
    Yii::$app->params['close']++;
}

/*
prie session prideda ++, kai session daugiau negu 6 uzdedi </div><div class="row">. Kitas </div> turi buti viduje pacio search failo dalyje.
*/
?>
<div class="col-xs-2" style="padding: 5px 5px;">

    <a href="<?= Url::to(['member/user', 'id' => $model->id]) ?>">

        <!-- Avataras -->
        <div id="a<?= $model->id; ?>" class="recentImgHolder">
            <img id="imga<?= $model->id; ?>" class="cntrm" src="<?= \frontend\models\Misc::getAvatar($model); ?>"
                 width="100%"/>
        </div>

        <!-- Info -->
        <div class="col-xs-12" style="text-align: center; padding: 0px 2px;background-color: #fff;">
            <?php
            $timeDiff = time() - $model->lastOnline;

            if ($timeDiff <= 600) {
                $online = 1;
            } else {
                $online = 0;
            }
            if ($online):
                ?>
                <img src="/css/img/online.png" title="Prisijungęs"
                     style="position: absolute; z-index: 1; margin-top: -14px; left: 0; margin-left: 1px;">
            <?php endif; ?>
            <span class="ProfName"
                  style="font-size: 13px;"><?= $model->username; ?><?= \frontend\models\Misc::vip($model); ?></span><br>

	            <span class="ProfInfo"
                      style="color: #5b5b5b; font-size: 11px; position: relative; top: -3px;"><?= ($diff->y) ? $diff->y . ',' : ""; ?>

                    <?= ($dataInfo['miestas'] != '' && $dataInfo['miestas']) ? \frontend\models\City::findOne((int)$dataInfo['miestas'])->title : "Nenurodyta"; ?>

                    <?php
                    if (isset($rodyti_kilometrus) && $rodyti_kilometrus == 1)
                    {
                        echo '<br>';
                        if (isset($miestas_temp) && (string)$miestas_temp != null) {
                            echo round(\frontend\models\City::getUser_miestas_distance($miestas_temp, $model->id), 0);
                        } else {
                            echo round(\frontend\models\City::getDistance(Yii::$app->user->id, $model->id), 0);
                        }
                        echo ' km.';
                    }

                    ?></span>

        </div>
    </a>

</div>

<?php if (isset(Yii::$app->params['close']) && Yii::$app->params['close'] > 5):
Yii::$app->params['close'] = 0; ?>

</div>
<div class="row" style="padding-left: 15px; padding-right: 15px;">

    <?php endif; ?>


    <?php //$this->registerJs($this->render('script.js')); ?>




