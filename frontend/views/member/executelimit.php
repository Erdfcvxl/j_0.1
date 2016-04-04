<?php

require __DIR__ . '/../../../vendor/paypal/rest-api-sdk-php/sample/bootstrap.php';
use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use yii\helpers\Url;
use frontend\models\User;

?>
<div class="listBox" style="position:fixed; width: 600px; height: 400px; margin-left: -300px; background-image: url('css/img/fade_white.jpg'); background-color: #000;">

<?php

if (isset($_GET['success']) && $_GET['success'] == 'true') {

    $moveOn = false;

    $paymentId = $_GET['paymentId'];
    $payment = Payment::get($paymentId, $apiContext);
    $res = Payment::get($paymentId, $apiContext);

    $execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);

    try {
        $result = $payment->execute($execution, $apiContext);
        try {
                $moveOn = true;



                $item = $payment->transactions[0]->item_list->items[0];

                $add = $item->sku;


                $user = User::find()->where(['id' => $_GET['i']])->one();

                $user->photoLimit += $add;
                $user->save(false);

                ?>
                    <div style="position: absolute; z-index: -1; width: 100%; height: 100px; left: 0; top :0; background-color: white;"></div>
                    <div style="position: absolute; z-index: -1; width: 100%; height: 200px; left: 0; top :100px; background-image: url('css/img/fade_vertical_white.png'); background-size: 100% 100%; "></div>
                    
                    <h2><span style="color: #56adfa;">Jūsų apmokėjimas sėkmingai priimtas!</span></h2>
                    Dabar jūs galite įkelti <b><?= $add; ?></b> nuotraukų.<br>

                    <a href="<?= Url::to(['member/settings']); ?>" class="btn btn-success">Tęsti</a>

                <?php
        } catch (Exception $ex) {

            ?>
                <div style="position: absolute; z-index: -1; width: 100%; height: 200px; left: 0; top :0; background-image: url('css/img/fade_vertical_white.png'); background-size: 100% 100%; "></div>

                <h2><span style="color: #ff0100;">Apmokėjimas nebuvo atliktas</span></h2><br>
                <a href="<?= Url::to(['member/settings']); ?>" class="btn btn-info">Tęsti</a>


                <script type="text/javascript">$('.listBox').css({"height" : 200 + "px"});</script>
            <?php
        }
    } catch (Exception $ex) {
        ?>
            <div style="position: absolute; z-index: -1; width: 100%; height: 200px; left: 0; top :0; background-image: url('css/img/fade_vertical_white.png'); background-size: 100% 100%; "></div>

            <h2><span style="color: #ff0100;">Apmokėjimas nebuvo atliktas</span></h2><br>
            <a href="<?= Url::to(['member/settings']); ?>" class="btn btn-info">Tęsti</a>


            <script type="text/javascript">$('.listBox').css({"height" : 200 + "px"});</script>
        <?php
    }

} else {
    ?>
        <div style="position: absolute; z-index: -1; width: 100%; height: 200px; left: 0; top :0; background-image: url('css/img/fade_vertical_white.png'); background-size: 100% 100%; "></div>

        <h2><span style="color: #ff0100;">Apmokėjimas nebuvo atliktas</span></h2><br>
        <a href="<?= Url::to(['member/settings']); ?>" class="btn btn-info">Tęsti</a>


        <script type="text/javascript">$('.listBox').css({"height" : 200 + "px"});</script>
    <?php
}

?>

</div>
