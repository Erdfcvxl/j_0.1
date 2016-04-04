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
use frontend\models\Chat;


include('../views/site/form/_list.php');

$user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();

$form = ActiveForm::begin([
    'method' => 'get',
    'action' => Url::to(['member/search', 'psl' => 'topF']),
    ]);
?>
 <div class="row" style="margin-top: 5px;">

        <div class="col-xs-3" style="background-color: #e7e7e7; min-height: 70px; padding: 0;">
            <?php ?>

                <?= $this->render('includes/leftFilters', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'form' => $form
            ]);?>
                    
        </div>

        <div class="col-xs-9" >
            <div class="container" style="width: 100%; background-color: #b6edcd; padding: 7px 15px 0px;">
                    <div class="col-xs-4 fixHelp"><?= $form->field($searchModel, 'lastOnline')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Tik prisijungę nariai</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
                    <div class="col-xs-4 fixHelp"><?= $form->field($searchModel, 'avatar')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Tik su nuotrauka</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
                    <div class="col-xs-4 fixHelp"><?= $form->field($searchModel, 'vip')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Vip</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
            </div>

            <div class="container" style="width:100%; background-color: #f9f9f9; height: auto; font-size: 12px; text-align: left;">
                <br>
                <div class="row" style="padding: 0px 5px;">

                    <?php Yii::$app->params['close'] = 0; ?>


                    <?=  ListView::widget( [
                        'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;"><div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div></div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
                        'dataProvider' => $dataProvider,
                        'itemView' => '//member/_searchResultTopF',
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

                    <script type="text/javascript">
                        $(".recentImgHolder img.cntrm").fakecrop({wrapperWidth: $('.recentImgHolder').width(),wrapperHeight: $('.recentImgHolder').width(), center: true });
                    </script>

                </div>
                
                <div class="row">
                <br>
                </div>
            </div>
        </div>
    </div>