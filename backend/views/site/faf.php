<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;
?>

<div class="container">
    <h1>Masiškai kviesti į draugus</h1>

    <h2>Pasirinkite narį</h2>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-2">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Ieškoti pagal slapyvardį']); ?>

            <?= Html::submitButton('Ieškoti', ['class' => 'btn btn-primary', 'value'=>'Create & Add New']) ?>

            <?php ActiveForm::end() ?>
        </div>

        <div class="col-xs-9">
            <?= ListView::widget( [
                'layout' => '<div style="float: left; width: 100%; ">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
                'dataProvider' => $dataProvider,
                'itemView' => '//site/_users',
            ] );
            ?>

            <script type="text/javascript">
                $(".recentImgHolder img.cntrm").fakecrop({wrapperWidth: $('.recentImgHolder').width(),wrapperHeight: $('.recentImgHolder').width(), center: true });
            </script>

        </div>
    </div>

</div>

