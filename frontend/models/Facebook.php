<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\helpers\Url;
use yii\helpers\BaseFileHelper;

class Facebook extends Model
{

    public $id;
    public $username;
    public $email;
    public $picture;
    public $user = false;


    public function login()
    {

        if($user = $this->getUser()){
            if((max(explode(' ', $user->reg_step))) == 4){
               Yii::$app->user->login($user, 3600 * 24 * 30); 
            }
            
            return $user;
        }
        
    }

    public function signup()
    {
        $model = new User;
        $model->username = $this->username;
        $model->auth_key = \Yii::$app->security->generateRandomString();
        $model->email = $this->email;
        $model->role = 10;
        $model->status = 10;
        $model->created_at = time();
        $model->fb_id = $this->id;
        $model->facebook = 1;
        $model->avatar = 'jpg';
        $model->save(false);

        $id = $model->id;

        $info = new InfoClear;
        $info->u_id = $id;
        $info->insert(false);


        $path = 'uploads/'.$id.'/profile/temp.jpg';

        $structure = 'uploads/'.$id.'/profile';  

        if (!is_dir($structure)) {
            BaseFileHelper::createDirectory($structure, $mode = 0777);
        }


        $f = (file_exists($path))? fopen($path, "a+") : fopen($path, "w+");
        fwrite($f, file_get_contents($this->picture));
        fclose($f);
        chmod($path, 0777);

        $this->saveToProfile($id);


        unlink($path);

        return $model;
        
    }

    public function getUser()
    {
        if ($this->user === false) {
            if($user = \common\models\User::find()->where(['fb_id' => $this->id])->one()){
                if($user->facebook){
                    return $this->user = $user;
                }
            }
        }

        return $this->user;
    }

    public function proccessPhoto($pathTake, $pathReturn, $fileTake, $fileReturn, $box, $width, $heigh)
    {
        $fileParts = explode('.', $fileTake);
        $returnFileParts = explode('.', $fileReturn);

        $imagine = new \Imagine\Gd\Imagine;
        $image = $imagine->open($pathTake.'/'.$fileParts[0].'.'.$fileParts[1]);

        $width = $image->getSize()->getWidth();
        $height = $image->getSize()->getHeight();

        $aspect_ratio = $width / $height;

        if($width == $height){

            $image  ->resize(new Box($box[0], $box[1]));
                    
        }else if($aspect_ratio > 1){

            $action = $image->getSize()->heighten($heigh);

            $size = new Box($action->getWidth(), $action->getHeight());

            $image  ->resize($size);
        }else{
            $action = $image->getSize()->widen($width);

            $size = new Box($action->getWidth(), $action->getHeight());
            $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

            $image  ->resize($size);
        }

        $image->save($pathReturn.'/'.$returnFileParts[0].'.'.$fileParts[1], ['quality' => 85]);
    }

    public function saveToProfile($id)
    {

        $path = "uploads/".$id."/profile";    

        if (!is_dir($path)) {
            BaseFileHelper::createDirectory($structure, $mode = 0777);
        }

        $prefix = time().md5(uniqid(mt_rand(), true));
        $new_file_name_full = 'BFl'.$prefix.'EFl'.$id;
        $new_file_name_thumb = 'BTh'.$prefix.'Eth'.$id;
        $new_file_name_prof = '531B'.$id.'Iav';

        //geros kokybės $pathTake, $pathReturn, $fileTake, $fileReturn, $box, $width, $heigh
        $this->proccessPhoto($path, $path, 'temp.jpg', $new_file_name_full, [720,720], 1280, 720);
        //geros thumbnail
        $this->proccessPhoto($path, $path, 'temp.jpg', $new_file_name_thumb, [250,250], 254, 254);
        //geros progile
        $this->proccessPhoto($path, "uploads", 'temp.jpg', $new_file_name_prof, [500,500], 504, 504);


    }
}