<?php
use yii\helpers\Url;
use frontend\models\Friends;
use frontend\models\Favourites;

$taveziurejo = \frontend\models\Profileview::find()->where(['ziurimasis' => $user->id])->andWhere(['>=', 'timestamp', $user->params->profileview_check])->count();

?>

<div class="GmenuBar">

        <a href="<?= Url::to(['member/index'])?>" class="index_top <?php echo($puslapis == 'index')? 'index_top_active' : '' ?>">
            <div >
                Pagrindinis
                <span class="msgCount btn btn-circle" id="pgrTopIndicator" style="<?= ($newNot > 0)? 'display: block' : 'display: none;' ?>"><?= ($newNot > 0)? $newNot : ""; ?></span>
            </div>
        </a>

    <a href="<?= Url::to(['member/msg'])?>" class="msg_top <?php echo($puslapis == 'msg')? 'msg_top_active' : ''?>">
        <div>
            Žinutės
            <span class="msgCount btn btn-circle" id="msgTopIndicator" style="<?= ($chatNew > 0)? 'display: block' : 'display: none;' ?>"><?= $chatNew ?></span>
        </div>
    </a>

    <a href="<?= Url::to(['member/search', 'psl' => 'index'])?>" class="search_top <?php echo($puslapis == 'search')? 'search_top_active' : '' ?>">
        <div >
            Ieškoti
            <span class="msgCount btn btn-circle" id="srcTopIndicator" style="<?= ($user->new > 0)? 'display: block' : 'display: none;' ?>"><?= ($user->new > 0)? $user->new : "" ?></span>
        </div>
    </a>

    <a href="<?= Url::to(['member/forum'])?>" class="forum_top <?php echo($puslapis == "forum" || $puslapis == "post" || $puslapis == "forumnewru" || $puslapis == "forumats")? "forum_top_active" : "" ?>">
        <div >
            Forumas
            <span class="msgCount btn btn-circle" id="forumTopIndicator" style="<?= ($forumNew > 0)? 'display: block' : 'display: none;' ?>"><?= ($forumNew > 0)? $forumNew : ""; ?></span>
        </div>
    </a>

    <a href="<?= Url::to(['member/friends'])?>" class="friends_top <?php echo($puslapis == "friends")? "friends_top_active" : "" ?>">
        <div >
            Draugai
            <span class="msgCount btn btn-circle" id="drgTopIndicator" style="<?= (Friends::isNew() > 0)? 'display: block' : 'display: none;' ?>"><?= (Friends::isNew() > 0)? Friends::isNew() : "" ?></span>
        </div>
    </a>

    <a href="<?= Url::to(['member/favs'])?>" class="favs_top <?php echo($puslapis == "favs")? "favs_top_active" : "" ?>">
        <div >
            Pamėgti
            <span class="msgCount btn btn-circle" id="megTopIndicator" style="<?= (Favourites::isNew() > 0)? 'display: block' : 'display: none;' ?>"><?= (Favourites::isNew() > 0)? Favourites::isNew() : "" ?></span>
        </div>
    </a>


    <a href="<?= Url::to(['member/date'])?>" class="date_top <?php echo($puslapis == "date")? "date_top_active" : "" ?>">
        <div class="">
            Pasimatymai
        </div>
    </a>

    <a href="<?= Url::to(['member/pviews'])?>" class="last pviews_top <?php echo($puslapis == "pviews")? "pviews_top_active" : "" ?>">
        <div >
            Tave žiūrėjo
            <span class="msgCount btn btn-circle" id="taziuTopIndicator" style="<?= ($taveziurejo > 0)? 'display: block' : 'display: none;' ?>"><?= ($taveziurejo > 0)? $taveziurejo : "" ?></span>
        </div>
    </a>

    <div class="dropdown">
        <button class="kumpliaratis dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="glyphicon glyphicon-cog" style="width: 100%;"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="<?= Url::to(['member/settings'])?>">Nustatymai</a></li>
            <li><a href="<?= Url::to(['site/logout'])?>">Atsijungti</a></li>
        </ul>
    </div>
</div>
