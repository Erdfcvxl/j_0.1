<?php
use yii\helpers\Url;

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";

?>

<div class="row" style="margin-bottom: 7px;">
    <a href="<?= Url::to(['member/date'])?>">
        <div class="col-md-5ths ptop date <?php echo($psl == "index" || $psl == "")? "date_active" : "" ?>">
            <img src="/css/img/icons/megsta<?php echo($psl == "index" || $psl == "")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;"/>
            <br>Su tavimi eitų
            <span class="msgCount btn btn-circle" id="megTopIndicator" style="<?= (\frontend\models\Pasimatymai::isNewPakviete() > 0)? 'display: block' : 'display: none;' ?>"><?= (\frontend\models\Pasimatymai::isNewPakviete() > 0)? \frontend\models\Pasimatymai::isNewPakviete() : "" ?></span>
        </div>
    </a>
    <a href="<?= Url::to(['member/date', 'psl' => 'tu'])?>">
        <div class="col-md-5ths ptop date <?php echo($psl == "draugu")? "date_active" : "" ?>">
            <img src="/css/img/icons/megsta<?php echo($psl == "tu")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;"/>
            <br>Tu eitum

        </div>
    </a>
    <a href="<?= Url::to(['member/date', 'psl' => 'abipusiai'])?>">
        <div class="col-md-5ths ptop date <?php echo($psl == "draugu")? "date_active" : "" ?>"><img src="/css/img/icons/megstami<?php echo($psl == "abipusiai")? "_w" : "_b" ?>.png" style="margin-top: -2px; margin-bottom: -2px;"/>
            <br>Abipusiai pasimatymai
            <span class="msgCount btn btn-circle" id="megTopIndicator" style="<?= (\frontend\models\Pasimatymai::isNewAbipusiai() > 0)? 'display: block' : 'display: none;' ?>"><?= (\frontend\models\Pasimatymai::isNewAbipusiai() > 0)? \frontend\models\Pasimatymai::isNewAbipusiai() : "" ?></span>
        </div>
    </a>
</div>
