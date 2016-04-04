<?php 
use yii\helpers\Url;
?>


<div class="row settings-ptop" style="margin-bottom: 7px;">
    <a href="<?= Url::to(['member/settings'])?>"><div class="col-md-5ths ptop ptop-single <?php echo($puslapis == "settings")? "active_sub_nav" : "" ?>"><img src="/css/img/icons/nustatymai<?php echo($puslapis == "settings")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;"/><br>Visi nustatymai</div></a>
    <a href="<?= Url::to(['member/help'])?>"><div class="col-md-5ths ptop ptop-single <?php echo($puslapis == "help")? "active_sub_nav" : "" ?>"><img src="/css/img/icons/pagalba<?php echo($puslapis == "help")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;"/><br>Pagalba</div>
    <a href="<?= Url::to(['member/duk'])?>"><div class="col-md-5ths ptop ptop-single <?php echo($puslapis == "duk")? "active_sub_nav" : "" ?>"><img src="/css/img/icons/duk<?php echo($puslapis == "duk")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;" /><br>D.U.K</div></a>
</div>
