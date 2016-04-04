<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use common\models\User;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\db\Query;
use yii\widgets\Pjax;

include('../views/site/form/_list.php');

$user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
?>
 <div class="row" style="margin-top: 5px;">
        <div class="col-xs-3" style="background-color: #e7e7e7; min-height: 70px; padding: 0;">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => Url::to(['member/search', 'psl' => 'new']),
                ]);
                ?>
                <div class="row searchRow" style="background-color: #e7e7e7;">Ieškoti pagal vardą
                    <?= $form->field($searchModel, 'username')->textInput(['class' => 'trans_input', 'style' => 'margin-top: 5px;'])->label(false); ?>  
                </div>
                <div class="row searchRow" style="background-color: #e7e7e7;">
                    <div class="col-xs-6 paddingFix fixHelp"><?= $form->field($searchModel, 'vyras')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Vyras</span>', 'uncheck' => null, 'checked' => '1']); ?></div>
                    <div class="col-xs-6 paddingFix fixHelp"><?= $form->field($searchModel, 'moteris')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Moteris</span>', 'uncheck' => null, 'checked' => '1']); ?></div>
                </div>
                <div class="row searchRow" style="background-color: #e7e7e7;">
                    Amžius tarp
                </div>
                <div class="row searchRow" style="background-color: #e7e7e7;">
                   <div class="col-xs-2 paddingFix fixHelp"><?= $form->field($searchModel, 'amzius1')->textInput(['style' => 'margin-top: -10px; width: 30px; height: 18px;', 'class' => 'trans_input'])->label(false); ?></div>
                   <div class="col-xs-1 paddingFix fixHelp"><center>ir</center></div>
                   <div class="col-xs-6 paddingFix fixHelp"><?= $form->field($searchModel, 'amzius2')->textInput(['style' => 'margin-top: -10px; margin-left:3px; width: 30px; height: 18px;', 'class' => 'trans_input'])->label(false); ?></div>
                </div>
                <div class="row searchRow" style="background-color: #e7e7e7;">
                    Ūgis nuo
                </div>
                <div class="row searchRow" style="background-color: #e7e7e7;">
                    <?php $searchModel->ugis1 = ($searchModel->ugis1 || $searchModel->ugis1 == '0') ? $searchModel->ugis1 : 51; ?>
                    <?php $searchModel->ugis2 = ($searchModel->ugis2 || $searchModel->ugis2 == '0') ? $searchModel->ugis2 : 91; ?>
                   <div class="col-xs-4 paddingFix fixHelp"><?= $form->field($searchModel, 'ugis1')->dropDownList($ugis, $options = ['style' => 'margin-top: -10px; height: 18px;', 'class' => 'trans_input arrow'])->label(false); ?></div>
                   <div class="col-xs-2 paddingFix fixHelp"><center>iki</center></div>
                   <div class="col-xs-4 paddingFix fixHelp"><?= $form->field($searchModel, 'ugis2')->dropDownList($ugis, $options = ['style' => 'margin-top: -10px; height: 18px;', 'class' => 'trans_input arrow'])->label(false); ?></div>
                </div>
                <div class="row searchRow" style="background-color: #e7e7e7;">
                    Svoris tarp
                </div>
                <div class="row searchRow" style="background-color: #e7e7e7; margin-top: 100px;">
                    <?php $searchModel->svoris1 = ($searchModel->svoris1 || $searchModel->svoris1 == '0') ? $searchModel->svoris1 : 11; ?>
                    <?php $searchModel->svoris2 = ($searchModel->svoris2 || $searchModel->svoris2 == '0') ? $searchModel->svoris2 : 81; ?>
                    <div class="col-xs-4 paddingFix fixHelp"><?= $form->field($searchModel, 'svoris1')->dropDownList($svoris, $options = ['style' => 'margin-top: -10px; height: 18px;', 'class' => 'trans_input arrow'])->label(false); ?></div>
                    <div class="col-xs-2 paddingFix fixHelp"><center>iki</center></div>
                    <div class="col-xs-4 paddingFix fixHelp"><?= $form->field($searchModel, 'svoris2')->dropDownList($svoris, $options = ['style' => 'margin-top: -10px; height: 18px;', 'class' => 'trans_input arrow'])->label(false); ?></div>
                </div>
                <div class="row searchRow" style="background-color: #e7e7e7;">
                    Miestas
                </div>
                <div class="row searchRow" style="background-color: #e7e7e7;">
                    <div class="col-xs-10 paddingFix fixHelp"><?= $form->field($searchModel, 'miestas')->dropDownList(array_merge([0 => 'Nesvarbu'],$list), $options = ['style' => 'margin-top: -10px; height: 18px;', 'class' => 'trans_input arrow'])->label(false); ?></div>
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
                </div>
                <div class="row searchRow" style="background-color: #e7e7e7; text-align: center;">
                    <?= Html::submitButton('Ieškoti', ['class' => 'btn btn-reg', 'style' => 'width: 100%; padding: 0px;']) ?>
                </div>
                
        </div>
        <div class="col-xs-9" >
            <div class="container" style="width: 100%; background-color: #b6edcd; padding: 7px 15px 0px;">
                    <div class="col-xs-4 fixHelp"><?= $form->field($searchModel, 'lastOnline')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Tik prisijungę nariai</span>', 'uncheck' => null, 'checked' => '1']); ?></div>
                    <div class="col-xs-4 fixHelp"><?= $form->field($searchModel, 'avatar')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Tik su nuotrauka</span>', 'uncheck' => null, 'checked' => '1']); ?></div>
                    <div class="col-xs-4 fixHelp"><?= $form->field($searchModel, 'vip')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Vip</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>

                <?php ActiveForm::end() ?>
            </div>

            <div class="container" style="width:100%; background-color: #f9f9f9; height: auto; font-size: 12px; text-align: left;">
                <br>
                <div class="row" style="padding: 0px 5px;">
                <?php Yii::$app->params['close'] = 0; ?>
                    <?php Pjax::begin();?>
                    <?= ListView::widget( [
                        'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;"><div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div></div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
                        'dataProvider' => $dataProvider,
                        'itemView' => '../_searchResultNew',
                        'pager' =>[
                            'maxButtonCount'=>0,
                            'nextPageLabel'=>'Kitas &#9658;',
                            'nextPageCssClass' => 'removeStuff',
                            'prevPageLabel'=>'&#9668; Atgal',
                            'prevPageCssClass' => 'removeStuff',
                            'disabledPageCssClass' => 'off',
                        ]

                        ] ); 
                    ?>
                    <?php Pjax::end(); ?>
                </div>
                
                <div class="row">
                <br>
                </div>
            </div>
    </div>
</div>   