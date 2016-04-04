<?php
use yii\helpers\Url;
?>

<a href="<?= Url::to(['member/index']); ?>">
    <div class="col-xs-3" id="miniprofile" style="background-color: #95c501; height: 70px; padding: 0;">
        <div style="width:80%; text-align: center; font-family: OpenSansSemibold; color: white; position: absolute;"><span class="miniProfNam"><?= $user->username;?><?= \frontend\models\Misc::vip($user, '5A7900'); ?></span></div>
            <div class="wraperis" style="max-width: 100px; float: right;">
                <img src="<?= \frontend\models\Misc::getAvatar($user); ?>" height="70px" />
            </div>
    </div>
</a>