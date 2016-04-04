<?php

$dovanos = \frontend\models\Dovanos::find()->where(['reciever' => $id])->andWhere(['object' => 'pav'])->andWhere(['opened' => 1])->all();


?>
<div class="row">
		
	<?php foreach($dovanos as $dovana): ?>
		<?php
			$url = \yii\helpers\Url::to(['member/'.Yii::$app->controller->action->id, 'ft' => 'showFoto', 'type' => 'dovana', 'id' => $id, 'photo_id' => $dovana->object_id]);
		?>

		<div class="col-xs-4">	
			<a href="<?= $url; ?>">
				<img src="/css/img/dovanos/<?= $dovana->object_id ?>.jpg" width="100%">
			</a>
		</div>
	<?php endforeach;?> 

</div>
