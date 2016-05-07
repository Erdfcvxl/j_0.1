<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Rašyti laišką';

$data = [
    'payment@pazintyslietuviams.co.uk' => 'payment@pazintyslietuviams.co.uk',
    'pazintys@pazintyslietuviams.co.uk' => 'pazintys@pazintyslietuviams.co.uk',
    'pagalba@pazintyslietuviams.co.uk' => 'pagalba@pazintyslietuviams.co.uk',
    'info@pazintyslietuviams.co.uk' => 'info@pazintyslietuviams.co.uk'
];

$populate = new \backend\models\UserSearch;

$datepicker = DateRangePicker::widget([
    'name'=>'created_at',
    'convertFormat'=>true,
    'pluginOptions'=>[
        'locale'=>[
            'format'=>'Y-m-d',
            'separator'=>' - ',
        ],
    ],
    'hideInput' => true,
    'containerTemplate' => '
        <span class="input-group-addon">
            <i class="glyphicon glyphicon-calendar"></i>
        </span>
        <span class="form-control text-right">
            <span class="pull-left">
                <span class="range-value">{value}</span>
            </span>
            {input}
        </span>
    ',
]);

?>

<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <?php // $form->field($model, 'name')->label('Siuntėjo el. paštas') ?>

                <?= $form->field($model, 'name')->widget(Select2::classname(), [
                    'data' => $data,
                    'options' => ['placeholder' => 'Select a state ...'],
                    'hideSearch' => true,
                ]);
                ?>

                <?= $form->field($model, 'email')->textArea(['rows' => 3])->label('Gavėjai') ?>
                <?= $form->field($model, 'subject')->label('Tema') ?>

                <?= $form->field($model, 'body')->textArea(['rows' => 6, 'id' => "body", 'style' => 'text-align: center;']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>

            <div class="arrow-left" style="position: absolute; right: -1px; top: 125px; border-right:16px solid #d6d5d1; z-index: 11;"></div>
        </div>

       <!-- <div class="col-lg-7">
            <?php /*if(Yii::$app->session->hasFlash('success')): */?>
                <div class="alert alert-success">
                    <?/*= Yii::$app->session->getFlash('success'); */?>
                </div>
            <?php /*endif; */?>
        </div>-->

        <div class="col-lg-7" style="background-color: #fafff4; padding: 15px 15px; min-height: 200px; border: 1px solid #d6d5d1; border-radius: 5px;">
            <?php $form = ActiveForm::begin([
                'id' => 'populate-form',
                'action' => Url::to(['site/getusers'])
            ]); ?>

                <?= $form->field($populate, 'vip')->radio();?>

                <?= $form->field($populate, 'iesko')->inline(true)->checkboxList(['Vyras' => 'Vyras', 'Moteris' => 'Moteris']);?>


                <?= $form->field($populate, 'created_at')->widget(DateRangePicker::classname(), [
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'locale'=>[
                            'format'=>'Y-m-d',
                            'separator'=>' - ',
                        ],
                    ],
                    'hideInput' => true,
                    'containerTemplate' => '
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <span class="form-control text-right">
                            <span class="pull-left">
                                <span class="range-value">{value}</span>
                            </span>
                            {input}
                        </span>
                    ',
                ])->label('Registracijos data'); ?>



                <div class="form-group" style="display: inline-block;">
                    <p class="text-success" id="loader" style="display: inline-block; display: none; margin-left: 15px;">Užklausa išsiųsta! Kraunama...</p>
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button', 'id' => 'submitas']) ?>

                    <p class="text-success" id="countSpot" style="display: inline-block; margin-left: 15px;"></p>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    new nicEditor({buttonList : ['fontSize','fontFamily', 'bold','italic','underline','strikeThrough','subscript','superscript', 'removeformat', 'link', 'unlink']}).panelInstance('body');
});

$('body').on('beforeSubmit', 'form#populate-form', function () {
    var form = $(this);
    // return false if form still have some validation errors
    if (form.find('.has-error').length) {
        return false;
    }

    $('#loader').css({'display' : 'inline-block'});
    $('#submitas').css({'display' : 'none'});

    // submit form
    $.ajax({
        url: form.attr('action'),
        type: 'post',
        dataType: 'json',
        data: form.serialize(),
        success: function (r) {
            console.log(r);

            $('#submitas').css({'display' : 'inline-block'});
            $('#loader').css({'display' : 'none'});

            $('#contactform-email').val(r['gavejai']);
            $('#countSpot').html('Buvo rasta <b>'+r['count']+'</b> vartotojų atitinkančių kriterijus');
            //$('body').html(r);
        },
        error: function(r){
            $('body').html(r.responseText);
        }
    });

    return false;
});

</script>
