<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\UploadForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Info;
use yii\helpers\Url;
use common\models\Mail;


use Imagine\Image\Box;
use Imagine\Image\Point;

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
                'only' => ['signup', 'success', 'afterfb', 'verifyemail'],
                'rules' => [
                    [
                        'actions' => ['signup', 'success', 'afterfb', 'verifyemail'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'verifyemail'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'actionOauthsuccess'],
            ],
        ];
    }

    public function actionConsole()
    {
        /*$users = \frontend\models\User::find()->select('email')->where(['reg_step' => ""])->andWhere(['facebook' => 1])->all();

        foreach ($users as $user) {
            $emails[] = $user->attributes['email'];
            Yii::$app->mailer->compose('_atsiprasome', ['logo' => 'css/img/icons/atsiprasomeLogo.jpg', 'avatars' => 'css/img/icons/avatarSectionEmail.jpg', 'link' => 'css/img/icons/link.jpg'])
                    ->setFrom('info@pazintyslietuviams.co.uk')
                    ->setTo($user->attributes['email'])
                    ->setSubject('Slaptažodis')
                    ->send();
        }
*/

    }

    public function actionOauthsuccess($client) {
        $userAttributes = $client->getUserAttributes();

        $id = $userAttributes['id'];
        $username = $userAttributes['name'];
        $email = $userAttributes["email"];
        $photoSrc = $userAttributes['picture']['data']['url'];
        
        $fb = new \frontend\models\Facebook;
        $fb->id = $id;
        $fb->username = $username;
        if(User::find()->where(['email' => $email])->one()){
            $fb->email = '';
        }else{
            $fb->email = $email;
        }
        $fb->picture = $photoSrc;

        if($user = $fb->login()){

            if($regStep = max(explode(' ', $user->reg_step))){

                if($regStep == 4){
                    return $this->redirect(Url::to(['member/index']));
                }else{
                    return $this->redirect(Url::to(['site/login', 're' => $regStep + 1, 'ra'=> $user->auth_key, 'id' => $user->id]));
                }

            }
        
        }elseif($user = $fb->signup()){
            
        }

        if($info = Info::find()->where(['u_id' => $user->id])->one()){
            if($info->iesko){
                return $this->redirect(Url::to(['site/login', 're' => 0, 'ra'=> $user->auth_key, 'id' => $user->id]));
            }
        }


        return $this->redirect(Url::to(['site/login', 'psl' => 'afterfb', 'ra'=> $user->auth_key, 'id' => $user->id]));

        // do some thing with user data. for example with $userAttributes['email']
    }

    public function actionCne()
    {
        $id = (isset($_GET['id'])) ? $_GET['id'] : null;
        $prt = (isset($_GET['prt'])) ? $_GET['prt'] : null;

        if($id && $prt) {

            $user = User::find()->where(['id' => $id])->one();

            if($user->password_reset_token == $prt) {
                $user->activated = 1;
                $user->save();

                Yii::$app->user->login($user, 3600 * 24 * 30);
                return $this->redirect(Url::to(['member/index']));
            }
        }


        return $this->redirect(Url::to(['site/login']));


    }

    public function actionSuccess()
    {
        $username = 'Jonis';
        $email = 'Jonis@gmail.com';
        $photoSrc = 'https://scontent.xx.fbcdn.net/hprofile-xpf1/v/t1.0-1/c62.216.494.494/10989464_819360724785243_7832270072348330648_n.jpg?oh=b607e8c8a2ecf4045eb81566e498a8b4&oe=566919F0';

        $fb = new \frontend\models\Facebook;
        $fb->username = $username;
        $fb->email = $email;
        $fb->picture = $photoSrc;

        if($user = $fb->login()){

            if($regStep = max(array($user->reg_step))){

                if($regStep == 4){
                    return $this->redirect(Url::to(['member/index']));
                }else{
                    return $this->redirect(Url::to(['site/login', 're' => $regStep + 1, 'ra'=> $user->auth_key, 'id' => $user->id]));
                }

            }
        
        }elseif($user = $fb->signup()){
            $feed = new \frontend\models\Feed;

            if(!$feed->find()->where(['u_id' => $user->id, 'action' =>"newUser"])->one()){
                $feed->u_id = $user->id;
                $feed->action = "newUser";
                $feed->timestamp = time();
                $feed->insert();
            }
            
        }

        if($info = Info::find()->where(['u_id' => $user->id])->one()){
            if($info->iesko){
                return $this->redirect(Url::to(['site/login', 're' => 0, 'ra'=> $user->auth_key, 'id' => $user->id]));
            }
        }


        return $this->redirect(Url::to(['site/login', 'psl' => 'afterfb', 'ra'=> $user->auth_key, 'id' => $user->id]));

    }   

    public function actionSkip()
    {
        if(isset($_GET['e']) && isset($_GET['ak'])){

            if($user = User::find()->where(['id' => $_GET['e']])->one()){
                Yii::$app->user->login($user, 3600 * 24 * 30);

               return $this->redirect(Url::to(['member/index'])); 
            }

            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Url::to(['site/login']));
        }else{
            return $this->redirect(Url::to(['member/index']));
        }
    }

    public function actionVerifyemail()
    {

        @extract($_GET);

        if(isset($gyp) && isset($re) && isset($ra) && isset($id)){

            $user = User::find()->where(['id' => $id])->andWhere(['auth_key' => $ra])->one();


            if($gyp == 'Yc7rmURCN23G'){

                if($re == 0){
                    if($user){
                        $user->activated = 1;
                        $user->save(false);

                        Yii::$app->user->login($user, 3600 * 24 * 30);

                        return $this->redirect(Url::to(['member/index']));
                    }
                }
            }
        }

        return $this->redirect(Url::to(['site/login']));
        
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
            return $this->redirect(Url::to(['member/index']));


        $id = (isset($_GET['id']) ? $_GET['id'] : "");
        $ra = (isset($_GET['ra']) ? $_GET['ra'] : "");
        $re = (isset($_GET['re']) ? $_GET['re'] : "");
        $gyp = (isset($_GET['gyp']) ? $_GET['gyp'] : "");
        $psl = (isset($_GET['psl']) ? $_GET['psl'] : "");


        $model = new LoginForm();
        $model2 = new SignupForm();
        $model2->pilnametis = null;
        $UploadForm = new UploadForm();

        if($model_info = Info::find()->where(['u_id' => $id])->one()){
            $model_info->ugis = 66;
            $model_info->svoris = 21;
        }else{
            $model_info = new Info;
        }
        

        $modelInfo = new Info;
        

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if($re != ""){
            if($id != ""){
               
            $user = User::find()->where(['id' => $id])->one();
            
                if($user){
                    if(!$model_info || $user->auth_key != $ra){
                        return $this->redirect(Url::to(['site/login']));
                    }

                    if($gyp == "Yc7rmURCN23G"){
                        $user->activated = 1;
                        $user->save(false);
                    }

                    $reg_step = ($user->reg_step)? explode(' ', $user->reg_step) : [];

                    $lack = false;
                    for($i = 4; $i >= 0; $i--){
                        if(array_search((string)$i, $reg_step) === false){
                            $lack = $i;
                        }
                    }

                    if($lack === false){
                        Yii::$app->user->login($user, 3600 * 24 * 30); 
                        return $this->redirect(Url::to(['member/index']));
                    }

                    $c_steps = explode(" ", $user->reg_step);
                    //var_dump(max($c_steps));
                    //die();
                    if($gyp == "Yc7rmURCN23G"){
                        $user->activated = 1;
                        $user->save(false);

                        if(max($c_steps) == 4){

                            return $this->redirect(Url::to(['member/index']));
                        }else{
                            $re_new = max($c_steps)+1;
                            return $this->redirect(array('login', 're' => $re_new, 'ra'=> $ra, 'id' => $id)); 
                        }
                    }

                    if($re != "0"){
                        if(!array_search($re, $c_steps)){
                            if(max($c_steps) == ""){
                                $re_new = 0;
                            }else{
                                $re_new = max($c_steps)+1;
                            }

                            if($re != $re_new){
                               //return $this->redirect(array('login', 're' => $re_new, 'ra'=> $ra, 'id' => $id)); 
                            }
                        }
                    }
                }else{
                    return $this->redirect(Url::to(['site/login']));
                }
            }else{
                return $this->redirect(Url::to(['site/login']));
            }

        }

        if($psl != 'afterfb'){
            if($info =Yii::$app->request->post()){ //YRA KAZKAS POSTE,SIUNCIAMA INFORMACIJA, JA REIKIA KAZKUR ISSAUGOTI

                if(isset($info['LoginForm'])){
                    if ($model->load(Yii::$app->request->post())) {
                       if($model->login()){
                        return $this->redirect(Url::to(['member/index', 'issite' => 1]));
                       }
                        return $this->redirect(Url::to(['site/login']));
                    }
                }

                if(isset($info['SignupForm'])){
                    if ($model2->load(Yii::$app->request->post())) {  
                        if ($user = $model2->signup()) {

                            $info = Yii::$app->request->post();

                            $model_info->scenario = 'signup';
                            $model_info->u_id = $user->id;
                            $model_info->iesko = $info['gender'];
                            $model_info->amzius_tarp = $info['age_from'] . "-" . $info['age_to'];
                            $model_info->suzinojo = $info['heard_from'];
                            $model_info->SignUpInfo();
                            
                            if($model_info->validate()){
                                return $this->redirect(array('login', 're' => '0', 'ra'=> $user->auth_key, 'id' => $user->id));
                            }

                        }     
                    }
                }

                if(isset($info['Info'])){
                    if($re == 0){$model_info->scenario = 'pirmas';}
                    elseif($re == 1){$model_info->scenario = 'antras';}
                    elseif($re == 2){$model_info->scenario = 'trecias';}
                    elseif($re == 3){$model_info->scenario = 'ketvirtas';}
                    elseif($re == 4){$model_info->scenario = 'penktas';}

                    $model_info->load(Yii::$app->request->post());

                    function del_kita($model_info, $info, $param){
                        if(isset($info[$param."2"]) && $info[$param."2"] != ""){

                            $model_info->$param = $info[$param."2"];
                        }
                    }
                    if($re == 0){
                        if(isset($info['Info']['gimtine']) && $info['Info']['gimtine'] != 126){
                            del_kita($model_info, $info['Info'], 'tautybe');
                        }
                        if(isset($info['Info']['pareigos']) && ($info['Info']['pareigos'] == 25 || $info['Info']['pareigos'] == "")){
                            del_kita($model_info, $info['Info'], 'pareigos');
                        }
                        if(isset($info['Info']['religija']) && ($info['Info']['religija'] == 9 || $info['Info']['religija'] == "")){
                            del_kita($model_info, $info['Info'], 'religija');
                        }
                    }elseif($re == 1){
                        if(isset($info['Info']['plaukai']) && ($info['Info']['plaukai'] == 7 || $info['Info']['plaukai'] == "")){
                            del_kita($model_info, $info['Info'], 'plaukai');
                        }
                        if(isset($info['Info']['akys']) && ($info['Info']['akys'] == 4 || $info['Info']['akys'] == "")){
                            del_kita($model_info, $info['Info'], 'akys'); 
                        }
                        if(isset($info['Info']['stilius']) && ($info['Info']['stilius'] == 17 || $info['Info']['stilius'] == "")){
                            del_kita($model_info, $info['Info'], 'stilius');
                        }
                    }
                    

                    /*if(isset($info['Info']['tautybe2']) && $info['Info']['tautybe2'] != ""){
                        $model_info->tautybe = $info['Info']['tautybe2'];
                    }*/

                    $model_info->u_id = $id;
                    $model_info = $model_info -> NextStep();

                    

                    if($model_info->validate()){
                        if($re == 4){
                            $user = User::find()->where(['id' => $_GET['id']])->one();

                            Yii::$app->user->login($user, 0);

                            $feed = new \frontend\models\Feed;

                            if(!$feed->find()->where(['u_id' => $user->id, 'action' =>"newUser"])->one()){
                                $feed->u_id = $user->id;
                                $feed->action = "newUser";
                                $feed->timestamp = time();
                                $feed->insert();
                            }

                           

                            return $this->redirect(Url::to(['member/index']));

                        }else{
                            return $this->redirect(array('login', 're' => $re+1, 'ra'=> $ra, 'id' => $id));
                        }
                    }
                }

                if(isset($info['UploadForm'])){

                    $newSave = new \frontend\models\Albums;
                    $newSave->file = UploadedFile::getInstance($UploadForm, 'file');
                    $didSaved = $newSave->saveToProfile($id, "profile");

                    $c_steps = explode(" ", $user->reg_step);

                    if($didSaved == true){
                        $user->avatar = ($user->avatar)? $user->avatar : $didSaved['ext'];

                        if(!array_search('3', $c_steps)){
                            $user->reg_step = $user->reg_step." 3";
                            $user->save();
                        }
                        
                        $user->save();


                        return $this->redirect(array('login', 're' => $re+1, 'ra'=> $ra, 'id' => $id));
                    }
                }
            }
        }else{
            if($infoF =Yii::$app->request->post()){

                if( $validate = User::find()->where(['username' => $infoF['User']['username']])->andWhere(['not',['id' => $id]])->one() ) {
                    Yii::$app->session->setFlash('error', 'Toks slapyvardis jau naudojamas.');
                }elseif($validate = User::find()->where(['email' =>$infoF['User']['email']])->andWhere(['not',['id' => $id]])->one()){
                    Yii::$app->session->setFlash('error', 'Toks el. paštas jau naudojamas.');
                }else{

                    if(isset($infoF['rules']) && $infoF['rules'] == 'on'){
                        $model_info->u_id = $_GET['id'];
                        $model_info->iesko = $infoF['Info']['iesko'];
                        $model_info->save(false);

                        if($user = User::find()->where(['id' => $id])->one()){



                            $user->username = $infoF['User']['username'];
                            $user->email = $infoF['User']['email'];
                            $user->save(false);


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
                                        <a href='".$url."'>Spausti čia</a>";

                            $mail = new \common\models\Mail;
                            $mail->sender = 'pazintys@pazintyslietuviams.co.uk';
                            $mail->reciever = $to;
                            $mail->subject = $subject;
                            $mail->content = $message;
                            $mail->timestamp = time();
                            $mail->trySend();
                            
                            $reg_step = ($user->reg_step)? explode(' ', $user->reg_step) : [];

                            $lack = false;
                            for($i = 4; $i >= 0; $i--){
                                if(array_search((string)$i, $reg_step) === false){
                                    $lack = $i;
                                }
                            }

                            if($lack === false){
                                Yii::$app->user->login($user, 3600 * 24 * 30); 
                                return $this->redirect(Url::to(['member/index']));
                            }else{
                                if($lack != '0'){
                                    return $this->redirect(Url::to(['site/login', 're' => $regStep + 1, 'ra'=> $user->auth_key, 'id' => $user->id]));
                                }else{
                                    return $this->redirect(Url::to(['site/login', 're' => 0, 'ra'=> $user->auth_key, 'id' => $user->id]));
                                }
                            }

                        }
                    }else{
                        Yii::$app->session->setFlash('error', 'Jūs privalote sutikti su taisyklėmis');
                    }
                }

            }
        }

        if($psl == "proceed"){

            if(isset($_GET['name']) && isset($_GET['token'])){

                $UserModel = new User;

                if($user = $UserModel->find()->where(['username' => $_GET['name']])->andWhere(['password_reset_token' => $_GET['token']])->one()){
                    $newPass = $this->randomPassword(8);
                    Yii::$app->view->params['newPass'] = $newPass;

                    $user->password_reset_token = null;
                    $user->password_hash = Yii::$app->security->generatePasswordHash($newPass);
                    $user->save();

                    $mail = new Mail;
                    $mail->sender = 'pazintys@pazintyslietuviams.co.uk';
                    $mail->reciever = $user->email;
                    $mail->subject = 'Slaptažodis';
                    $mail->vars = 'logo=>css/img/icons/logo2.jpg|,|avatars=>css/img/icons/avatarSectionEmail.jpg|,|link=>css/img/icons/link.jpg|,|pass=>'.$newPass;
                    $mail->view = '_pass';
                    $mail->timestamp = time();
                    $mail->trySend();

                    return $this->render('login', [
                        'modelis' => $model, 
                        'model2' => $model2, 
                        'model_info' => $model_info, 
                        'UploadForm' => $UploadForm,
                    ]);
                }else{
                    return $this->goHome();
                }

            }else{
                return $this->goHome();
            }
        }

        if($psl == "afterfb"){
            if($user = User::find()->where(['id' => $id])->one()){
                if($re == $user->auth_key){

                }
            }
        }

        $modelInfo->iesko = (isset($infoF['Info']['iesko']))? $infoF['Info']['iesko'] : 'mv';


        return $this->render('login', [
                'modelis' => $model, 'model2' => $model2, 'model_info' => $model_info, 'UploadForm' => $UploadForm, 'modelInfo' => $modelInfo 
        ]);

    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(Url::to(['member/index']));
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    //return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    function randomPassword($l) {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $l; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function actionLost()
    {
        $model = new User;

        if($post = Yii::$app->request->post()){
            if($user = $model::find()->where(['email' => $post['User']['email'] ])->one()){
                $token = ($user->password_reset_token)? $user->password_reset_token : $this->randomPassword(20);


                $user->password_reset_token = $token;
                $user->save();

                $mail = new \common\models\Mail;
                $mail->sender = 'pazintys@pazintyslietuviams.co.uk';
                $mail->reciever = $post['User']['email'];
                $mail->subject = 'Prisijungimo duomenys';
                $mail->vars = 'logo=>css/img/icons/logo2.jpg|,|avatars=>css/img/icons/avatarSectionEmail.jpg|,|link=>css/img/icons/link.jpg|,|name=>'.$user->username.'|,|token=>'.$token;
                $mail->view = '_lostMail';
                $mail->trySend();

                //var_dump($mail->getErrors());

            }else{
                Yii::$app->setFlash('danger', 'Toks el. paštas nėra registruotas.');
                return $this->redirect(Url::to(['site/login', 'lost' => 1]));
            }
        }else{
            echo " ...";
        }

        return $this->redirect(Url::to(['site/login', 'lost' => 1, 'psl' => 'issiusta']));

    }

    public function actionTerms()
    {
        return $this->render('terms.php');
    }

    public function actionNotloged()
    {
        return $this->render('notloged');
    }

    public function actionTest()
    {
        @extract($_GET);

        if(isset($l)){
            echo urldecode($l);
        }

        if(isset($pdb) && isset($p)){
            $hash = Yii::$app->getSecurity()->generatePasswordHash($p);

            var_dump($hash);
            var_dump((Yii::$app->getSecurity()->validatePassword($p, $pdb)));
        }
    }

    public function actionPayseracallback()
    {
        $model = new \frontend\models\Payseracallback;
        $model->proceed();
    }

    public function actionSmscallback()
    {
        $model = new \frontend\models\Smscallback;
        $model->proceed();
    }

    public function actionInvite()
    {
        if (Yii::$app->user->isGuest) {
            if (isset($_GET['id']) && $_GET['id'] != NULL)
            {
                Yii::$app->session->set('invite', $_GET['id']);
                return $this->redirect(['/site/login', 'invite' => 1]);
            }
            return $this->redirect('/site/login');
        }else{
            return $this->redirect(Url::to(['member/index']));
        }
    }

    public function actionPrivatumo_politika()
    {
        return $this->render('privatumas');
    }

}
