<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Rašyti laišką';

$data = [
    'payment@pazintyslietuviams.co.uk' => 'payment@pazintyslietuviams.co.uk',
    'pazintys@pazintyslietuviams.co.uk' => 'pazintys@pazintyslietuviams.co.uk',
    'pagalba@pazintyslietuviams.co.uk' => 'pagalba@pazintyslietuviams.co.uk',
    'info@pazintyslietuviams.co.uk' => 'info@pazintyslietuviams.co.uk'
]

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
        </div>

        <div class="col-lg-7">
            <?php if(Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('success'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    new nicEditor({buttonList : ['fontSize','fontFamily', 'bold','italic','underline','strikeThrough','subscript','superscript', 'removeformat', 'link', 'unlink']}).panelInstance('body');
});

</script>
