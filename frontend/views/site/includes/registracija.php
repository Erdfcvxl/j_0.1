<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

for($i = 18; $i < 90; $i++){
    $agech[$i] = $i;
}
?>
<div class="first_flat_right">

    <h1 class="title" style="color: #111111; font-size: 26px; margin-top: 0px;"><div style="position: absolute; z-index: -1;"><img src="/css/img/gradient.png" style="position: relative; top:-100px; left: -40px; z-index: -1;" width="450px;" height="250px;"></div>SURASK ANTRĄ PUSĘ <span class="title_bold">ANGLIJOJE IR AIRIJOJE</span></h1>

    <div class="login_box">
        <div style="position: relative; margin-top: -61px; top: 61px; height: 60px; display: block; padding-top: 1px;">
            <h2 id="off1" style="margin-bottom: -5px; font-size: 25px;">REGISTRACIJA</h2>
            <div class="hrcustm" id="off2" style="margin-top:5px;"></div>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'form-signup', 'enableClientValidation' => true]); ?>
        <table style="text-align: left; font-size: 15px; position: relative; top:50px; margin-top: 20px; z-index: 5;" id="first">
            <tr>
                <td style="padding: 10px 5px 10px 5px;" class="th">Aš esu:</td>
                <td style="padding: 10px 10px 10px 10px;" class="td"><?= Html::dropDownList('gender', $selection = 'mv', ['vm' => 'Vyras ieškantis moters', 'mv' => 'Moteris ieškanti vyro' , 'vv' => 'Vyras ieškantis vyro' , 'mm' => 'Moteris ieškanti moters' ], $options = ['style' => 'width: 210px; color: #353535; height: 25px; padding: 0 0 3px 5px; font-size: 15px', 'class' => 'reg_dropbox', 'id' => 'change_color0'] ); ?></td>
            </tr>
            <tr id="2tr">
                <td style="padding: 10px 5px 20px 5px;" class="th">Amžius tarp:</td>
                <td style="padding: 10px 10px 20px 10px;" class="td">
                    <?= Html::dropDownList('age_from', $selection = 18, $agech, $options = ['style' => 'width:85px; color: #353535; height: 25px; padding: 0 0 3px 5px;', 'class' => 'reg_dropbox']); ?>
                    &nbsp&nbsp ir &nbsp&nbsp
                    <?= Html::dropDownList('age_to', $selection = 25, $agech, $options = ['style' => 'width: 85px; color: #353535; height: 25px; padding: 0 0 3px 5px;', 'class' => 'reg_dropbox']); ?>
                </td>
            </tr>
        </table>

        <div id="expand_complete" style="display:none; opacity: 0; position: relative; top: -14px; font-size: 15px; ">
            <table style="text-align: left;" id="second">
                <tr>
                    <td style="padding: 10px 5px 5px 10px">Slapyvardis:</td>
                    <td style="padding-left: 8px"><?= $form->field($model2, 'username')->label(false); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px 5px 5px 10px">Slaptažodis:</td>
                    <td style="padding-left: 8px"><?= $form->field($model2, 'password')->passwordInput()->label(false); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px 5px 5px 10px">E-paštas:</td>
                    <td style="padding-left: 8px"><?= $form->field($model2, 'email')->label(false); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px 5px 5px 10px; font-size: 13px">Apie šią svetainę sužinojau:</td>
                    <td style="padding-left: 8px"><?= Html::dropDownList('heard_from', $selection = '', ['Google paieškoje', 'Reklamoje Internete', 'Iš draugo', 'Spaudoje', 'Kita'], $options = ['style' => 'width: 210px; color: #353535; height: 25px; padding: 0 0 3px 5px;', 'class' => 'reg_dropbox'] ); ?></td>
                </tr>
            </table>

            <div class="row" style="margin-top: 0px; font-size: 12px;">
                <?php $model2->pilnametis = 0; ?>
                <div class="col-xs-1" style="text-align: right; padding-right: 0; margin-left: 30%;"><?= $form->field($model2, 'pilnametis')->checkbox(['style' => 'display: inline-block; position: static; width: 20px; margin-top: -4px;','template' => '{input}<div style="position: relative; width: 200px; left: -50px; margin-top: -10px; font-size: 12px;">{error}</div>'])->label(false); ?></div>
                <div class="col-xs-6" style="margin-left: 10px; padding-left: 0; text-align: left;">Man yra 18 metų, su <span style="cursor: pointer; border-bottom: 1px solid white;" id="triggerT">taisyklėmis</span> sutinku</div>
            </div>
        </div>


        <?= Html::submitButton('Baigti registraciją', ['class' => 'btn btn-reg', 'style' => 'display: none; opacity: 0; margin: -105px auto 30px auto; position: relative; top: 100px', 'id' => 'expand_end_btn', 'name' => 'signup-button']) ?>

        <script type="text/javascript">
            $('#triggerT').click(function(){
                $('.fade_back').css({"display" : "block"});
                $('#taisykles').css({"z-index": "15"});
            });

            $('#xas').click(function(){
                $('.fade_back').css({"display" : "none"});
                $('#taisykles').css({"z-index": "-1"});
            });
        </script>

        <div style="clear:both"></div>

        <div style="margin-top: 0px;" id="off3">

            <div class="btn btn-reg" id="exp" style="font-size:15px; padding: 5px 8px 5px 8px;margin-top: 50px;">Registruotis Nemokamai</div>

            <div style="margin-top: 15px;" id="off4">
                <div class="hrcustm" style="width: 135px; float: left; position: relative; top:19px;"></div>
                <img src="/css/img/icons/arba.png"/>
                <div class="hrcustm" style="width: 135px; float: right; position: relative; top:19px;"></div>
                <?= $authAuthChoice->clientLink($authAuthChoice->getClients()['facebook']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>