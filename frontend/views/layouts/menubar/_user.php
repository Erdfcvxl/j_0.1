<?php 
use yii\helpers\Url;

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";

?>

<div class="row" style="margin-bottom: 7px; background-color: #e3f1d0; ">
    <a href="<?= Url::to(['member/user', 'id' => $_GET["id"]])?>"><div class="col-md-5ths ptop main <?php echo($puslapis == "user")? "main_active" : "" ?>"><img src="/css/img/icons/<?php echo($puslapis == "user")? "baltas_" : "" ?>sauktukas.png" /><br>Pokalbio istorija</div></a>
    <a href="<?= Url::to(['member/fotos', 'id' => $_GET["id"], 'psl' => 'p'])?>"><div class="col-md-5ths ptop main <?php echo($puslapis == "fotos" || $puslapis == "fotosalbumview")? "main_active" : "" ?>"><img src="/css/img/icons/<?php echo($puslapis == "fotos" || $puslapis == "fotosalbumview")? "baltas_" : "" ?>fotoaparatas.png" /><br>Nuotraukos</div></a>
    <a href="<?= Url::to(['member/iesko', 'id' => $_GET["id"]])?>"><div class="col-md-5ths ptop main <?php echo($puslapis == "iesko")? "main_active" : "" ?>"><img src="/css/img/icons/<?php echo($puslapis == "iesko")? "baltas_" : "" ?>sirdele.png" /><br>Ieško</div></a>
    <a href="<?= Url::to(['member/anketa', 'id' => $_GET["id"]])?>"><div class="col-md-5ths ptop main <?php echo($puslapis == "anketa")? "main_active" : "" ?>"><img src="/css/img/icons/<?php echo($puslapis == "anketa")? "baltas_" : "" ?>zmogeliukas.png" /><br>Anketa</div></a>
    <div class="col-md-5ths ptop main disabled" style="opacity: 0.5"><img src="/css/img/icons/zvaigzdute.png" /><br>Statistika</div>
</div>
