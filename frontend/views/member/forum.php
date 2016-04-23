<?php

use frontend\models\Forum;
use frontend\models\Post;
use frontend\models\User;
use frontend\models\CheckedForums;
use yii\helpers\Url;

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
$sections = Forum::getSections($psl);

$colors = ['#e1f1d7', '#d1f1ee'];

?>

<div class="container-fluid" style="background-color: #e8e8e8; text-align: left; padding-top: 5px;">
	<div class="row">
		<div class="col-xs-8"><h4>Forumas</h4></div>
		<div class="col-xs-4" style="text-align: right; padding-top: 3px;">
			<?php if(!\frontend\models\Expired::prevent()): ?>
				<a href="<?= Url::to(['member/forumnew']) ?>" class="btn btn-success">Sukurti</a>		
			<?php endif; ?>
		</div>
	</div>

	<?php if(\frontend\models\Expired::prevent()): ?>
		<div class="row">
			<div class="col-xs-12">
				<div class="alert alert-warning">
	                <b>Jūsų abonimento galiojimas baigėsi.</b>
	                <br>
	                Kurti naujus forumus gali tik tie nariai, kurių abonimentas yra galiojantis.
	            </div>
			</div>
		</div>
	<?php endif; ?>
	
	<div class="row" style=" margin-bottom: 20px;">
		<div class="col-xs-6">
			<?php
				foreach ($sections['left'] as $forum) {
					if($user = User::find()->where(['id' => $forum->u_id])->one()){

						if($user->avatar){
							$avataras = "/uploads/531B".$user->id."Iav.".$user->avatar;
						}else{
							$avataras = "/css/img/icons/no_avatar.png";
						}

						$post = Post::find()->where(['forum_id' => $forum->id])->all();

						$color = $colors[rand(0, 1)];

						?>
							<a href="<?= Url::to(['member/post', 'id' => $forum->id, 'color' => $color]); ?>">
								<div class="row">
									<div class="col-xs-12">
										<div class="forum_box container-fluid" style="background-color: <?= $color ?>;">
											<div class="row" style="margin: 5px -10px;">
												<div class="col-xs-3" style="padding: 0 5px 0 0;"><img width="100%" src="<?= $avataras; ?>"></div>
												<div class="col-xs-9 forum_name"><?= $forum->name; ?></div>
											</div>
											<div class="row" style="margin: 5px 0 0;  position: relative;">
												<div class="col-xs-6 col-xs-offset-3" style="font-size: 10px; padding: 0;">
													Atsakymų: <?= count($post); ?>&nbsp &nbsp &nbsp
													Peržiūrų: <?= $forum->views; ?>
												</div>
												<div class="col-xs-3" style="padding-right: 0;">
													<?php if(!CheckedForums::isChecked($forum->id)): ?>
														<a href="<?= Url::to(['member/check', 'id' => $forum->id]); ?>" title="Pridėti prie mėgstamiausių">
															<img src="/css/img/icons/sirdele_black.png" height="15px" style="position: absolute; top: -3px; left: 21px;">
															<div class="btn btn-reg btn-reg-new boxShadow" style="position: absolute; font-size:10px; padding: 0 4px; top: -4px; margin: 0; right: -17px;">Pažymėti</div>
														</a>
													<?php else: ?>
														<a href="<?= Url::to(['member/uncheck', 'id' => $forum->id]); ?>"  title="Ištrinti iš mėgstamiausių">
															<img src="/css/img/icons/baltas_sirdele.png" height="15px" style="position: absolute; top: -3px; left: 21px;">
															<div class="btn btn-reg btn-reg-new boxShadow" style="position: absolute; font-size:10px; padding: 0 4px; top: -4px; margin: 0; right: -17px;">Nužymėti</div>
														</a>
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						<?php
					}
				}
			?>
		</div>
		<div class="col-xs-6" style="padding-left: 0;">
			<?php
				foreach ($sections['right'] as $forum) {
					if($user = User::find()->where(['id' => $forum->u_id])->one()) {

						if ($user->avatar) {
							$avataras = "/uploads/531B" . $user->id . "Iav." . $user->avatar;
						} else {
							$avataras = "/css/img/icons/no_avatar.png";
						}

						$post = Post::find()->where(['forum_id' => $forum->id])->all();

						$color = $colors[rand(0, 1)];

						?>
						<a href="<?= Url::to(['member/post', 'id' => $forum->id, 'color' => $color]); ?>">
							<div class="row">
								<div class="col-xs-12">
									<div class="forum_box container-fluid" style="background-color: <?= $color ?>;">
										<div class="row" style="margin: 5px -10px;">
											<div class="col-xs-3" style="padding: 0 5px 0 0;"><img width="100%"
																								   src="<?= $avataras; ?>">
											</div>
											<div class="col-xs-9 forum_name"><?= $forum->name; ?></div>
										</div>
										<div class="row" style="margin: 5px 0 0;  position: relative;">
											<div class="col-xs-6 col-xs-offset-3" style="font-size: 10px; padding: 0;">
												Atsakymų: <?= count($post); ?>&nbsp &nbsp &nbsp
												Peržiūrų: <?= $forum->views; ?>
											</div>
											<div class="col-xs-3" style="padding-right: 0;">
												<?php if (!CheckedForums::isChecked($forum->id)): ?>
													<a href="<?= Url::to(['member/check', 'id' => $forum->id]); ?>"
													   title="Pridėti prie mėgstamiausių">
														<img src="/css/img/icons/sirdele_black.png" height="15px"
															 style="position: absolute; top: -3px; left: 21px;">
														<div class="btn btn-reg btn-reg-new boxShadow"
															 style="position: absolute; font-size:10px; padding: 0 4px; top: -4px; margin: 0; right: -17px;">
															Pažymėti
														</div>
													</a>
												<?php else: ?>
													<a href="<?= Url::to(['member/uncheck', 'id' => $forum->id]); ?>"
													   title="Ištrinti iš mėgstamiausių">
														<img src="/css/img/icons/baltas_sirdele.png" height="15px"
															 style="position: absolute; top: -3px; left: 21px;">
														<div class="btn btn-reg btn-reg-new boxShadow"
															 style="position: absolute; font-size:10px; padding: 0 4px; top: -4px; margin: 0; right: -17px;">
															Nužymėti
														</div>
													</a>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</a>
						<?php
					}
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php
				if(!$sections['left']){
					?>
						<div class="alert alert-warning">Forumų nėra</div>
					<?php
				}
			?>
		</div>
	</div>
</div> 