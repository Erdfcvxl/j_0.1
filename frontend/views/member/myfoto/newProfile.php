<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\UploadForm2;

?>

<div class="container" style="width:100%; background-color: #f4f4f4; min-height: 150px; font-size: 12px; text-align: left; padding: 15px;">
    <?php if(Yii::$app->session->hasFlash('success') || Yii::$app->session->hasFlash('danger')): ?>
        <div id="alert" class="col-xs-12">
            <div class="alert alert-<?= (Yii::$app->session->hasFlash('success'))? 'success' : 'danger' ?>">
                <a href="#" class="close" data-dismiss="alert"></a>
                <?= Yii::$app->session->getFlash('danger')?>
                <?= (Yii::$app->session->hasFlash('success'))? "<strong>Baigta!</strong> ".Yii::$app->session->getFlash('success') : '';?>
            </div>
        </div>

    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <script type="text/javascript">
            setTimeout(function(){
                $('#alert').fadeOut();
            },5000);
        </script>
    <?php endif; ?>

    <?php endif; ?>

    <div class="col-xs-12">
        <h5>Įkelti naują profilio nuotrauką</h5>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php if(\frontend\models\Expired::prevent()): ?>
            <div class="alert alert-warning">
                <b>Jūsų abonimento galiojimas baigėsi.</b>
                <br>
                Įkelti nuotrauką gali tik tie nariai, kurių abonimentas yra galiojantis.
            </div>
            <?= $this->registerJsFile('js/preventDefault'); ?>
        <?php else: ?>

            <div class="row">
                <div class="col-xs-6">
                    Pasirinkite failą
                    <?= $form->field($model, 'file', ['template' => '{input}<div class="new_er">{error}</div>'])->fileInput()->label(false);   ?>
                </div>

            </div>


            <?= Html::submitButton('Įkelti', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 14px; padding: 0 20px 0 20px; margin-top:25px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7); border-radius: 0;']) ?>

            <a href="<?= \yii\helpers\Url::to(['member/myfoto']);?>" class="btn btn-default" style="border-radius: 0; padding: 0px 10px; margin-top: 10px;">Atgal</a>

        <?php endif; ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

