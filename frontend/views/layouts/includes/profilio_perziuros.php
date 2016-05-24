<?php
/**
 * Created by PhpStorm.
 * User: evald
 * Date: 2016-04-27
 * Time: 17:25
 * Ar eitum į pasimatymą widget'as
 */

use yii\helpers\Url;
use frontend\models\Info2;
use yii\helpers\Html;

$this->registerJs("
var page_number = 1;

function profilio_perziuros(page_movement)
{
    $.ajax({
       url: '". Url::to(['ajax/profilio_perziuros']) ."',
       type: 'post',
       data: {
                 page_movement: page_movement,
                 page_number: page_number,
             },
       success: function (data) {
             
            page_number = parseInt(data.page_number);
             
                $('#profilio_perziuros-foto').html('<img src=\'' + data.foto + '\' style=\'width: 100%;\'/>');
                $('#profilio_perziuros-vardas').html(data.vardas);
                $('#profilio_perziuros-miestas').html(data.miestas);
       }
  });
}

profilio_perziuros(0);

$(document).on('click', '#profilio_perziuros-ankstesnis', function (){
    profilio_perziuros(1);
}); 

$(document).on('click', '#profilio_perziuros-kitas', function (){
    profilio_perziuros(2);
}); 

");

?>
<div id="profilio_perziuros" style="display: block; margin-bottom: 20px;">
    <div class="row">
        <div class="sidebar-pavadinimas" style="text-align: center;">Tavo anketą žiūrėję žmonės</div>
    </div>

    <div class="row" style="background-color: #E3F1D0;">
        <div class="col-xs-12">
            <div class="row" id="profilio_perziuros-foto"></div>

            <div class="row">
                <div class="col-xs-6" id="profilio_perziuros-vardas"></div>
                <div class="col-xs-6" id="profilio_perziuros-miestas"></div>
            </div>
            <div class="row">
                <div class="col-xs-4"></div>
                <div class="col-xs-6" id="profilio_perziuros-laikas"></div>
            </div>
        </div>

    </div>
    <!-- #BDDC5E #ff8888 -->
    <div class="row" style="line-height: 40px; padding: 0px 0px 0px 0px; text-align: center;">
        <div class="col-xs-6" id="profilio_perziuros-ankstesnis">Ankstesnis</div>
        <div class="col-xs-6" id="profilio_perziuros-kitas">Kitas</div>
    </div>
    <div class="row" style="line-height: 40px; padding: 0px 0px 0px 0px; text-align: center;">
        <?= Html::a('Žiūrėti daugiau', ['/member/pviews'], ['class'=>'col-xs-12', 'id'=>'profilio_perziuros-daugiau']); ?>
    </div>
</div>