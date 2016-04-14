<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

require(__DIR__ . '/../../../frontend/views/site/form/_list.php');
?>

<div class="container">
    <h1>Rašyti masinę žinutę iš fake nario</h1>

    <div class="row">
        <div class="col-xs-12 col-lg-3">
            <div style="width: 200px;">
                <?= $this->render('avatar', ['model' => $user]);?>

                Nario orentacija: <?= $orentacija[$user->info->orentacija]; ?>
            </div>

            <script type="text/javascript">
                $(".manualAvatar img.cntrm").fakecrop({wrapperWidth: 200,wrapperHeight: 200, center: true });
            </script>

            <br>

            <p>Žinutė visiems priešingos lyties ir tinkamos pakraipos nariams bus išsiųsta šio nario vardu.</p>

        </div>

        <div class="col-xs-12 col-lg-9">
            <h4>Patvirtinimas</h4>

            <table class="table table-bordered">
                <tr>
                    <th>Gavėjai</th>
                    <td><?= $model->publika; ?></td>
                    <th>Atitikmenų</td>
                    <td><a href="<?= Url::to(['site/list', 'model' => $model->recievers]);?>" target="_blank"><?= count($model->recievers) ?></a></td>
                </tr>
                <tr>
                    <td colspan="4" id="btnSite"><a id="confirm" class="btn btn-success" style="width: 100%;">Patvirtinti</a></td>
                </tr>
            </table>


            Jei kažkas neatitinka <a href="<?= Yii::$app->request->referrer; ?>">atgal</a>.

        </div>

    </div>


</div>

<?php $url = Yii::$app->urlManager->createUrl('/site/fafinvite'); ?>

<script type="text/javascript">
    $('#confirm').click(function(){
        var model = <?= json_encode($model); ?>;

        $('#btnSite').css({'text-align' : 'center'})
        $('#btnSite').html('Siunčiama...');

        $.ajax({
            type: "post",
            url: "<?= $url; ?>",
            data: {'model' : model, 'id' : '<?= $_GET['id']; ?>'},
            success: function(data){
                console.log(data);
                $('#btnSite').html('<p class="text-success">Išsiųsta sėkmingai</p>');

            },
            error: function(ts){
                console.log('error');
                console.log(ts.responseText);
            }
        });
    });
</script>
