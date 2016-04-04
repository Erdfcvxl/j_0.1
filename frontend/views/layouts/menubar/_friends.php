<?php 
use yii\helpers\Url;

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
?>

<div class="row" style="margin-bottom: 7px;">
    <a href="<?= Url::to(['member/friends'])?>"><div class="col-md-5ths ptop friends <?php echo($puslapis == "friends" && $psl == "")? "friends_active" : "" ?>"><img src="/css/img/icons/nariai<?php echo($puslapis == "friends" && $psl == "")? "_w" : "_g" ?>.png" style="margin-top: -2px; margin-bottom: -2px;" /><br>Draugai</div></a>
    <a href="<?= Url::to(['member/friends', 'psl' => 'news'])?>"><div class="col-md-5ths ptop friends <?php echo($psl == "news")? "friends_active" : "" ?>"><img src="/css/img/icons/draugu<?php echo($psl == "news")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;" /><br>Draugų naujienos</div></a>
</div>