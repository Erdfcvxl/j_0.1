<?php 
use yii\helpers\Url;
use frontend\models\User;

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
$user = User::find()->where(['id' => Yii::$app->user->id])->one();
?>

<div class="row search-ptop">
    <a href="<?= Url::to(['member/search', 'psl' => 'detail'])?>"><div class="col-md-5ths ptop <?php echo($psl == "detail")? "active_sub_nav" : "" ?>"><img src="/css/img/icons/<?php echo($psl == "detail")? "paieska_w" : "paieska_g" ?>.png" /><br>Detali paieška</div></a>
    <a href="<?= Url::to(['member/search', 'psl' => 'new'])?>"><div class="col-md-5ths ptop <?php echo($psl == "new")? "active_sub_nav" : "" ?>"><img src="/css/img/icons/<?php echo($psl == "new")? "prisijunge_w" : "prisijunge_g" ?>.png" /><br>Naujai prisijungę</div></a>
    <a href="<?= Url::to(['member/search', 'psl' => 'top'])?>"><div class="col-md-5ths ptop <?php echo($psl == "top")? "active_sub_nav" : "" ?>"><img src="/css/img/icons/<?php echo($psl == "top")? "top_w" : "top_g" ?>.png" /><br>Top</div></a>
    <a href="<?= Url::to(['member/search', 'psl' => 'topF'])?>"><div class="col-md-5ths ptop <?php echo($psl == "topF")? "active_sub_nav" : "" ?>"><img src="/css/img/icons/<?php echo($psl == "topF")? "populiariausi_w" : "populiariausi_b" ?>.png" /><br>Top nuotraukos</div></a>
    <a href="<?= Url::to(['member/search', 'psl' => 'recommended'])?>"><div class="col-md-5ths ptop <?php echo($psl == "recommended")? "active_sub_nav" : "" ?>"><img src="/css/img/icons/<?php echo($psl == "recommended")? "rekomenduojami_w" : "rekomenduojami_g" ?>.png" /><br>Rekomenduojami<span class="msgCount btn btn-circle" id="srcTopIndicator" style="<?= ($user->new > 0)? 'display: block' : 'display: none;' ?>"><?= ($user->new > 0)? $user->new : "" ?></span></div></a>
</div>
