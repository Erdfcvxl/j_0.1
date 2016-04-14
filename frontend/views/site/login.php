<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\SignupForm;
use yii\helpers\Url;
use yii\authclient\widgets\AuthChoice;
use kartik\spinner\Spinner;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$model = new SignupForm();



$re = (isset($_GET['re']) ? $_GET['re'] : "");



if(Yii::$app->session->hasFlash('error')): ?>

  <script type="text/javascript" src="/js/expandReg.js"></script>
  <script type="text/javascript">$(document).ready(expn); $(body).css({"background-color" : "#e7e7e7"});</script>

<?php endif ?>

<?php if($re != ""): ?>
  <?= $this->render('_regStep.php', ['model' => $model, 'UploadForm' => $UploadForm, 'model_info' => $model_info,]) ?>  
<?php endif ?>


 <?php if(isset($_GET['psl']) && $_GET['psl'] == "afterfb"): ?>
    <script type="text/javascript">$('.fade_back').css({"display" : "block"});</script>

    <?= $this->render('//site/_afterfb', ['modelInfo' => $modelInfo] ); ?>

<?php endif; ?>

<?php $authAuthChoice = AuthChoice::begin([
    'baseAuthUrl' => ['site/auth'],
    'options' => ['style' => 'display: none']
]); ?>
<?php AuthChoice::end(); ?>

<?php $authAuthChoice2 = AuthChoice::begin([
    'baseAuthUrl' => ['site/auth'],
    'options' => ['style' => 'display: none', 'class' => 'btn btn-info fb']
]); ?>
<?php AuthChoice::end(); ?>

<div class="whiteOut">
  <div id="spinner">
    <?= Spinner::widget(['preset' => 'large', 'align' => 'center']); ?>
  </div>
</div>

<script type="text/javascript">
  $('#spinner').css({
    "top" : $(document).height() / 2 - $('#spinner').height() / 2 + "px",
  });

  $(function(){
    setTimeout(function(){
      $('.whiteOut').fadeOut();
    }, 300)
    
  })
</script>

<div id="taisykles" style="position: relative; width: 100%; z-index: -1">
  <div class="xHolder">
    <a id="xas" style="color: #b7b7b7; cursor: pointer; font-size: 20px;" class="glyphicon glyphicon-remove"></a>
  </div>
  <div class="taisykles">
    <?= $this->render('_taisykles'); ?>
  </div>
</div>


<div class="first_flat" id="original" style="z-index: 1;">
  <div class="first_flat" id="copy" style="position: absolute; z-index: -999998;">
    <img src="/css/img/pazintys_lietuviams.jpg?t=<?/*/*= time(); */*/?>" class="bg_img" id="log_bg1" style="display: none; z-index: -1; top: 0;"alt="Pažintys lietuviams Anglijoje" title="Pažintys lietuviams Anglijoje"/>
    <img src="/css/img/pazintys_lietuviams.jpg?t=<?/*/*= time(); */*/?>" class="bg_img" id="log_bg2" style="display: block; z-index: -2; top: 0;"alt="Pažintys lietuviams Anglijoje" title="Pažintys lietuviams Anglijoje"/>
  </div>

  <?= $this->render('//site/includes/header', ['modelis' => $modelis]); ?>





    <div class="container">

      <div id="Review0" style="position: absolute; bottom: 90px; width: 280px; line-height: 1.2; font-size: 22px; color: white;"><B>"Dar niekada nebuvo taip paprasta naudotis pažinčių svetaine!"</B> <span style="font-size: 16px">-Simona. Londonas, 27 metai.</span></div>

      <?= $this->render('//site/includes/registracija', ['model' => $model, 'model2' => $model2, 'authAuthChoice' => $authAuthChoice]); ?>

    </div>

    <div class="bottom-line"></div>

</div>

<div class="flat navigation" style="z-index: 1; background-color: #fff; min-height: 20px; padding: 0px 0 0px; border-bottom: 1px solid #dedede;">
  <div class="container" id="atskaita">

    <div class="row" style="text-align: center; color: black; font-size: 16px">
      <div class="col-xs-6 col-sm-3 btnn" ><a href="#flat2" class="work" style="width: 114px;">APIE MUS</a></div>
      <div class="col-xs-6 col-sm-3 btnn" ><a href="#flat3" class="work" style="width: 114px;">KODĖL MES</a></div>
      <div class="col-xs-6 col-sm-3 btnn" ><a href="#flat4" class="work" style="width: 114px;">KAIP TAI VEIKIA</a></div>
      <div class="col-xs-6 col-sm-3 btnn" ><a href="#flat5" class="work" style="width: 114px;">ATSILIEPIMAI</a></div>
    </div>

  </div>
</div>

<?= $this->render('//site/includes/about');?>
<?= $this->render('//site/includes/kodel');?>
<?= $this->render('//site/includes/kaip');?>
<?= $this->render('//site/includes/atsiliepimai');?>




<div class="flat" id="flat5" style="background-color: #f8f8f8; padding: 25px; min-height: 0; text-align: center;">
    <a href="#" class="btn btn-reg" id="registruokisDabar" style="font-size: 30px; border-radius: 0; font-family: OpenSansBold;text-shadow: 1px 1px 11px rgba(150, 150, 150, 1); ">REGISTRUOKIS DABAR!</a>


<?php if($model2->getErrors()){
    $er_yra = 1;
  } else{
    $er_yra = 0;
  }
?>
<script type="text/javascript">
  $('#registruokisDabar').click(function(){
    $('html, body').animate({scrollTop : 0},800);
    return false;
  });

  $(document).on('click','.work', function(event) {
      event.preventDefault();
      var target = this.getAttribute('href');
      $('html, body').animate({
          scrollTop: $(target).offset().top
      }, 500);
  });

  $(function(){
    fixTop();
  });

  $(window).resize(function(){
    fixTop();
  });


</script>
<script type="text/javascript">var er_yra = <?= $er_yra; ?>;</script>
<script type="text/javascript" src="/js/bg_fixing.js"></script>
<script type="text/javascript" src="/js/fixing.js"></script>
<script type="text/javascript">$("#flat2").backstretch("/css/img/pazintys.jpg"); $("#flat5").backstretch("/css/img/couple.jpg");</script>
<script type="text/javascript" src="/js/expandReg.js"></script>
<script type="text/javascript" src="/js/bgChange.js"></script>

