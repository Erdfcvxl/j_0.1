<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use common\models\User;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\db\Query;
use yii\widgets\Pjax;
use yii\data\ArrayDataProvider;

include('../views/site/form/_list.php');

$user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();

$form = ActiveForm::begin([
    'method' => 'get',
    'action' => Url::to(['member/search', 'psl' => 'recommended']),
]);
?>
<div class="row" style="margin-top: 5px;">

<div class="col-xs-3" style="background-color: #e7e7e7; min-height: 70px; padding: 0;">
    <?= $this->render('includes/leftFilters', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'form' => $form
    ]);?>
</div>

<div class="col-xs-9" >
    <?= $this->render('//member/index/progress'); ?>

    <?= $this->render('includes/topFilters', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'form' => $form
    ]);?>

            <div class="container" style="width:100%; background-color: #f9f9f9; height: auto; font-size: 12px; text-align: left;">
                <br>
                <div class="row" style="padding: 0px 5px;">
<!--                    --><?php
//                        if($dataProvider->models){
//                            $provider = \frontend\models\Reccomended::getProvider($dataProvider->models);
//                        }else{
//                            $provider = new ArrayDataProvider([
//                                'allModels' => [],
//                                'pagination' => [
//                                    'pageSize' => 8,
//                                ],
//                            ]);
//                        }
//
//                    ?>

                    <?php Yii::$app->params['close'] = 0; ?>

                    <?php Pjax::begin();?>
                        <?= ListView::widget( [
                            'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
                            'dataProvider' => $dataProvider,
                            'itemView' => '../_searchResultRecomended2',
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
                
                <div class="row">
                <br>
                </div>
            </div>
        </div>
</div>   