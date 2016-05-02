<?php

$stats = $model->msgStats();

?>

<h2>Tavo populiarumo analizė</h2>

<div class="row">
    <div class="col-xs-6 vcenter" style="text-align: center">

        <div class="arrow-left" style="position: absolute; right: 20px; top: 45px"></div>

        <div style="display: inline-block; margin: 20px 5px 0;">
            <div class="gSquare" style="width: 74px; height: 74px; padding-top: 18px"><?= $stats->p ?></div>
            <p style="margin:0">Populiarumo balas<br>&nbsp;</p>
        </div>

    </div>



    <div class="col-xs-6 vcenter">
        <div class="frame" style="font-size: 18px;">
            <p style="padding: 15px 5px;margin: 0; display: inline-block">Profilio peržiūros</p>

            <div class="hKvadratas gSquare" style="float: right"><?= $stats->profile_visits ?></div>
        </div>

        <br>

        <div class="frame" style="font-size: 18px;">
            <p style="padding: 15px 5px;margin: 0; display: inline-block">Nuotraukų pamėgimai</p>

            <div class="hKvadratas gSquare" style="float: right"><?= $stats->likes ?></div>
        </div>

        <br>

        <div class="frame" style="font-size: 18px;">
            <p style="padding: 15px 5px;margin: 0; display: inline-block">Gautos žinutės</p>

            <div class="hKvadratas gSquare" style="float: right"><?= $stats->msg_recieved ?></div>
        </div>

        <br>
    </div>

</div>



