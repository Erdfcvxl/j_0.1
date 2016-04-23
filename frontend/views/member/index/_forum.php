<?php 
use frontend\models\Forum;
use frontend\models\Post;
use frontend\models\CheckedForums;
use frontend\models\User;
use yii\helpers\Url;

$colors = ['#e1f1d7', '#d1f1ee'];

$sections = Forum::getSections('new');
?>

<div class="col-xs-12" style="padding: 0 5px;">
    Naujos diskusijos<br><br>
</div>

<div class="col-xs-6" style="padding: 0 5px;">
    <?php
        $i = 0;

        foreach ($sections['left'] as $forum) {
            $user = User::find()->where(['id' => $forum->u_id])->one();



            if(!$user) {
                continue;
            }


            if($user->avatar){
                $avataras = "/uploads/531B".$user->id."Iav.".$user->avatar;
            }else{
                $avataras = "/css/img/icons/no_avatar.png";
            }

            $post = Post::find()->where(['forum_id' => $forum->id])->all();

            $color = $colors[rand(0, 1)];

            ?>
                <a href="<?= Url::to(['member/post', 'id' => $forum->id, 'color' => $color]); ?>">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="forum_box container-fluid" style="background-color: <?= $color ?>;">
                                <div class="row" style="margin: 5px -10px;">
                                    <div class="col-xs-3" style="padding: 0 5px 0 0;"><img width="100%" src="<?= $avataras; ?>"></div>
                                    <div class="col-xs-9 forum_name"><?= $forum->name; ?></div>
                                </div>
                                <div class="row" style="margin: 5px 0 0;  position: relative;">
                                    <div class="col-xs-6 col-xs-offset-3" style="font-size: 10px; padding: 0;">
                                        Atsakymų: <?= count($post); ?>&nbsp &nbsp &nbsp
                                        Peržiūrų: <?= $forum->views; ?>
                                    </div>
                                    <div class="col-xs-3" style="padding-right: 0;">
                                        <?php if(!CheckedForums::isChecked($forum->id)): ?>
                                            <a href="<?= Url::to(['member/check', 'id' => $forum->id]); ?>"  title="Pridėti prie mėgstamiausių">
                                                <img src="/css/img/icons/sirdele_black.png" height="15px" style="position: absolute; top: -3px; left: 21px;">
                                                <div class="btn btn-reg btn-reg-new boxShadow" style="position: absolute; font-size:10px; padding: 0 4px; top: -4px; margin: 0; right: -17px;">Pažymėti</div>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= Url::to(['member/uncheck', 'id' => $forum->id]); ?>"  title="Ištrinti iš mėgstamiausių">
                                                <img src="/css/img/icons/baltas_sirdele.png" height="15px" style="position: absolute; top: -3px; left: 21px;">
                                                <div class="btn btn-reg btn-reg-new boxShadow" style="position: absolute; font-size:10px; padding: 0 4px; top: -4px; margin: 0; right: -17px;">Nužymėti</div>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
            $i++;
            if($i == 2){
                break;
            }
        }
    ?>
</div>

<div class="col-xs-6" style="padding-left: 0; padding-right: 5px;">
    <?php
        $i = 0;
        foreach ($sections['right'] as $forum) {
            $user = User::find()->where(['id' => $forum->u_id])->one();

            if(!$user) {
                continue;
            }

            if($user->avatar){
                $avataras = "/uploads/531B".$user->id."Iav.".$user->avatar;
            }else{
                $avataras = "/css/img/icons/no_avatar.png";
            }

            $post = Post::find()->where(['forum_id' => $forum->id])->all();

            $color = $colors[rand(0, 1)];

            ?>
                <a href="<?= Url::to(['member/post', 'id' => $forum->id, 'color' => $color]); ?>">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="forum_box container-fluid" style="background-color: <?= $color ?>;">
                                <div class="row" style="margin: 5px -10px;">
                                    <div class="col-xs-3" style="padding: 0 5px 0 0;"><img width="100%" src="<?= $avataras; ?>"></div>
                                    <div class="col-xs-9 forum_name"><?= $forum->name; ?></div>
                                </div>
                                <div class="row" style="margin: 5px 0 0;  position: relative;">
                                    <div class="col-xs-6 col-xs-offset-3" style="font-size: 10px; padding: 0;">
                                        Atsakymų: <?= count($post); ?>&nbsp &nbsp &nbsp
                                        Peržiūrų: <?= $forum->views; ?>
                                    </div>
                                    <div class="col-xs-3" style="padding-right: 0;">
                                        <?php if(!CheckedForums::isChecked($forum->id)): ?>
                                            <a href="<?= Url::to(['member/check', 'id' => $forum->id]); ?>">
                                                <img src="/css/img/icons/sirdele_black.png" height="15px" style="position: absolute; top: -3px; left: 21px;">
                                                <div class="btn btn-reg btn-reg-new boxShadow" style="position: absolute; font-size:10px; padding: 0 4px; top: -4px; margin: 0; right: -17px;">Pažymėti</div>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= Url::to(['member/uncheck', 'id' => $forum->id]); ?>">
                                                <img src="/css/img/icons/baltas_sirdele.png" height="15px" style="position: absolute; top: -3px; left: 21px;">
                                                <div class="btn btn-reg btn-reg-new boxShadow" style="position: absolute; font-size:10px; padding: 0 4px; top: -4px; margin: 0; right: -17px;">Nužymėti</div>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
            $i++;
            if($i == 2){
                break;
            }
        }
    ?>
</div>