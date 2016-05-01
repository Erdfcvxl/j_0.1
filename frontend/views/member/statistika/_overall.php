<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 4/28/2016
 * Time: 11:46 PM
 */

use frontend\models\User;
use yii\helpers\Url;

if($rating):
?>

<div class="row">
    <div class="col-xs-6" style="padding-right: 0">

        <?php
        $i = 0;

        foreach ($models as $model):

            $i++;
            $avatar = \frontend\models\Misc::getAvatarADP($model);
        ?>

            <div style="display: inline-block; text-align: center; font-size: 16px;">
                <a href="<?= Url::to(['member/user', 'id' => $model['id']]);?>">
                    <div class="recentImgHolder">
                        <img src="<?= $avatar ?>" class="cntrm" width="35px;" style="border: 1px solid #95c501">
                    </div>
                </a>

                <?= $i; ?>
            </div>

        <?php endforeach; ?>

        <script type="text/javascript">
            $(".recentImgHolder img.cntrm").fakecrop({wrapperWidth: $('.recentImgHolder').width(),wrapperHeight: $('.recentImgHolder').width(), center: true });
        </script>

    </div>

    <div class="col-xs-6" style="font-size: 16px; padding-left: 5px; margin-top: 9px;">
        <b>...<span style="font-size: 24px;"><?= $rating; ?></span></b> iš <?= User::find()->count()?>
    </div>
</div>

<?php else: ?>
    <div class="row">
        <div class="col-xs-2 vcenter">
            <div class="arrow-left" style="margin: 12px 0;"></div>
        </div>
        <div class="col-xs-10 vcenter" style="font-size: 18px;">
            Pasirinkite kategoriją
        </div>
    </div>

<?php endif; ?>





