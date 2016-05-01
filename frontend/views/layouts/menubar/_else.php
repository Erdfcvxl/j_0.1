<?php 
use yii\helpers\Url;

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
?>

<div class="row" style="margin-bottom: 7px; background-color: #e3f1d0; ">
    <a href="<?= Url::to(['member/index'])?>"><div class="col-md-5ths ptop main <?php echo($puslapis == "index")? "main_active" : "" ?>"><img src="/css/img/icons/<?php echo($puslapis == "index")? "baltas_" : "" ?>sauktukas.png" /><br>Naujienos</div></a>
    <a href="<?= Url::to(['member/myfoto'])?>"><div class="col-md-5ths ptop main <?php echo($puslapis == "myfoto")? "main_active" : "" ?>"><img src="/css/img/icons/<?php echo($puslapis == "myfoto")? "baltas_" : "" ?>fotoaparatas.png" /><br>Mano Nuotraukos</div></a>
    <a href="<?= Url::to(['member/ilookfor'])?>"><div class="col-md-5ths ptop main <?php echo($puslapis == "ilookfor")? "main_active" : "" ?>"><img src="/css/img/icons/<?php echo($puslapis == "ilookfor")? "baltas_" : "" ?>sirdele.png" /><br>Aš ieškau</div></a>
    <a href="<?= Url::to(['member/manoanketa'])?>"><div class="col-md-5ths ptop main <?php echo($puslapis == "manoanketa")? "main_active" : "" ?>"><img src="/css/img/icons/<?php echo($puslapis == "manoanketa")? "baltas_" : "" ?>zmogeliukas.png" /><br>Mano anketa</div></a>
    <a href="<?= Url::to(['member/statistika'])?>"><div class="col-md-5ths ptop main <?php echo($puslapis == "statistika")? "main_active" : "" ?>"><img src="/css/img/icons/<?php echo($puslapis == "statistika")? "baltas_" : "" ?>zvaigzdute.png" /><br>Statistika</div></a>
</div>
