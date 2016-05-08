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

$user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();

$form = ActiveForm::begin([
        'method' => 'get',
        'action' => Url::to(['member/search', 'psl' => 'detail']),
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

            <div class="container" style="width:100%; background-color: #f9f9f9; padding-bottom: 20px; height: auto; font-size: 12px; text-align: left;">

                <br>

                <!-- Searcho forma begin -->
                <div style="display: <?= !$searchModel->search? 'block' : 'none'; ?> ">

                    <?= $this->render('_detailForm.php', ['searchModel' => $searchModel, 'form' => $form]); ?>

                    <div class="row">
                       <div class="col-xs-6"><?= Html::submitButton('Ieškoti', ['class' => 'btn btn-reg', 'style' => 'width: 100%; padding: 0px;', 'name' => 'DetailSearchP[search]', 'value' => 1]) ?></div>
                       <div class="col-xs-6"><a href="<?= Url::to(['member/search', 'psl' => 'detail']); ?>" class="btn btn-default" style='width: 100%; padding: 0px; font-size: 18px;'>Valyti</a></div>            
                    </div>

                    <?php $this->registerJs("var date = '$searchModel->metai'"); ?>
                    <?php $this->registerJs($this->render('script.js')); ?>

                </div>
                <!-- Searcho forma end -->

                <!-- Rezultatai begin-->
                <?php if($searchModel->search): ?>
                    <div class="row" style="padding: 0px 10px;">
                        
                    </div>
                    <div class="row" style="padding: 0px 5px;">
                        <?php Pjax::begin();?>

                            <?php  Yii::$app->params['close'] = 0; ?>

                            <?= ListView::widget( [
                                'layout' => '<div class="row" style="padding-left: 15px; padding-right: 15px;"><div class="row" style="padding-left: 15px; padding-right: 15px;">{items}</div></div><div class="row" style="padding-left: 15px; padding-right: 15px; text-align: right;">{pager}</div>',
                                'dataProvider' => $dataProvider,
                                'itemView' => '//member/_searchResult',
                                'viewParams' => [
                                  'rodyti_kilometrus' => 1,
                                ],
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
                            
                        <?php Pjax::end(); ?>
                    </div>



                <?php endif; ?>
                <!-- Rezultatai end-->

                <!-- Paieska pagal rengionus begin -->
                <?= $this->render('includes/paieskaPagalSpinduli.php', ['searchModel' => $searchModel, 'form' => $form]); ?>
                <!-- Paieska pagal regionus end -->
                
                <div class="row">
                <br>
                </div>
            </div>
        </div>
</div>   

<?= $form->field($searchModel, 'search')->hiddenInput()->label(false);?>

<?php ActiveForm::end() ?>