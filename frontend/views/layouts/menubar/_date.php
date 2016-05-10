<?php
use yii\helpers\Url;

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";

?>

<div class="row" style="margin-bottom: 7px;">
    <a href="<?= Url::to(['member/date'])?>"><div class="col-md-5ths ptop date <?php echo($psl == "index" || $psl == "")? "date_active" : "" ?>"><img src="/css/img/icons/megstami<?php echo($psl == "index" || $psl == "")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;"/><br>Tave pakvietė į pasimatymą</div></a>
    <a href="<?= Url::to(['member/date', 'psl' => 'tu'])?>"><div class="col-md-5ths ptop date <?php echo($psl == "draugu")? "date_active" : "" ?>"><img src="/css/img/icons/megsta<?php echo($psl == "tu")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;"/><br>Tu pakvietei į pasimatymą</div></a>
    <a href="<?= Url::to(['member/date', 'psl' => 'abipusiai'])?>"><div class="col-md-5ths ptop date <?php echo($psl == "draugu")? "date_active" : "" ?>"><img src="/css/img/icons/megsta<?php echo($psl == "abipusiai")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;"/><br>Abipusiai pasimatymai</div></a>
</div>
