<?php 
use yii\helpers\Url;

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
?>

<div class="row" style="margin-bottom: 7px;">
    <a href="<?= Url::to(['member/forum'])?>"><div class="col-md-5ths ptop forum <?php echo($psl == "")? "forum_active" : "" ?>"><img src="/css/img/icons/populiariausi2<?php echo($psl == "")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;" /><br>Populiariausi</div></a>
    <a href="<?= Url::to(['member/forum', 'psl' => 'new'])?>"><div class="col-md-5ths ptop forum <?php echo($psl == "new")? "forum_active" : "" ?>"><img src="/css/img/icons/naujausi2<?php echo($psl == "new")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;" /><br>Naujausi</div></a>
    <a href="<?= Url::to(['member/forum', 'psl' => 'check'])?>"><div class="col-md-5ths ptop forum <?php echo($psl == "check")? "forum_active" : "" ?>"><img src="/css/img/icons/pazymeti<?php echo($psl == "check")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;" /><br>Pažymėti</div></a>
    <a href="<?= Url::to(['member/forum', 'psl' => 'mine'])?>"><div class="col-md-5ths ptop forum <?php echo($psl == "mine")? "forum_active" : "" ?>"><img src="/css/img/icons/pateikti<?php echo($psl == "mine")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;" /><br>Mano pateikti</div></a>
    <a href="<?= Url::to(['member/forum', 'psl' => 'drg'])?>"><div class="col-md-5ths ptop forum <?php echo($psl == "drg")? "forum_active" : "" ?>"><img src="/css/img/icons/draugu<?php echo($psl == "drg")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;" /><br>Draugų</div></a>
</div>