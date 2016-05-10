<?php
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use frontend\assets\AppAsset;

require('_list.php');

$question = $model->getQuestion();

$data = [];

// var_name, placeholder, label
$info = [
    'tautybe' => ['gimtine', 'gimtajį miestą', 'Kokiame mieste esi gimęs?'],
    'gimtine' => ['gimtoji_salis', 'gimtają šalį', 'Kokioje šalyje gimėte?'],
    'religija' => ['religija', 'religiją', 'Kokią religiją išpažystate?'],
    'statusas' => ['statusas', 'statusą', 'Kokis Jūsų statusas?'],
    'pareigos' => ['pareigos', 'pareigas', 'Kokias pareigas užimate?'],
    'uzdarbis' => ['uzdarbis', 'uždarbį', 'Koks Jūsų uždarbis?'],
    'orentacija' => ['orentacija', 'orentaciją', 'Kokios esate orentacijos?'],
    'tikslas' => ['tikslas', 'tikslą', 'Kokios Jūsų tikslas portale?'],
    'miestas' => ['list', 'miestą', 'Iš kokio esate miesto?'],
    'grajonas' => ['rajonai', 'gyvenamajį rajoną', 'Kokiame rajone gyvenate?'],
    'drajonas' => ['rajonai', 'darbovietės rajoną', 'Kokiame rajone dirbate?'],
    'metai' => ['year', 'gimimo metus', 'Kokiais metais gimetė?'],
    'menuo' => ['month', 'gimimo mėnesį', 'Kelintą mėnesį gimete?'],
    'diena' => ['day', 'gimimo dieną', 'Kelintą dieną gimete?'],
    'issilavinimas' => ['issilavinimas', 'išsilavinimą', 'Koks Jūsų išsilavinimas?'],
    'ugis' => ['ugis', 'ugį', 'Koks Jūsų ūgis?'],
    'svoris' => ['svoris', 'svorį', 'Koks Jūsų svoris?'],
    'sudejimas' => ['sudejimas', 'sudėjimą', 'Koks Jūsų sudėjimas?'],
    'plaukai' => ['plaukai', 'plaukų spalvą', 'Kokia Jūsų plaukų spalva?'],
    'akys' => ['akys', 'akių spalvą', 'Kokia Jūsų akių spalva?'],
    'stilius' => ['stilius', 'stilių', 'Koks Jūsų stilius?'],
];

?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, $question)->dropdownList(${$info[$question][0]}, ['placeholder' => 'Pasirinkite '.$info[$question][1].' ...', 'style' => 'width: 100%', 'id' => 'input', 'attr' => $question])->label($info[$question][2]);?>

    <a class="btn-reg" id="submitQuestions" style="font-size: 14px;padding: 2px 20px;border-radius: 0px; position: relative; top: -8px; cursor: pointer;">Kitas klausimas</a>

<?php ActiveForm::end(); ?>

<script type="text/javascript">
    var dont = true;
</script>


