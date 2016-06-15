<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div class="header">

    <div class="fix" id="fixLeft"></div>
    <div class="fix" id="fixRight"></div>

    <div class="container">
        <div class="row headerAtskaita">
            <div class="col-sm-3 col-md-4" id="h2"><img src="/css/img/icons/logo2.png"><span style="margin-left: 15px;">Pažintyslietuviams.co.uk</span></div>
            <div class="col-sm-9 col-md-8" id="h3">

                <div class="row" style="display: none;" id="almost">
                    <div class="col-xs-12"style="text-align:right;">
                        <a href="<?= Url::to(['site/auth', 'authclient' => 'facebook']); ?>"><div class="loginPick fb2"></div></a><!--
                 --><div class="loginPick normalus m2" id="si"></div>
                    </div>
                </div>

                <div class="row" style="padding-top: 15px;" id="preLog">
                    <div class="col-xs-11 col-sm-11" style="text-align: right; padding-right: 0;">
                        <a class="" id="firstLog">Prisijungti</a>
                    </div>
                    <div class="col-xs-1 col-sm-1" style="text-align: right; padding-left: 0;">
                        <a class="ltRound">LT</a>
                    </div>
                </div>

                <script type="text/javascript">
                    var selected = 0;
                    var touch;

                    function is_touch_device() {
                        return 'ontouchstart' in window // works on most browsers
                            || 'onmsgesturechange' in window; // works on ie10
                    };

                    $(function(){
                        touch = is_touch_device();

                        if(touch){
                            $('#firstLog').click(function(){
                                $('#preLog').css({"display" : "none"});
                                $('#almost').css({"display" : "block"});
                                $('#errorBox').css({'display':'none'});
                            });
                        }else{
                            $('#firstLog').mouseenter(function(){
                                $('#preLog').css({"display" : "none"});
                                $('#almost').css({"display" : "block"});
                                $('#errorBox').css({'display':'none'});
                            });

                            $('#almost').mouseleave(function(){
                                if(selected == 0){
                                    $('#preLog').css({"display" : "block"});
                                    $('#almost').css({"display" : "none"});
                                    $('#simpleL').css({"display" : "none"});
                                }
                            });
                        }
                    });



                    $('#si').click(function(){
                        selected = 1;

                        $('#errorBox').css({'display':'none'});
                        $('#almost').css({'display':'none'});
                        $('#simpleL').css({'display':'block'});

                    });





                </script>

                <div class="row" >
                    <div class="col-xs-6 col-sm-6" style="text-align: right;" id="topFB">

                    </div>
                </div>

                <div class="row" id="errorBox">
                    <div class="col-xs-5 col-xs-offset-6" style="text-align: right; padding-right: 0;">
                        <?php if(Yii::$app->session->hasFlash("info")): ?>
                            <?= Yii::$app->session->getFlash("info"); ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div id="simpleL" style="display: none;">

                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-xs-1" style="padding-right: 0; text-align: right;"></div>
                        <div class="col-xs-4 col-sm-3 styled_inp"><?= $form->field($modelis, 'username')->textInput(['placeholder' => 'Vardas arba el.paštas'])->label(false); ?></div>
                        <div class="col-xs-4 col-sm-3 styled_inp"><?= $form->field($modelis, 'password')->passwordInput(['placeholder' => 'Slaptažodis'])->label(false); ?></div>
                        <div class="col-xs-3 col-sm-3"><?= Html::submitButton('Prisijungti', ['class' => 'btn btn-reg btn-prisijungti', 'id' => 'login_btn', 'name' => 'signup-button2']) ?></div>
                    </div>

                    <div class="row" style="position: relative; top: -15px; font-size: 12px;">
                        <div class="col-xs-1"></div>
                        <div class="col-xs-4 col-sm-3"><?= $form->field($modelis, 'rememberMe')->checkbox()->label('<span style="position: absolute; top: -8px; color: black !important;">Prisiminti mane</span>'); ?></div>
                        <div class="col-xs-4 col-sm-3"><a href="<?= Url::current(['lost' => 1]); ?>" style="font-size: 11px; position: relative; top: 2px;">Pamiršau slaptažodį</a></div>
                    </div>

                    <div class="row" style="position: relative; top: -48px; font-size: 12px;">
                        <div class="col-xs-1"></div>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function fixTop(){
        var atskaita = $('#atskaita'),
            containerW = atskaita.innerWidth(),
            WW =  $('body').innerWidth();
        fixLeft = $('#fixLeft'),
            fixRightW = $('#fixRight'),
            newW = (WW - containerW) / 2;

        fixLeft.css({"width" : newW + "px"});
        fixRightW.css({"width" : newW + "px"});
    }


</script>