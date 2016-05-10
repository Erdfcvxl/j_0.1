<?php
use yii\helpers\Url;
?>

<div class="boxInside container" style="width: 600px; left: 50%; margin-left: -300px; padding: 0 15px; margin-top : 150px;">
	<a href="<?= Url::to(Url::to(['member/myfoto']), true) ?>" id="xas" style="position: absolute; right: 1px; top: -30px; color: #b7b7b7; cursor: pointer; font-size: 20px;" class="glyphicon glyphicon-remove"></a>

	<div class="row">
		<div class="col-xs-12" style="padding-top: 10px; padding-bottom: 10px; background-color: white;">
			Į svėtainę įkelti nemokamai galima 5 nuotraukas. <Br>
			Norint įkelti daugiau nuotraukų, reikia užsisakyti papildomą nuotraukų įkėlimo paslaugą
		</div>
	</div>

	<div class="row" style="padding-top: 10px; padding-bottom: 10px;background-color: rgba(225,225,225, 0.7);">
		<div class="col-xs-12">
			<div class="row">
					<div class="col-xs-12" style="margin-top: 2px;"><b>5 nuotraukų - 3&#8364;</b>
				</div>				
			</div>
			<!--<div class="row">
				<div class="col-xs-1 col-xs-offset-4"  style="text-align: right; padding-right: 0;">
					<input type="radio" name="amount" value="10" price="2">
				</div>
					<div class="col-xs-6" style="margin-top: 2px;"><b>10 nuotraukų - 2&#8364;</b>
				</div>		
			</div>
			<div class="row">
				<div class="col-xs-1 col-xs-offset-4"  style="text-align: right; padding-right: 0;">
					<input type="radio" name="amount" value="20" price="3">
				</div>
					<div class="col-xs-6" style="margin-top: 2px;"><b>20 nuotraukų - 3&#8364;</b>
				</div>		
			</div>
			<div class="row">
				<div class="col-xs-1 col-xs-offset-4"  style="text-align: right; padding-right: 0;">
					<input type="radio" name="amount" value="50" price="5">
				</div>
					<div class="col-xs-6" style="margin-top: 2px;"><b>50 nuotraukų - 5&#8364;</b>
				</div>		
			</div>-->

		</div>
	</div>

	<div class="row">
		<div class="col-xs-12"style="padding-top: 5px; padding-bottom: 5px;px;">
			<a class="btn btn-reg disabled" id="submitBuy" style="padding: 1px 10px; margin-bottom: 0;">Luktelkite...</a>
		</div>
	</div>

</div>

<script type="text/javascript">
	$(function(){
    	var amount = 5,
    		price = 3;

    	$.ajax({
			type: "post",
		    url: "<?= Url::to(['member/getppapplinknuotraukos']) ?>",
		    data: {'amount' : amount, 'price' : price},
		    dataType: 'json',
		    success: function(data){
		    	$('#submitBuy').removeClass('disabled');
		    	$('#submitBuy').addClass('active');
		    	$('#submitBuy').attr("href", data);
				$('#submitBuy').text("Įsigyti");
		    },
			error:function(ts){
				console.log(ts);
		    	$('.boxInside').append(ts.responseText);
		    },
		});  
	});
</script>
