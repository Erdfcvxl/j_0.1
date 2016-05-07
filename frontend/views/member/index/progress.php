<?php
use frontend\models\InfoLatest;
use yii\helpers\Url;


$model = InfoLatest::find()->where(['u_id' => Yii::$app->user->id])->one();
$percent = $model->getPercent();


if($percent < 100):
    $this->registerCssFile('/css/circle.css');

?>

    <div class="index-container" style="margin-bottom: 7px; min-height: 100px;">
        <div style="border: 1px solid #bce8f1; background-color: #d9edf7; width: 100px; height: 100px; text-align: center; float: left">

            <div id="radP" class="c100 p<?= $percent; ?> small" style="margin-left: 20px; margin-top: 5px;">
                <span id="textP"><?= $percent; ?>%</span>
                <div class="slice">
                    <div class="bar"></div>
                    <div class="fill"></div>
                </div>
            </div>
            <span style="color: #31708f; position: relative; top: -7px;">Anketos užpildymas</span>

        </div>

        <div id="questionBox" style="float: left; padding: 10px 15px;">
            <?= $this->render('_question', ['model' => $model]); ?>

        </div>

        <div style="float: right; text-align: center; height: 100px; width: 220px; background-color: #e2e2e2; padding: 15px 25px 5px;">
            <p style="text-align: left; margin-bottom: 5px">Užpildęs visą anketą lengviau rasite antrąją pusę, turinčią daugiau bendrų dalykų.</p>
            <a href="<?= Url::to(['member/manoanketa']); ?>" class="btn-reg" style="font-size: 12px;padding: 1px 10px;border-radius: 0px;">Pildyti visą anketą</a>
        </div>
    </div>

    <script type="text/javascript">
        $( document ).on( "click", "#submitQuestions", function() {
            var val = $('#input').val();
            var attr = $('#input').attr('attr');

            $.ajax({
                url: '/member/questions',
                type: 'POST',
                dataType : 'json',
                data : {attr : attr, val : val},
                success: function(data){
                    $('#questionBox').fadeOut().html(data['part']).fadeIn();

                    setTimeout(function(){
                        $('#radP').addClass('p'+data['percent']);
                        $('#textP').text(data['percent']+"%");
                    },500);

                }
            });
        });
        


    </script>


<?php endif; ?>