<?php

use yii\base\Security;
use yii\helpers\Url;

$url = Url::to([
    'site/invite',
    'id' => $invitecode,
], true);

?>

<center>

    <img src="<?= $message->embed($logo); ?>" height="70" style="display: inline-block;">


    <p style="font-size: 20px; color:#000; font-family: OpenSans;">

            Prisijungti prie pazintyslietuviams.co.uk puslapio pakvietė <b><?= $user; ?></b><br><br>

            Kad užsiregistuotumėte spauskite šią nuorodą:
            <a href='<?= $url; ?>'>spausti čia</a><br><br>

            Arba nusikopijuokite žemiai esančią nuorodą:<br> <?= $url; ?>
        
    </p>


    <div style="padding: 80px 0; margin-top: 80px; position: relative;">


        <img src="<?= $message->embed($avatars); ?>">


        <div style="margin-top: -100px; ">

            <a href="https://pazintyslietuviams.co.uk"><img src="<?= $message->embed($link); ?>"></a>

        </div>


    </div>


</center>