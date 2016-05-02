<h2>Tavo susirašinėjimų suvestinė</h2>

<div class="row">
    <div class="col-xs-6">

        <div class="frame" style="font-size: 18px;">
            <p style="padding: 15px 5px;margin: 0; display: inline-block">Išsiųstos žinutės</p>

            <div class="hKvadratas gSquare" style="float: right"><?= $model->msgStats()->msg_sent ?></div>
        </div>

    </div>



    <div class="col-xs-6">

        <div class="frame" style="font-size: 18px;">
            <p style="padding: 15px 5px;margin: 0; display: inline-block">Gautos žinutės</p>

            <div class="hKvadratas gSquare" style="float: right"><?= $model->msgStats()->msg_recieved ?></div>
        </div>


        <br>
    </div>


</div>

