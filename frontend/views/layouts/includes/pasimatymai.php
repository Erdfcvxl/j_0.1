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

//$pasimatymu_masyvas = \frontend\controllers\AjaxController::Pasimatymai();
$this->registerJs("
var pasimatymu_vartotojo_id = 0;
var hide_pasimatymai = 1;

function pasimatymai(going)
{
    $.ajax({
       url: '" . Url::to(['ajax/pasimatymai']) . "',
       type: 'post',
       data: {
                 going: going, 
                 pasimatymu_vartotojo_id: parseInt(pasimatymu_vartotojo_id),
             },
       success: function (data) {
             
            if (parseInt(data.hide_pasimatymai) == 0)
            {
                pasimatymu_vartotojo_id = data.id;
                $('#pasimatymai-foto').html('<img src=\'' + data.foto + '\' style=\'width: 100%;\'/>');
                $('#pasimatymai-vardas').html(data.vardas);
                $('#pasimatymai-miestas').html(data.miestas);
                //$('#pasimatymai-miestas').html(data.atstumas);
//                $('#profilio_perziuros').css('display', 'none');
                $('#pasimatymai').css('display', 'block');
            }
            else
            {
                $('#pasimatymai').css('display', 'none');
//                $('#profilio_perziuros').css('display', 'block');
            }
//            console.log(data);
       },
            error: function(ts){
//                console.log(ts.responseText);
            }
  });
}

pasimatymai(0);

$(document).on('click', '#pasimatymai-taip', function (){
    pasimatymai(1);
}); 

$(document).on('click', '#pasimatymai-ne', function (){
    pasimatymai(2);
}); 



//function profilio_perziuros()
//{
//    $.ajax({
//       url: '" . Url::to(['ajax/profilio_perziuros']) . "',
//       type: 'post',
//       data: {
//                 _csrf : '" . Yii::$app->request->getCsrfToken() . "',
//             },
//       success: function (data) {
//       
//       console.log(data.profili_perziurejo);
//       
//       $.each(data.profili_perziurejo , function(i) { 
//        $('#profilio_perziuros-turinys').append('<div class='row' id='profilio_perziuros-juosta' style='background-color: #ffffff; padding: 0px 0px 0px 0px;'>');
//             $('#profilio_perziuros-turinys').append('<div class='col-xs-4' id='profilio_perziuros-foto'><img src='' + data.avatarai[i] + '' width='100%' /></div>');
//             $('#profilio_perziuros-turinys').append('<div class='col-xs-6' id='profilio_perziuros-vardas'>' + data.vardai[i] + '</div>');
//             $('#profilio_perziuros-turinys').append('<div class='col-xs-2' id='profilio_perziuros-laikas'>' + data.profili_perziurejo[i].timestamp + '</div>');
//        $('#profilio_perziuros-turinys').append('</div>');
//        });
//          
//       }
//  });
//}
//
//$(document).on('click', '#profilio_perziuros-daugiau', function (){
//    profilio_perziuros();
//}); 



");

?>
<div id="pasimatymai" style="display: none; margin-bottom: 20px;">
    <div class="row">
        <div class="sidebar-pavadinimas" style="text-align: center;">Ar eitum į pasimatymą?</div>
    </div>

    <div class="row" style="background-color: #E3F1D0;">
        <div class="col-xs-12">
            <div class="row" id="pasimatymai-foto"></div>

            <div class="row">
                <div class="col-xs-12" id="pasimatymai-vardas"></div>
            </div>
            <div class="row">
                <div class="col-xs-12" id="pasimatymai-miestas"></div>
            </div>
        </div>

    </div>
    <!-- #BDDC5E #ff8888 -->
    <div class="row" style="line-height: 40px; padding: 0px 0px 0px 0px; text-align: center;">
        <div class="col-xs-6" id="pasimatymai-taip">TAIP</div>
        <div class="col-xs-6" id="pasimatymai-ne">NE</div>
    </div>
</div>
<!---->
<!--<div id="profilio_perziuros" style="display: none;">-->
<!--    <div class="row">-->
<!--        <div class="sidebar-pavadinimas">Profilio peržiūros</div>-->
<!--    </div>-->
<!---->
<!--    <div id="profilio_perziuros-turinys"></div>-->
<!---->
<!--    <div class="row" id="profilio_perziuros-daugiau">Daugiau</div>-->
<!--</div>-->
