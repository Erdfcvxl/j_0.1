<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use frontend\models\Pakvietimai;
use common\models\User;
use backend\models\Functions;
use frontend\models\UserPack;
use backend\models\Welcome;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'glogin'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [

                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;

        if($action->id == 'login' || $action->id == 'glogin'){

        }else{
            $this->restricted();
        }


        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionGlogin(){
        if(isset($_GET['p']) && $_GET['p'] == '   '){
            //Yii::$app->session['admin'] = 1;
            $sentInerval = date('Y-m-d', time())." - ".date('Y-m-d', time() + 3600 * 24);
            return $this->redirect('/backend/web/index.php?r=site%2Ffakemsg&sent='.$sentInerval);
        }
    }

    public function restricted()
    {
        if(!isset(Yii::$app->session['admin'])){
            return $this->redirect(Url::to(['site/login']));
        }else{
            if(Yii::$app->session['admin'] != 1 && Yii::$app->session['admin'] != 88)
                return $this->redirect(Url::to(['site/login']));
        }
    }

    public function actionIga()
    {

        if(Yii::$app->session['inGameAdmin']) {
            Yii::$app->session['inGameAdmin'] = null;
        }else{
            Yii::$app->session['inGameAdmin'] = true;
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionFunctions()
    {
        return $this->render('functions');
    }

    public function actionMiestai()
    {
        Yii::$app->language = 'lt';

        $this->restricted();

        $searchModel = new \backend\models\NariaiMiestuose;      

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /*$query = \backend\models\NariaiMiestuose::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);*/

        return $this->render('miestuose', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionIndex()
    {
        return $this->redirect(Url::to(['site/login']));
    }

    public function actionEmail()
    {
        $model = new \backend\models\ContactForm;
        $model->name = 'pazintys@pazintyslietuviams.co.uk';

        if($post = Yii::$app->request->post()) {

            $emails = explode(',', $post['ContactForm']['email']);
            $model->email = null;

            if ($model->load($post)) {
                $i = 0;
                $gavejai = null;
                foreach ($emails as $email) {
                    $gavejai .= $email . "<br>";

                    $mail = new \common\models\Mail;
                    $mail->sender = $model->name;
                    $mail->reciever = $email;
                    $mail->subject = $model->subject;
                    $mail->vars = 'logo=>css/img/icons/logoEmpty.jpg|,|avatars=>css/img/icons/avatarSectionEmail.jpg|,|link=>css/img/icons/link.jpg|,|body=>' . $model->body;
                    $mail->view = '_sablonas';
                    $mail->timestamp = time();
                    $mail->trySend();

                    $i++;
                }

                Yii::$app->session->setFlash('success', 'Sėkmingai išsiųstas(-i) <b>' . $i . '</b> laiškas(-ai) <br><br> <b>Gavėjai</b>: <br>' . $gavejai);

            }

        }

        

        return $this->render('email', ['model' => $model]);
    }

    public function actionCleanavatar()
    {

        if(Functions::CleanAvatar()){
            Yii::$app->session->setFlash('success', 'Avatarų išvalimo');
        }else{
            Yii::$app->session->setFlash('danger', 'Avatarų išvalimo');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLogin()
    {
        $this->layout = false;

        if (isset(Yii::$app->session['admin']) && (Yii::$app->session['admin'] == 1 || Yii::$app->session['admin'] == 88)) {
            return $this->redirect(Url::to(['site/users']));
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            if($model->username == "configure" && $model->password === "TiesineFunkcija2x"){
                Yii::$app->session['admin'] = 1;
                return $this->redirect(Url::to(['site/users']));
            }elseif($model->username == "ggghgghghghghghgh" && $model->password == "ssdsdfsdsdsdsdsdf"){
                Yii::$app->session['admin'] = 88;
                return $this->redirect(Url::to(['site/users'])); 
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->session['admin'] = 0;

        return $this->goHome();
    }

    public function actionUsers()
    {
        Yii::$app->language = 'lt';

        $this->restricted();

        $searchModel = new \backend\models\UserSearch();

        if(!empty($_GET['expires'])){
            $_GET['UserSearch']['expires'] = $_GET['expires'];
            $_GET['UserSearch']['created_at'] = $_GET['created_at'];
        }
        if(!empty($_GET['created_at'])){
            $_GET['UserSearch']['expires'] = $_GET['expires'];
            $_GET['UserSearch']['created_at'] = $_GET['created_at'];
        }

        

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        return $this->render('users', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
       
    }

    public function actionMsg()
    {
        Yii::$app->language = 'lt';

        $this->restricted();

        $searchModel = new \backend\models\MostMesssagesSent;      

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('msg', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
       
    }

    public function actionFakemsg()
    {
        Yii::$app->language = 'lt';

        $this->restricted();

        $searchModel = new \backend\models\FakeMsg;      

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('fakemsg', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
       
    }

    public function actionFakemsgcheck()
    {
        $msg = count(\backend\models\FakeMsg::find()->all());
        $likes = count(\backend\models\Fakenewlikes::find()->all());
        $friends = count(\backend\models\Fakenewfriends::find()->all());

        $result = [$msg, $likes, $friends];

        return json_encode($result);

    }

    public function actionFakelikes()
    {
        Yii::$app->language = 'lt';

        $this->restricted();

        $searchModel = new \backend\models\Fakenewlikes;      

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('fakelikes', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionFakedrg()
    {
        Yii::$app->language = 'lt';

        $this->restricted();

        $searchModel = new \backend\models\Fakenewfriends;      

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('fakefriends', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionFaf()
    {
        $model = new \backend\models\CustomSearch;

        @extract($_GET);

        if(!isset($id)){

            $query = \frontend\models\UserPack::find()->where(['f' => 1]);

            $post = (Yii::$app->request->post())? Yii::$app->request->post() : null;

            $dataProvider = $model->CustomSearch($post, $query);

            return $this->render('faf', ['model' => $model, 'dataProvider' => $dataProvider]);
        }else{
            $user = UserPack::find()->where(['id' => $id])->one();

            if($post = Yii::$app->request->post()){
                $model = new \backend\models\Mass;
                $model->populate($post);

                return $this->render('faf_confirm', ['user' => $user, 'model' => $model]);
            }

            return $this->render('faf2', ['user' => $user]);
        }
    }

    public function actionFafinvite()
    {
        @extract($_POST);

        foreach ($model['recievers'] as $v) {
            $model = new Pakvietimai;
            $model->sender = $id;
            $model->reciever = (int)$v;
            $model->timestamp = time();
            $model->save();
        }

    }

    public function actionControl()
    {
        return $this->render('control');
    }

    public function actionSwitch()
    {

        $model = \frontend\models\FunctionsSettings::find()->where(['id' => $_GET['fid']])->one();

        if($model->on){
            $model->on = 0;
        }else{
            $model->on = 1;
        }

        $model->save(false);


        Yii::$app->session->setFlash('success', ''); 

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUseredit()
    {
        $model = User::find()->where(['id' => $_GET['id']])->one();

        if($post = Yii::$app->request->post()){
            $info = \frontend\models\InfoClear::find()->where(['u_id'=>$_GET['id']])->one();

            $info->load($post);

            $info->save(false);

            Yii::$app->session->setFlash('success', 'Atlikta'); 
        }
        
        return $this->render('//site/user', ['model'=>$model]);
    }

    public function actionUserdelete()
    {
        $id = $_GET['id'];

        $model = new \backend\models\Functions;
        $model->deleteChat($id);
        $model->deleteChatters($id);
        $model->deleteChatnot($id);
        $model->deletePakvietimai($id);

        $model = User::find()->where(['id' => $_GET['id']])->one();
        $model->delete();

        Yii::$app->session->setFlash('success', 'Narys ištrintas');

        return $this->redirect(Url::to(['site/users']));
    }

    public function actionUserblock()
    {
        $model = User::find()->where(['id' => $_GET['id']])->one();


        if($model->blocked){
            $model->blocked = 0;
            $model->blockedInfo = '';
            $model->save(false);

            Yii::$app->session->setFlash('success', 'Narys atblokuotas');

            return $this->redirect(Url::to(['site/useredit', 'id' => $model->id]));
        }else{


            if($post = Yii::$app->request->post()){
                $model->blockedInfo = $post['User']['blockedInfo'];
                $model->blocked = 1;
                if($model->save(false)){
                    Yii::$app->session->setFlash('success', 'Narys užblokuotas');
                    return $this->redirect(Url::to(['site/useredit', 'id' => $model->id]));
                }
            }

            return $this->render('user', ['model' => $model, 'blocking' => 1]);
        }
        
    }

    public function actionTitulinis()
    {
        Yii::$app->controller->enableCsrfValidation = false;
        $model = new \backend\models\uploadPhoto;

       if (Yii::$app->request->isPost) {
            $model->imageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {

            }
        }

        return $this->render('titulinis', ['model' => $model]);
    }

    public function actionFmm()
    {
        $model = new \backend\models\CustomSearch;

        @extract($_GET);

        if(!isset($id)){

            $query = \frontend\models\UserPack::find()->where(['f' => 1]);

            $post = (Yii::$app->request->post())? Yii::$app->request->post() : null;

            $dataProvider = $model->CustomSearch($post, $query);

            return $this->render('MM', ['model' => $model, 'dataProvider' => $dataProvider]);
        }else{
            $user = UserPack::find()->where(['id' => $id])->one();

            if($post = Yii::$app->request->post()){
                $model = new \backend\models\MM;
                $model->populate($post);

                return $this->render('MM_confirm', ['user' => $user, 'model' => $model]);
            }

            return $this->render('MM2', ['user' => $user]);
        }

    }

    public function actionTest()
    {

    }

    public function actionFparam()
    {
        @extract($_GET);

        $user = User::find()->where(['id' => $id])->one();
        $user->f = $val;

        if($val){
            $user->expires = time() + 60 * 60 * 24 * 31 * 12;
            $user->valiuta = 5000;
            $user->vip = 1;
        }else{
            $user->expires = time();
            $user->valiuta = 0;
            $user->vip = 0;
        }

        $user->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSoondead()
    {
        $model = new \backend\models\UserPackSearch;

        $dataProvider = $model->VipSD();

        
        return $this->render('//site/vip/soondead', ['dataProvider' => $dataProvider]);
    }

    public function actionFmmsend()
    {
        @extract($_POST);

        $MM = new \backend\models\MM;

        $MM->sender = $model['sender'];
        $MM->recievers = $model['recievers'];
        $MM->msg = $model['msg'];
        $MM->sendMM();

        echo "as cia";

    }

    public function actionWelcome()
    {
        $model = new \backend\models\CustomSearch;
        $welcome = new Welcome;

        $post = (Yii::$app->request->post())? Yii::$app->request->post() : null;

        $query['fakes'] = \frontend\models\UserPack::find()->where(['f' => 1]);
        $DP_fakes = $model->CustomSearch($post, $query['fakes']);

        $ids = $welcome::find()->all();
        $query['in'] = \frontend\models\UserPack::find()->where(['id' => \frontend\models\Misc::getByu_id($ids)]);
        $DP_players = $model->CustomSearch($post, $query['in']);

        return $this->render('welcome', ['welcome' => $welcome, 'model' => $model, 'DP' => ['fakes' => $DP_fakes, 'players' => $DP_players]]);

    }

    public function actionTowelcome()
    {
        $model = new Welcome;

        if($model->addToGame($_GET['id'])){
            return $this->redirect(Yii::$app->request->referrer);
        }else{

            die('kazkas negerai');
        }

    }

    public function actionUpdatemsg()
    {
        $model = \backend\models\Welcome::find()->where(['u_id' => $_POST['id']])->one();
        $model->msg = $_POST['msg'];
        $model->save();

        return true;
    }
    
    public function actionRemovefromwelcome()
    {
        $model = \backend\models\Welcome::find()->where(['u_id' => $_GET['id']])->one();
        $model->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionList()
    {
        @extract($_GET);
        
        $m = new \backend\models\CustomSearch;
        $m->id = $model;


        $query = \frontend\models\UserPack::find();
        $dataProvider = $m->CustomSearch(null, $query);

        return $this->render('list', ['dataProvider' => $dataProvider]);
    }

    public function actionGodmode()
    {

        if(isset($_GET['loginTo'])){
            Yii::$app->user->logout();

            $user = \common\models\User::find()->where(['id' => $_GET['loginTo']])->one();

            Yii::$app->user->login($user, 3600 * 24 * 30);
        }

        $url = Yii::$app->urlManagerFrontend->createUrl([$_GET['redirectTo']]);

        return $this->redirect($url);

    }

    public function actionGetusers()
    {
        $_GET['ps'] = 99999999999999;

        $model = new \backend\models\UserSearch();
        $dp = $model->search(Yii::$app->request->post());

        foreach ($dp->getModels() as $v)
            $result[] = $v->email;

        if(isset($result))
            $result = ['gavejai' => implode(',',$result), 'count' => count($result)];
        else
            $result = ['gavejai' => 'Nieko nerasta', 'count' => 0];

        return json_encode($result);

    }
   
}
