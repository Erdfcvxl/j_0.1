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

for($i = 18; $i < 90; $i++){
  $agech[$i] = $i;
}

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
  </div>
  <div class="header">

    <div class="fix" id="fixLeft"></div>
    <div class="fix" id="fixRight"></div>
    
    <div class="container">
      <div class="row headerAtskaita">
        <div class="col-sm-3 col-md-4" id="h2"><img src="/css/img/icons/logo2.png"><span style="margin-left: 15px;">Pažintyslietuviams.co.uk</span></div>
        <div class="col-sm-9 col-md-8" id="h3">

            <div class="row" style="display: none;" id="almost">
              <div class="col-xs-12"style="text-align:right;">
                <a href="<?= Url::to(['site/auth', 'authclient' => 'facebook']); ?>"><div class="loginPick fb2"></div></a><!-- 
                 --><div class="loginPick normalus m2" id="si"></div>
              </div>
            </div>

            <div class="row" style="padding-top: 15px;" id="preLog">
              <div class="col-xs-11 col-sm-11" style="text-align: right; padding-right: 0;">
                <a class="" id="firstLog">Prisijungti</a>
              </div>
              <div class="col-xs-1 col-sm-1" style="text-align: right; padding-left: 0;">
                <a class="ltRound">LT</a>
              </div>
            </div>

            <script type="text/javascript">
              var selected = 0;
              var touch;

              function is_touch_device() {
                return 'ontouchstart' in window // works on most browsers
                    || 'onmsgesturechange' in window; // works on ie10
              };

              $(function(){
                touch = is_touch_device();

                if(touch){
                  $('#firstLog').click(function(){
                    $('#preLog').css({"display" : "none"});
                    $('#almost').css({"display" : "block"});
                    $('#errorBox').css({'display':'none'});
                  });
                }else{
                  $('#firstLog').mouseenter(function(){
                    $('#preLog').css({"display" : "none"});
                    $('#almost').css({"display" : "block"});
                    $('#errorBox').css({'display':'none'});
                  });

                  $('#almost').mouseleave(function(){
                    if(selected == 0){
                      $('#preLog').css({"display" : "block"});
                      $('#almost').css({"display" : "none"});
                      $('#simpleL').css({"display" : "none"});
                    }
                  });
                }
              });



              $('#si').click(function(){ 
                  selected = 1;

                  $('#errorBox').css({'display':'none'});
                  $('#almost').css({'display':'none'});
                  $('#simpleL').css({'display':'block'});

                });

              
              
              

            </script>

            <div class="row" >
              <div class="col-xs-6 col-sm-6" style="text-align: right;" id="topFB">
                
              </div>
            </div>

            <div class="row" id="errorBox">
              <div class="col-xs-5 col-xs-offset-6" style="text-align: right; padding-right: 0;">
                <?php if(Yii::$app->session->hasFlash("info")): ?>
                  <?= Yii::$app->session->getFlash("info"); ?>
                <?php endif; ?>
              </div>
            </div>

          <div id="simpleL" style="display: none;">

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-xs-1" style="padding-right: 0; text-align: right;"></div>
                <div class="col-xs-4 col-sm-3 styled_inp"><?= $form->field($modelis, 'username')->textInput(['placeholder' => 'Vardas'])->label(false); ?></div>
                <div class="col-xs-4 col-sm-3 styled_inp"><?= $form->field($modelis, 'password')->passwordInput(['placeholder' => 'Slaptažodis'])->label(false); ?></div>
                <div class="col-xs-3 col-sm-3"><?= Html::submitButton('Prisijungti', ['class' => 'btn btn-reg btn-prisijungti', 'id' => 'login_btn', 'name' => 'signup-button2']) ?></div>
           </div>

            <div class="row" style="position: relative; top: -15px; font-size: 12px;">
              <div class="col-xs-1"></div>
              <div class="col-xs-4 col-sm-3"><?= $form->field($modelis, 'rememberMe')->checkbox()->label('<span style="position: absolute; top: -8px; color: black !important;">Prisiminti mane</span>'); ?></div>
              <div class="col-xs-4 col-sm-3"><a href="<?= Url::current(['lost' => 1]); ?>" style="font-size: 11px; position: relative; top: 2px;">Pamiršau slaptažodį</a></div>
            </div>

            <div class="row" style="position: relative; top: -48px; font-size: 12px;">
              <div class="col-xs-1"></div>
            </div>
            <?php ActiveForm::end(); ?>

          </div>

        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
      function fixTop(){
        var atskaita = $('#atskaita'),
            containerW = atskaita.innerWidth(),
            WW =  $('body').innerWidth();
            fixLeft = $('#fixLeft'),
            fixRightW = $('#fixRight'),
            newW = (WW - containerW) / 2;

        fixLeft.css({"width" : newW + "px"});
        fixRightW.css({"width" : newW + "px"});
      }


  </script>

  <img src="/css/img/pazintys_lietuviams.jpg?t=<?= time(); ?>" class="bg_img" id="log_bg1" style="display: none; z-index: -1; top: 0;"alt="Pažintys lietuviams Anglijoje" title="Pažintys lietuviams Anglijoje"/>
  <img src="/css/img/pazintys_lietuviams.jpg?t=<?= time(); ?>" class="bg_img" id="log_bg2" style="display: block; z-index: -2; top: 0;"alt="Pažintys lietuviams Anglijoje" title="Pažintys lietuviams Anglijoje"/>
  <img src="/css/img/vv.jpg" class="bg_img" id="log_bg3" style="display: none; z-index: -3; top: 0;" alt="Pažintys lietuviams Anglijoje" title="Pažintys lietuviams Anglijoje"/> 
  <img src="/css/img/mm.jpg" class="bg_img" id="log_bg4" style="display: none; z-index: -4; top: 0;" alt="Pažintys lietuviams Anglijoje" title="Pažintys lietuviams Anglijoje"/>


    <div class="container">

      <div id="Review0" style="position: absolute; bottom: 90px; width: 280px; line-height: 1.2; font-size: 22px; color: white;"><B>"Dar niekada nebuvo taip paprasta naudotis pažinčių svetaine!"</B> <span style="font-size: 16px">-Simona. Londonas, 27 metai.</span></div>

      <div class="first_flat_right">

      <h1 class="title" style="color: #111111; font-size: 26px; margin-top: 0px;"><div style="position: absolute; z-index: -1;"><img src="/css/img/gradient.png" style="position: relative; top:-100px; left: -40px; z-index: -1;" width="450px;" height="250px;"></div>SURASK ANTRĄ PUSĘ <span class="title_bold">ANGLIJOJE IR AIRIJOJE</span></h1>

        <div class="login_box">
          <div style="position: relative; margin-top: -61px; top: 61px; height: 60px; display: block; padding-top: 1px;">
            <h2 id="off1" style="margin-bottom: -5px; font-size: 25px;">REGISTRACIJA</h2>
            <div class="hrcustm" id="off2" style="margin-top:5px;"></div>
          </div>

          <?php $form = ActiveForm::begin(['id' => 'form-signup', 'enableClientValidation' => true]); ?>
            <table style="text-align: left; font-size: 15px; position: relative; top:50px; margin-top: 20px; z-index: 5;" id="first">
              <tr>
                <td style="padding: 10px 5px 10px 5px;" class="th">Aš esu:</td>
                <td style="padding: 10px 10px 10px 10px;" class="td"><?= Html::dropDownList('gender', $selection = 'mv', ['vm' => 'Vyras ieškantis moters', 'mv' => 'Moteris ieškanti vyro' , 'vv' => 'Vyras ieškantis vyro' , 'mm' => 'Moteris ieškanti moters' ], $options = ['style' => 'width: 210px; color: #353535; height: 25px; padding: 0 0 3px 5px; font-size: 15px', 'class' => 'reg_dropbox', 'id' => 'change_color0'] ); ?></td>
              </tr>
              <tr id="2tr">
                <td style="padding: 10px 5px 20px 5px;" class="th">Amžius tarp:</td>
                <td style="padding: 10px 10px 20px 10px;" class="td">
                  <?= Html::dropDownList('age_from', $selection = 18, $agech, $options = ['style' => 'width:85px; color: #353535; height: 25px; padding: 0 0 3px 5px;', 'class' => 'reg_dropbox']); ?>
                  &nbsp&nbsp ir &nbsp&nbsp  
                  <?= Html::dropDownList('age_to', $selection = 25, $agech, $options = ['style' => 'width: 85px; color: #353535; height: 25px; padding: 0 0 3px 5px;', 'class' => 'reg_dropbox']); ?>
                </td>
              </tr>
            </table>

          <div id="expand_complete" style="display:none; opacity: 0; position: relative; top: -14px; font-size: 15px; ">
            <table style="text-align: left;" id="second">
              <tr>
                <td style="padding: 10px 5px 5px 10px">Slapyvardis:</td>
                <td style="padding-left: 8px"><?= $form->field($model2, 'username')->label(false); ?></td>
              </tr>
              <tr>
                <td style="padding: 10px 5px 5px 10px">Slaptažodis:</td>
                <td style="padding-left: 8px"><?= $form->field($model2, 'password')->passwordInput()->label(false); ?></td>
              </tr>
              <tr>
                <td style="padding: 10px 5px 5px 10px">E-paštas:</td>
                <td style="padding-left: 8px"><?= $form->field($model2, 'email')->label(false); ?></td>
              </tr>
              <tr>
                <td style="padding: 10px 5px 5px 10px; font-size: 13px">Apie šią svetainę sužinojau:</td>
                <td style="padding-left: 8px"><?= Html::dropDownList('heard_from', $selection = '', ['Google paieškoje', 'Reklamoje Internete', 'Iš draugo', 'Spaudoje', 'Kita'], $options = ['style' => 'width: 210px; color: #353535; height: 25px; padding: 0 0 3px 5px;', 'class' => 'reg_dropbox'] ); ?></td>
              </tr>
            </table>
            
            <div class="row" style="margin-top: 0px; font-size: 12px;">
            <?php $model2->pilnametis = 0; ?>
              <div class="col-xs-1" style="text-align: right; padding-right: 0; margin-left: 30%;"><?= $form->field($model2, 'pilnametis')->checkbox(['style' => 'display: inline-block; position: static; width: 20px; margin-top: -4px;','template' => '{input}<div style="position: relative; width: 200px; left: -50px; margin-top: -10px; font-size: 12px;">{error}</div>'])->label(false); ?></div>
              <div class="col-xs-6" style="margin-left: 10px; padding-left: 0; text-align: left;">Man yra 18 metų, su <span style="cursor: pointer; border-bottom: 1px solid white;" id="triggerT">taisyklėmis</span> sutinku</div>
            </div>
          </div>

      
          <?= Html::submitButton('Baigti registraciją', ['class' => 'btn btn-reg', 'style' => 'display: none; opacity: 0; margin: -105px auto 30px auto; position: relative; top: 100px', 'id' => 'expand_end_btn', 'name' => 'signup-button']) ?>
          
          <script type="text/javascript">
            $('#triggerT').click(function(){
              $('.fade_back').css({"display" : "block"});
              $('#taisykles').css({"z-index": "15"});
            });

            $('#xas').click(function(){
              $('.fade_back').css({"display" : "none"});
              $('#taisykles').css({"z-index": "-1"});
            });
          </script>

          <div style="clear:both"></div>

          <div style="margin-top: 0px;" id="off3">

            <div class="btn btn-reg" id="exp" style="font-size:15px; padding: 5px 8px 5px 8px;margin-top: 50px;">Registruotis Nemokamai</div>

            <div style="margin-top: 15px;" id="off4">
              <div class="hrcustm" style="width: 135px; float: left; position: relative; top:19px;"></div>
                <img src="/css/img/icons/arba.png"/>
              <div class="hrcustm" style="width: 135px; float: right; position: relative; top:19px;"></div>
               <?= $authAuthChoice->clientLink($authAuthChoice->getClients()['facebook']) ?>
            </div>
          </div>

          <?php ActiveForm::end(); ?>

        </div>

      </div>

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

<div class="flat" id="flat2" style="background-image: url(css/img/pazintys.jpg); background-size: 100% auto; height: 600px; padding-top: 50px;">
  <div class="container">
    <div class="row"  style="margin-bottom: 30px;">
      <div class="col-xs-12">
        <div class="sviesulys" style="position: absolute; z-index: -100;"><img src="/css/img/gradient.png" style="position: relative; top:-250px; left: -200px;" width="700px;" height="800px;"></div>
        <span class="h2">Mes esame <img src="/css/img/icons/logo3.png"></span><h2 style="display: inline-block;"><span style="color: #94c500;">Pažintyslietuviams.co.uk</span></h2>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-8 col-md-5">
        <p>
        Ar žinojai, kad Jungtinėje Karalystėje gyvena beveik 300 000 tavo tautiečių? Su jais visais tu gali susipažinti čia! Norėdami suteikti Tau šią galimybę mes sukūrėme šią svetainę. Esame išsibarstę po visą šalį, todėl norime padėti atrasti gyvenimo meilę. Kartu su jumis stengsimės, jog ši svetainė taptų sėkmingų santykių pradžia. Sėkmės!
        </p>
      </div> 
    </div>
  </div>
</div>

<div class="flat" id="flat3" style="min-height: 600px; padding-top: 50px; padding-bottom: 50px; background-color: #f8f8f8;">
  <div class="container">
    <div class="row" style="margin-bottom: 30px;">
      <div class="col-xs-12">
        <div  class="sviesulys" style="position: absolute; z-index: -100;"><img src="/css/img/gradient.png" style="position: relative; top:-250px; left: -200px;" width="700px;" height="800px;"></div>
        <span class="h2">Kodėl verta rinktis <img src="/css/img/icons/logo3.png"></span><h2 style="display: inline-block;"><span style="color: #94c500;">Pažintyslietuviams.co.uk</span></h2>
      </div>
    </div>

    <div class="row">
      <div class="col-md-5 col-md-offset-1">
        <p>
          <b>Jūs esate patikimose rankose!</b> <br>
          Mūsų komandoje dirba ne tik profesionalai meilės srityje, bet ir saugumo ekspertai, užtikrinantys nepriekaištingą Jūsų privatumo apsaugą.
        </p>
      </div>

      <div class="col-md-5"> 
        <div class="row">
          <div class="col-xs-4"><img src="/css/img/icons/raktas.png" width="100%"></div>
          <div class="col-xs-4"><img src="/css/img/icons/spyna.png" width="100%"></div>
          <div class="col-xs-4"><img src="/css/img/icons/skydas.png" width="100%"></div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-top: 80px;">
      <div class="col-xs-6 col-md-5 col-md-offset-1">
        <div class="col-xs-12 col-md-4 col-md-offset-8"><img src="/css/img/icons/strele.png" width="100%"></div>
      </div>
      <div class="col-xs-6 col-md-5">
        <p>
          <b>Išmani ir patogi naudotis svetainė</b> <br>

          Išmani programa automatiškai pasiūlys 
          susipažinti tau, su labiausiai tinkančiu 
          kanditatu, pasimatymui.

          Išnaudok visas paieškos galimybes ir rask labiausiai tau tinkančią antrąją pusę
        </p>
      </div>
    </div>

  </div>
</div>

<div class="flat" id="flat4" style="height: auto; padding-top: 50px; padding-bottom: 50px; background-color: #1d86c8;">
  <div class="container">
    <div class="row">
      <div class="col-md-12" style="color: white;"><h2>Kaip tai veikia</h2></div>
    </div>
    <div class="row">
      <div class="col-xs-12">
          <img src="/css/img/antra-puse.jpg" width="100%">
      </div>
    </div>
  </div>
</div>

<div class="flat" id="flat5" style="min-height: 600px; padding-bottom: 50px;">

  <div class="container">
    <h2 style="font-face: OpenSans-Light; color: white;">Atsiliepimai</h2>
    <div class="row">


      <div id="container">
        <div id="carousel">
          <div id="slide01" class="slide">

            <div class="col-md-6" id="s1">
              <p style="background-color: rgba(255,255,255,0.7); padding: 15px; margin-top: 20px; margin-bottom: 20px; font-family: OpenSansItalic;">
                Mes su vyru susipažinome pažinčių svetainėje pazintyslietuviams.co.uk. Į Angliją abu atvykome

                ieškodami geresnio gyvenimo, dirbome labai daug, o naujoms pažintims laiko beveik nelikdavo. 

                Todėl teko pasitelkti  šią pažinčių svetainę ir tikrai nenusivylėme. Esame be galo dėkingi 

                pazintyslietuviams.co.uk. už tai, kad suradome vienas kitą, esame mylimi ir nebe vieniši. 

                Pazintyslietuviams.co.uk. yra puiki pažinčių svetainė užmėgsti naujus santykius lietuviams, 

                gyvenantiems Anglijoje ir Airijoje.              
              </p>
              <div class="row" style="margin-top: -10px; text-align: right;">
                <div class="col-xs-6 col-xs-offset-6" style="color: white; font-size: 16px;">Ieva ir Evaldas, <span style="font-size: 14px;">Londonas</span></div>
              </div>
            </div>
            <div class="col-md-6" id="s2">
              <p style="background-color: rgba(255,255,255,0.7); padding: 15px; margin-top: 20px; margin-bottom: 20px; font-family: OpenSansItalic;">
                Su savo mylimuoju susipažinome pazintyslietuviams.co.uk. Be šios pažinčių svetainės pagalbos

                turbūt nebūtume suradę vienas kito, kadangi aš gyvenau Anglijoje, o jis  - Airijoje. Nors mus skyrė 

                didelis atstumas, šio modernaus portalo dėka galėjome bendrauti betarpiškai, lengvai, daug ir 

                smagiai.  Šiuo metu įsikūrėme Dubline, esame labai laimingi ir įsimylėję. Norime padėkoti 

                pazintyslietuviams.co.uk. už atrastą antrąją pusę!  Tai neabejotinai geriausia pažinčių svetainė 

                lietuviams, gyvenantiems Jungtinėje karalystėje. Ačiū.
              </p>
              <div class="row" style="margin-top: -10px; text-align: right;">
                <div class="col-xs-6 col-xs-offset-6" style="color: white; font-size: 16px;">Simona ir Tadas, <span style="font-size: 14px;">Londonas</span></div>
              </div>
            </div>

          </div>

          <div id="slide01" class="slide">

            <div class="col-md-6" id="s3">
              <p style="background-color: rgba(255,255,255,0.7); padding: 15px; margin-top: 20px; margin-bottom: 20px; font-family: OpenSansItalic;">
                Savo žmoną sutikau pazintyslietuviams.co.uk. Man labai patiko, kad ši pažinčių svetainė yra patogi 

                naudoti, turi daugiau naudingų funkcijų nei kitos panašaus turinio svetainės, svarbiausia, kad turi 

                išmaniąją paieškos sistemą, kuri atrenka ir pasiūlo susipažinti su žmonėmis, gyvenančiais netoli 

                tavęs. Negalėjau patikėti, jog su Evelina gyvenome  visai šalia vienas kito, tačiau to nežinojome. 

                Pazintyslietuviams.co.uk. padėjo surasti vienas kitą, ačiū jums!!!           
              </p>
              <div class="row" style="margin-top: -10px; text-align: right;">
                <div class="col-xs-6 col-xs-offset-6" style="color: white; font-size: 16px;">Evelina ir Dima, <span style="font-size: 14px;">Londonas</span></div>
              </div>
            </div>
            <div class="col-md-6" id="s4">
              <p style="background-color: rgba(255,255,255,0.7); padding: 15px; margin-top: 20px; margin-bottom: 20px; font-family: OpenSansItalic;">
                Pazintyslietuviams.co.uk išgelbėjo mane nuo vienatvės užsienyje. Atvykusi dirbti į Angliją pasijutau 

                labai vieniša, gerai nemokėjau anglų kalbos, todėl susirasti draugų  užsieniečių, o juo labiau 

                mylimąjį atrodė neįmanoma. Paskatinta Lietuvoje likusių draugų užsiregistravau 

                pazintyslietuviams.co.uk. ir gana greitai pradėjo megztis įvairios linksmos ir draugiškos pažintys ne 

                tik Anglijoje, bet ir Airijoje. Iš pirmo žvilgsnio nieko nežadanti pažintis su Povilu, gyvenusiu 

                Dubline, buvo viena iš jų, netikėtai peraugusių į tvirtus ir laimingus mūsų santykius. Šiuo metu 

                planuojame vestuves vasarą! Dar kartą ačiū pazintyslietuviams.co.uk.
              </p>
              <div class="row" style="margin-top: -10px; text-align: right;">
                <div class="col-xs-6 col-xs-offset-6" style="color: white; font-size: 16px;">Povilas ir Lina, <span style="font-size: 14px;">Londonas</span></div>
              </div>
            </div>

          </div>

        </div>
        <a href="#" id="ui-carousel-next"><span>next</span></a>
        <a href="#" id="ui-carousel-prev"><span>prev</span></a>
        <div id="pages"></div>
      </div>


      <script type="text/javascript">
        $(function(){
          $('.wrap').css({
            'padding-bottom' : $('.footerMine').height() + 'px',
            //'padding-top' : $('.headerAtskaita').height() + 'px',
          });
          $('#copy').css({
            'padding-top' : $('.headerAtskaita').height() + 'px',
          });
          $('#original').css({
            'padding-top' : $('.headerAtskaita').height() + 'px',
          });

        }); 

        $(window).resize(function(){
          $('.wrap').css({
            'padding-bottom' : $('.footerMine').height() + 'px',
          });
          $('#copy').css({
            'padding-top' : $('.headerAtskaita').height() + 'px',
          });
          $('#original').css({
            'padding-top' : $('.headerAtskaita').height() + 'px',
          });
        });
      </script>

    <script type="text/javascript" src="/widget/lib/jquery.ui.core.js"></script>
    <script type="text/javascript" src="/widget/lib/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="/widget/lib/jquery.ui.rcarousel.js"></script>
    <script type="text/javascript">
      $('head').append('<link rel="stylesheet" type="text/css" href="/widget/css/rcarousel.css">');



      jQuery(function($) {
        function generatePages() {
          var _total, i, _link;
          
          _total = $( "#carousel" ).rcarousel( "getTotalPages" );
          
          for ( i = 0; i < _total; i++ ) {
            _link = $( "<a href='#'></a>" );
            
            $(_link)
              .bind("click", {page: i},
                function( event ) {
                  $( "#carousel" ).rcarousel( "goToPage", event.data.page );
                  event.preventDefault();
                }
              )
              .addClass( "bullet off" )
              .appendTo( "#pages" );
          }
          
          // mark first page as active
          $( "a:eq(0)", "#pages" )
            .removeClass( "off" )
            .addClass( "on" )
            .css( "background-image", "url(/css/img/page-on.png)" );

        }

        function pageLoaded( event, data ) {
          $( "a.on", "#pages" )
            .removeClass( "on" )
            .css( "background-image", "url(/css/img/page-off.png)" );

          $( "a", "#pages" )
            .eq( data.page )
            .addClass( "on" )
            .css( "background-image", "url(/css/img/page-on.png)" );
        }
        
        var s1H = $('#s1').outerHeight() + $('#s2').outerHeight(),
            s2H = $('#s3').outerHeight() + $('#s4').outerHeight(),
            wW = $(window).width();

        if(s1H > s2H){var sH = s1H}else{var sH = s2H}
    console.log(wW);
        if(wW < 520){
           var add = 200;
        }else if(wW < 975){
          var add = 100;
        }else if(wW < 1184){
          var add = -300;
        }else if(wW < 1584){
          var add = -200;
        }else{
          var add = -300;
        }


        $("#carousel").rcarousel(
          {
            visible: 1,
            step: 1,
            speed: 700,
            auto: {
              enabled: false
            },
            width: $('#container').width() - 120,
            height: sH+add,
            start: generatePages,
            pageLoaded: pageLoaded
          }
        );



        $('#ui-carousel-next').add('#ui-carousel-prev').css({height : sH});
        //$('#ui-carousel-prev').css({height : $('#slide01').height()});
        
        $( "#ui-carousel-next" )
          .add( "#ui-carousel-prev" )
          .add( ".bullet" )
          .hover(
            function() {
              $( this ).css( "opacity", 0.7 );
            },
            function() {
              $( this ).css( "opacity", 1.0 );
            }
          );
      });
    </script>


    </div>



  </div>
</div>

<div class="flat" id="flat5" style="background-color: #f8f8f8; padding: 25px; min-height: 0;">
    <center><a href="#" class="btn btn-reg" id="registruokisDabar" style="font-size: 30px; border-radius: 0; font-family: OpenSansBold;text-shadow: 1px 1px 11px rgba(150, 150, 150, 1); ">REGISTRUOKIS DABAR!</a></center>



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

