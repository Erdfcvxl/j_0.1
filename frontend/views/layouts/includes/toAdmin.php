<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 4/21/2016
 * Time: 10:14 PM
 */

use yii\helpers\Url;

$url = Yii::$app->urlManagerBackend->createUrl(['index.php?r=site/glogin&p=+++']);

?>

<div style="position: absolute; margin: 5px;">
    <a href="<?= $url; ?>" class="btn btn-default" style="padding: 11px 15px 7px; font-size: 24px;"><span class="glyphicon glyphicon-king"></span></a>
</div>
