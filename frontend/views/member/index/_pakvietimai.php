<?php 
use yii\helpers\Url;

$pakvietimaiKiti = \frontend\models\Pakvietimai::find()->where(['reciever' => Yii::$app->user->identity->id])->all();

if($pakvietimaiKiti):


    foreach($pakvietimaiKiti as $kvietimas):

        if($user = \frontend\models\User::find()->where(['id' => $kvietimas->sender])->one()):
        
            $dataInfo = \frontend\models\Info2::find()->where(['u_id' => $kvietimas->sender])->one();

            $d1 = new DateTime($dataInfo['diena'].'.'.$dataInfo['menuo'].'.'.$dataInfo['metai']);
            $d2 = new DateTime();

            $diff = $d2->diff($d1);

            require(__DIR__ ."/../../site/form/_list.php");

            $atitikimai = new frontend\models\Atitikimai;

            $keys = $atitikimai->main($user);

            ?>

            <div class="row">
                <div class="col-xs-12" style="background-color: #95c501;margin-bottom: 8px;"><?= $user->username; ?> siūlio tapti draugais</div>
            </div>

            <div class="row">

                <div class="col-xs-3" style="padding: 0;">
                    
                    <div style="position: relative;">
                        <?php if($user->avatar): ?>
                           <img src="/uploads/531B<?= $user->id; ?>Iav.<?= $user->avatar; ?>" width="100%" />
                        <?php else: ?>
                            <img src="/css/img/icons/no_avatar.png" width="100%" />
                        <?php endif;?>
                        <?php 
                            $timeDiff = time() - $user->lastOnline;

                            if($timeDiff <= 600){
                                $online = 1;
                            }else{
                                $online = 0;
                            }
                            if($online):
                        ?>
                            <img src="/css/img/online.png" title="Prisijungęs" style="position: absolute; z-index: 1; margin-top: -14px; margin-left: 1px; left: 0; bottom: 1px;">
                        <?php endif; ?>
                    </div>

                </div>

                <div class="col-xs-5" style="">

                    <span class="ProfName" style="font-size: 20px; color: #93c501;"><?= $user->username; ?></span><br>
                    <span class="ProfInfo" style="color: #262626; font-size: 11px; position: relative; top: -3px;"><?= $diff->y; ?> metai, <?= $list[$dataInfo->miestas]; ?></span>

                    <div>
                        <a href="<?= Url::to(['member/acceptinvitation', 'id' => $user->id]); ?>" class="btn btn-reg" style="padding: 1px 10px; width: 85%; border-radius: 0; margin: 0 0 5px;">PRIIMTI</a>
                        <a href="<?= Url::to(['member/declineinvitation', 'id' => $user->id]); ?>" class="btn btn-reg" style="padding: 1px 10px; width: 85%; border-radius: 0; background-color: #d9a0a7; margin: 0 0 5px;">ATMESTI</a>
                        <a href="<?= Url::to(['member/user', 'id' => $user->id])?>" class="btn btn-reg" style="padding: 1px 10px; width: 85%; border-radius: 0; background-color: #fefff5; margin: 0 0 5px; color: #95c501; border: 2px solid #95c501;">PERŽIŪRĖTI PROFILĮ</a>
                    </div>

                </div>

                 <div class="col-xs-4" >

                    <img src="/css/img/sirdeles.png" style="position: absolute; left: -55px; top: -12px">
                    <div style="border: 1px solid #95c501; background-color: #d7d7d7; padding: 12px 10px 8px; margin-left: -55px; width: 80%;">
                    <?php 
                        foreach($keys as $atitikmuo){
                            echo $atitikmuo."<br>";
                        }
                    ?>
                    </div>

                 </div>

            </div>

        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>