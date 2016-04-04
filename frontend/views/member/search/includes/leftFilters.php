<?php
use yii\helpers\Html;

include('../views/site/form/_list.php');
?>


<div class="row searchRow" style="background-color: #e7e7e7;">Ieškoti pagal vardą
    <?= $form->field($searchModel, 'username')->textInput(['class' => 'trans_input', 'style' => 'margin-top: 5px;'])->label(false); ?>  
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
    <div class="col-xs-6 paddingFix fixHelp"><?= $form->field($searchModel, 'vyras')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Vyras</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
    <div class="col-xs-6 paddingFix fixHelp"><?= $form->field($searchModel, 'moteris')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Moteris</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
    Amžius tarp
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
   <div class="col-xs-2 paddingFix fixHelp"><?= $form->field($searchModel, 'amzius1')->textInput(['style' => ' width: 30px; height: 18px;', 'class' => 'trans_input'])->label(false); ?></div>
   <div class="col-xs-1 paddingFix fixHelp"><center>ir</center></div>
   <div class="col-xs-6 paddingFix fixHelp"><?= $form->field($searchModel, 'amzius2')->textInput(['style' => ' margin-left:3px; width: 30px; height: 18px;', 'class' => 'trans_input'])->label(false); ?></div>
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
    Ūgis nuo
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
    <?php $searchModel->ugis1 = ($searchModel->ugis1 || $searchModel->ugis1 == '0') ? $searchModel->ugis1 : 0; ?>
    <?php $searchModel->ugis2 = ($searchModel->ugis2 || $searchModel->ugis2 == '0') ? $searchModel->ugis2 : 122; ?>
   <div class="col-xs-4 paddingFix fixHelp"><?= $form->field($searchModel, 'ugis1')->dropDownList($ugis, $options = ['style' => ' height: 18px;', 'class' => 'trans_input arrow'])->label(false); ?></div>
   <div class="col-xs-2 paddingFix fixHelp"><center>iki</center></div>
   <div class="col-xs-4 paddingFix fixHelp"><?= $form->field($searchModel, 'ugis2')->dropDownList($ugis, $options = ['style' => ' height: 18px;', 'class' => 'trans_input arrow'])->label(false); ?></div>
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
    Svoris tarp
</div>
<div class="row searchRow" style="background-color: #e7e7e7; margin-top: 100px;">
    <?php $searchModel->svoris1 = ($searchModel->svoris1 || $searchModel->svoris1 == '0') ? $searchModel->svoris1 : 0; ?>
    <?php $searchModel->svoris2 = ($searchModel->svoris2 || $searchModel->svoris2 == '0') ? $searchModel->svoris2 : 142; ?>
    <div class="col-xs-4 paddingFix fixHelp"><?= $form->field($searchModel, 'svoris1')->dropDownList($svoris, $options = ['style' => ' height: 18px;', 'class' => 'trans_input arrow'])->label(false); ?></div>
    <div class="col-xs-2 paddingFix fixHelp"><center>iki</center></div>
    <div class="col-xs-4 paddingFix fixHelp"><?= $form->field($searchModel, 'svoris2')->dropDownList($svoris, $options = ['style' => ' height: 18px;', 'class' => 'trans_input arrow'])->label(false); ?></div>
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
    Miestas
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
    <div class="col-xs-10 paddingFix fixHelp"><?= $form->field($searchModel, 'miestas')->dropDownList(array_merge([0 => 'Nesvarbu'],$list), $options = ['style' => ' height: 18px;', 'class' => 'trans_input arrow'])->label(false); ?></div>
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
    Ieško
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 'rs')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Rimtų santykių</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 'ts')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Trumpalaikių santykių</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 'se')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Seksas</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 'f')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Flirtas</span>', 'uncheck' => '0', 'checked' => '3']); ?></div>
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 'sl')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Slapti pasimatymai</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 's')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Susirašinėti</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
    Šiuo metu yra
</div>
<div class="row searchRow" style="background-color: #e7e7e7;">
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 'i')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Įsipareigojęs(-usi)</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 'l')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Laisvas(-a)</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 'tu')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Turi neįpareigojančių santykių)</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 've')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Vedęs (ištekėjusi)</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 've2')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Vedęs (ištekėjusi) (negyvena kartu)(-a)</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>      
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 'is')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Išsiskyręs (-usi)</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
    <div class="col-xs-12 paddingFix fixHelp"><?= $form->field($searchModel, 'na')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Našlys (-ė)</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>              
</div>
<div class="row searchRow" style="background-color: #e7e7e7; text-align: center;">
    <?php if($dataProvider && empty($data)):?><?= Html::submitButton('Ieškoti', ['class' => 'btn btn-reg', 'style' => 'width: 100%; padding: 0px;', 'name' => 'DetailSearchP[search]', 'value' => 1]) ?><?php endif ?>
    <?php if($_GET['psl'] == 'detail'): ?>
        <?php if($dataProvider && empty($data)):?><?= Html::submitButton('&#171; Iš naujo', ['class' => 'btn btn-default', 'name' => 'DetailSearchP[search]', 'value' => 0]) ?><?php endif ?>
    <?php endif; ?>
</div>