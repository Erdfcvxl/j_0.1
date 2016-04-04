<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\models\Parametres;
use common\models\Mail;
use frontend\widgets\Alert;

$params = Parametres::find()->one();
$mail = Mail::find()->all();

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            if(!Yii::$app->user->isGuest){
                NavBar::begin([
                    'brandLabel' => '<span>Administravimas</span>',
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar-inverse navbar-fixed-top',
                    ],
                ]);

                $monitorius = [
                    '<li class="dropdown-header">Laiškų šiai valandai liko: '.$params->MailLeft.'</li>',
                    '<li class="dropdown-header">Laiškai laukia kol bus išsiųsti: '.count($mail).'</li>',
                ];

                $fakeLinks = [
                        '<li class="dropdown-header">Informacija apie fake narius</li>',
                        ['label' => 'Susirašinėjimai', 'url' => ['/site/msg']],
                        ['label' => 'Naujos žinutės', 'url' => ['/site/fakemsg'], 'linkOptions' => ['id' => 'fakemsg']],
                        ['label' => 'Nauji laikai', 'url' => ['/site/fakelikes'], 'linkOptions' => ['id' => 'fakelikes']],
                        ['label' => 'Nauji draugai', 'url' => ['/site/fakedrg'], 'linkOptions' => ['id' => 'fakedrg']],
                        '<li class="dropdown-header">Veiksmai su fake nariais</li>',
                        ['label' => 'Rašyti masinę žinutę', 'url' => Url::to(['/site/fmm'])],
                        ['label' => 'Automatinė žinutė', 'url' => Url::to(['/site/welcome'])],
                    ];

                $vipLinks = [
                        ['label' => 'Greitai baigsis', 'url' => ['/site/soondead']],
                    ];


                $menuItems = [
                    ['label' => 'Monitorius', 'items' => $monitorius],
                    ['label' => 'Nariai', 'url' => ['/site/users']],
                    ['label' => 'Miestai', 'url' => ['/site/miestai']],
                    ['label' => 'Rašyti laišką', 'url' => ['/site/email']],
                    ['label' => 'Akcijos', 'url' => ['/site/control']],
                    ['label' => 'Titulinis', 'url' => ['/site/titulinis']],
                    ['label' => 'Fake nariai', 'items' => $fakeLinks],
                    ['label' => 'Vip nariai', 'items' => $vipLinks],
                ];
                $manoItemes = [
                    ['label' => 'Funkcijos', 'url' => ['/site/functions']],
                ];

                if(isset(Yii::$app->session['admin']) && Yii::$app->session['admin'] == 88){
                    $menuItems = array_merge($menuItems, $manoItemes);
                }
                if (isset(Yii::$app->session['admin']) && (Yii::$app->session['admin'] == 1 || Yii::$app->session['admin'] == 88)) {
                    $menuItems[] = [
                        'label' => 'Atsijungti', 'url' => ['/site/logout']
                    ];
                }
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => $menuItems,
                ]);
                NavBar::end();

                ?>

                <!-- Parametru informacija -->
                <!--<div class="infoBox">
                    <b>Laiškų galima išsiųsti:</b> <?/*= $params->MailLeft; */?>
                    <b>Laiškų eilė:</b> <?/*= count($mail); */?>
                </div>-->

                <!-- <div class="monitorBtn"></div>-->

                <?php
            }
        ?>

        <div class="container-fluid" style="padding-top: 80px;">

            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <?= Alert::widget() ?>
            <?= $content ?>

        </div>
    </div>
    <a href="http://pazintyslietuviams.co.uk" class="btn btn-warning" style="width: 100%">Atgal į svetainę</a>

    <script type="text/javascript">
    function checkMsg()
    {
        $.ajax({
            url: "<?= Url::to(['site/fakemsgcheck']); ?>",
            type: "post",
            dataType: "json",
            success: function(data){
                
                if(data[0] > 0){
                    $('#fakemsg').html("Naujos žinutės <span class='badge badge-notify'>"+data[0]+"</span>");
                }else{
                    $('#fakemsg').html("Naujos žinutės");
                }

                if(data[1] > 0){
                    $('#fakelikes').html("Nauji laikai <span class='badge badge-notify'>"+data[1]+"</span>");
                }else{
                    $('#fakelikes').html("Nauji laikai");
                }

                if(data[2] > 0){
                    $('#fakedrg').html("Nauji draugai <span class='badge badge-notify'>"+data[2]+"</span>");
                }else{
                    $('#fakedrg').html("Nauji draugai");
                }

                setTimeout(function(){
                    checkMsg();
                }, 5000);
            },
            error: function(ts){
                console.log(ts.responseText);
                console.log('msgcheckerrorr');
            }
        });  
    };

    $(function() {
      checkMsg();
      console.log('called');
    });
    
    </script>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
