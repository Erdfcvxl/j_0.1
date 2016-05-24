<?php

use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

?>


    <div class="container-fluid" style="text-align: center; padding-left: 0;">

        <div class="col-xs-12" style="padding: 7px 0px;background-color: #e8e8e8; ">

            <?php if(Yii::$app->session->getFlash('error')): ?>
                <div class="row" style="margin: 0 5px 1px 5px" >
                    <div class="col-xs-12">
                        <div class="alert alert-warning" style="margin: 0; padding: 10px 30px; text-align: left;"><?= Yii::$app->session->getFlash('error'); ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            $psl = (isset($_GET['psl']))? $_GET['psl'] : "";

            if($psl == "tu"){
                echo $this->render('pasimatymai/tu.php', ['dataProvider' => $dataProvider]);
            }else if($psl == "abipusiai"){
                echo $this->render('pasimatymai/abipusiai.php', ['dataProvider' => $dataProvider]);
            }else{
                echo $this->render('pasimatymai/index.php', ['dataProvider' => $dataProvider]);
            }
            ?>
        </div>

    </div>
