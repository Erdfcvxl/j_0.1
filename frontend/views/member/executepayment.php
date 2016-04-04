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
            $payment = Payment::get($paymentId, $apiContext);
                $moveOn = true;

                $item = $payment->transactions[0]->item_list->items[0];

                $menuoS = 31 * 24 * 60 * 60;

                if($item->sku == 1){
                    $menesiuNr = 1; 
                    $addTime = 1 * $menuoS;
                }elseif($item->sku == 2){
                    $menesiuNr = 3;
                    $addTime = 3 * $menuoS;
                }elseif($item->sku == 3){
                    $menesiuNr = 6;
                    $addTime = 6 * $menuoS;
                }elseif($item->sku == 4){
                    $menesiuNr = 12;
                    $addTime = 12 * $menuoS;
                }else{
                    $addTime = 0;
                }

                $user = User::find()->where(['id' => $_GET['i']])->one();

                if($user->expires < time()){
                    $user->expires = time() + $addTime;
                }else{
                    $user->expires = $user->expires + $addTime;
                }

                $user->vip = 1;
                $user->save();

                $data = date('o-m-d G:i', $user->expires);

                ?>
                    <div style="position: absolute; z-index: -1; width: 100%; height: 100px; left: 0; top :0; background-color: white;"></div>
                    <div style="position: absolute; z-index: -1; width: 100%; height: 200px; left: 0; top :100px; background-image: url('css/img/fade_vertical_white.png'); background-size: 100% 100%; "></div>
                    
                    <h2><span style="color: #56adfa;">Jūsų apmokėjimas sėkmingai priimtas!</span></h2>
                    Abonimentas pratęstas <?= $menesiuNr; ?> mėn. ir galios iki <?= $data; ?> .<br>

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
