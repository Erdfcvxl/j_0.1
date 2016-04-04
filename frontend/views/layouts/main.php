<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Moderniausia pažinčių svetainė lietuviams Anglijoje, Airijoje, Škotijoje ir Velse! Rimtos pažintys Anglijoje ir Airijoje! Nemokama registracija!" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="..." >


    <?= Html::csrfMetaTags() ?>
    <title>Pažintys lietuviams</title>
    <?php $this->head() ?>
    <link href="/css/desktop.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="favicon.ico">
    <script type="text/javascript" src="/js/velocity.min.js"></script>
    <script type="text/javascript" src="/js/jquery.backstretch.min.js"></script>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">

        <div class="fade_back"></div>

        <?php 
            $r = (isset($_GET['r']) ? $_GET['r'] : ""); 
            $piece = explode("/", $r);
        ?>

        <?php if(isset($_GET['lost']) && $_GET['lost'] == "1"): ?>
            <script type="text/javascript">$('.fade_back').css({"display" : "block"});</script>

            <?= $this->render('//site/_lost'); ?>

        <?php endif; ?>


        <?= $content ?>

    </div>
    
    <footer class="footerMine">
        <div class="container">
            <div class="row">
                <div class="col-sm-4" style="font-size: 12px; color: #126e9f">
                    <table>
                        <tr>
                            <td width="80px;"><p>Privatumas</p></td>
                            <td><p>Rekomenduok draugams</p></td>
                        </tr>
                        <tr>
                            <td><p>Straipsniai</p></td>
                            <td><p><a href="mailto:pazintys@pazintyslietuviams.co.uk" target="_top">Kontaktai</a></p></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-8" style="color: #636363;">
                    <div class="row">
                        <div class="col-xs-12 foterioinfo">
                            <span style="font-size: 18px;"><B>&copy; Pazintyslietuviams.co.uk <?= date('Y') ?></b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 foterioinfo" style="font-size: 12px;">
                            <p>Pazintys Anglijoje &nbsp&nbsp&nbsp&nbsp Pazintys Airijoje &nbsp&nbsp&nbsp&nbsp Pazintys Londone &nbsp&nbsp&nbsp&nbsp Pazintys UK &nbsp&nbsp&nbsp&nbsp Nemokamos pažintys Anglijoje.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
