<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ListView;
use kartik\daterange\DateRangePicker;
require(__DIR__ . '/../../../frontend/views/site/form/_list.php');
?>

<div class="container">
    <h1>Rašyti masinę žinutę iš fake nario</h1>

    <div class="row">
        <div class="col-xs-12 col-lg-3">
            <div style="width: 200px;">
                <?= $this->render('avatar', ['model' => $user]);?>

                Nario orentacija: <?= $orentacija[$user->info->orentacija]; ?>
            </div>

            <script type="text/javascript">
                $(".manualAvatar img.cntrm").fakecrop({wrapperWidth: 200,wrapperHeight: 200, center: true });
            </script>

            <br>

            <p>Žinutė visiems priešingos lyties ir tinkamos pakraipos nariams bus išsiųsta šio nario vardu.</p>

        </div>

        <div class="col-xs-12 col-lg-9">
            <p>Rašyti žinutę</p>

            <?php $form = ActiveForm::begin() ?>
            <?= Html::input('hidden', 'id', $user->id) ?>
            <?= Html::input('hidden', 'lytis', substr($user->info->iesko, 0, 1)) ?>

            <table class="table table-bordered" width="100%">
                <tr>
                    <th style="vertical-align: middle; text-align: center;">Gavėjai</th>
                </tr>

                <tr>
                    <td width="400px;">

                        <p class="text-center">Naudoti automtinį įvedimą <?= Html::input('radio', 'ivestis', 'auto', ['style' => 'display: inline-block;', 'checked' => true]) ?></p>

                        <p>
                            <?= Html::checkBox('mass[pla]', false) ?> Priešingos lyties atstovams (ne VIP'ams) &nbsp; &nbsp; &nbsp; &nbsp;
                            <?= Html::checkBox('mass[plaV]', false) ?> Priešingos lyties atstovams (VIP'ams)
                        </p>
                        <!--<p><?/*= Html::checkBox('mass[tpla]', false) */?> Tos pačios lyties atstovams (ne VIP'ams)</p>
                        <p><?/*= Html::checkBox('mass[tplaV]', false) */?> Tos pačios lyties atstovams (VIP'ams)</p>-->
                </tr>

                <tr>
                    <th><?= Html::submitButton('Ieškoti', ['class' => 'btn btn-primary', 'value'=>'Create & Add New', 'style' => 'width: 100%']) ?></th>
                </tr>

            </table>


            <br>


            <?php ActiveForm::end() ?>
        </div>

    </div>

</div>
