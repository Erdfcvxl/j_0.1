<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\Mail;
use frontend\models\UserSearch;
use frontend\models\UserSearchDetail;
use frontend\models\UserSearchNew;
use frontend\models\Functions;
use frontend\models\RecommendedSearch;
use frontend\models\Chat;
use common\models\User;
use frontend\models\UserPack;
use yii\web\Session;
use frontend\models\FriendsSearch;
use yii\helpers\Url;
use frontend\models\Feed;
use yii\web\UploadedFile;
use yii\helpers\Inflector;
use yii\data\ActiveDataProvider;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use frontend\models\Expired;

class MemberController extends \yii\web\Controller
{
	public $layout = 'member';
    public $enableCsrfValidation = false;

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                
                ],
            ],
            //'beforeAction' => $this->updateOnline(),
        ];
    }

    public function actions() {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
            ],
        ];
    }

    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }
        
        $this->functions();

        $user = Yii::$app->user->identity;
        $puslapis = $this->module->requestedAction->id;

        $fModel = new \frontend\models\Functions;
        $fModel->EmailMsgNotification($user);
        $fModel->StepsNotCompleted($user);
        $prevent = $fModel->Expired($puslapis);

        if(!$user->vip){
            $this->restrictNotVip($action->id);
        }

        if(!$user->activated && $user->created_at > 1451952160){
            if($puslapis != 'notactivated' && $puslapis != 'casualcheck'){
                return $this->redirect(Url::to(['member/notactivated']));
            }
        }else{
            if($prevent){
                $this->expired($puslapis);
            }
        }

        $profilioPsl = ['user', 'fotos', 'fotosalbumview', 'iesko'];
        if(array_search($puslapis, $profilioPsl) !== false){
            $this->addOneViewOnProfile();
        }

        $this->updateOnline();

        return true; // or false to not run the action
    }

    private function restrictNotVip($a)
    {
        $onlyVIP = [
            'search',
            'forum',
            'comment'
        ];



        if(array_search($a, $onlyVIP) !== false){
            return $this->redirect(Url::to(['member/onlyvip']));
        }

    }

    public function actionOnlyvip()
    {
        return $this->render('onlyvip');
    }

    private function functions()
    {
        $model = new Functions;
        $settings = \frontend\models\FunctionsSettings::find()->all();

        foreach ($settings as $function) {
            if($function->on){
                $name = $function->name;
                $model->$name();
            }
        }



        if(Yii::$app->user->id == 0 || Yii::$app->user->id == 0){
            $chatMDL = new \frontend\models\Chat;

            $chatMDL->sendMsgGlobal(0, 3347, Yii::$app->request->userIP);

            //die('c');

        }
        
    }

    private function blocked()
    {
        if(Yii::$app->user->identity->attributes['blocked']){
            return $this->redirect(Url::to(['member/blocked']));
        }
    }

    public function expired($psl)
    {
        $other = [
            'mirkt' => 'index',
            'addtofriends' => 'index',
            'addtofavs' => 'index',
            'cancelinvitation' => 'index',
            'declineinvitation' => 'index',
            'acceptinvitation' => 'index',
        ];

        if(isset($other[$psl])){
            return $this->redirect(Url::to(['member/'.$other[$psl], 'expired' => 1]));
        }

        return $this->redirect(Url::current(['expired' => 1]) );
    }

    public function adminExMsg()
    {
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();

        if($adminChat = \frontend\models\AdminChat::find()->where(['u_id' => Yii::$app->user->id])->andWhere(['msg' => 'Jūsų abonimento galiojimas baigėsi'])->orderBy(['id' => SORT_DESC])->one()){
            if($user->expires > $adminChat->timestamp){
                $model = new \frontend\models\AdminChat;

                $model->u_id = $user->id;
                $model->msg = 'Jūsų abonimento galiojimas baigėsi';
                $model->timestamp = time();
                $model->save(false);

                $user->adminChat++;
                $user->save(false);

            }
        }else{
            $model = new \frontend\models\AdminChat;

            $model->u_id = $user->id;
            $model->msg = 'Jūsų abonimento galiojimas baigėsi';
            $model->timestamp = time();
            $model->save(false);

            $user->adminChat++;
            $user->save(false);
        }

    }

    public function actionBlocked()
    {
        return $this->render('blocked');
    }

    public function naujokas()
    {
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        $user->expires = time() + 60 * 60 * 24;
        $user->save(false);
    }

    public function addOneViewOnProfile()
    {
        if(!isset($_GET['id'])){
            return $this->redirect(Url::to(['member/index']));
        }

        $model = new \frontend\models\Profileview;
        $model->addView($_GET['id']);
    }

    public function updateOnline()
    {
    	$session = new Session;
        $session->open();
        $last = $session['lastchecked'];

        if(time() - $last  > 60 * 10){
            $thisID = Yii::$app->user->identity->id;
            $user = User::find()->where(['id' => $thisID])->one();

            if($user){
                $user->lastOnline = time();
                $user->save();
            }

            $session['lastchecked'] = time();
        }

        return true;
    }

    public function actionCasualcheck()
    {
        $chat = new Chat;
        $friends = new \frontend\models\Friends;
        $favs = new \frontend\models\Favourites;
        $forum = new \frontend\models\Forum;
        $not_model = new \frontend\models\Notifications;

        $newMsg = $chat->isNew();

        $username = array();
        $message = array();

        foreach(Chat::isNew() as $chatterId){
            $user = User::find('username')->where(['id' => $chatterId])->one();
            $lastMsg = Chat::find('message')->where(['sender' => $chatterId])->andWhere(['reciever' => Yii::$app->user->id])->orderBy(['timestamp' => SORT_DESC])->one();
        
            $username[] = $user->username;
            $message[] = $lastMsg->message;
        }

        if(isset($user) && $user->firstMsg){
            $newMsg[] = 0;
        }

        $newDrg = ($newDrg = $friends::find()->where(['u_id' => Yii::$app->user->id])->one())? $newDrg->new : 0;

        $newMeg = ($newMeg = $favs::find()->where(['u_id' => Yii::$app->user->id])->one())? $newMeg->new : 0;

        $pakvietimaiKiti = \frontend\models\Pakvietimai::find()->where(['reciever' => Yii::$app->user->identity->id])->all();

        $notification = count($pakvietimaiKiti) + \frontend\models\LikesNot::notification();

        $forumas = $forum->find()->where(['u_id' => Yii::$app->user->id])->all();

        $forumNew = 0;

        foreach ($forumas as $forumasVienetas) {
            $forumNew = $forumNew + $forumasVienetas->new;
        }



        if(count($newMsg) > 1) {
            $newMsg = array_reverse($newMsg, true);
        }

        //var_dump($newMsg);

        /*if(count($username > 1))
            $username = array_reverse($username, true);

        if(count($message > 1))
            $message = array_reverse($message, true);*/

        $complete = [
            'newMsg' => $not_model::countNewMessages(Yii::$app->user->id),
            'newMsgId' => $newMsg,
            'usernames' =>  $username, 
            'messages' => $message, 
            'newDrg' => $newDrg,
            'newMeg' => $newMeg,  
            'forumNew' => $forumNew, 
            'notification' => $notification,  
            'url' => Url::to(['member/msg', 'id' => '']) 
        ];

        return json_encode($complete);
    }

    private function resendVerifEmail($user)
    {
        $to = $user->email;
        $subject = "Registracija";
        $url = Url::to([
            'site/verifyemail', 
            're' => 0,
            'arl' => Yii::$app->Security->generateRandomString(32),
            'sk' => Yii::$app->Security->generateRandomString(64),
            'gyp' => 'Yc7rmURCN23G',
            'ra' => $user->auth_key,
            'id' => $user->id,
        ], true);

        $message = "Kad patvirtintumėte registraciją spauskite šią nuorodą: 
                    <a href='".$url."'>Spausk čia!</a>";


        $mail = new Mail;
        $mail->sender = 'pazintys@pazintyslietuviams.co.uk';
        $mail->reciever = $to;
        $mail->subject = $subject;
        $mail->content = $message;
        $mail->timestamp = time();
        $mail->trySend();

    }

    public function actionNotactivated()
    {
        @extract($_GET);
        $error = null;

        $user = \frontend\models\User::find()->where(['id' => Yii::$app->user->id])->one();

        if(isset($psl) && $psl == "rs"){

            $this->resendVerifEmail($user);

        }elseif(isset($psl) && $psl == "ch"){

            if(isset($_POST)){
                @extract($_POST);

                if(isset($email)){
                    if(User::find()->where(['email' => $email])->one()){
                        $error['email'] = 'Toks el. paštas jau naudojamas.';
                    }else{
                        $user->email = $email;
                        $user->save(false);

                        $this->resendVerifEmail($user);
                    }

                    
                }



            }

            
        }

        return $this->render('notActivated', ['user' => $user, 'error' => $error]);
    }

    public function actionBacktoreg()
    {
        @extract($_GET);

        Yii::$app->user->logout();
        return $this->redirect(Url::to(['site/login', 'id' => $id, 're' => $re, 'ra' => $ra]));
    }

    public function actionIndex()
    {
        \frontend\models\Debug::run();

        $dataProvider = Feed::favsFeed();
        $dataNoobies = Feed::noobies();
        $model = new \frontend\models\LikesNot;
        $query = $model->find()->where(['u_id' => Yii::$app->user->id]);

        $limit = (isset($_GET['l'])) ? $_GET['l'] : 6;

        $dataProviderLikes = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $limit,
            ],
            'sort' => [
                'defaultOrder' => [
                    'timestamp' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index',[
            'dataProviderFeed' => $dataProvider,
            'dataProviderLikesFeed' => $dataProviderLikes,
            'dataNoobies' => $dataNoobies,
        ]);
    }

    public function actionSearch()
    {
        $psl = (isset($_GET['psl']))? $_GET['psl'] : "";

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if($psl == 'index'){
            return $this->actionSearchIndex();
        }elseif($psl == 'detail'){
            return $this->actionSearchDetail();
        }elseif($psl == 'new'){
            return $this->actionSearchNew();
        }elseif($psl == 'top'){
            return $this->actionSearchTop();
        }elseif($psl == 'topF'){
            return $this->actionSearchTopF();
        }elseif($psl == 'recommended'){
            return $this->actionSearchRecommended();
        }


        
    }

    public function actionSearchTopF(){
        $searchModel = new \frontend\models\TopFotos();

        //filtrus ideda i session
        $searchModel->preLoad();

        //pagamina dataprovideri
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearchTop()
    {
        $searchModel = new \frontend\models\SearchTopP();

        $searchModel->preLoad();

        //pagamina dataprovideri
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('search', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionSearchRecommended()
    {
        $searchModel = new RecommendedSearch();

        $info = \frontend\models\InfoClear::find()->where(['u_id' => Yii::$app->user->id])->one();

        $lytis = ($info->iesko == "vv" || $info->iesko == "vm")? "vyras" : "moteris";

        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        $user->new = 0;
        $user->save();

        if($info->orentacija == 1){
            if($lytis == "vyras"){
                $searchModel->moteris = 1;
            }else{
                $searchModel->vyras = 1;
            }
        }elseif ($info->orentacija == 2) {
            if($lytis == "vyras"){
                $searchModel->vyras = 1;
            }else{
                $searchModel->moteris = 1;
            }
        }

        $post = Yii::$app->request->post();
        if($post){
            Yii::$app->session['post'] = $post;
        }

        $dataProvider = $searchModel->search(Yii::$app->session['post']);

        return $this->render('search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearchIndex()
    {
        return $this->redirect(['member/search', 'psl' => 'detail']);
        
        $searchModel = new UserSearch();

        //filtrus ideda i session
        $post = Yii::$app->request->post();
        if($post){
            Yii::$app->session['post'] = $post;
        }

        //pagamina dataprovideri
        $dataProvider = $searchModel->search(Yii::$app->session['post'], 0);

        return $this->render('search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearchNew()
    {
        $searchModel = new \frontend\models\SearchSimpleP();

        $searchModel->ugis1 = 0;
        $searchModel->ugis2 = 122;
        $searchModel->svoris1 = 0;
        $searchModel->svoris2 = 143;
       /*$searchModel->rs = 1;
        $searchModel->ts = 1;
        $searchModel->se = 1;
        $searchModel->f = 1;
        $searchModel->sl = 1;
        $searchModel->s = 1;
        $searchModel->i = 1;
        $searchModel->l = 1;
        $searchModel->tu = 1;
        $searchModel->ve = 1;
        $searchModel->ve2 = 1;
        $searchModel->is = 1;
        $searchModel->na = 1;*/

        //pagamina dataprovideri
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('search', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionSearchDetail()
    {
        $searchModel = new \frontend\models\DetailSearchP();

        $searchModel->rs = 1;
        $searchModel->ts = 1;
        $searchModel->se = 1;
        $searchModel->f = 1;
        $searchModel->sl = 1;
        $searchModel->s = 1;
        $searchModel->i = 1;
        $searchModel->l = 1;
        $searchModel->tu = 1;
        $searchModel->ve = 1;
        $searchModel->ve2 = 1;
        $searchModel->is = 1;
        $searchModel->na = 1;

        $searchModel->preLoad();

        //pagamina dataprovideri
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('search', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionUser()
    {
        if(isset($_GET['id']) && $_GET['id'] == Yii::$app->user->id){
            return $this->redirect(['member/index']);
        }

        $chat = new Chat;

        if($post = Yii::$app->request->post()){
            if(Expired::prevent()){
                $this->expired();
            }else{
                $chat = new Chat;

                if(isset($post['ajax']) && $post['ajax'] == 1){

                    $user = Yii::$app->user->identity;
                    $gavejoUser = UserPack::find()->where(['id' => $post['otherID']])->one();

                    $chat->tryEmail($user, $gavejoUser);
                    $chat->sendMsg($post['otherID'], $post['data']);

                    \frontend\models\Statistics::addSent();
                    \frontend\models\Statistics::addRecieved($post['otherID']);

                    $not = new \frontend\models\Chatnot;
                    $not->insertNot($chat->reciever);

                    return $this->render('user');
                }
            }

        }else{
            return $this->render('user');
        }
    }

    public function actionUpdatechat()
    {
        $chat = new Chat;

        $thisID = Yii::$app->user->id;
        $otherID = $_POST['otherID'];

        $messages = $chat::find()->where(['and', ['or', 'sender = '.$thisID , 'reciever = '.$thisID], ['or', 'sender = '.$otherID , 'reciever = '.$otherID]])
                                ->andWhere(['newID' => Yii::$app->user->id])
                                ->andWhere(['not', ['dontShow' => Yii::$app->user->id]])
                                ->all();

        \frontend\models\Chatnot::remove($_POST['otherID']);

        if($messages){
            $i = 0;

            foreach($messages as $message){
                $manoMsg = ($message->sender == $thisID)? true: false;

                $div = ($manoMsg)? "myCloud" : "yourCloud";
                $id = ($manoMsg)? $thisID : $otherID;

                if($manoMsg){
                    $avatar = \frontend\models\Misc::getMyAvatar();
                }else{
                    $user = User::find()->where(['id' => $otherID])->one();
                    $avatar = \frontend\models\Misc::getAvatar($user);
                }
                
                $message->newID = 0;
                $message->save(false);

                $complete[$i] = (['number' => count($messages), 'message' => $message->message, 'div' => $div, 'id' => $id, 'avatar' => $avatar]);
                $i++;
            }
            return json_encode($complete);
        }

        return json_encode([]);

    }

    public function actionAddtofriends()
    {
        if(!Expired::prevent()){
            $model = new \frontend\models\Pakvietimai;
            $modelFriends = new \frontend\models\Friends;

            if(!$model->find()->where(['sender' => Yii::$app->user->id, 'reciever' => $_GET['id']])->one()){

                $model->sender = Yii::$app->user->id;
                $model->reciever = $_GET['id'];
                $model->timestamp = time();
                $model->save();
            }

            if($friends = $modelFriends->find()->where(['u_id' => $_GET['id']])->one()){
                $friends->new++;
                $friends->save();
            }else{
                $modelFriends->u_id = $_GET['id'];
                $modelFriends->new = 1;
                $modelFriends->save();
            }


            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionCancelinvitation()
    {
        if(!Expired::prevent()){

            $model = new \frontend\models\Pakvietimai;

            if($user = $model->find()->where(['sender' => Yii::$app->user->identity->id, 'reciever' => $_GET['id']])->one()){
                $user->delete();
            }

            return $this->redirect(Yii::$app->request->referrer);

        }
    }

    public function actionAcceptinvitation()
    {
        if(!Expired::prevent()){

            $model = new \frontend\models\Pakvietimai;
            $draugai = new \frontend\models\Friends;

            if($user = $draugai->find()->where(['u_id' => Yii::$app->user->identity->id])->one()){
                $user->friends = $user->friends.' '.$_GET['id'];
                $user->save();
            }else{
                $draugai->u_id = Yii::$app->user->identity->id;
                $draugai->friends = $_GET['id'];
                $draugai->insert();
            }

            if($user = $draugai->find()->where(['u_id' => $_GET['id']])->one()){
                $user->friends = $user->friends.' '.Yii::$app->user->identity->id;
                $user->new++;
                $user->save();
            }else{
                $draugai->u_id = $_GET['id'];
                $draugai->friends = Yii::$app->user->identity->id;
                $draugai->new++;
                $draugai->insert();
            }

            if($user = $model->find()->where(['reciever' => Yii::$app->user->identity->id, 'sender' => $_GET['id']])->one()){
                $user->delete();
            }


            Feed::tapoDraugais(Yii::$app->user->id, $_GET['id']);

            return $this->redirect(Yii::$app->request->referrer);

        }
    }

    public function actionDeclineinvitation()
    {
        if(!Expired::prevent()){
            $model = new \frontend\models\Pakvietimai;

            if($user = $model->find()->where(['reciever' => Yii::$app->user->identity->id, 'sender' => $_GET['id']])->one()){
                $user->delete();
            }

            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionFriends()
    {
        $searchModel = new UserSearch();
        $modelFriends = new \frontend\models\Friends;
        $dataProvider = $searchModel->searchFriends(Yii::$app->request->post());

        if(isset($_GET['psl']) && $_GET['psl'] == "news"){
            
            $dataProvider2 = Feed::friendsFeed();

            return $this->render('friends', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dataProvider2' => $dataProvider2,
            ]);

        }else{
            if($friends = $modelFriends->find()->where(['u_id' => Yii::$app->user->id])->one()){
                $friends->new = 0;
                $friends->save();
            }


            return $this->render('friends', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }  

    }

    public function actionSettings()
    {
        $model = new \frontend\models\UserChange;

        if(Yii::$app->request->post()){

            $model->scenario = Yii::$app->request->post()['name'];

            if(Yii::$app->request->post()['name'] == 'pass'){
                if($model->PasswordChange(Yii::$app->request->post())){
                    $model = new \frontend\models\UserChange;
                }

            }elseif(Yii::$app->request->post()['name'] == 'email'){
                if($model->EmailChange(Yii::$app->request->post())){
                    $model = new \frontend\models\UserChange;
                }
            }

        }

        return $this->render('settings', ['model' => $model]);
    }

    public function actionFavs()
    {
        $model = new \frontend\models\Favourites;

        $psl = (isset($_GET['psl']))? $_GET['psl'] : "";

        if($favs = $model::find()->where(['u_id' => Yii::$app->user->id])->one()){
            $favs->new = 0;
            $favs->save();
        }

        if($psl){
            return $this->drauguNaujienos();
        }else{
            return $this->visosNaujienos();
        }

        
    }

    public function drauguNaujienos()
    {
        $model = new \frontend\models\Favourites;
        $dataProvider = $model->maneMegsta();

        return $this->render('favourites',[
                'dataProvider' => $dataProvider,
            ]);
    }

    public function visosNaujienos()
    {
        $model = new \frontend\models\Favourites;
        $dataProvider = $model->manoFavourites();

        return $this->render('favourites',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRemovefromfavs()
    {
        $model = new \frontend\models\Favourites;
        $model = $model::find()->where(['u_id' => Yii::$app->user->id])->one();

        $favourites = explode(' ', $model->favs_id);

        if(($key = array_search($_GET['id'], $favourites)) !== false) {
            unset($favourites[$key]);
        }

        $complete = implode(" ", $favourites);

        $model->favs_id = $complete;
        $model->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionMsg()
    {
        if(isset($_GET['id']) && $_GET['id'] == Yii::$app->user->id){
            return $this->redirect(['member/msg']);
        }elseif(isset($_GET['id']) && $_GET['id'] != 'admin'){
            if(!$other = UserPack::find()->where(['id' => $_GET['id']])->one())
                return $this->redirect(['member/msg']);
        }

        $other = (isset($other))? $other : null;

        $post = Yii::$app->request->post();

        $searchModel = new \frontend\models\Chatters();
        $dataProvider = $searchModel->searchPokalbiai(Yii::$app->request->post());


        if($post = Yii::$app->request->post()){
            if(Expired::prevent()){
                $this->expired();
            }else{
                $chat = new Chat;

                if(isset($post['ajax']) && $post['ajax'] == 1){

                    $user = Yii::$app->user->identity;
                    $gavejoUser = UserPack::find()->where(['id' => $post['otherID']])->one();

                    $chat->tryEmail($user, $gavejoUser);
                    $chat->sendMsg($post['otherID'], $post['data']);

                    \frontend\models\Statistics::addSent();
                    \frontend\models\Statistics::addRecieved($post['otherID']);

                    $not = new \frontend\models\Chatnot;
                    $not->insertNot($chat->reciever);

                    return $this->render('msg', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);
                }
            }

        }

        return $this->render('msg', [
            'user' => $other,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        //return $this->render('msg');
    }

    public function actionDeletechat()
    {
        $model = new Chat;

        $id = (isset($_GET['id']))? $_GET['id'] : "";
        $id2 = (isset($_GET['id2']))? $_GET['id2'] : "";
        $who = (isset($_GET['who']))? $_GET['who'] : "";

        if($who == "both"){
            if($id && $id2){
                $chat = $model::deleteAll(['and', ['or', 'sender = '.$id , 'reciever = '.$id], ['or', 'sender = '.$id2 , 'reciever = '.$id2]]);
            }
        }elseif($who == "reciever"){
            if($id){
                $chat = $model::find()->where(['reciever' => $id])->all();
                $chat->delete();
            }
        }elseif($who == "sender"){
            if($id){
                $chat = $model::find()->where(['sender' => $id])->all();
                $chat->delete();
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDelete()
    {
        if(\frontend\models\Misc::iga()){
            @extract($_GET);

            $model = $class::find()->where([$k => $v])->one();
            $model->delete();
        }else{
            throw new \yii\web\HttpException(403, 'Jūs neturite prieigos prie šio puslapio.');
        }
        

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAddtofavs()
    {
        if(!Expired::prevent()){
            $favs = new \frontend\models\Favourites;

            if($favourites = $favs::find()->where(['u_id' => Yii::$app->user->id])->one()){
                $favourites->favs_id = $favourites->favs_id.$_GET['id']." ";
                $favourites->save(false);
            }else{
                $favs->u_id = Yii::$app->user->id;
                $favs->favs_id = $_GET['id']." ";
                $favs->save(false);
            }

            $favourites = null;
            $favs = new \frontend\models\Favourites;

            if($favourites = $favs::find()->where(['u_id' => $_GET['id']])->one()){
                $favourites->new++;
                $favourites->save();
            }else{
                $favs->u_id = $_GET['id'];
                $favs->new = 1;
                $favs->save();
            }


           return $this->redirect(Yii::$app->request->referrer);
       }
    }

    public function actionMyfoto()
    {

        $psl = (isset($_GET['psl']))? $_GET['psl'] : "";

        if($psl == "changePPic"){
            return $this->changePPic();
        }elseif($psl == "newAlbum"){
            return $this->newAlbum();
        }elseif($psl == "newFoto"){
            return $this->newFoto();
        }elseif($psl == "c"){
            return $this->profileFotos();
        }else{
            $model = new \frontend\models\Albums;

            $dataProvider = $model->Albums(Yii::$app->user->id);

            return $this->render('myfoto/index', ['dataProvider' => $dataProvider]);
        }
        
    }

    /*public dovanosFotos()
    {
        # code...
    }*/

    public function changePPic()
    {
        $model = new \frontend\models\Albums;
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();


        $model->file = UploadedFile::getInstance($model, 'file');

        $didChange = $model->saveToProfile(Yii::$app->user->id, 'profile');

        if($didChange['ext']){
            $user->avatar = $didChange['ext'];
            $user->save();
        }

        if($didChange['complete']){
            Feed::pakeitePPic(Yii::$app->user->id);
        }

        header('Cache-Control: no-cache');
        header('Pragma: no-cache');

        return $this->render('myfoto/index', ['UploadForm' => $model]);
    }

    public function newAlbum()
    {
        $model = new \frontend\models\Albums;

        $model->load(Yii::$app->request->post());

        $model->file = UploadedFile::getInstance($model, 'file');
        $create = $model->albumCoverNew(Yii::$app->user->id);

        $albumName = $model->name;

        if($create[0] && $create[1]){
            $model = new $model;

            if(!$model::find()->where(['and', ['u_id' => Yii::$app->user->id, 'name' => $albumName]])->one()){

                $model->u_id = Yii::$app->user->id;
                $model->name = $albumName;
                $model->cover = $create['ext'];
                $model->timestamp = time();
                $model->insert();

                Yii::$app->session->setFlash('success');

                Feed::newAlbum(Yii::$app->user->id, $albumName);

            }

        }

        
        return $this->render('myfoto/index', ['model' => $model]);
    }

    public function newFoto()
    {
        $this->enableCsrfValidation = false;
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();

        if($user->photoLimit < 5){
            $user->photoLimit = 5;
            $user->save();
        }

        $files = (count(\yii\helpers\BaseFileHelper::findFiles("uploads/".$user->id."/"))) / 2;

        $model = new \frontend\models\Albums;
        $model->preCheck(Yii::$app->request->post());

        if($user->photoLimit > $files){

            $model->name = "1";

            $model->file = UploadedFile::getInstance($model, 'file');
            $create = $model->fotoNew(Yii::$app->user->id);

            if($create[0] !== false && $create[1] !== false){      
                Feed::newFoto(Yii::$app->user->id, $create['n'], $create['d']);
            }
        }else{
            return $this->redirect(Url::to(['member/myfoto', 'psl' => 'limit']));
            Yii::$app->session->setFlash('danger', 'Jūs pasiekėte nuotraukų limitą');
        }      

        return $this->render('myfoto/index', ['model' => $model]);
    }

    public function profileFotos()
    {
        $model = new \frontend\models\Albums;

        $dataProvider = $model->Albums(Yii::$app->user->id."/1");

        return $this->render('myfoto/index', ['dataProvider' => $dataProvider]);
    }

    public function actionDeletefoto()
    {
        $file = (isset($_GET['file']))? $_GET['file'] : "";

        if($file){
            $model = new \frontend\models\filterFileName;

            $pieces = explode("/", $file);

            if($pieces[1] == Yii::$app->user->id){

                unlink($file);
                unlink($model->filter($file));
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionChooseppic()
    {
        $file = (isset($_GET['file']))? $_GET['file'] : "";

        if($file){
            $model = new \frontend\models\filterFileName;

            $pieces = explode("/", $file);

            if($pieces[1] == Yii::$app->user->id){

                $filename = (strlen($pieces[2]) >= 10)? $pieces[2] : $pieces[3];

                $albums = new \frontend\models\Albums;
                $extension = new \frontend\models\getPhotoList;

                $user = User::find()->where(['id' => Yii::$app->user->id])->one();

                $extension = $extension->nameExtraction($filename);

                if($user->avatar != $extension['ext']){
                    $user->avatar = $extension['ext'];
                    $user->save();
                }

                $albums->choosePPic(Yii::$app->user->id, $file, $extension['ext']);


            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionMovetoalbum()
    {
        $newAlbum = $_GET['albmn'];
        $file = $_GET['file'];


        $model = new \frontend\models\filterFileName;

        $model->filter($file);

        rename("uploads/".Yii::$app->user->id."/".$file, "uploads/".Yii::$app->user->id."/".$newAlbum."/".$file);
        rename("uploads/".Yii::$app->user->id."/".$model->filter($file), "uploads/".Yii::$app->user->id."/".$newAlbum."/".$model->filter($file));

        return $this->redirect(Url::to(['member/myfoto']));
    }

    public function actionCaname()
    {
        $model = new \frontend\models\Albums;

        $model = $model::find()->where(['id' => $_GET['id']])->one();

        if(Yii::$app->request->post()){
            $fixed = Inflector::slug(Yii::$app->request->post()['Albums']['name'], '' , false );

            rename("uploads/".Yii::$app->user->id."/".$model->name, "uploads/".Yii::$app->user->id."/".$fixed);

            $model->name = $fixed;
            $model->save();

            Yii::$app->session->setFlash('success');
        }


        return $this->render('myfoto/index', ['fromController' => 'caname', 'AlbumsModel' => $model]);
    }

    public function actionCac()
    {
        $model = new \frontend\models\Albums;

        $model = $model::find()->where(['id' => $_GET['id']])->one();

        $model->file = UploadedFile::getInstance($model, 'file');
        $change = $model->ChangeAlbumCover($model);

        return $this->render('myfoto/index', ['fromController' => 'cac', 'AlbumsModel' => $model]);
    }

    function deleteDirectory($dirPath) {
        if (is_dir($dirPath)) {
            $objects = scandir($dirPath);
            foreach ($objects as $object) {
                if ($object != "." && $object !="..") {
                    if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                        deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                    } else {
                        unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                    }
                }
            }
        reset($objects);
        rmdir($dirPath);
        }
    }

    public function actionDa()
    {
        $model = new \frontend\models\Albums;

        $model = $model::find()->where(['id' => $_GET['id']])->one();


        $this->deleteDirectory("uploads/".Yii::$app->user->id."/".$model->name);

        $model->delete();

        $modelPre = new \frontend\models\Albums;

        $dataProvider = $modelPre->Albums(Yii::$app->user->id);

        return $this->render('myfoto/index', ['dataProvider' => $dataProvider]);
    }

    public function actionFotos()
    {
        $model = new \frontend\models\Albums;

        $dataProvider = $model->Albums($_GET['id']);

        return $this->render('fotos/index', ['dataProvider' => $dataProvider]);
    }

    public function actionFotosalbumview()
    {
        return $this->render('fotos/albumView');
    }

    public function actionIlookfor()
    {
        $model = new \frontend\models\Ilookfor;

        //$model = $model::find()->where(['u_id' => Yii::$app->user->id])->one();

        if(!$model::find()->where(['u_id' => Yii::$app->user->id])->one()){
            $model->u_id = Yii::$app->user->id;
            $model->insert();
            Feed::editIesko(Yii::$app->user->id);
        }else{

            $model = $model::find()->where(['u_id' => Yii::$app->user->id])->one();

            if($info = (isset(Yii::$app->request->post()['Ilookfor']))? Yii::$app->request->post()['Ilookfor'] : null){
                $model->load(Yii::$app->request->post());

                if($info['gimtine'] != 126){
                   $model->tautybe = $info['tautybe2']; 
                }

                if($info['religija'] == 9){
                   $model->religija = $info['religija2']; 
                }elseif($info['religija'] == ""){
                    $model->religija = $info['religija2'];
                }

                if($info['pareigos'] == 25){
                   $model->pareigos = $info['pareigos2']; 
                }elseif($info['pareigos'] == ""){
                    $model->pareigos = $info['pareigos2'];
                }

                if($info['plaukai'] == 7){
                   $model->plaukai = $info['plaukai2']; 
                }elseif($info['plaukai'] == ""){
                    $model->plaukai = $info['plaukai2'];
                }

                if($info['akys'] == 4){
                   $model->akys = $info['akys2']; 
                }elseif($info['akys'] == ""){
                    $model->akys = $info['akys2'];
                }

                if($info['stilius'] == 17){
                   $model->stilius = $info['stilius2']; 
                }elseif($info['stilius'] == ""){
                    $model->stilius = $info['stilius2'];
                }

                if($info['miestas'] != '0'){
                    $model->drajonas = "";
                    $model->grajonas = "";
                }

                $model->save();
                Feed::editIesko(Yii::$app->user->id);
            }
        }
     
        return $this->render('iLookFor', ['model' => $model]);  
    }

    public function actionManoanketa()
    {
        $model = new \frontend\models\Info;
        $error = null;

        $model = $model::find()->where(['u_id' => Yii::$app->user->id])->one();

        if($info = (isset(Yii::$app->request->post()['Info']))? Yii::$app->request->post()['Info'] : null){
            $model->scenario = "iLookFor";
            $model->load(Yii::$app->request->post());

            $date = new \DateTime($model->metai."-".$model->menuo."-".$model->diena);
            
            $model->gimimoTS = $date->getTimestamp();

            $post = Yii::$app->request->post();

            $at = $post['age_from']."-".$post['age_to'];
            $model->amzius_tarp = $at;

            if(Yii::$app->user->identity['username'] != $post['username']){
                $user = User::find()->where(['id' => Yii::$app->user->id])->one();


                if(User::find()->where(['username' => $post['username']])->one()){
                    $error['username'] = 'Toks slapyvardis jau naudojamas';
                }elseif(strlen($post['username']) < 4){
                    $error['username'] = 'Slapyvardį turi sudaryti bent 4 raidės';
                }else{
                    $user->username = $post['username'];
                    $user->save(false); 
                }
                
            } 

            if($info['gimtine'] != 126){
               $model->tautybe = $info['tautybe2']; 
            }

            if($info['religija'] == 9){
               $model->religija = $info['religija2']; 
            }elseif($info['religija'] == ""){
                $model->religija = $info['religija2'];
            }

            if($info['pareigos'] == 25){
               $model->pareigos = $info['pareigos2']; 
            }elseif($info['pareigos'] == ""){
                $model->pareigos = $info['pareigos2'];
            }

            if($info['plaukai'] == 7){
               $model->plaukai = $info['plaukai2']; 
            }elseif($info['plaukai'] == ""){
                $model->plaukai = $info['plaukai2'];
            }

            if($info['akys'] == 4){
               $model->akys = $info['akys2']; 
            }elseif($info['akys'] == ""){
                $model->akys = $info['akys2'];
            }

            if($info['stilius'] == 17){
               $model->stilius = $info['stilius2']; 
            }elseif($info['stilius'] == ""){
                $model->stilius = $info['stilius2'];
            }

            if($info['miestas'] != 0){
                $model->drajonas = "";
                $model->grajonas = "";
            }

            $model->save();

            Feed::editAnketa(Yii::$app->user->id);
        }
        

        return $this->render('manoAnketa', ['model' => $model, 'error' => $error]);  

        
    }

    public function actionIesko()
    {
        $model = new \frontend\models\Ilookfor;
        if(!isset($_GET['id'])){
            return $this->goBack();
        }

        $model = $model::find()->where(['u_id' => $_GET['id']])->one();

        return $this->render('iesko', ['model' => $model]);
    }

    public function actionStatistika()
    {
        $psl = (isset($_GET['psl']))? $_GET['psl'] : '';
        
        $model = new \frontend\models\Statistics;
        $model->setID();

        if($psl){
            $dataProfider = $this->{'Statistika'.$psl}();

            return $this->render('statistika', ['dataProvider' => $dataProfider, 'model' => $model]);
        }

        return $this->render('statistika', ['model' => $model]);
    }

    public function StatistikaViews()
    {
        $model = new \frontend\models\Profileview;

        return $model->getViewers();
    }

    public function StatistikaPop()
    {
        //$model = new \frontend\models\Pop;

        return [];
    }

    public function StatistikaForum()
    {
        $model = new \frontend\models\Statistics;
        $model->setID();

        return [$model->openedForums(), $model->atsForums()];
    }

    public function StatistikaMsg()
    {
        //$model = new \frontend\models\Pop;

        return [];
    }

    public function actionAnketa()
    {
        $model = new \frontend\models\InfoClear;
        if(!isset($_GET['id'])){
            return $this->goBack();
        }

        $model = $model::find()->where(['u_id' => $_GET['id']])->one();

        return $this->render('anketa', ['model' => $model]);
    }

    public function actionLikeit()
    {
        if($n = $_GET['photoName']){
            $extract = new \frontend\models\getPhotoList;

            $extract = $extract::nameExtraction($n);

            $model = new \frontend\models\Likes;
            $modelNot = new \frontend\models\LikesNot;

            if(!$model::find()->where(['user_id' => $extract['ownerId']])->andWhere(['photo_name' => $n])->andWhere(['givenBy' => Yii::$app->user->id])->one()){

                $model->user_id = $extract['ownerId'];
                $model->photo_name = $n;
                $model->givenBy = Yii::$app->user->id;
                $model->timestamp = time();
                $model->insert();

                $modelNot->u_id = $extract['ownerId'];
                $modelNot->giver_id = Yii::$app->user->id;
                $modelNot->object = 'foto';
                $modelNot->o_info = $n;
                $modelNot->timestamp = time();
                $modelNot->new = 1;
                $modelNot->insert();

                \frontend\models\Statistics::addLike($extract['ownerId']);

            }
        }
        
        
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionComment()
    {

        if(!Yii::$app->user->identity->vip){
            $this->restrictNotVip('comment');
        }else {

            $model = new \frontend\models\Comments;
            $modelNot = new \frontend\models\LikesNot;

            $object = (isset($_GET['object'])) ? $_GET['object'] : "";
            $name = (isset($_GET['name'])) ? $_GET['name'] : "";
            $u_id = (isset($_GET['u_id'])) ? $_GET['u_id'] : "";
            $comment = Yii::$app->request->post()['Comments']['comment'];

            $model->u_id = $u_id;
            $model->object = $object;
            $model->commented_on = $name;
            $model->commented_by = Yii::$app->user->id;
            $model->comment = $comment;
            $model->timestamp = time();
            $model->save();

            if ($u_id != Yii::$app->user->id) {
                $modelNot->u_id = $u_id;
                $modelNot->giver_id = Yii::$app->user->id;
                $modelNot->object = 'comment';
                $modelNot->o_info = $name;
                $modelNot->timestamp = time();
                $modelNot->new = 1;
                $modelNot->insert();
            }


            return $this->redirect(Url::to(Yii::$app->request->referrer) . "&phover=1");
        }
    }

    public function actionChatallsearch()
    {
        $searchModel = new UserSearch();

        $dataProvider = $searchModel->byUsername($_POST['username']);

        return $this->renderPartial('_randomLineUpdate',[
            'dataProvider' => $dataProvider,
            'username' => $_POST['username'],
        ]);
    }

    public function actionChatchatterssearch()
    {
        $searchModel = new \frontend\models\Chatters;
        $searchModel->username = $_GET['username'];
        $dataProvider = $searchModel->searchPokalbiai(Yii::$app->request->post());

        return $this->renderPartial('_pasnekovaiUpdate',[
            'dataProvider' => $dataProvider,
            'username' => $_GET['username'],
            'current' => $_GET['current'],
        ]);
    }

    public function actionMirkt()
    {
        if(!Expired::prevent()){
            if($_GET['to'] != Yii::$app->user->id){
                $model = new Chat;
                $user = Yii::$app->user->identity;

                $time = time();

                $lastMirkt = $model->find()->where(['sender' => Yii::$app->user->id, 'reciever' => $_GET['to'], 'extra' => 'mirkt 1'])->orderBy(['timestamp' => SORT_DESC])->one();

                $skirtumas = (isset($lastMirkt))? time() - $lastMirkt->timestamp : 61;

                if($skirtumas > 60 ||isset($_GET['id'])){

                    $model->sender = Yii::$app->user->id;
                    $model->reciever = $_GET['to'];
                    $model->timestamp = $time;
                    $model->message = "-%necd%%".$user->username." jums mirktelėjo akį! <a style='border-bottom: 1px solid black;' href='".Url::to(['member/mirkt', 'to' => Yii::$app->user->id, 'id' => $time])."'>Mirktelti atgal.</a>";
                    $model->dontShow = Yii::$app->user->id;
                    $model->newID = $_GET['to'];
                    $model->extra = "mirkt 1";
                    $model->sVip = Yii::$app->user->identity->vip;
                    $model->save(false);

                    $model = new Chat;
                    $model->sender = Yii::$app->user->id;
                    $model->reciever = $_GET['to'];
                    $model->timestamp = $time;
                    $model->message = "-%necd%%<span style='color: #7A7A7A'>Jūs mirktelėjote akį!</span>";
                    $model->dontShow = $_GET['to'];
                    $model->newID = $_GET['to'];
                    $model->extra = "mirkt 1";
                    $model->save(false);


                    Yii::$app->session->setFlash('success');

                }else{
                    Yii::$app->session->setFlash('error', 'Jūs neseniai mirktelėjote');
                }

                if(isset($_GET['id'])){
                    $user = User::find()->where(['id' => $_GET['to']])->one();
                    $model::updateAll(['message' => "-%necd%%".$user->username." jums mirktelėjo akį!", 'extra' => 'mirkt 0'], ['timestamp' => $_GET['id'], 'sender' => $_GET['to']]);
                    //$model->find()->where(['timestamp' => $_GET['id'], 'sender' => $_GET['to']])->all();
                }
            }

        
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionGetusermodel()
    {
        $model = new User;
        $user = $model::find()->where(['username' => $_POST['name']])->one();

        $infoSource = new \frontend\models\InfoClear;
        $info = $infoSource::find()->where(['u_id' => $user->id])->one();

        require(__DIR__ ."/../views/site/form/_list.php");

        $metai = time() - $info->gimimoTS;

        $arDraugas = \frontend\models\Friends::arDraugas($user->id);


        $complete['arDraugas'] = ($arDraugas !== false)? 1 : 0;
        $complete['miestas'] = ($info->miestas)? $list[$info->miestas] : 'nenustatyta';
        $complete['metai'] = date('Y', $metai) - 1970;
        $complete['id'] = $user->id;
        $complete['avatar'] = $user->avatar;
        $complete['vip'] = ($user->vip)? 'VIP' : '';
        

        return json_encode($complete);
    }

    public function actionExecutepayment(){

        return $this->render('executepayment');
    }

    public function actionGetppapplink()
    {
        require __DIR__ . '/../../vendor/paypal/rest-api-sdk-php/sample/bootstrap.php';

        if(isset($_GET['obj'])){

            $payer = new Payer();
            $payer->setPaymentMethod("paypal");

            $obj = $_GET['obj'];
            if($obj == 114411){
                $item1 = new Item();
                $item1->setName('Abonimento Pratęsimas')
                    ->setCurrency('GBP')
                    ->setQuantity(1)
                    ->setSku("1") // Similar to `item_number` in Classic API
                    ->setPrice(0.01);

                $itemList = new ItemList();
                $itemList->setItems(array($item1));

                $details = new Details();
                $details->setSubtotal(0.01);

                $amount = new Amount();
                $amount->setCurrency("GBP")
                    ->setTotal(0.01)
                    ->setDetails($details);

            }elseif($obj == 1){
                $item1 = new Item();
                $item1->setName('Abonimento Pratęsimas')
                    ->setCurrency('GBP')
                    ->setQuantity(1)
                    ->setSku("1") // Similar to `item_number` in Classic API
                    ->setPrice(7);

                $itemList = new ItemList();
                $itemList->setItems(array($item1));

                $details = new Details();
                $details->setSubtotal(7);

                $amount = new Amount();
                $amount->setCurrency("GBP")
                    ->setTotal(7)
                    ->setDetails($details);

            }elseif($obj == 2){
                $item1 = new Item();
                $item1->setName('Abonimento Pratęsimas')
                    ->setCurrency('GBP')
                    ->setQuantity(1)
                    ->setSku("2") // Similar to `item_number` in Classic API
                    ->setPrice(14);

                $itemList = new ItemList();
                $itemList->setItems(array($item1));

                $details = new Details();
                $details->setSubtotal(14);

                $amount = new Amount();
                $amount->setCurrency("GBP")
                    ->setTotal(14)
                    ->setDetails($details);
            }elseif($obj == 3){
                $item1 = new Item();
                $item1->setName('Abonimento Pratęsimas')
                    ->setCurrency('GBP')
                    ->setQuantity(1)
                    ->setSku("3") // Similar to `item_number` in Classic API
                    ->setPrice(21);

                $itemList = new ItemList();
                $itemList->setItems(array($item1));

                $details = new Details();
                $details->setSubtotal(21);

                $amount = new Amount();
                $amount->setCurrency("GBP")
                    ->setTotal(21)
                    ->setDetails($details);
            }elseif($obj == 4){
                $item1 = new Item();
                $item1->setName('Abonimento Pratęsimas')
                    ->setCurrency('GBP')
                    ->setQuantity(1)
                    ->setSku("4") // Similar to `item_number` in Classic API
                    ->setPrice(29);

                $itemList = new ItemList();
                $itemList->setItems(array($item1));

                $details = new Details();
                $details->setSubtotal(29);

                $amount = new Amount();
                $amount->setCurrency("GBP")
                    ->setTotal(29)
                    ->setDetails($details);
            }


            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription('Abonimento Pratęsimas (description)')
                ->setInvoiceNumber(uniqid());

            $baseUrl = getBaseUrl();
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(Url::to(['member/executepayment', 'success' => 'true', 'i' => Yii::$app->user->id], true))
                ->setCancelUrl(Url::to(['member/executepayment', 'success' => 'false', 'i' => Yii::$app->user->id], true));

            $payment = new Payment();
            $payment->setIntent("sale")
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions(array($transaction));

            $payment->create($apiContext);
            $approvalUrl = $payment->getApprovalLink();

            echo $approvalUrl;
        }
    }

    public function actionZodis()
    {
        $model = new \frontend\models\InfoClear;
        $info = $model::find()->where(['u_id' => Yii::$app->user->id])->one();


        $info->load(Yii::$app->request->post());
        $info->save(false);

        if($info->save(false) && Yii::$app->request->post()){
            Feed::pakeiteZodi(Yii::$app->user->id);
        }
        

        return $this->render('zodis', ['model' => $info]);
    }

    public function actionForum()
    {
        return $this->render('forum');
    }

    public function actionPost()
    {
        $id = (isset($_GET['id']))? $_GET['id'] : '';

        if($id){
            $model = new \frontend\models\Post;
            $modelForum = new \frontend\models\Forum;

            $forum = $modelForum::find()->where(['id' => $id])->one();

            if(!$forum)
                return $this->redirect(['member/forum']);
            $forum->addView();

            if($forum->new > 0){
                $forum->new = 0;
                $forum->save(false);
            }

            if($post = $model->find()->where(['forum_id' => $id])){
                $provider = new ActiveDataProvider([
                    'query' => $post,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ]);
                return $this->render('post', ['dataProvider' => $provider]);
            }else{
                return $this->redirect(['member/forum']);
            }

        }else{
            return $this->redirect(['member/forum']);
        }

    }

    public function actionForumats()
    {
        $model = new \frontend\models\Post;

        $id = (isset($_GET['id']))? $_GET['id'] : '';

        if(Yii::$app->request->post()){
            if($id){
                $model->load(Yii::$app->request->post());
                $model->atsakyti();

                \frontend\models\Statistics::addForum();
            }
        }

        return $this->render('forumAts');
    }

    public function actionForumnew()
    {
        $model = new \frontend\models\Forum;

        if(Yii::$app->request->post()){
            $model->load(Yii::$app->request->post());
            $save = $model->kurti();

            \frontend\models\Statistics::addForum();

            if($save){
                return $this->redirect(['member/post', 'id' => $save]);
            }
        }

        return $this->render('forumNew', ['model' => $model]);
    }

    public function actionCheck()
    {
        $model = new \frontend\models\CheckedForums;

        $id = (isset($_GET['id']))? $_GET['id'] : '';

        if($check = $model::find()->where(['u_id' => Yii::$app->user->id])->one()){
            $check->forum_ids = $check->forum_ids." ".$id;
            $check->save(false);
        }else{
            $model->u_id = Yii::$app->user->id;
            $model->forum_ids = $id;
            $model->insert(false);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUncheck()
    {
        $model = new \frontend\models\CheckedForums;

        $id = (isset($_GET['id']))? $_GET['id'] : '';

        $check = $model::find()->where(['u_id' => Yii::$app->user->id])->one();

        $checked = explode(' ', $check->forum_ids);

        if(($key = array_search($id, $checked)) !== false) {
            unset($checked[$key]);
        }

        $complete = implode(" ", $checked);

        $check->forum_ids = $complete;
        $check->save(false);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUnfriend()
    {
        $model = new \frontend\models\Friends;

        $id = (isset($_GET['id']))? $_GET['id'] : '';

        $check = $model::find()->where(['u_id' => Yii::$app->user->id])->one();

        $friends = explode(' ', $check->friends);

        if(($key = array_search($id, $friends)) !== false) {
            unset($friends[$key]);
        }

        $complete = implode(" ", $friends);

        $check->friends = $complete;
        $check->save(false);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDuk()
    {
        
        return $this->render('duk');
    }

    public function actionHelp()
    {
        $model = new \frontend\models\ContactForm;
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();

        if($post = Yii::$app->request->post()){
            $model->load($post);

            $additional = '';

            if(isset($_GET['id'])){
                if($user = User::find()->where(['id' => $_GET['id']])->one())
                    $additional = "<br><br><small>Pranešimas gautas paspaudus <i>Pranešti apie profilį</i>. Vartotojas: ".$user->username." (".$user->email.")</small>";
            }

            $mail = new Mail;
            $mail->sender = $user->email;
            $mail->reciever = 'pagalba@pazintyslietuviams.co.uk';
            $mail->subject = $model->subject;
            $mail->content = $model->body.$additional;
            $mail->timestamp = time();
            $mail->trySend();

            Yii::$app->session->setFlash('success', 'Laiškas išsiųstas. Su Jumis susisieksime, kai tik galėsime.');

            return $this->refresh();
        }
        
        return $this->render('help', ['model' => $model]);
    }

    public function actionFotoer()
    {
        return $this->render('fotoer');
    }

    public function actionCheckdovana()
    {
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        $model = new \frontend\models\Dovanos;
        $chat = new \frontend\models\Chat;

        @extract($_GET);
        @extract($_POST);

        if($object == "pav"){
            $kaina = 10;
        } 

        if($user->valiuta >=  $kaina){
            $complete['er'] = 0;
            $complete['msg'] = "Dovana sėkmingai padovanota!";
            $complete['kaina'] = $kaina;

            $model->sender = Yii::$app->user->id;
            $model->reciever = $id;
            $model->object = "pav";
            $model->object_id = $object_id;
            $model->time = time();
            $model->save(false);

            $chat->sender = Yii::$app->user->id; 
            $chat->reciever = $id;
            $chat->message = "-%necd%% ".$user->username." jums padovanojo dovaną! <a href='".Url::to(['member/msg', 'dopen' => $model->id])."' style='border-bottom: 1px solid black;'>Išpakuoti</a>";
            $chat->dontShow = Yii::$app->user->id;
            $chat->timestamp = time();
            $chat->sVip = Yii::$app->user->identity->vip;
            $chat->newID = $id;
            $chat->save(false);

            $chat = new Chat;
            $chat->sender = Yii::$app->user->id;
            $chat->reciever = $id;
            $chat->message = "-%necd%%<span style='color: #7A7A7A'>Jūs padovanojote paveikslėlį!</span>";
            $chat->dontShow = $id;
            $chat->timestamp = time();
            $chat->newID = 0;
            $chat->save(false);

            $user->valiuta -= $kaina;
            $user->save(false);

            $not = new \frontend\models\Chatnot;
            $not->insertNot($id);
            $chat->updateChatters($id);
            \frontend\models\Statistics::addSent();
            \frontend\models\Statistics::addRecieved($id);

 
            return json_encode($complete);
        }else{
            $complete['er'] = 1;
            $complete['msg'] = "Jums nepakanka širdelių";

            return json_encode($complete);
        }

    }

    public function actionDovanaopen()
    {
        @extract($_GET);
        return $this->redirect(Yii::$app->request->referrer."&dopen=".$id);
    }

    public function actionChecktalpa()
    {
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        $model = new \frontend\models\Dovanos;
        $chat = new \frontend\models\Chat;

        @extract($_GET);
        @extract($_POST);

        if($object == "talpa"){
            $kaina = 30;
        } 

        if($user->valiuta >=  $kaina){
            $complete['er'] = 0;
            $complete['msg'] = "Dovana sėkmingai padovanota!";
            $complete['kaina'] = $kaina;

            $model->sender = Yii::$app->user->id;
            $model->reciever = $id;
            $model->object = "talpa";
            $model->object_id = 0;
            $model->time = time();
            $model->save(false);

            $chat->sender = Yii::$app->user->id; 
            $chat->reciever = $id;
            $chat->message = "-%necd%% ".$user->username." jums padovanojo dovaną! <a href='".Url::to(['member/msg', 'dopen' => $model->id])."' style='border-bottom: 1px solid black;'>Išpakuoti</a>";
            $chat->dontShow = Yii::$app->user->id;
            $chat->timestamp = time();
            $chat->newID = $id;
            $chat->sVip = Yii::$app->user->identity->vip;
            $chat->save(false);

            $chat = new Chat;
            $chat->sender = Yii::$app->user->id;
            $chat->reciever = $id;
            $chat->message = "-%necd%%<span style='color: #7A7A7A'>Jūs padovanojote nuotraukų talpinimą!</span>";
            $chat->dontShow = $id;
            $chat->timestamp = time();
            $chat->newID = 0;
            $chat->save(false);

            $user->valiuta -= $kaina;
            $user->save(false);

            $not = new \frontend\models\Chatnot;
            $not->insertNot($id);
            $chat->updateChatters($id);
            \frontend\models\Statistics::addSent();
            \frontend\models\Statistics::addRecieved($id);

 
            return json_encode($complete);
        }else{
            $complete['er'] = 1;
            $complete['msg'] = "Jums nepakanka širdelių";

            return json_encode($complete);
        }
    }

    public function actionCheckaboni()
    {
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        $model = new \frontend\models\Dovanos;
        $chat = new \frontend\models\Chat;

        @extract($_GET);
        @extract($_POST);

        if($object == "aboni"){
            $kaina = 100;
        } 

        if($user->valiuta >=  $kaina){
            $complete['er'] = 0;
            $complete['msg'] = "Dovana sėkmingai padovanota!";
            $complete['kaina'] = $kaina;

            $model->sender = Yii::$app->user->id;
            $model->reciever = $id;
            $model->object = "aboni";
            $model->object_id = 0;
            $model->time = time();
            $model->save(false);

            $chat->sender = Yii::$app->user->id; 
            $chat->reciever = $id;
            $chat->message = "-%necd%% ".$user->username." jums padovanojo dovaną! <a href='".Url::to(['member/msg', 'dopen' => $model->id])."' style='border-bottom: 1px solid black;'>Išpakuoti</a>";
            $chat->dontShow = Yii::$app->user->id;
            $chat->timestamp = time();
            $chat->sVip = Yii::$app->user->identity->vip;
            $chat->newID = $id;
            $chat->save(false);

            $chat = new Chat;
            $chat->sender = Yii::$app->user->id;
            $chat->reciever = $id;
            $chat->message = "-%necd%%<span style='color: #7A7A7A'>Jūs padovanojote abonimentą!</span>";
            $chat->dontShow = $id;
            $chat->timestamp = time();
            $chat->newID = 0;
            $chat->save(false);

            $user->valiuta -= $kaina;
            $user->save(false);

            $not = new \frontend\models\Chatnot;
            $not->insertNot($id);
            $chat->updateChatters($id);
            \frontend\models\Statistics::addSent();
            \frontend\models\Statistics::addRecieved($id);

 
            return json_encode($complete);
        }else{
            $complete['er'] = 1;
            $complete['msg'] = "Jums nepakanka širdelių";

            return json_encode($complete);
        }
    }

    public function actionGetppapplinksirdeles()
    {
        require __DIR__ . '/../../vendor/paypal/rest-api-sdk-php/sample/bootstrap.php';

        @extract($_POST);

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item1 = new Item();
        $item1->setName('Valiutos pirkimas')
            ->setCurrency('GBP')
            ->setQuantity(1)
            ->setSku($amount) // Similar to `item_number` in Classic API
            ->setPrice($price);

        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        $details = new Details();
        $details->setSubtotal($price);

        $amount = new Amount();
        $amount->setCurrency("GBP")
            ->setTotal($price)
            ->setDetails($details);       


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Valiutos pirkimas (description)')
            ->setInvoiceNumber(uniqid());

        $baseUrl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(Url::to(['member/executesirdeles', 'success' => 'true', 'i' => Yii::$app->user->id], true))
            ->setCancelUrl(Url::to(['member/executesirdeles', 'success' => 'false', 'i' => Yii::$app->user->id], true));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $payment->create($apiContext);
        $approvalUrl = $payment->getApprovalLink();

        return json_encode($approvalUrl);
    }

    public function actionGetppapplinknuotraukos($value='')
    {
        require __DIR__ . '/../../vendor/paypal/rest-api-sdk-php/sample/bootstrap.php';

        @extract($_POST);

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item1 = new Item();
        $item1->setName('Nuotraukų limito didinimas')
            ->setCurrency('GBP')
            ->setQuantity(1)
            ->setSku($amount) // Similar to `item_number` in Classic API
            ->setPrice($price);

        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        $details = new Details();
        $details->setSubtotal($price);

        $amount = new Amount();
        $amount->setCurrency("GBP")
            ->setTotal($price)
            ->setDetails($details);       


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Nuotraukų limito didinimas (description)')
            ->setInvoiceNumber(uniqid());

        $baseUrl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(Url::to(['member/executelimit', 'success' => 'true', 'i' => Yii::$app->user->id], true))
            ->setCancelUrl(Url::to(['member/executelimit', 'success' => 'false', 'i' => Yii::$app->user->id], true));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $payment->create($apiContext);
        $approvalUrl = $payment->getApprovalLink();

        return json_encode($approvalUrl);
    }

    public function actionExecutesirdeles($value='')
    {

        return $this->render('executesirdeles');
    }

    public function actionExecutelimit($value='')
    {

        return $this->render('executelimit');
    }

    //user; msg; img; path; cost;
    public function actionUmipc()
    {
        $model = new \frontend\models\Dovanos;
        $chat = new \frontend\models\Chat;

        @extract($_POST);

        $valiuta = Yii::$app->user->identity['valiuta'];

        if($valiuta > $cost){
            Yii::$app->user->identity['valiuta'] -= $cost;
            Yii::$app->user->identity->save(false);

            $model->sender = Yii::$app->user->id;
            $model->reciever = $user;
            $model->object = 'pav';
            $model->object_id = 'kaledos/'.$img;
            $model->time = time();
            $model->save(false);

            $chat->sender = Yii::$app->user->id; 
            $chat->reciever = $user;
            $chat->message = "-%necd%% ".Yii::$app->user->identity['username']." jums padovanojo dovaną! ".$msg." <a href='".Url::to(['member/dovanaopen', 'id' => $model->id])."' style='border-bottom: 1px solid black;'>Išpakuoti</a>";
            $chat->dontShow = Yii::$app->user->id;
            $chat->timestamp = time();
            $chat->newID = $user;
            $chat->save(false);

            $message = 'Dovana išsųsta';
        }else{
            $message = "Jums nepakanka kreditų";
        }

        return json_encode($message);

    }

    public function actionChatterspop()
    {
        $model = new \frontend\models\Chat;

        $offset = $_GET['offset'];

        $chat = \frontend\models\Chat::find()->offset($offset)->limit(1000)->all();

        var_dump($chat);

        foreach ($chat as $c) {
            $model->updateChattersIndependent($c->sender, $c->reciever);
        }



        //$model->updateChattersIndependent();

    }

    public function actionSuccesful_payment()
    {
        return $this->render('succesful_payment');
    }

    public function actionCancelled_payment()
    {
        return $this->render('cancelled_payment');
    }

    public function actionGetpayseralink()
    {

        if(isset($_GET['obj'])) {
            
            $obj = $_GET['obj'];
            $model = new \frontend\models\Paysera;

            if ($obj == 1)
                $url = $model->buyCoins(7);
            elseif ($obj == 2)
                $url = $model->buyCoins(14);
            elseif ($obj == 3)
                $url = $model->buyCoins(21);
            elseif ($obj == 4)
                $url = $model->buyCoins(28);

            if (isset($url) && $url != '')
                echo $url;
        }
    }

}
