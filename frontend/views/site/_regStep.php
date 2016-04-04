<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use frontend\models\User;
use frontend\models\Info;

//$model_info = new Info;

$id = (isset($_GET['id']) ? $_GET['id'] : "");
$ra = (isset($_GET['ra']) ? $_GET['ra'] : "");
$re = (isset($_GET['re']) ? $_GET['re'] : "");

$user = User::find()->where(['id' => $_GET['id']])->one();

$re_next = $re + 1;

if($re == 0){$heading = "Truputi apie tave"; $sub_txt = ""; }
elseif($re == 1){$heading = "Tavo išvaizda"; $sub_txt = ""; }
elseif($re == 2){$heading = "Gyvenamoji vieta"; $sub_txt = ""; }
elseif($re == 3){$heading = "Profilio nuotrauka"; $sub_txt = "Įkelk profilio nuotrauką geriausiai atspindinčia tave";}
elseif($re == 4){$heading = "Tavo žodis"; $sub_txt = "Anketos pateika daug informacijos apie tave, bet tik tu žinai kas esi"; }

?>

<div class="profile_reg">
  <div class="title_zone">
    <div class="row">
      <div class="rutuliukai">
        
        <div id="container5">
          <div id="container4">
            <div id="container3">
              <div id="container2">
                <div id="container1">
                  <div id="col1">
                    <?= '<a href="?r=site/login&re=0&id='.$id .'&ra='.$ra.'" style="color: white; text-decoration: none;">'; ?>
                      <span style="position: relative; top: 5px; font-size: 40px;" id="skc1">1</span> <br>
                      <img src="/css/img/rutuliukas_z.png" class="rutuliukas" id="rutuliukas1z" style="display: none;" />
                      <img src="/css/img/rutuliukas_b.png" class="rutuliukas" id="rutuliukas1b" />
                    </a>
                  </div>
                  <div id="col2">
                    <?= '<a href="?r=site/login&re=1&id='.$id .'&ra='.$ra.'" style="color: white; text-decoration: none;">'; ?>               
                      <span style="position: relative; top: 5px; font-size: 40px;" id="skc2">2</span> <br>
                      <img src="/css/img/rutuliukas_z.png" class="rutuliukas" id="rutuliukas2z" style="display: none;" />
                      <img src="/css/img/rutuliukas_b.png" class="rutuliukas" id="rutuliukas2b" />
                    </a>
                  </div>
                  <div id="col3">
                    <?= '<a href="?r=site/login&re=2&id='.$id .'&ra='.$ra.'" style="color: white; text-decoration: none;">'; ?>
                      <span style="position: relative; top: 5px; font-size: 40px;" id="skc3">3</span> <br>
                      <img src="/css/img/rutuliukas_z.png" class="rutuliukas" id="rutuliukas3z" style="display: none;" />
                      <img src="/css/img/rutuliukas_b.png" class="rutuliukas" id="rutuliukas3b" />
                    </a>
                  </div>
                  <div id="col4">
                    <?= '<a href="?r=site/login&re=3&id='.$id .'&ra='.$ra.'" style="color: white; text-decoration: none;">'; ?>
                      <span style="position: relative; top: 5px; font-size: 40px;" id="skc4">4</span> <br>
                      <img src="/css/img/rutuliukas_z.png" class="rutuliukas" id="rutuliukas4z" style="display: none;" />
                      <img src="/css/img/rutuliukas_b.png" class="rutuliukas" id="rutuliukas4b" />
                    </a>
                  </div>
                  <div id="col5">
                    <?= '<a href="?r=site/login&re=4&id='.$id .'&ra='.$ra.'" style="color: white; text-decoration: none;">'; ?>
                      <span style="position: relative; top: 5px; font-size: 40px;" id="skc5">5</span> <br>
                      <img src="/css/img/rutuliukas_z.png" class="rutuliukas" id="rutuliukas5z" style="display: none;" />
                      <img src="/css/img/rutuliukas_b.png" class="rutuliukas" id="rutuliukas5b" />
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      <div class="hrcustm" id="reg_hrcustm" style="position: relative; opacity:1; top: -23px; background-color:#fff;"></div>
      </div>

    </div>

    <div class="row" style="position: relative; top: -20px;">


      <div class="reg_description">
        <h2 style="margin-top: 0;">
          <?= $heading; ?>
        </h2> 
        <br>
        <span class="reg_detailed_desc" style=" ">
          <a href="<?= Url::to(['site/skip', 'e' => $user->id, 'ak' => $user->auth_key ]); ?>" class="btn" style="position: relative; top: -20px; font-size: 14px; padding: 0 20px 0 20px; margin-top:25px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7);">Praleisti ir prisijungti</a>
        </span>
      </div>
    </div>
  </div>

  <?php 
  ?>
  <div class="input_zone">
    <?= $this->render('form/_form.php', ['model' => $model, 'UploadForm' => $UploadForm, 'model_info' => $model_info,]) ?>
  
</div>

<?php 
  $c_steps = explode(" ", $user->reg_step);
?>
<script type="text/javascript">
  var cur = <?= $re; ?>;
  var step = [<?php foreach($c_steps as $value){ echo $value.","; } ?>]; 
  $('.fade_back').css({"display" : "block"});
</script>
<script type="text/javascript" src="/js/reg_green.js"></script>