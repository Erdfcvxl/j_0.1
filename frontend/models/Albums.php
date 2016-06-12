<?php

namespace frontend\models;

use Yii;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\data\ActiveDataProvider;
use yii\helpers\BaseFileHelper;
use \Imagine\Gd\Imagine;

/**
 * This is the model class for table "albums".
 *
 * @property integer $id
 * @property integer $u_id
 * @property string $name
 * @property string $cover
 * @property integer $timestamp
 */
class Albums extends \yii\db\ActiveRecord
{

    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'albums';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'name', 'cover', 'timestamp'], 'safe'],
            [['file'], 'file', 'extensions' => 'gif, jpg, png, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'message' => 'Ledžiami failo plėtiniai yra: gif, jpg, png, jpeg.', 'maxSize' => 1024 * 1024 * 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u_id' => 'U ID',
            'name' => 'Pavadinimas',
            'cover' => 'Cover',
            'timestamp' => 'Timestamp',
        ];
    }

    public function albumCoverNew($id)
    {   

        $check[0] = false;
        $pass = false;

        $structure = "uploads/".$id."/".$this->name;

        if (!is_dir($structure)) {
            BaseFileHelper::createDirectory($structure, $mode = 0777);
        }

        $new_file_name_full = '6o73r'.$id.'EFl';


        if ($this->file && $this->validate()) {                
            $pass = true;

            $this->file->saveAs($structure.'/'.$new_file_name_full.'.' . $this->file->extension);
            // frame, rotate and save an image
            $imagine = new \Imagine\Gd\Imagine;
            $image = $imagine->open($structure.'/'.$new_file_name_full.'.'.$this->file->extension);

            $width = $image->getSize()->getWidth();
            $height = $image->getSize()->getHeight();

            $aspect_ratio = $width / $height;

            if($width == $height){
                $image  ->resize(new Box(720, 720))
                        ->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(720);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(1280);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[0] = true;
            $check['ext'] = $this->file->extension;

        }


        $new_file_name = '6o73r'.$id.'Eth';

        if ($pass) {
            // frame, rotate and save an image
            $imagine = new \Imagine\Gd\Imagine;
            $image = $imagine->open($structure.'/'.$new_file_name_full.'.'.$this->file->extension);

            $width = $image->getSize()->getWidth();
            $height = $image->getSize()->getHeight();

            $aspect_ratio = $width / $height;

            if($width == $height){
                $image  ->resize(new Box(250, 250))
                        ->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(254);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(254);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[1] = true;

        }

        $prefix = time().md5(uniqid(mt_rand(), true));
        $new_file_name_full2 = 'BFl'.$prefix.'EFl'.$id;

        if ($pass) {                
            $imagine = new \Imagine\Gd\Imagine;
            $image = $imagine->open($structure.'/'.$new_file_name_full.'.'.$this->file->extension);

            $width = $image->getSize()->getWidth();
            $height = $image->getSize()->getHeight();

            $aspect_ratio = $width / $height;

            if($width == $height){
                $image  ->resize(new Box(720, 720))
                        ->save($structure.'/'.$new_file_name_full2.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(720);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name_full2.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(1280);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name_full2.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[0] = true;
            $check['ext'] = $this->file->extension;

        }


        $new_file_name2 = 'BTh'.$prefix.'Eth'.$id;

        if ($pass) {
            // frame, rotate and save an image
            $imagine = new \Imagine\Gd\Imagine;
            $image = $imagine->open($structure.'/'.$new_file_name_full2.'.'.$this->file->extension);

            $width = $image->getSize()->getWidth();
            $height = $image->getSize()->getHeight();

            $aspect_ratio = $width / $height;

            if($width == $height){
                $image  ->resize(new Box(250, 250))
                        ->save($structure.'/'.$new_file_name2.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(254);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name2.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(254);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name2.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[1] = true;

        }

        if($pass){
            Yii::$app->session->setFlash('success', "Albumas sėkmingai sukurtas!");
        }

        return $check;

    }

    static function preCheck($params)
    {
        $check[0] = false;
        $pass = false;
        $id = (isset($id))? 0 : 1;

        $structure = "uploads/".$id."/";

        $new_file_name_full = '6o73r'.$id.'EFl';

            
        $pass = true;

        //$this->file->saveAs($structure.'/'.$new_file_name_full.'.' . $this->file->extension);
        // frame, rotate and save an image
        $imagine = new \Imagine\Gd\Imagine;
        //$image = $imagine->open($structure.'/'.$new_file_name_full.'.'.$this->file->extension);

        $width = 100;
        $height = 100;

        $aspect_ratio = $width / $height;

        if($width == $height){
            //$image  ->resize(new Box(720, 720))
                    //->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
        }else if($aspect_ratio > 1){

            $action = $image->getSize()->heighten(720);

            $size = new Box($action->getWidth(), $action->getHeight());

            //$image  ->resize($size)
                    //->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
        }else{
            $action = $image->getSize()->widen(1280);

            $size = new Box($action->getWidth(), $action->getHeight());
            $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

            //$image  ->resize($size)
                    //->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
        }

        $check[0] = true;
 


        $new_file_name = '6o73r'.$id.'Eth';

        if ($pass) {
            // frame, rotate and save an image
            $passgird = \kartik\grid\GridPreCheck::useFilters($params);
            //$image = $imagine->open($structure.'/'.$new_file_name_full.'.'.$this->file->extension);



            $aspect_ratio = $width / $height;

            if($width == $height){
                //$image  ->resize(new Box(250, 250))
                        //->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(254);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size);
                        //->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(254);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size);
                        //->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[1] = true;

        }

        $prefix = time().md5(uniqid(mt_rand(), true));
        $new_file_name_full2 = 'BFl'.$prefix.'EFl'.$id;

        if ($pass) {                
            $imagine = new \Imagine\Gd\Imagine;
            //$image = $imagine->open($structure.'/'.$new_file_name_full.'.'.$this->file->extension);


            $aspect_ratio = $width / $height;

            if($width == $height){
                //$image  ->resize(new Box(720, 720));
                        //->save($structure.'/'.$new_file_name_full2.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(720);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size);
                        //->save($structure.'/'.$new_file_name_full2.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(1280);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size);
                        //->save($structure.'/'.$new_file_name_full2.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[0] = true;

        }


        $new_file_name2 = 'BTh'.$prefix.'Eth'.$id;

        if ($pass) {
            // frame, rotate and save an image
            $imagine = new \Imagine\Gd\Imagine;
            //$image = $imagine->open($structure.'/'.$new_file_name_full2.'.'.$this->file->extension);

            if($width == $height){
                //$image  ->resize(new Box(250, 250));
                        //->save($structure.'/'.$new_file_name2.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(254);

                $size = new Box($action->getWidth(), $action->getHeight());

                //$image  ->resize($size);
                        //>save($structure.'/'.$new_file_name2.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(254);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size);
                        //-/>save($structure.'/'.$new_file_name2.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[1] = true;

        }

        return $check;
    }

    public function fotoNew($id)
    {   
        $check[0] = false;
        $pass = false;

        $str = (isset($_GET['str']))? $_GET['str'] : "";

        if($str == "p"){
            $str = "profile";
        }

        if(!$str){
            $structure = "uploads/".$id;    
        }else{
            $structure = "uploads/".$id."/".$str;  
        }

        if (!is_dir($structure)) {
            BaseFileHelper::createDirectory($structure, $mode = 0777);
        }


        $prefix = time().md5(uniqid(mt_rand(), true));
        $new_file_name_full = 'BFl'.$prefix.'EFl'.$id;

        if ($this->file && $this->validate()) {                
            $pass = true;

            $this->file->saveAs($structure.'/'.$new_file_name_full.'.' . $this->file->extension);
            // frame, rotate and save an image
            $imagine = new \Imagine\Gd\Imagine;
            $image = $imagine->open($structure.'/'.$new_file_name_full.'.'.$this->file->extension);

            $width = $image->getSize()->getWidth();
            $height = $image->getSize()->getHeight();

            $aspect_ratio = $width / $height;

            if($width == $height){
                $image  ->resize(new Box(720, 720))
                        ->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(720);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(1280);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[0] = true;
            $check['ext'] = $this->file->extension;

        }


        $new_file_name = 'BTh'.$prefix.'Eth'.$id;

        if ($pass) {
            // frame, rotate and save an image
            $imagine = new \Imagine\Gd\Imagine;
            $image = $imagine->open($structure.'/'.$new_file_name_full.'.'.$this->file->extension);

            $width = $image->getSize()->getWidth();
            $height = $image->getSize()->getHeight();

            $aspect_ratio = $width / $height;

            if($width == $height){
                $image  ->resize(new Box(250, 250))
                        ->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(254);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(254);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[1] = true;
            $check['n'] = $new_file_name_full.'.'.$this->file->extension;
            $check['d'] = $structure;
        }

        if($pass){
            Yii::$app->session->setFlash('success', "Nuotrauka sėkmingai įkelta!");
        }

        return $check;

    }

    public function Albums($id)
    {


        $provider = new ActiveDataProvider([
            'query' => Albums::find()->where(['u_id' => $id]),
            'sort' => [
                'defaultOrder' => [
                    'timestamp' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $provider;
    }

    public function ChangeAlbumCover($model)
    {
        $check[0] = false;
        $pass = false;

        $id = $model->u_id;

        $structure = "uploads/".$id."/".$model->name;

        $new_file_name_full = '6o73r'.$id.'EFl';


        if ($this->file && $this->validate()) {                
            $pass = true;

            $this->file->saveAs($structure.'/'.$new_file_name_full.'.' . $this->file->extension);
            // frame, rotate and save an image
            $imagine = new \Imagine\Gd\Imagine;
            $image = $imagine->open($structure.'/'.$new_file_name_full.'.'.$this->file->extension);

            $width = $image->getSize()->getWidth();
            $height = $image->getSize()->getHeight();

            $aspect_ratio = $width / $height;

            if($width == $height){
                $image  ->resize(new Box(720, 720))
                        ->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(720);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(1280);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name_full.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[0] = true;
            $check['ext'] = $this->file->extension;

        }


        $new_file_name = '6o73r'.$id.'Eth';

        if ($pass) {
            // frame, rotate and save an image
            $imagine = new \Imagine\Gd\Imagine;
            $image = $imagine->open($structure.'/'.$new_file_name_full.'.'.$this->file->extension);

            $width = $image->getSize()->getWidth();
            $height = $image->getSize()->getHeight();

            $aspect_ratio = $width / $height;

            if($width == $height){
                $image  ->resize(new Box(250, 250))
                        ->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(254);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(254);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[1] = true;

        }

        $prefix = time().md5(uniqid(mt_rand(), true));
        $new_file_name_full2 = 'BFl'.$prefix.'EFl'.$id;

        if ($pass) {                
            $imagine = new \Imagine\Gd\Imagine;
            $image = $imagine->open($structure.'/'.$new_file_name_full.'.'.$this->file->extension);

            $width = $image->getSize()->getWidth();
            $height = $image->getSize()->getHeight();

            $aspect_ratio = $width / $height;

            if($width == $height){
                $image  ->resize(new Box(720, 720))
                        ->save($structure.'/'.$new_file_name_full2.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(720);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name_full2.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(1280);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name_full2.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[0] = true;
            $check['ext'] = $this->file->extension;

        }


        $new_file_name2 = 'BTh'.$prefix.'Eth'.$id;

        if ($pass) {
            // frame, rotate and save an image
            $imagine = new \Imagine\Gd\Imagine;
            $image = $imagine->open($structure.'/'.$new_file_name_full2.'.'.$this->file->extension);

            $width = $image->getSize()->getWidth();
            $height = $image->getSize()->getHeight();

            $aspect_ratio = $width / $height;

            if($width == $height){
                $image  ->resize(new Box(250, 250))
                        ->save($structure.'/'.$new_file_name2.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(254);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name2.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(254);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size)
                        ->save($structure.'/'.$new_file_name2.'.'.$this->file->extension, ['quality' => 85]);
            }

            $check[1] = true;

        }

        if($pass){
            Yii::$app->session->setFlash('success');
        }

        return $check;
    }

    public function saveToProfile($id, $str)
    {
        // Checkina ar vartotojas prisijungęs ir ar yra įmanoma išgauti vartotojo id duomenis
        if (!isset(Yii::$app->user->id)
            || isset(Yii::$app->user->id) && Yii::$app->user->id == NULL)
            $vartotojo_id = $id;
        else
            $vartotojo_id = Yii::$app->user->id;

        $check[0] = false;
        $pass = false;
        $check['ext'] = "";
        $check['complete'] = "";

        $path = "uploads/".$id;

        $prefix = time().md5(uniqid(mt_rand(), true));
        $full = 'BFl'.$prefix.'EFl'.$id . '.' . $this->file->extension;
        $thumb = 'BTh'.$prefix.'ETh'.$id . '.' . $this->file->extension;

        if ($this->file && $this->validate()) {

            BaseFileHelper::createDirectory($path, 0777);

            $this->file->saveAs($path . $full);

            $imagine = new Imagine();

            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

            $size = new \Imagine\Image\Box(250, 250);
            $imagine->open($path . $full)
                ->thumbnail($size, $mode)
                ->save($path . $thumb);

            $model = new Photos;
            $model->u_id = $vartotojo_id;
            $model->pureName = $prefix;
            $model->ext = $this->file->extension;
            $model->friendsOnly = 0;
            $model->profile = 1;
            $model->timestamp = time();
            $model->save();

            $imagine = new Imagine();

            $profileName = '531B' . $vartotojo_id . 'Iav.' . $this->file->extension;

            $model = User::find()->where(['id' => $vartotojo_id])->one();
            $model->avatar = $this->file->extension;
            $model->save();
            

            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

            $size = new \Imagine\Image\Box(250, 250);
            $imagine->open($path . $full)
                ->thumbnail($size, $mode)
                ->save('uploads/' . $profileName);

            $check[0] = true;
            $check[1] = true;

            $check['ext'] = $this->file->extension;
            $check['n'] = $new_file_name_full . '.' . $this->file->extension;
            $check['d'] = $path;
            $check['complete'] = 1;

            Yii::$app->session->setFlash('success', "Nuotrauka sėkmingai įkelta!");
        }

        return $check;

    }

//    public function saveToProfile($id, $str)
//    {
//
//        $check[0] = false;
//        $pass = false;
//        $check['ext'] = "";
//        $check['complete'] = "";
//
//        $path = "uploads/".$id;
//
//        $prefix = time().md5(uniqid(mt_rand(), true));
//        $full = 'BFl'.$prefix.'EFl'.$id . '.' . $this->file->extension;
//        $thumb = 'BTh'.$prefix.'ETh'.$id . '.' . $this->file->extension;
//
//        if ($this->file && $this->validate()) {
//
//            BaseFileHelper::createDirectory($path, 0777);
//
//            $this->file->saveAs($path . $full);
//
//            $imagine = new Imagine();
//
//            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
//
//            $size = new \Imagine\Image\Box(250, 250);
//            $imagine->open($path . $full)
//                ->thumbnail($size, $mode)
//                ->save($path . $thumb);
//
//            $model = new Photos;
//            $model->u_id = Yii::$app->user->id;
//            $model->pureName = $prefix;
//            $model->ext = $this->file->extension;
//            $model->friendsOnly = 0;
//            $model->profile = 1;
//            $model->timestamp = time();
//            $model->save();
//
//            $imagine = new Imagine();
//
//            $profileName = '531B' . Yii::$app->user->id . 'Iav.' . $this->file->extension;
//
//            if (isset($this->file->extension) && $this->file->extension != null)
//            {
//                $model = User::find()->where(['id' => Yii::$app->user->id])->one();
//                $model->avatar = $this->file->extension;
//                $model->save();
//            }
//
//
//            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
//
//            $size = new \Imagine\Image\Box(250, 250);
//            $imagine->open($path . $full)
//                ->thumbnail($size, $mode)
//                ->save('uploads/' . $profileName);
//
//            $check[0] = true;
//            $check[1] = true;
//
//            $check['ext'] = $this->file->extension;
//            $check['n'] = $new_file_name_full . '.' . $this->file->extension;
//            $check['d'] = $path;
//            $check['complete'] = 1;
//
//            Yii::$app->session->setFlash('success', "Nuotrauka sėkmingai įkelta!");
//        }
//
//        return $check;
//
//    }

    public function choosePPic($id, $file, $ext)
    {
        $profileName = '531B'.$id.'Iav';

        $imagine = new \Imagine\Gd\Imagine;
        $image = $imagine->open($file);

        $width = $image->getSize()->getWidth();
        $height = $image->getSize()->getHeight();

        $aspect_ratio = $width / $height;

        if($width == $height){
            $image  ->resize(new Box(250, 250))
                    ->save('uploads/'.$profileName.'.'.$ext, ['quality' => 85]);
        }else if($aspect_ratio > 1){

            $action = $image->getSize()->heighten(254);

            $size = new Box($action->getWidth(), $action->getHeight());

            $image  ->resize($size)
                    ->save('uploads/'.$profileName.'.'.$ext, ['quality' => 85]);
        }else{
            $action = $image->getSize()->widen(254);

            $size = new Box($action->getWidth(), $action->getHeight());
            $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

            $image  ->resize($size)
                    ->save('uploads/'.$profileName.'.'.$ext, ['quality' => 85]);
        }

        $check[1] = true;

        return $check;
    }

}
