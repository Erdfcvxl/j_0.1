<?php
use yii\helpers\Html;
use frontend\models\User;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->registerCssFile('css/events.css');

$p = (isset($_GET['p']))? $_GET['p'] : 0;

$provider = new ActiveDataProvider([
    'query' => User::find()
    				->orderBy('lastOnline')
    				->where(['not', ['id' => Yii::$app->user->id]])
    				->andWhere(['like', 'username', (isset($_GET['u']))? $_GET['u'] : '']),
    'pagination' => [
        'pageSize' => 12,
        'page' => $p,
    ],
]);


$maxPage = floor($provider->totalCount / 12);
?>

<div class="aboveFade">
	<div class="container">
		<div class="row" style="">
			<div class="col-xs-12">
				<h1>
					Pasirink atvirutę 
					<!-- <div class="btn btn-regPlus">Daugiau atviručių</div> -->
				</h1>
				<?= $this->render('//includes/xas', ['right' => 15, 'left' => 15, 'size' => 20]); ?>

				<div class="row" id="atvirutes">
					<div class="col-xs-3">
						<div class="Epick" id="1">
							<img src="/css/img/dovanos/kaledos/1.jpg" name="1" width="100%">
						</div>		
					</div>
					<div class="col-xs-3">
						<div class="Epick" id="2">
							<img src="/css/img/dovanos/kaledos/2.jpg" name="2" width="100%">
						</div>	
					</div>
					<div class="col-xs-3">
						<div class="Epick active" id="3">
							<img src="/css/img/dovanos/kaledos/3.jpg" name="3" width="100%">
							<input id="msg" class="zinute" name="msg" placeholder="Žinutė">
						</div>	
					</div>
					<div class="col-xs-3">
						<div class="Epick" id="4">
							<img src="/css/img/dovanos/kaledos/2.jpg" name="2" width="100%">
						</div>	
					</div>
				</div>

			</div>
		</div>

		<br>
		<br>

		<?php Pjax::begin(); ?>
		<?php $url = Url::canonical(); ?>
		<a id="link" href="<?= $url; ?>"></a>

		<div class="row">
			<div class="col-xs-12 users">
				<div class="row">
					<div class="arnav"><?php if($p > 0): ?><a href="<?= Url::current(['p' => $p-1]); ?>"><?php endif; ?><span style="font-size: 28px;">&#8249;</span><?php if($p > 0): ?></a><?php endif; ?></div>
					<div style="display: inline-block;">
						<?php foreach ($provider->models as $model): ?>
							<?php 
								$avatar = ($model->avatar)? 'uploads/531B'.$model->id.'Iav.'.$model->avatar : 'css/img/icons/no_avatar.png';
							?>
							<div class="col-xs-1 aHolder">
								<img id="<?= $model->id; ?>" class="Eavatar" name="<?= $model->username ?>" src="<?= $avatar; ?>">
							</div>

						<?php endforeach; ?>
					</div>
					<div class="arnav" style="left: 0px;"><?php if($p < $maxPage-1): ?><a href="<?= Url::current(['p' => $p+1]); ?>"><?php endif; ?><span style="font-size: 28px;">&#8250;</span><?php if($p < $maxPage-1): ?></a><?php endif; ?></div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
				$('.Eavatar').fakecrop({wrapperWidth: 940/12,wrapperHeight: 940/12});
		</script>

		<br>

		<div class="addon">Kam:</div>
		<input type="text" name="name" id="name" class="input" value="<?= (isset($_GET['u']))? $_GET['u'] : ''; ?>">

		<br>
		<br>

		<a id="submit" class="btn btn-regRound disabled">Siųsti</a>

		<br>

		<div class="kaina">10<span class="glyphicon glyphicon-heart" style="color: #bd0c0c"></span></div>

		<script type="text/javascript">
			

			$('#submit').click(function(){
				console.log('aa');

				var user = $(this).attr('name'),
					msg = $('#msg').val(),
					img = active.children('img').attr('name'),
					path = 'css/img/dovanos/kaledos';

				if(user){
					$.ajax({
						type: "POST",
						dataType: "/json",
						data : {'user' : user, 'msg' : msg, 'img' : img, 'path' : path, 'cost' : 10},
						url: "<?= Url::to(['member/umipc']); ?>",
						success: function(data){
							var liko = $('#valiuta').html() - 10;
							$('#valiuta').html(liko);

							$('#done').fadeIn();
							setTimeout(function(){
								$('#done').fadeOut();
							}, 5000);

							console.log('success');
							console.log(data);
						},
						error: function(ts){
							$('#fail').fadeIn();
							setTimeout(function(){
								$('#fail').fadeOut();
							}, 5000);

							console.log('error');
							console.log(ts.responseText);
						}
					});
				}
			});
		</script>

		<?php Pjax::end(); ?>

		<div class="alert alert-success" id="done">Dovana sėkmingai išsiųsta!</div>
		<div class="alert alert-danger" id="fail">Jums nepakanka kreditų</div>

		<script type="text/javascript">
			$('#name').on('input', function() {
				var get = "<?= $url; ?>&eventpresent=1&u="+$('#name').val();

				clearTimeout(timer);
				timer = setTimeout(function(){
					$('#name').blur();
					$("#link").attr('href', get);
					$("#link").click();
				}, 500);
			});

			$('.Eavatar').click(function(){
				$('#submit').attr('name', $(this).attr('id'));
				$('#submit').removeClass('disabled');
				$('#submit').html('Siųsti <b>'+$(this).attr('name')+'<b>');
			});

			function focusCampo(id){
			    var inputField = document.getElementById(id);
			    if (inputField != null && inputField.value.length != 0){
			        if (inputField.createTextRange){
			            var FieldRange = inputField.createTextRange();
			            FieldRange.moveStart('character',inputField.value.length);
			            FieldRange.collapse();
			            FieldRange.select();
			        }else if (inputField.selectionStart || inputField.selectionStart == '0') {
			            var elemLen = inputField.value.length;
			            inputField.selectionStart = elemLen;
			            inputField.selectionEnd = elemLen;
			            inputField.focus();
			        }
			    }else{
			        inputField.focus();
			    }
			}

			var timer = setTimeout(function(){

			}, 500);

			focusCampo('name');
		</script>

		<?php $form = ActiveForm::begin();?>
			<div class="row apatinisBox" style="border-color: #94c500;">
				<div class="col-xs-8 vcenter" style="margin-top: -7px; color: #000; font-size: 18px; font-family: OpenSans;">
				 	<i>Už dovanas atsiskaityk meilės valiuta -</i> 
				 	<span style="color:#9dd624">
				 		<span class="glyphicon glyphicon-heart" style="font-size: 25px; position: relative; top: 7px; "></span>
				 		<small><b>(liko <span id="valiuta"><?= $user->valiuta ?></span>)</b></small>

				 	</span>
				</div>

				<div class="col-xs-3 vcenter" style="position: relative; left: -15px;  text-align: left; font-size:10px; color: #000;">
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
</div>

<script type="text/javascript">
	var active = $('#3');




	$('.Epick img').click(function(){
		var el = $(this).parent('.Epick');
		active.removeClass('active');
		$(active).children('input').appendTo(el);
		el.addClass('active');
		active = el;
	});

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
