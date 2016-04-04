<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

?>



<?php Pjax::begin();?>
<div class="apmokejimoBox" style="">
	<a href="<?= Url::canonical(); ?>"><div class="glyphicon glyphicon-remove" style="position: absolute; top: 5px; right: 5px; font-size: 20px;"></div></a>
    <div style="position: absolute; z-index: -1; width: 100%; height: 100px; left: 0; top :0; background-color: white;"></div>
    <div style="position: absolute; z-index: -1; width: 100%; height: 150px; left: 0; top :100px; background-image: url('/css/img/fade_vertical_white.png'); background-size: 100% 100%; "></div>
    <h3><center><span style="color: #56adfa; text-shadow: 2px 2px 2px #c5c5c5;">PASIRINK TAVE DOMINANTĮ PLANĄ</span></center></h3>

    <div class="container-fluid">
    	<div class="row" style="color: #393939;"><!--
    		--><div class="col-xs-3 vcenter  <?= (isset($_GET['obj']) && $_GET['obj'] == 1)? 'activePlanas' : ''; ?>" style="margin-left: 6px;">
    			<a href="<?= Url::current(['obj' => 1]); ?>">
    				<div class="topPart"><b>4 sav.</b> <strike style="color: #fe0000">10£</strike></div>
    				<div class="lowerPart">7 £<?= (isset($_GET['obj']) && $_GET['obj'] == 1)? '<br><img src="/css/img/icons/tick.jpg" />' : ''; ?></div>
    			</a>
    		</div><!--
    		--><div class="col-xs-3 vcenter  <?= (isset($_GET['obj']) && $_GET['obj'] == 2)? 'activePlanas' : ''; ?>">
    			<a href="<?= Url::current(['obj' => 2]); ?>">
    				<div class="topPart"><b>12 sav.</b> <strike style="color: #fe0000">19£</strike></div>
    				<div class="lowerPart">14 £<?= (isset($_GET['obj']) && $_GET['obj'] == 2)? '<br><img src="/css/img/icons/tick.jpg" />' : ''; ?></div>
    			</a>
    		</div><!--
    		--><div class="col-xs-3 vcenter  <?= (isset($_GET['obj']) && $_GET['obj'] == 3)? 'activePlanas' : ''; ?>">
    			<a href="<?= Url::current(['obj' => 3]); ?>">
    				<div class="topPart"><b>24 sav.</b> <strike style="color: #fe0000">27£</strike></div>
    				<div class="lowerPart">21 £ <?= (isset($_GET['obj']) && $_GET['obj'] == 3)? '<br><img src="/css/img/icons/tick.jpg" />' : ''; ?></div>
    			</a>
    		</div><!--
    		--><div class="col-xs-3 vcenter  <?= (isset($_GET['obj']) && $_GET['obj'] == 4)? 'activePlanas' : ''; ?>">
    			<a href="<?= Url::current(['obj' => 4]); ?>">
    				<div class="topPart"><b>48 sav.</b> <strike style="color: #fe0000">38£</strike></div>
    				<div class="lowerPart">29 £<?= (isset($_GET['obj']) && $_GET['obj'] == 4)? '<br><img src="/css/img/icons/tick.jpg" />' : ''; ?></div>
    			</a>
    		</div>
    	</div>

    	<div class="row" style="margin-top: 15px;">
    		    <h3><center><span style="color: #56adfa; text-shadow: 2px 2px 2px #c5c5c5;">PASIRINK MOKĖJIMO BŪDĄ</span></center></h3>
    	</div>

    	<div class="row" style="margin-top: 15px;">
			<!-- <div class="col-xs-2 col-xs-offset-3"><a class="btn btn-success disabled">SMS</a></div> -->
			<div class="col-xs-12" id="paypal" style="text-align: center;"><a class="btn btn-success disabled">PayPal</a></div>
			<!-- <div class="col-xs-2"><a class="btn btn-success disabled">Kortele</a></div> -->
		</div>
    </div>

    <!-- <div class="listBox" style="bottom: -63px; width: 600px; margin-left: -300px; padding-top: 15px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12" id="result" style="text-align: center;"><img src="/css/img/loader.gif" width="35px" id="loader" style="display: none;" /></div>
            </div>
        </div>
    </div> -->
</div>


<script type="text/javascript">

function paypal(){

	var obj = <?= (isset($_GET["obj"]))? $_GET["obj"] : ""; ?>;
	
	$.ajax({
	    type: "GET",
	    url: "<?= Url::to(['member/getppapplink']); ?>",
	    data: {'obj' : obj},
	    dataType: 'html',
	    success: function(data){

	    	$('#paypal').html("<a class='btn btn-success' href='"+data+"'>PayPal</a>");
            $('#paypal').css({"display" : "inline-block"});

	    },
	    error:function(ts){
	    	console.log(ts.responseText);
	    },
	    complete: function (data) {

	    }

	});
}

$(function(){
    paypal();
});
</script>

<?php Pjax::end(); ?>
