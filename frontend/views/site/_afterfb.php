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

$heading = "Truputi apie tave"; $sub_txt = "";


?>

<div class="profile_reg" style="min-height: 300px;">
  <div class="title_zone" style="height: 50px;">

    <div class="row" style="position: relative;">
      <div class="reg_description">
        <h2 style="margin-top: 7px;">
          <?= $heading; ?>
        </h2> 
        <br>
        <span class="reg_detailed_desc" style=" ">
          <?= $sub_txt; ?>
        </span>
      </div>
    </div>
  </div>

  <?php 
  ?>

  <?php $form = ActiveForm::begin();?>

	  <div class="input_zone" style="height: auto; min-height: 230px;">

	  	    <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
		        <div class="row">
		          	<div class="col-xs-4 vcenter top2">Jūs esate</div>
		          	<div class="col-xs-8 vcenter top2"><?= $form->field($modelInfo, 'iesko')->dropDownList(['vm' => 'Vyras ieškantis moters', 'mv' => 'Moteris ieškanti vyro' , 'vv' => 'Vyras ieškantis vyro' , 'mm' => 'Moteris ieškanti moters' ],['class' => 'reg_dropbox', 'style' => 'padding-left: 5px;'])->label(false); ?></div>
		        </div>
		    </div>
		    <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
		        <div class="row">
		          	<div class="col-xs-4 vcenter top2">Jūsų slapyvardis</div>
		          	<div class="col-xs-8 vcenter top2"><?= $form->field($user, 'username')->textInput()->label(false); ?></div>
		        </div>
		    </div>
		    <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
		        <div class="row">
		          	<div class="col-xs-4 vcenter top2">Jūsų el.paštas</div>
		          	<div class="col-xs-8 vcenter top2"><?= $form->field($user, 'email')->textInput()->label(false); ?></div>
		        </div>
		    </div>
		    <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
		        <div class="row" style="margin-top: 0px;">
		          	<div class="col-xs-12 vcenter top2">Registruodamėsi jūs sutinkate su <a href="<?= Url::to(['site/terms']);?>">taisyklėmis</a> ir patvirtinatė kad jums yra 18 metų</div>
				</div>
				<div class="row">
					<div class="col-xs-12 vcenter top2" style="text-align: center;">
						<input type="checkbox" id="c1" name="rules" /><label for="c1" style="font-family: OpenSans; cursor: pointer;font-weight: normal;"><span></span>Sutinku ir patvirtinu</label>
		        	</div>
		        </div>
		        <div class="row">
					<div class="col-xs-12 vcenter top2" style="text-align: center; font-family: OpenSansLight; color: #A94442; margin-top: -15px;">
						<?php if(Yii::$app->session->hasFlash('error')): ?>
							<small><?= Yii::$app->session->getFlash('error'); ?></small>
						<?php endif; ?>
					</div>
				</div>
		    </div>
	   </div>

		<div class="bottom_zone">
	  		<?= Html::submitButton('Kitas', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 30px; padding: 0 130px 0 130px; margin-top:25px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7);']) ?>
		</div>

    <?php ActiveForm::end() ?>
</div>
  
