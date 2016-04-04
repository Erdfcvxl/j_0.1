<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\UploadForm2;


//$UploadForm = new UploadForm2;

if($user->avatar != ""){
	$avatar = "/uploads/531B".$user->id."Iav.".$user->avatar;
}else{
	$avatar = null;
}

?>

<div class="row">
  <div class="col-xs-4">
  	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
  		<?= $form->field($UploadForm, 'file', ['template' => '{input}<div class="new_er">{error}</div>'])->fileInput()->label(false);   ?>

      <?php if(\frontend\models\Expired::prevent()): ?>
        <?= $this->registerJsFile('js/preventDefault'); ?>
      <?php else: ?>
    		<?= Html::submitButton('Keisti', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 14px; padding: 0 20px 0 20px; margin-top:25px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7); border-radius: 0;']) ?>
    	 <?php endif; ?>

    <?php ActiveForm::end() ?>
  </div>

  <div class="col-xs-8 upload_bg">
  	<div class="img_container" id="imgCont">
          <div id="no_av_place" style="overflow: hidden; position: relative; width: 160px; height:160px;">
              <img id="avatarOld" style="position: relative;" src="<?= ($avatar)? $avatar : "/css/img/icons/no_avatar.png" ?>"/>
              <img id="avatar" style="position: relative; display: hidden;"/>
          </div>
    </div>
  </div>
</div>


<div class="row" style="margin-top: 15px;">
  <div class="col-xs-12">
    <?php if(\frontend\models\Expired::prevent()): ?>
      <div class="alert alert-warning">
        <b>Jūsų abonimento galiojimas baigėsi.</b>
        <br>
        Atsakyti gali tik tie nariai, kurių abonimentas yra galiojantis.
      </div>

    <?php endif; ?>
  </div>
</div>



<script type="text/javascript" src="/js/centerInBox.js"></script>

<script type="text/javascript">

	  $('#avatarOld').load(function(){
	  	centerInBox($('#no_av_place').width(), $('#no_av_place').height(), $('#avatarOld').width(), $('#avatarOld').height(), '#avatarOld');
	  });

      $(function (){
        $('.upload_bg input').css({"width" : $('.upload_bg').width() + "px"});
        $('.new_er').css({"width" : $('#atstaskas').width() + "px"});
      });
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              
              reader.onload = function (e) {
                
                var filename = $("#uploadform2-file").val();
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
                      $('#avatarOld').css({"display" : "none"});

                  });
                }
              }



              
              reader.readAsDataURL(input.files[0]);
          }
      }
      
      $("#uploadform2-file").change(function(){
          readURL(this);
      });
</script>