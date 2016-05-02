<?php

$stats = $model->msgStats();

?>

<h2>Tavo nuotraukų pamėgimai</h2>

<div class="row">
    <div class="col-xs-6 vcenter">

        <div class="frame" style="font-size: 18px;">
            <p style="padding: 15px 5px;margin: 0; display: inline-block">Nuotraukų pamėgimai</p>

            <div class="hKvadratas gSquare" style="float: right"><?= $stats->likes ?></div>
        </div>

        <br>

    </div>

</div>