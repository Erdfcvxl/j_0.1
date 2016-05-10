<?php

use yii\helpers\Url;
use frontend\models\getPhotoList;
use frontend\models\Photos;
use frontend\models\Friends;
use yii\helpers\BaseFileHelper;


$id = isset($_GET['id'])? $_GET['id'] : Yii::$app->user->id;

?>

<?php foreach ($photos as $photo): ?>
	<?php
	$photo = BaseFileHelper::normalizePath($photo, '/');
	$parts = explode('/', $photo);
	$name = $parts[count($parts)-1];

	$name = getPhotoList::nameExtraction($name);

	$fullName = 'BFl'.$name['pure'].'EFl'.$name['ownerId'].'.'.$name['ext'];

	$dir = '';
	for($i = 0; $i < count($parts) - 1; $i++){
		$dir .=$parts[$i].'/';
	}

	$url = Url::to(['member/fotos', 'ft' => 'showFoto', 'n' => $fullName, 'd' => '/'.$dir, 'id' => $id]);

	$model = Photos::getPhoto($name['pure'], $id);


	if(($model->friendsOnly && Friends::arDraugas($id)) || !$model->friendsOnly)
		if($name['pirmostrys'] == 'BTh'){
			?>

			<div class="col-xs-4 notEmptyPhoto kvadratas" id="<?= $name['pure'] ?>">

				<a href="<?= $url ?>">
					<div>
						<img src="<?= '/'.$photo; ?>" class="cntrm" width="221px">
					</div>
				</a>

			</div>

			<?php Yii::$app->params['photoOK'] = true; ?>

			<?php
		}

	//var_dump($name);
	?>
<?php endforeach; ?>
