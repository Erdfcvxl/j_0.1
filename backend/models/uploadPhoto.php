<?php

namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Imagine\Gd\Imagine;
use yii\helpers\BaseFileHelper;

class uploadPhoto extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('../../frontend/web/css/img/pazintys_lietuviams.jpg');


            return true;
        } else {
            return false;
        }
    }
}

?>