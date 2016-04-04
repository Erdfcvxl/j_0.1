<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use frontend\models\Info;

use frontend\models\UploadForm;
use common\models\User;

use Imagine\Image\Box;
use Imagine\Image\Point;

use kartik\select2\Select2;

require_once('_list.php');

//$UploadForm = new UploadForm();
$id = (isset($_GET['id']) ? $_GET['id'] : "");
$ra = (isset($_GET['ra']) ? $_GET['ra'] : "");
$re = (isset($_GET['re']) ? $_GET['re'] : "");

$re_next = $re + 1;

for($i = date('Y')-18; $i > date('Y') - 80; $i--){
  $year[$i] = $i;
}
for($i = 1; $i <= 12; $i++){
  $month[$i] = $i;
}
for($i = 1; $i < 32; $i++){
  $day[$i] = $i;
}

//$model_info = Info::find()->where(['u_id' => $_GET['id']])->one();
/*
if(!$model_info) $model_info = new Info;
*/
?>

<?php if($re == 0): ?>

  <?php $form = ActiveForm::begin(['id' => 'reg_step', 'action' => '?r=site/login&re='.$re.'&id='.$id.'&ra='.$ra]);?>
    <div class="container" style="width: 100%">
      <div class="col-sm-6">

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top">Gimimo data</div>
          <div class="col-xs-8 col-sm-8 vcenter top">
            <div class="row" style="padding: 0 15px 0 15px">
              <div class="col-xs-4" style="padding: 0;"><?= $form->field($model_info, 'metai')->dropDownList($year,['class' => 'reg_dropbox', 'style' => 'padding-left: 5px;'])->label(false); ?> </div>
              <div class="col-xs-4" style="padding: 0 0 0 5px;"><?= $form->field($model_info, 'menuo')->dropDownList($month,['class' => 'reg_dropbox', 'style' => 'padding-left: 5px;'])->label(false); ?> </div>
              <div class="col-xs-4" style="padding: 0 0 0 5px;"><?= $form->field($model_info, 'diena')->dropDownList($day,['class' => 'reg_dropbox', 'style' => 'padding-left: 5px;'])->label(false); ?> </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Gimtoji šalis</div>
          <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($model_info, 'gimtine')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($gimtoji_salis),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Pasirinkite gimtajį miestą ...'],
                                                                                          'pluginEvents' => [
                                                                                            'select2-selected' => "function(e) { tautybe(e); }",
                                                                                          ],
                                                                                        ])->label(false);?> 
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Gimtoji vieta</div>
          <div class="col-xs-8 col-sm-8 vcenter top">
            <div id="tautybes" style="display: none"><?= $form->field($model_info, 'tautybe')->widget(Select2::classname(), [
                                                                    'data' => array_merge($gimtine),
                                                                    'language' => 'en',
                                                                    'options' => ['placeholder' => 'Pasirinkite gimtąją vietovę ...'],
                                                                    'pluginEvents' => [
                                                                      'select2-selected' => "function(e) { kitas(e, 'tautybes'); }",
                                                                    ],
                                                                  ])->label(false);?></div>
            <div id="tautybes2">
              <?= $form->field($model_info, 'tautybe2')->textInput(['placeholder' => 'Įrašykite gimtąją vietovę'])->label(false); ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Religija</div>
          <div class="col-xs-8 col-sm-8 vcenter top">
            <div id="religijos"><?= $form->field($model_info, 'religija')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($religija),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Pasirinkite religiją ...'],
                                                                                          'pluginEvents' => [
                                                                                              "select2-open" => "function() { search_off(); }",
                                                                                              "select2-close" => "function() { search_on(); }",
                                                                                              'select2-selected' => "function(e) { kitas(e, 'religijos'); }",
                                                                                            ],
                                                                                        ])->label(false);?> </div>
            <div id="religijos2" style="display: none">
              <?= $form->field($model_info, 'religija2')->textInput(['placeholder' => 'Įrašykite gimtąją vietovę'])->label(false); ?><div class="xas" id="tautoff" parent="religijos" style="right: 20px;"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Statusas</div>
          <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($model_info, 'statusas')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($statusas),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Pasirinkite statusą ...'],
                                                                                            'pluginEvents' => [
                                                                                              "select2-open" => "function() { search_off(); }",
                                                                                              "select2-close" => "function() { search_on(); }"
                                                                                            ],
                                                                                          ])->label(false);?> 
          </div>
        </div>

      </div>

      <div class="col-sm-6">

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Išsilavinimas</div>
          <div class="col-xs-8 col-sm-8 vcenter top" style="position: relative; top: 1px;"><?= $form->field($model_info, 'issilavinimas')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($issilavinimas),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Pasirinkite išsilavinimą ...'],
                                                                                          'pluginEvents' => [
                                                                                              "select2-open" => "function() { search_off(); }",
                                                                                              "select2-close" => "function() { search_on(); }"
                                                                                          ],
                                                                                        ])->label(false);?> 
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Darbo sritys</div>
          <div class="col-xs-8 col-sm-8 vcenter top">
            <div id="pareigoss"><?= $form->field($model_info, 'pareigos')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($pareigos),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Pasirinkite darbo sritį ...'],
                                                                                          'pluginEvents' => [
                                                                                            'select2-selected' => "function(e) { kitas(e, 'pareigoss'); }",
                                                                                          ],
                                                                                        ])->label(false);?></div>
            <div id="pareigoss2" style="display: none">
              <?= $form->field($model_info, 'pareigos2')->textInput()->label(false); ?><div class="xas" id="tautoff" parent="pareigoss" style="right: 20px;"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Uždarbis</div>
          <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($model_info, 'uzdarbis')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($uzdarbis),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Pasirinkite uždarbį ...'],
                                                                                          'pluginEvents' => [
                                                                                              "select2-open" => "function() { search_off(); }",
                                                                                              "select2-close" => "function() { search_on(); }"
                                                                                          ],
                                                                                        ])->label(false);?> 
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Seksualinė orentacija</div>
          <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($model_info, 'orentacija')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($orentacija),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Pasirinkite seksualinę orentaciją ...'],
                                                                                          'pluginEvents' => [
                                                                                              "select2-open" => "function() { search_off(); }",
                                                                                              "select2-close" => "function() { search_on(); }"
                                                                                          ],
                                                                                        ])->label(false);?> 
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Tikslas šiame portale</div>
          <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($model_info, 'tikslas')->widget(Select2::classname(), [
                                                                                        'data' => array_merge($tikslas),
                                                                                        'language' => 'en',
                                                                                        'options' => ['placeholder' => 'Pasirinkite tikslą ...'],
                                                                                        'pluginEvents' => [
                                                                                            "select2-open" => "function() { search_off(); }",
                                                                                            "select2-close" => "function() { search_on(); }"
                                                                                        ],
                                                                                      ])->label(false);?> 
          </div>
        </div>

      </div>
    </div>
      

    <div style="height: 15px;"></div>
    </div>

    <div class="bottom_zone">
      <?= Html::submitButton('Kitas', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 30px; padding: 0 130px 0 130px; margin-top:25px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7);']) ?>
    </div>
  <?php ActiveForm::end() ?>
<?php elseif($re == 1): ?>
  <?php $form = ActiveForm::begin(['id' => 'reg_step', 'action' => '?r=site/login&re='.$re.'&id='.$id.'&ra='.$ra.'']); ?>
    <div class="container" style="width: 100%">
      <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
        <div class="row">
          <div class="col-xs-4 vcenter top2">Ūgis</div>
          <div class="col-xs-8 vcenter top2"><?= $form->field($model_info, 'ugis')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($ugis),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Pasirinkite savo ugį ...'],
                                                                                          ])->label(false);?> 
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4 vcenter top2">Svoris</div>
          <div class="col-xs-8 vcenter top2"><?= $form->field($model_info, 'svoris')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($svoris),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Pasirinkite savo svorį ...'],
                                                                                          ])->label(false);?> 
          </div>
        </div> 
        <div class="row">
          <div class="col-xs-4 vcenter top2">Kūno sudėjimas</div>
          <div class="col-xs-8 vcenter top2"><?= $form->field($model_info, 'sudejimas')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($sudejimas),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Pasirinkite savo sudejimą ...'],
                                                                                            'pluginEvents' => [
                                                                                                "select2-open" => "function() { search_off(); }",
                                                                                                "select2-close" => "function() { search_on(); }"
                                                                                            ],
                                                                                          ])->label(false);?> 
          </div>
        </div> 
        <div class="row">
          <div class="col-xs-4 vcenter top2">Plaukų spalva</div>
          <div class="col-xs-8 vcenter top2">
            <div id="pspalva"><?= $form->field($model_info, 'plaukai')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($plaukai),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Pasirinkite savo plaukų spalvą ...'],
                                                                                            'pluginEvents' => [
                                                                                                "select2-open" => "function() { search_off(); }",
                                                                                                "select2-close" => "function() { search_on(); }",
                                                                                                'select2-selected' => "function(e) { kitas(e, 'pspalva'); }",
                                                                                            ],
                                                                                          ])->label(false);?></div>
            <div id="pspalva2" style="display: none;">
              <?= $form->field($model_info, 'plaukai2')->textInput(['placeholder' => 'Įrašykite plaukų spalvą'])->label(false); ?><div class="xas" id="tautoff" parent="pspalva" style="right: 20px;"></div>
            </div>
          </div>
        </div> 
        <div class="row">
          <div class="col-xs-4 vcenter top2">Akių spalva</div>
          <div class="col-xs-8 vcenter top2">
            <div id="aspalva"><?= $form->field($model_info, 'akys')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($akys),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Pasirinkite savo akių spalvą ...'],
                                                                                            'pluginEvents' => [
                                                                                                "select2-open" => "function() { search_off(); }",
                                                                                                "select2-close" => "function() { search_on(); }",
                                                                                                'select2-selected' => "function(e) { kitas(e, 'aspalva'); }",
                                                                                            ],
                                                                                          ])->label(false);?> </div>
            <div id="aspalva2" style="display: none;">
              <?= $form->field($model_info, 'akys2')->textInput(['placeholder' => 'Įrašykite akių spalvą'])->label(false); ?><div class="xas" id="tautoff" parent="aspalva" style="right: 20px;"></div>
            </div>
          </div>
        </div> 
        <div class="row">
          <div class="col-xs-4 vcenter top2">Aprangos stilius</div>
          <div class="col-xs-8 vcenter top2">
            <div id="stilius"><?= $form->field($model_info, 'stilius')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($stilius),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Pasirinkite savo stilių ...'],
                                                                                            'pluginEvents' => [
                                                                                                'select2-selected' => "function(e) { kitas(e, 'stilius'); }",
                                                                                            ],
                                                                                          ])->label(false);?></div>
            <div id="stilius2" style="display: none;">
              <?= $form->field($model_info, 'stilius2')->textInput(['placeholder' => 'Įrašykite stilių'])->label(false); ?><div class="xas" id="tautoff" parent="stilius" style="right: 20px;"></div>
            </div>
          </div>
        </div> 
      </div>
    </div>

    <div style="height: 15px;"></div>
    </div>

    <div class="bottom_zone">
      <?= Html::submitButton('Kitas', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 30px; padding: 0 130px 0 130px; margin-top:25px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7);']) ?>
    </div>
  <?php ActiveForm::end() ?>
<?php elseif($re == 2): ?>
  <?php $form = ActiveForm::begin(['id' => 'reg_step', 'action' => '?r=site/login&re='.$re.'&id='.$id.'&ra='.$ra.'']); ?>

    <?php 
      $data = array('London' => 'London', 'Vilnius' => 'Vilnius');
    ?>

  <div class="container" style="width: 100%">
      <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
        <div class="row" style="padding: 10px 0 0 0"> 
          <div class="col-xs-4 vcenter">Miestas</div>
          <div class="col-xs-8 vcenter"><?= $form->field($model_info, 'miestas')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($list),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Pasirinkite miestą ...'],
                                                                                          'pluginEvents' => [
                                                                                             "change" => "function(e) { rajonas(e); console.log(e); }",
                                                                                             "select2-removed" => "function() { close(); }"
                                                                                          ],
                                                                                        ])->label(false);?> 
          </div>
        </div>

        <?php   

          if($model_info->miestas != "" && $list[$model_info->miestas] == "London"){
            $pre_open = 1;
          }else{
            $pre_open = 0;
          }

        ?>
        <script type="text/javascript">var pre_open = <?= $pre_open; ?></script>

        <div id="rajonas" style="display: none;">
          <div class="row" style="padding: 10px 0 0 0"> 
            <div class="col-xs-4 vcenter">Gyvenamasis rajonas</div>
            <div class="col-xs-8 vcenter"><?= $form->field($model_info, 'grajonas')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($rajonai),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Pasirinkite miestą ...'],
                                                                                            'pluginEvents' => [
                                                                                               "change" => "function(e) { rajonas(e); }"
                                                                                            ],
                                                                                          ])->label(false);?> 
            </div>
          </div>
          <div class="row" style="padding: 10px 0 0 0"> 
            <div class="col-xs-4 vcenter">Darbovietės rajonas</div>
            <div class="col-xs-8 vcenter"><?= $form->field($model_info, 'drajonas')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($rajonai),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Pasirinkite miestą ...'],
                                                                                            'pluginEvents' => [
                                                                                               "change" => "function(e) { rajonas(e); }"
                                                                                            ],
                                                                                          ])->label(false);?> 
            </div>
          </div>
        </div>
    </div>
  </div>

  <script type="text/javascript" src="/js/gyvVieta.js"></script>

  <div style="height: 15px;"></div>
  </div>

  <div class="bottom_zone">
    <?= Html::submitButton('Kitas', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 30px; padding: 0 130px 0 130px; margin-top:25px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7);']) ?>
    <?php ActiveForm::end() ?>
  </div>
<?php elseif($re == 3): ?>
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="container" style="width: 100%;">

    <div class="col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-3 top" id="atstaskas"  style="margin-top: 15px;">
      <div class="row">
        <div class="col-xs-6 col-sm-7 upload_bg vcenter" style="padding: 8px 0 8px 8px">
          <div class="col-xs-3" style="padding: 0px; position: relative; z-index: 1;"><?= $form->field($UploadForm, 'file', [
                                                                                                                          'template' => '{input}<div class="new_er">{error}</div>',
                                                                                                                      ])->fileInput()->label(false);   ?>
          </div>
          <img src="/css/img/icons/computer.png" style="position: absolute; left: 10px; top: 13px;"/>
          <div class="col-xs-9" style="margin-top: 25px;color: #414141; position: relative; z-index: 0;">Ieškoti kompiuteryje</div>
          <div class="row" style="position: absolute; left: 15px; bottom: -40px;"><input type="checkbox" id="c1" name="skip" /><label for="c1" style="font-family: OpenSans; cursor: pointer;font-weight: normal;"><span></span>Praleisti šį žingsnį</label> </div>
        </div>
        <div class="col-xs-5 col-xs-offset-1 col-sm-offset-0 vcenter">
          <div class="img_container">
            <div id="no_av_place" style="overflow: hidden; position: relative; top: 10px; left: 10px; width: 160px; height: 160px; background-image: url('/css/img/icons/no_avatar.png');">
            <img id="avatar" style="position: relative; display: hidden;"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    </div>

    <?php 
      $user = User::find()->where(['id' => $_GET['id']])->one();
      

      if($user->avatar){
        $name = '/uploads/531B'.$user->id.'Iav.'.$user->avatar;
      }else{
        $name = '/css/img/na.jpg';
      }
    ?>
    
    <script type="text/javascript">
      $(function (){
        $('.upload_bg input').css({"width" : $('.upload_bg').width() + "px"});
        $('.new_er').css({"width" : $('#atstaskas').width() + "px"});
        $('#avatar').attr('src', '<?= $name; ?>');
      });

      $( '#avatar' ).load(function() {
        //$('#avatar').css({"left" : "0", "top" : "0", "width" : "", "height" : ""});

        var w_c = 160,
            h_c = 160;
            w_i = $('#avatar').width(),
            h_i = $('#avatar').height(),
            margin = Array(),
            aspect_ratio = w_c / h_c, //jeigu > 1 tai width(plotis) > height(ilgis), si kintamaji galima traktuoti kaip width
            aspect_ratio_i = w_i / h_i;

            console.log(w_i + " " + h_i);

            if(w_i == h_i){
              $('#avatar').css({"width" : "160px", "heigt" : "160px"});

            }else if(aspect_ratio_i.toFixed(1) > 1){console.log("variantas 1"); //variantas 1

              if(w_i > w_c){
                $('#avatar').css({"width" : "auto", "height" : "100%"});
                big();big();

              }else{

                $('#avatar').css({"width" : "100%", "height" : "auto"});
                small();small();
              }
            }else{console.log("variantas2");//variantas 2
              
              if(h_i > h_c){
                $('#avatar').css({"width" : "100%", "height" : "auto"});
                big();big();

              }else{
                $('#avatar').css({"width" : "auto", "height" : "100%"});
                small();small();
              }
            }

          $('#avatar').css({"display" : "block"});
          $('#no_av_place').css({"background-image" : "none"});

      });


      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              
              reader.onload = function (e) {
                
                var filename = $("#uploadform-file").val();
                var extension = filename.replace(/^.*\./, '');

                if(extension == "gif" || extension == "jpg" || extension == "png" || extension == "jpeg"){
                  

                  function small()
                  {
                    if(aspect_ratio_i != aspect_ratio){
                      margin[0] = (160 - $('#avatar').width()) / 2;
                      margin[1] = (160 - $('#avatar').height()) / 2;

                      $('#avatar').css({"left" : margin[0] + "px", "top" : margin[1] + "px"});
                    }
                  }

                  function big()
                  {
                    if(aspect_ratio_i != aspect_ratio){
                      margin[0] = ($('#avatar').width() / 2) - 80;
                      margin[1] = ($('#avatar').height() / 2) - 80;

                      $('#avatar').css({"left" : "-" + margin[0] + "px" , "top" : "-" + margin[1] + "px"});
                    }
                  }

                  $('#avatar').attr('src', e.target.result);


                }
              }



              
              reader.readAsDataURL(input.files[0]);
          }
      }
      
      $("#uploadform-file").change(function(){
          readURL(this);
      });
    </script>


    <div style="height: 25px;"></div>
    </div>

    <div class="bottom_zone">
      <?= Html::submitButton('Kitas', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 30px; padding: 0 130px 0 130px; margin-top:25px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7);']) ?>
    </div>
  <?php ActiveForm::end() ?>
<?php elseif($re == 4): ?>
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
  <div class="container" style="width:90%; font-family: OpenSans">
    <div class="row top">
      <div class="col-xs-4"></div>
      <div class="col-xs-8" style="padding-left: 0;">Keletas žodžių visiems(-oms) tavo profilio lankytojams (-oms)</div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        <div id="no_av_place" style="overflow: hidden; position: relative; float: right; width: 160px; height: 160px; background-image: url('/css/img/icons/no_avatar.png');">
          <img id="avatar" style="position: relative; display: hidden; " alt="" />
        </div>

      </div>
      <div class="col-xs-8">
        <div class="row"><?= $form->field($model_info, 'zodis')->textarea(['style' => 'height: 129px'])->label(false); ?></div>
        <div class="row top2"><input type="checkbox" id="c1" name="skip" /><label for="c1" style="font-family: OpenSans; cursor: pointer; font-weight: normal;"><span></span>Praleisti šį žingsnį</label> </div>
      </div>
    </div>

  </div>

  <div style="height: 15px;"></div>
  </div>

  <div class="bottom_zone">
    <?= Html::submitButton('Kitas', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 30px; padding: 0 130px 0 130px; margin-top:25px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7);']) ?>
    <?php ActiveForm::end() ?>
  </div>

  <?php
    $user = User::find()->where(['id' => $_GET['id']])->one();

    $c_steps = explode(" ", $user->reg_step);

    if(array_search(3, $c_steps)): ?>

      <script type="text/javascript">
        var extension = '<?= $user->avatar; ?>';
        $('#avatar').attr('src', "/uploads/531B"+<?= $id; ?>+"Iav."+extension);

        $( '#avatar' ).load(function() {

          var hBox = 160,
              wBox = 160;
              wImg = $('#avatar').width(),
              hImg = $('#avatar').height(),
              aRatio = hImg / wImg,
              margin = Array();
        
          if(aRatio >= 1){ //portrait
            $('#avatar').css({"width" : 160+"px", "height" : "auto"});

            hImg = $('#avatar').height();
            wImg = $('#avatar').width();

          }else{ 
            $('#avatar').css({"height" : 160+"px", "width" : "auto"});

            hImg = $('#avatar').height();
            wImg = $('#avatar').width();

          }

          margin[0] = (wImg - wBox) / -2;
          margin[1] = (hBox - hImg) / -2;

          $('#avatar').css({"left" : margin[0] + "px", "bottom" : margin[1] + "px"});
            });
      </script>

  <?php endif ?>
<?php endif ?>

<?php 
  if($info = Info::find()->where(['u_id' => $id])->one()){

    function pre_check($info, $param)
    {
      if(strlen($info->$param) >= 3){
        return $info->$param;
      }
    }

    if($info->gimtine == 126){
      $result = "01keisti";
    }else{
      $result = $info->tautybe;
    }

  }

?>
  
  <script type="text/javascript"> 
    var tauta = '<?= $result; ?>',
        pareiga = '<?= pre_check($info, "pareigos"); ?>',
        religija = '<?= pre_check($info, "religija"); ?>',
        plaukai = '<?= pre_check($info, "plaukai"); ?>',
        akys = '<?= pre_check($info, "akys"); ?>',
        stilius = '<?= pre_check($info, "stilius"); ?>';

  </script>
  <script type="text/javascript" src="/js/sSearch.js"></script>
  <script type="text/javascript" src="/js/kita.js"></script>
  <script type="text/javascript">
  </script>
