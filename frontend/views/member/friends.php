<?php

use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\widgets\ListView;

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";

if($psl == ""):

require(__DIR__ ."/../site/form/_list.php");

Yii::$app->params['close'] = 0;

$pakvietimaiAs = \frontend\models\Pakvietimai::find()->where(['sender' => Yii::$app->user->identity->id])->all();
$pakvietimaiKiti = \frontend\models\Pakvietimai::find()->where(['reciever' => Yii::$app->user->identity->id])->all();

?>

<div class="container-fluid" style="padding: 0; text-align: center;">

	<div class="col-xs-12" style="padding: 5px 9px 5px 0;">

		<div class="col-xs-8" id="col1" style="padding: 7px 20px; background-color: #e8e8e8; min-height: 158px; text-align: left;">
			<div class="row"><div class="col-xs-12">Mano draugai</div></div>
			<?php $form = ActiveForm::begin();?>
				<div class="row">
					<div class="col-xs-12">
						<?= $form->field($searchModel, 'username')->textInput(['class' => 'trans_input', 'style' => 'margin-top: 5px;', 'placeholder' => 'Ieškoti pagal vardą'])->label(false); ?>  
					</div>
				</div>
			<?php ActiveForm::end() ?>

			<div class="row" style="padding: 0 10px;">
			        <?php Pjax::begin();?>
	                    <?= ListView::widget( [
	                        'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
	                        'dataProvider' => $dataProvider,
	                        'itemView' => '//member/friends/_friends',
	                        'pager' =>[
	                            'maxButtonCount'=>0,
	                            'nextPageLabel'=>'Kitas &#9658;',
	                            'nextPageCssClass' => 'removeStuff',
	                            'prevPageLabel'=>'&#9668; Atgal',
	                            'prevPageCssClass' => 'removeStuff',
	                            'disabledPageCssClass' => 'off',
	                        ]

	                        ] ); 
	                    ?>
	                <?php Pjax::end(); ?>

				
			</div>
		</div>

		<div class="col-xs-4" id="col2" style="background-color: #d9d9d9; min-height: 158px; padding-top: 7px;">

			<div class="row">
				<div class="col-xs-6">Tavo išsiųstos užklausos</div>
				<div class="col-xs-6">Laukiantys patvirtinimo</div>
			</div>

			<div class="row">
				<div class="row-same-height row-full-height col-top" style="margin-top: 5px;">

					<div class="col-xs-6 col-xs-height col-full-height" style="border-right: 1px solid white;">
						

							<?php
								foreach($pakvietimaiAs as $kvietimas){
									$user = \frontend\models\User::find()->where(['id' => $kvietimas->reciever])->one();

									$dataInfo = \frontend\models\Info2::find()->where(['u_id' => $kvietimas->sender])->one();

				                    $d1 = new DateTime($dataInfo['diena'].'.'.$dataInfo['menuo'].'.'.$dataInfo['metai']);
				                    $d2 = new DateTime();

				                    $diff = $d2->diff($d1);

									?>

									
									<div style="margin: 8px 0;">
										<div id="holder" style="background-color: #fff; width:100%;">
											<a href="<?= Url::to(['member/user', 'id' => $user->id]); ?>">						
												<?php if($user->avatar): ?>
									               <img id="imga<?= $user->id; ?>" src="/uploads/531B<?= $user->id; ?>Iav.<?= $user->avatar; ?>" width="100%" />
									            <?php else: ?>
								                    <img id="imga<?= $user->id; ?>" src="/css/img/icons/no_avatar.png" width="100%" />
								                <?php endif;?>

								                <div class="col-xs-12" style="text-align: center; padding: 0px 2px;background-color: #fff;">
										            <span class="ProfName" style="font-size: 13px;"><?= $user->username; ?></span><br>

										            <span class="ProfInfo" style="color: #5b5b5b; font-size: 11px; position: relative; top: -3px;"><?= $diff->y; ?>, <?= ($dataInfo['miestas'] !== '')? $list[$dataInfo['miestas']] : "Nenurodyta"; ?></span>

										        </div>
							                </a>
						              	</div>

						                <a href="<?= Url::to(['member/cancelinvitation', 'id' => $user->id]); ?>" >
						                	<div style="color: white; background-color: #454545; width: 100%">
						                		<a href="<?= Url::to(['member/cancelinvitation', 'id' => $user->id]); ?>">Atšaukti</a>
						                	</div>
						                </a>
					                </div>

					                <?php
								}
							?>
					</div>

					<div class="col-xs-6 col-xs-height col-full-height col-top">

						<?php
							foreach($pakvietimaiKiti as $kvietimas){
								$user = \frontend\models\User::find()->where(['id' => $kvietimas->sender])->one();

								$dataInfo = \frontend\models\Info2::find()->where(['u_id' => $kvietimas->sender])->one();

			                    $d1 = new DateTime($dataInfo['diena'].'.'.$dataInfo['menuo'].'.'.$dataInfo['metai']);
			                    $d2 = new DateTime();

			                    $diff = $d2->diff($d1);

								?>

								<div style="margin: 8px 0;">
									<div id="holder" style="background-color: #fff; width:100%;">
										<a href="<?= Url::to(['member/user', 'id' => $user->id]); ?>">						
											<?php if($user->avatar): ?>
								               <img id="imga<?= $user->id; ?>" src="/uploads/531B<?= $user->id; ?>Iav.<?= $user->avatar; ?>" width="100%" />
								            <?php else: ?>
							                    <img id="imga<?= $user->id; ?>" src="/css/img/icons/no_avatar.png" width="100%" />
							                <?php endif;?>

							               	<div class="col-xs-12" style="text-align: center; padding: 0px 2px;background-color: #fff;">
									            <span class="ProfName" style="font-size: 13px;"><?= $user->username; ?></span><br>

									            <span class="ProfInfo" style="color: #5b5b5b; font-size: 11px; position: relative; top: -3px;"><?= $diff->y; ?>, <?= ($dataInfo['miestas'] !== '')? $list[$dataInfo['miestas']] : "Nenurodyta"; ?></span>

									        </div>
						                </a>
					                </div>

					                <div>
					                	<a href="<?= Url::to(['member/acceptinvitation', 'id' => $user->id]); ?>" class="w-border glyphicon glyphicon-ok"></a>
					                	<a href="<?= Url::to(['member/declineinvitation', 'id' => $user->id]); ?>" class="w-border glyphicon glyphicon-remove"></a>
					                </div>

				                </div>

				                <?php
							}
						?>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(function(){
		var col1 = $('#col1').outerHeight(),
			col2 = $('#col2').outerHeight();

		if(col1 > col2){
			$('#col2').css({'height' : col1});
		}else{
			$('#col1').css({'height' : col2});
		}
	});
</script>

<?php else: ?>
	<div class="container-fluid" style="padding: 0 0 0 0; margin-top: 5px; text-align: center;">

		<div class="col-xs-12" style="padding: 7px 0px;background-color: #e8e8e8; ">
			<?= $this->render('friends/news', ['dataProvider' => $dataProvider2]); ?>
		</div>

	</div>
<?php endif; ?>