<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

use kartik\select2\Select2;

include('../views/site/form/_list.php');

for($i = date('Y')-18; $i > date('Y') - 80; $i--){
  $year[$i] = $i;
}
for($i = 1; $i <= 12; $i++){
  $month[$i] = $i;
}
for($i = 1; $i < 32; $i++){
  $day[$i] = $i;
}
?>

<div class="row">
    <div class="col-xs-12 greenTitle">Antroji pusė tūrėtų būti</div>
    <div class="col-xs-12 greenHr"></div>
</div>
<div class="row"style="margin-top: 3px;">
  <div class="col-xs-6">
    <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0;">Gimimo data<span id="dateOff" class="glyphicon glyphicon-remove" style="float: right; cursor: pointer;"></span><span id="dateOn" class="glyphicon glyphicon-ok" style="float: right; cursor: pointer; display: none;"></span></div>
          <div class="col-xs-8 col-sm-8 vcenter top">
            <div class="row" style="padding: 0 15px 0 15px">
              <div class="col-xs-4" style="padding: 0;"><?= $form->field($searchModel, 'metai')->dropDownList($year,['class' => 'reg_dropbox', 'style' => 'padding-left: 5px;'])->label(false); ?> </div>
              <div class="col-xs-4" style="padding: 0 0 0 5px;"><?= $form->field($searchModel, 'menuo')->dropDownList($month,['class' => 'reg_dropbox', 'style' => 'padding-left: 5px;'])->label(false); ?> </div>
              <div class="col-xs-4" style="padding: 0 0 0 5px;"><?= $form->field($searchModel, 'diena')->dropDownList($day,['class' => 'reg_dropbox', 'style' => 'padding-left: 5px;'])->label(false); ?> </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Gimtoji šalis</div>
          <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($searchModel, 'gimtine')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($gimtoji_salis),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Praleisti jei nesvarbu'],
                                                                                          'pluginEvents' => [
                                                                                            'select2-selected' => "function(e) { tautybe(e); }",
                                                                                          ],
                                                                                        ])->label(false);?> 
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Gimtoji vieta</div>
          <div class="col-xs-8 col-sm-8 vcenter top">
            <div id="tautybes" style="display: none"><?= $form->field($searchModel, 'tautybe')->widget(Select2::classname(), [
                                                                    'data' => array_merge($gimtine),
                                                                    'language' => 'en',
                                                                    'options' => ['placeholder' => 'Praleisti jei nesvarbu'],
                                                                    'pluginEvents' => [
                                                                      'select2-selected' => "function(e) { kitas(e, 'tautybes');  naujas(e, 'tautybe');}",
                                                                    ],
                                                                  ])->label(false);?></div>
            <div id="tautybes2">
              <?= $form->field($searchModel, 'tautybe2')->textInput(['placeholder' => 'Praleisti jei nesvarbu'])->label(false); ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Religija</div>
          <div class="col-xs-8 col-sm-8 vcenter top">
            <div id="religijos"><?= $form->field($searchModel, 'religija')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($religija),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Praleisti jei nesvarbu'],
                                                                                          'pluginEvents' => [
                                                                                              "select2-open" => "function() { search_off(); }",
                                                                                              "select2-close" => "function() { search_on(); }",
                                                                                              'select2-selected' => "function(e) { kitas(e, 'religijos'); naujas(e, 'religija'); }",
                                                                                            ],
                                                                                        ])->label(false);?> </div>
            <div id="religijos2" style="display: none">
              <?= $form->field($searchModel, 'religija2')->textInput(['placeholder' => 'Įrašykite gimtąją vietovę'])->label(false); ?><div class="xas glyphicon glyphicon-remove" id="tautoff" parent="religijos" style="right: 20px; top: 10px;"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Statusas</div>
          <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($searchModel, 'statusas')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($statusas),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Praleisti jei nesvarbu'],
                                                                                            'pluginEvents' => [
                                                                                              "select2-open" => "function() { search_off(); }",
                                                                                              "select2-close" => "function() { search_on(); }"
                                                                                            ],
                                                                                          ])->label(false);?> 
          </div>
        </div>

        <div class="row rajonas">
            <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Gyvenamasis rajonas</div>
            <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($searchModel, 'grajonas')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($rajonai),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Praleisti jei nesvarbu'],
                                                                                          ])->label(false);?> 
            </div>
        </div>

      </div>

      <div class="col-xs-6">

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Išsilavinimas</div>
          <div class="col-xs-8 col-sm-8 vcenter top" style="position: relative; top: 1px;"><?= $form->field($searchModel, 'issilavinimas')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($issilavinimas),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Praleisti jei nesvarbu'],
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
            <div id="pareigoss"><?= $form->field($searchModel, 'pareigos')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($pareigos),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Praleisti jei nesvarbu'],
                                                                                          'pluginEvents' => [
                                                                                            'select2-selected' => "function(e) { kitas(e, 'pareigoss'); naujas(e, 'pareigos'); }",
                                                                                          ],
                                                                                        ])->label(false);?></div>
            <div id="pareigoss2" style="display: none">
              <?= $form->field($searchModel, 'pareigos2')->textInput()->label(false); ?><div class="xas glyphicon glyphicon-remove" id="tautoff" parent="pareigoss" style="right: 20px; top: 10px;"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Uždarbis</div>
          <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($searchModel, 'uzdarbis')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($uzdarbis),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Praleisti jei nesvarbu'],
                                                                                          'pluginEvents' => [
                                                                                              "select2-open" => "function() { search_off(); }",
                                                                                              "select2-close" => "function() { search_on(); }"
                                                                                          ],
                                                                                        ])->label(false);?> 
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Seksualinė orentacija</div>
          <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($searchModel, 'orentacija')->widget(Select2::classname(), [
                                                                                          'data' => array_merge($orentacija),
                                                                                          'language' => 'en',
                                                                                          'options' => ['placeholder' => 'Praleisti jei nesvarbu'],
                                                                                          'pluginEvents' => [
                                                                                              "select2-open" => "function() { search_off(); }",
                                                                                              "select2-close" => "function() { search_on(); }"
                                                                                          ],
                                                                                        ])->label(false);?> 
          </div>
        </div>

        <div class="row">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Tikslas šiame portale</div>
          <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($searchModel, 'tikslas')->widget(Select2::classname(), [
                                                                                        'data' => array_merge($tikslas),
                                                                                        'language' => 'en',
                                                                                        'options' => ['placeholder' => 'Praleisti jei nesvarbu'],
                                                                                        'pluginEvents' => [
                                                                                            "select2-open" => "function() { search_off(); }",
                                                                                            "select2-close" => "function() { search_on(); }"
                                                                                        ],
                                                                                      ])->label(false);?> 
          </div>
        </div>

        <div class="row rajonas">
          <div class="col-xs-4 col-sm-4 vcenter top" style="padding-right: 0px;">Darbovietės rajonas</div>
          <div class="col-xs-8 col-sm-8 vcenter top"><?= $form->field($searchModel, 'drajonas')->widget(Select2::classname(), [
                                                                                            'data' => array_merge($rajonai),
                                                                                            'language' => 'en',
                                                                                            'options' => ['placeholder' => 'Praleisti jei nesvarbu'],
                                                                                          ])->label(false);?> 
          </div>
        </div>

    </div>
</div>

<br>

<div class="row">
    <div class="col-xs-12 greenTitle">Antroji pusė tūrėtų atrodyti</div>
    <div class="col-xs-12 greenHr"></div>
</div>

<div class="row" style="margin-top: 5px;">
  <div class="col-xs-6">
    <div class="row">
      <div class="col-xs-4 vcenter top2">Kūno sudėjimas</div>
      <div class="col-xs-8 vcenter top2"><?= $form->field($searchModel, 'sudejimas')->widget(Select2::classname(), [
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
        <div id="pspalva"><?= $form->field($searchModel, 'plaukai')->widget(Select2::classname(), [
                                                                                        'data' => array_merge($plaukai),
                                                                                        'language' => 'en',
                                                                                        'options' => ['placeholder' => 'Pasirinkite savo plaukų spalvą ...'],
                                                                                        'pluginEvents' => [
                                                                                            "select2-open" => "function() { search_off(); }",
                                                                                            "select2-close" => "function() { search_on(); }",
                                                                                            'select2-selected' => "function(e) { kitas(e, 'pspalva'); naujas(e, 'plaukai');}",
                                                                                        ],
                                                                                      ])->label(false);?></div>
        <div id="pspalva2" style="display: none;">
          <?= $form->field($searchModel, 'plaukai2')->textInput(['placeholder' => 'Įrašykite plaukų spalvą'])->label(false); ?><div class="xas glyphicon glyphicon-remove" id="tautoff" parent="pspalva" style="right: 20px; top: 10px;"></div>
        </div>
      </div>
    </div> 
  </div>
  <div class="col-xs-6">
    <div class="row">
      <div class="col-xs-4 vcenter top2">Akių spalva</div>
      <div class="col-xs-8 vcenter top2">
        <div id="aspalva"><?= $form->field($searchModel, 'akys')->widget(Select2::classname(), [
                                                                                        'data' => array_merge($akys),
                                                                                        'language' => 'en',
                                                                                        'options' => ['placeholder' => 'Pasirinkite savo akių spalvą ...'],
                                                                                        'pluginEvents' => [
                                                                                            "select2-open" => "function() { search_off(); }",
                                                                                            "select2-close" => "function() { search_on(); }",
                                                                                            'select2-selected' => "function(e) { kitas(e, 'aspalva'); naujas(e, 'akys');}",
                                                                                        ],
                                                                                      ])->label(false);?> </div>
        <div id="aspalva2" style="display: none;">
          <?= $form->field($searchModel, 'akys2')->textInput(['placeholder' => 'Įrašykite akių spalvą'])->label(false); ?><div class="xas glyphicon glyphicon-remove" id="tautoff" parent="aspalva" style="right: 20px; top: 10px;"></div>
        </div>
      </div>
    </div> 

    <div class="row">
      <div class="col-xs-4 vcenter top2">Aprangos stilius</div>
      <div class="col-xs-8 vcenter top2">
        <div id="stilius"><?= $form->field($searchModel, 'stilius')->widget(Select2::classname(), [
                                                                                        'data' => array_merge($stilius),
                                                                                        'language' => 'en',
                                                                                        'options' => ['placeholder' => 'Pasirinkite savo stilių ...'],
                                                                                        'pluginEvents' => [
                                                                                            'select2-selected' => "function(e) { kitas(e, 'stilius'); naujas(e, 'stilius');}",
                                                                                        ],
                                                                                      ])->label(false);?></div>
        <div id="stilius2" style="display: none;">
          <?= $form->field($searchModel, 'stilius2')->textInput(['placeholder' => 'Įrašykite stilių'])->label(false); ?><div class="xas glyphicon glyphicon-remove" id="tautoff" parent="stilius" style="right: 20px; top: 10px;"></div>
        </div>
      </div>
    </div> 
  </div>
</div>

<br>

<?= $form->field($searchModel, 'religijacomplete')->textInput(['placeholder' => 'Įrašykite stilių', 'style' => 'display: none;'])->label(false); ?>
<?= $form->field($searchModel, 'pareigoscomplete')->textInput(['placeholder' => 'Įrašykite stilių', 'style' => 'display: none;'])->label(false); ?>
<?= $form->field($searchModel, 'plaukaicomplete')->textInput(['placeholder' => 'Įrašykite stilių', 'style' => 'display: none;'])->label(false); ?>
<?= $form->field($searchModel, 'akyscomplete')->textInput(['placeholder' => 'Įrašykite stilių', 'style' => 'display: none;'])->label(false); ?>
<?= $form->field($searchModel, 'stiliuscomplete')->textInput(['placeholder' => 'Įrašykite stilių', 'style' => 'display: none;'])->label(false); ?>


<?php $this->registerJs($this->render('scriptForm.js')); ?>



<script type="text/javascript"> 
  var tauta = '',
      pareiga = '<?php echo (!$searchModel->pareigos && $searchModel->pareigos2)? "a" : "" ?>',
      religija = '<?php echo (!$searchModel->religija && $searchModel->religija2)? "a" : "" ?>',
      plaukai = '<?php echo (!$searchModel->plaukai && $searchModel->plaukai2)? "a" : "" ?>',
      akys = '<?php echo (!$searchModel->akys && $searchModel->akys2)? "a" : "" ?>',
      stilius = '<?php echo (!$searchModel->stilius && $searchModel->stilius2)? "a" : "" ?>';

</script>
<script type="text/javascript" src="/js/sSearch.js"></script>
<script type="text/javascript" src="/js/kita.js"></script>

<script type="text/javascript">
  $( "#detailsearchp-miestas" ).change(function(e) {
    miestas(e.target.selectedIndex);
  });

  $(function(){
    miestas($( "#detailsearchp-miestas" )[0].selectedIndex);
  });

  function miestas(index)
  {
    if(index == 1){
      $('.rajonas').fadeIn();
    }else{
      $('.rajonas').fadeOut();
    }
  }


  $(function (){
    var miestas = '<?= $searchModel->miestas; ?>';

    if(miestas == '0'){
      $('.rajonas').css({'display' : "block"});
    }
  });
</script>
