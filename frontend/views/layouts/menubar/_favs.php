<?php 
use yii\helpers\Url;

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";

?>

<div class="row" style="margin-bottom: 7px;">
    <a href="<?= Url::to(['member/favs'])?>"><div class="col-md-5ths ptop favs <?php echo($psl == "index" || $psl == "")? "favs_active" : "" ?>"><img src="/css/img/icons/megstami<?php echo($psl == "index" || $psl == "")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;"/><br>Mėgstami</div></a>
    <a href="<?= Url::to(['member/favs', 'psl' => 'draugu'])?>"><div class="col-md-5ths ptop favs <?php echo($psl == "draugu")? "favs_active" : "" ?>"><img src="/css/img/icons/megsta<?php echo($psl == "draugu")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;"/><br>Tave mėgsta</div></a>
</div>
