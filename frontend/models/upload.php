<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 5/8/2016
 * Time: 1:20 AM
 */

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;
use Imagine\Gd\Imagine;
use yii\helpers\BaseFileHelper;
use yii\base\Model;


class upload extends Model
{
    public $file;
    public $friendsOnly;

    public function rules()
    {
        return [
            ['friendsOnly' , 'safe']
        ];
    }

    public function upload($id, $path = null)
    {

        if(!$path)
            $path = 'uploads/'.$id.'/';



        $prefix = time().md5(uniqid(mt_rand(), true));
        $full = 'BFl'.$prefix.'EFl'.$id . '.' . $this->file->extension;
        $thumb = 'BTh'.$prefix.'ETh'.$id . '.' . $this->file->extension;

        BaseFileHelper::createDirectory($path, 0777);

        $this->file->saveAs($path . $full);

        $imagine = new Imagine();

        $mode    = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

        $size    = new \Imagine\Image\Box(250, 250);
        $imagine->open($path.$full)
            ->thumbnail($size, $mode)
            ->save($path.$thumb);

        $model = new Photos;
        $model->u_id = Yii::$app->user->id;
        $model->pureName = $prefix;
        $model->ext = $this->file->extension;
        $model->friendsOnly = $this->friendsOnly;
        $model->timestamp = time();
        $model->save();

        return ['n' => $full, 'd' => $path];

    }

    public function changeProfilePicture($n, $d)
    {
        $imagine = new Imagine();

        $ext = pathinfo($d.$n, PATHINFO_EXTENSION);
        $profileName = '531B'.Yii::$app->user->id.'Iav.'.$ext;

        $model = User::find()->where(['id' => Yii::$app->user->id])->one();
        $model->avatar = $ext;
        $model->save();

        $mode    = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

        $size    = new \Imagine\Image\Box(250, 250);
        $imagine->open($d.$n)
            ->thumbnail($size, $mode)
            ->save('uploads/'.$profileName);

    }
}