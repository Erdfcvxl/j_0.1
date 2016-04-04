<?php
use frontend\models\Post;
use frontend\models\Forum;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;


$id = (isset($_GET['id']))? $_GET['id'] : '';
$color = (isset($_GET['color']))? $_GET['color'] : '#90C3D4'; 

$forum = Forum::find()->where(['id' => $id])->one();

$model = new Post;
$model->forum_id = $id;

?>
<div class="container-fluid" style="background-color: #e8e8e8; text-align: left; padding: 15px;">
	<div class="row">
		<div class="col-xs-12"><h4>Atsakyti į <b><?= $forum->name; ?></b></h4></div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(); ?>
				<?= $form->field($model, 'text')->textArea(['style' => 'width: 100%;'])->label(false);   ?>
				<?= $form->field($model, 'forum_id')->hiddenInput()->label(false); ?>

				<?= Html::submitButton('Atsakyti', ['class' => 'btn btn-reg', 'name' => 'signup-button', 'style' => 'font-size: 14px; padding: 0 20px 0 20px; font-family: OpenSansLight;text-shadow: 0px 0px 7px rgba(0, 0, 0, 0.7); border-radius: 0;']) ?>
			<?php ActiveForm::end() ?>
		</div>
	</div>
</div>
<?php
	if($id){
        $model = new \frontend\models\Post;

        if($post = $model->find()->where(['forum_id' => $id])){
            $provider = new ActiveDataProvider([
                'query' => $post,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            echo $this->render('post', ['id' => $id, 'dataProvider' => $provider, 'color' => $color]); 
        }
    }
?>