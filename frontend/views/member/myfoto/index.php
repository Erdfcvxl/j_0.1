<?php

use frontend\models\User;
use frontend\models\Albums;
use yii\helpers\Url;
use yii\widgets\ListView;
use frontend\models\getPhotoList;
use yii\helpers\BaseFileHelper;


$structure = "uploads/".Yii::$app->user->id;

if (!is_dir($structure)) {
    BaseFileHelper::createDirectory($structure, $mode = 0777);
}

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";
$id = (isset($_GET['id']))? $_GET['id'] : Yii::$app->user->id;
$extra = (isset($_GET['extra']))? $_GET['extra'] : "";

getPhotoList::fixProfileDir($id);


$user = User::find()->where(['id' => Yii::$app->user->id])->one();


$photos = \yii\helpers\BaseFileHelper::findFiles("uploads/".$user->id."/");
$count = count($photos) / 2;

?>

<div class="container" style="width:100%; background-color: #f9f9f9; min-height: 150px; font-size: 12px; text-align: left; padding: 15px;">
    <div class="alert alert-warning">Šiuo metu vykdomi serverio profilaktikos darbai, todėl nepasikeitus nuotraukai, spauskite F5 savo klaviatūroje.</div>
    <?php if(!\frontend\models\Photos::find()->where(['u_id' => Yii::$app->user->id])->andWhere(['profile' => 1])->all()): ?>
        <div class="alert alert-info">
            <h3>Dėmesio!</h3>
            <p>
                Dėl techninių atnaujinimų jums reikia patvirtinti savo profilio nuotrauką. Tai galite padaryti taip:
                <ul>
                    <li>Spustelkite <span class="glyphicon glyphicon-resize-full"></span> apatiniame kairiajame nuotraukos kampe;</li>
                    <li>Spustelkite <i>Nustatyti kaip profilio nuotrauką</i> viršutinimae kairiajame nuotraukos kampe.</li>
                </ul>
            </p>
        </div>
    <?php endif; ?>

    <?= $this->render('_fotos', ['photos' => $photos]); ?>
    <?= $this->render('_spots', ['photos' => $count]); ?>
</div>

<script type="text/javascript">
    $(".cntrm").fakecrop({wrapperWidth: 222.5,wrapperHeight: 222, center: true });

    $('.morePhoto').click(function(){
        $(this).css({'display' : 'none'});
        $('.menuPhoto[data-trigger="'+$(this).attr('data-trigger')+'"]').css({'display' : 'block'});
    });

    $('.less').click(function(){
        //$(this).css({'display' : 'none'});
        $('.menuPhoto[data-trigger="'+$(this).attr('data-trigger')+'"]').css({'display' : 'none'});
        $('.morePhoto[data-trigger="'+$(this).attr('data-trigger')+'"]').css({'display' : 'block'});
    });
</script>

