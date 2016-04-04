<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Url;

$user = \frontend\models\User::find()->where(['id' => Yii::$app->user->id])->one();

?>

<div class="box">
	<a href="<?= Url::to(Yii::$app->request->referrer, true) ?>" id="xas" style="position: absolute; right: 1px; top: -30px; color: #b7b7b7; cursor: pointer; font-size: 20px;" class="glyphicon glyphicon-remove"></a>

	<div class="row">
		<div class="col-xs-3 vcenter">
			<img src="/css/img/icons/debeselis.png">
			<h3>Padovanok 5 nuotraukos vietas</h3>
			<a class="btn-dovanoti" style="cursor: pointer" id="talpa">Dovanoti</a><br>
			<span style="color:#9dd624;">30<span class="glyphicon glyphicon-heart" style="font-size: 25px; position: relative; top: 7px;"></span></span>
		</div>

		<div class="col-xs-6 vcenter">
			<div class="row">
				<div class="col-xs-3"><img src="/css/img/dovanos/dPav_10.jpg" class="pav" id="10" style="cursor: pointer"></div>
				<div class="col-xs-3"><img src="/css/img/dovanos/dPav_9.jpg" class="pav" id="9" style="cursor: pointer"></div>
				<div class="col-xs-3"><img src="/css/img/dovanos/dPav_8.jpg" class="pav" id="8" style="cursor: pointer"></div>
				<div class="col-xs-3"><img src="/css/img/dovanos/dPav_7.jpg" class="pav" id="7" style="cursor: pointer"></div>
			</div>
			<div class="row" style="margin-top: 10px;">
				<div class="col-xs-3"><img src="/css/img/dovanos/dPav_1.jpg" class="pav" id="1" style="cursor: pointer"></div>
				<div class="col-xs-6">
					<h3 style="margin-top:5px;">Išsirink atvirutę</h3>
					<a class="btn-dovanoti" id="submit_pav" style="cursor: pointer">Dovanoti</a><br>
					<span style="color:#9dd624;">10<span class="glyphicon glyphicon-heart" style="font-size: 25px; position: relative; top: 7px;"></span></span>
				</div>
				<div class="col-xs-3"><img src="/css/img/dovanos/dPav_6.jpg" class="pav" id="6" style="cursor: pointer"></div>
			</div>
			<div class="row" style="margin-top: 10px;">
				<div class="col-xs-3"><img src="/css/img/dovanos/dPav_2.jpg" class="pav" id="2" style="cursor: pointer"></div>
				<div class="col-xs-3"><img src="/css/img/dovanos/dPav_3.jpg" class="pav" id="3" style="cursor: pointer"></div>
				<div class="col-xs-3"><img src="/css/img/dovanos/dPav_4.jpg" class="pav" id="4" style="cursor: pointer"></div>
				<div class="col-xs-3"><img src="/css/img/dovanos/dPav_5.jpg" class="pav" id="5" style="cursor: pointer"></div>
			</div>
		</div>

		<div class="col-xs-3 vcenter">
			<img src="/css/img/icons/dovanele.png">
			<h3>Padovanok 1 mėnesio abonementą</h3>
			<a class="btn-dovanoti" style="cursor: pointer" id="abonimentas">Dovanoti</a><br>
			<span style="color:#9dd624;">100<span class="glyphicon glyphicon-heart" style="font-size: 25px; position: relative; top: 7px;"></span></span>
		</div>
	</div>

	<div class="row" style="color: #A94442; margin-top: 15px;">
		<div class="col-xs-12" id="erbox">

		</div>
	</div>

<?php $form = ActiveForm::begin();?>
	<div class="row apatinisBox">
		<div class="col-xs-6 col-xs-offset-3 vcenter" style="margin-top: -7px;">
		 	<i>Už dovanas atsiskaityk meilės valiuta -</i> 
		 	<span style="color:#9dd624">
		 		<span class="glyphicon glyphicon-heart" style="font-size: 25px; position: relative; top: 7px;"></span>
		 		<small><b>(liko <span id="valiuta"><?= $user->valiuta ?></span>)</b></small>

		 	</span>
		</div>

		<div class="col-xs-3 vcenter" style="position: relative; left: -15px;  text-align: left; font-size:10px;">
			<div class="row">
					<div class="col-xs-6 vcenter" style="padding-right: 0">
						
						<div class="row">
							<div class="col-xs-1" style="padding: 0;"><input type="radio" name="amout" value="200" price="15"></div>
							<div class="col-xs-11" style="padding: 0; margin-top: 3px;">&nbsp&nbsp200<span class="glyphicon glyphicon-heart"></span> - 15 svarų</div>
						</div>

						<div class="row">
							<div class="col-xs-1" style="padding: 0;"><input type="radio" name="amout" value="130" price="10"></div>
							<div class="col-xs-11" style="padding: 0; margin-top: 3px;">&nbsp&nbsp130<span class="glyphicon glyphicon-heart"></span> - 10 svarų</div>
						</div>

						<div class="row">
							<div class="col-xs-1" style="padding: 0;"><input type="radio" name="amout" value="60" price="5"></div>
							<div class="col-xs-11" style="padding: 0; margin-top: 3px;">&nbsp&nbsp60<span class="glyphicon glyphicon-heart"></span> - 5 svarų</div>
						</div>

						<div class="row">
							<div class="col-xs-1" style="padding: 0;"><input type="radio" name="amout" value="30" price="3"></div>
							<div class="col-xs-11" style="padding: 0; margin-top: 3px;">&nbsp&nbsp30<span class="glyphicon glyphicon-heart"></span> - 3 svarų</div>
						</div>
									
					</div>


					<div class="col-xs-6 vcenter" style="padding-left: 0">
						<a class="btn btn-reg disabled" style="font-size: 14px; padding: 1px 10px; border-radius: 0; margin-top: 15px;" id="submitBuy">Prikti širdeles</a>
					</div>

					
			</div>
		</div>
		

		
	</div>
<?php ActiveForm::end() ?>

</div>

<script type="text/javascript">
	$(function(){

		$('input:radio').change(
		    function(){
		    	var amount = $(this).attr("value"),
		    		price = $(this).attr("price");

		    	$.ajax({
					type: "post",
				    url: "<?= Url::to(['member/getppapplinksirdeles']) ?>",
				    data: {'amount' : amount, 'price' : price},
				    dataType: 'json',
				    success: function(data){
				    	$('#submitBuy').removeClass('disabled');
				    	$('#submitBuy').addClass('active');
				    	$('#submitBuy').attr("href", data);
				    },
					error:function(ts){
						console.log(ts);
				    	$('.box').append(ts.responseText);
				    },
				})
		    }
		);          

	});
</script>


<div id="myAlert" class="myAlert" style="z-index: 100; margin-top: -250px;">
	<div class="container-fluid" >

		<div id="xas" style="position: absolute; right: 1px; top: 1px; color: #A8A8A8; cursor: pointer;" class="glyphicon glyphicon-remove"></div>


		<div class="row" style="margin-bottom: 15px;">

			<div class="col-xs-12">
				<b>Ar tikrai norite dovanoti dovaną?</b>
			</div>

		</div>

		<div class="row">
			<div class="col-xs-3 col-xs-offset-2 mygtukas" id="confirm" style="cursor: pointer;">Taip</div>
			<div class="col-xs-3 col-xs-offset-2 mygtukas" id="decline" style="cursor: pointer;">Ne</div>
		</div>

	</div>
</div>



<script type="text/javascript">
	var pav = 0,
		lastpav = 0,
		lastItem = '';

	$('.pav').click(function(){
		lastpav = pav;
		pav = this.id;

		$('.glow#'+lastpav).removeClass( "glow" );
		$(this).addClass( "glow" );

	});

	$('#talpa').click(function(){
		lastItem = 'talpa';
		$('#myAlert').fadeIn();
	});

	$('#submit_pav').click(function(){
		lastItem = 'pav';
		$('#myAlert').fadeIn();
	});

	$('#abonimentas').click(function(){
		lastItem = 'aboni';
		$('#myAlert').fadeIn();
	});


	/////////////////Paveiksliukai/////////////////

	$('#confirm').click(function(){
		$('#myAlert').fadeOut();

		if(lastItem == "pav"){
			if(pav){
				$('#erbox').text('');

				$.ajax({
					type: "post",
				    url: "<?= Url::to(['member/checkdovana', 'object' => 'pav']) ?>",
				    data: {id : '<?= $_GET["id"]; ?>', object_id : pav},
				    dataType: 'json',
				    success: function(data){
				    	if(data['er'] == 1){
				    		$('#erbox').text(data['msg']);
				    	}else{
				    		$('#erbox').html("<span style='color: #3C763D'>"+data['msg']+"</span>");
				    		var pinigai = $('#valiuta').html();

				    		$('#valiuta').html(pinigai - data['kaina']);
				    	}
				    	
				    },
					error:function(ts){
						console.log(ts.responseText);
				    	$('.box').append(ts);
				    },
				})
			}else{
				$('#erbox').text('Jūs neišsirinkote atvirutės');
			}
		}else if(lastItem == "talpa"){
			$('#erbox').text('');

				$.ajax({
					type: "post",
				    url: "<?= Url::to(['member/checktalpa', 'object' => 'talpa']) ?>",
				    data: {id : '<?= $_GET["id"]; ?>'},
				    dataType: 'json',
				    success: function(data){
				    	if(data['er'] == 1){
				    		$('#erbox').text(data['msg']);
				    	}else{
				    		$('#erbox').html("<span style='color: #3C763D'>"+data['msg']+"</span>");
				    		var pinigai = $('#valiuta').html();

				    		$('#valiuta').html(pinigai - data['kaina']);
				    	}
				    	
				    },
					error:function(ts){
						console.log(ts.responseText);
				    	$('.box').append(ts);
				    	$('#erbox').text('Įvyko klaida');
				    },
				});
		}else if(lastItem == "aboni"){
			$('#erbox').text('');

				$.ajax({
					type: "post",
				    url: "<?= Url::to(['member/checkaboni', 'object' => 'aboni']) ?>",
				    data: {id : '<?= $_GET["id"]; ?>'},
				    dataType: 'json',
				    success: function(data){
				    	if(data['er'] == 1){
				    		$('#erbox').text(data['msg']);
				    	}else{
				    		$('#erbox').html("<span style='color: #3C763D'>"+data['msg']+"</span>");
				    		var pinigai = $('#valiuta').html();

				    		$('#valiuta').html(pinigai - data['kaina']);
				    	}
				    	
				    },
					error:function(ts){
						console.log(ts.responseText);
				    	$('.box').append(ts);
				    	$('#erbox').text('Įvyko klaida');
				    },
				});
		}
	});
	////////////////////////////////



	$('#decline').click(function(){
		$('#myAlert').fadeOut();
	});

	$('#xas').click(function(){
		$('#myAlert').fadeOut();
	});



	console.log(pav);
</script>
