<?php

use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

?>

<?php if(isset($design) && $design == "full"): 

	$psl = (isset($_GET['psl']))? $_GET['psl'] : "";

	if($psl == "draugu"){
	    echo $this->render('favourites/draugu.php', ['dataProvider' => $dataProvider]); 
	}else{
		echo $this->render('favourites/index.php', ['dataProvider' => $dataProvider]);
	}

else: ?>

	<div class="container-fluid" style="text-align: center; padding-left: 0;">

		<div class="col-xs-12" style="padding: 7px 0px;background-color: #e8e8e8; ">

			<?php if(Yii::$app->session->getFlash('error')): ?>
				<div class="row" style="margin: 0 5px 1px 5px" >
					<div class="col-xs-12"> 
						<div class="alert alert-warning" style="margin: 0; padding: 10px 30px; text-align: left;"><?= Yii::$app->session->getFlash('error'); ?></div>
					</div>
				</div>
			<?php endif; ?>

			<?php
				$psl = (isset($_GET['psl']))? $_GET['psl'] : "";

				if($psl == "draugu"){
				    echo $this->render('favourites/draugu.php', ['dataProvider' => $dataProvider]); 
				}else{
					echo $this->render('favourites/index.php', ['dataProvider' => $dataProvider]);
				}
			?>
		</div>

	</div>
	
<?php endif; ?>
