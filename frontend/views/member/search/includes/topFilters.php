<div class="container" style="width: 100%; background-color: #b6edcd; padding: 7px 15px 0px;">
        <div class="col-xs-4 fixHelp"><?= $form->field($searchModel, 'lastOnline')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Tik prisijungę nariai</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
        <div class="col-xs-4 fixHelp"><?= $form->field($searchModel, 'avatar')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Tik su nuotrauka</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
        <div class="col-xs-4 fixHelp"><?= $form->field($searchModel, 'vip')->checkBox(['label' => '<span id="asas"></span><span style="font-weight: normal;">Vip</span>', 'uncheck' => '0', 'checked' => '1']); ?></div>
</div>