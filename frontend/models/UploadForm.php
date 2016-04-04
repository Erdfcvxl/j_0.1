<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

use Imagine\Image\Box;
use Imagine\Image\Point;

use common\models\User;
/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'gif, jpg, png, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'message' => 'Ledžiami failo plėtiniai yra: gif, jpg, png, jpeg.'],
        ];
    }
    public function saveImage($id)
    { 

        $user = User::find()->where(['id' => $id])->one();
        $c_steps = explode(" ", $user->reg_step);

        $pref = mt_rand(100,1000);
        $new_file_name = '531B'.$id.'Iav';
        if ($this->file && $this->validate()) {                
            $this->file->saveAs('uploads/'.$new_file_name.'.' . $this->file->extension);

            $user->avatar = $this->file->extension;
            $user->save();

            // frame, rotate and save an image
            $imagine = new \Imagine\Gd\Imagine;
            $image = $imagine->open('uploads/'.$new_file_name.'.'.$this->file->extension);

            $width = $image->getSize()->getWidth();
            $height = $image->getSize()->getHeight();

            $aspect_ratio = $width / $height;

            if($width == $height){
                $image  ->resize(new Box(250, 250))
                        ->save('uploads/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }else if($aspect_ratio > 1){

                $action = $image->getSize()->heighten(254);

                $size = new Box($action->getWidth(), $action->getHeight());

                $image  ->resize($size)
                        ->save('uploads/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }else{
                $action = $image->getSize()->widen(254);

                $size = new Box($action->getWidth(), $action->getHeight());
                $size2 = new Box($action->getWidth()-4, $action->getHeight()-4);

                $image  ->resize($size)
                        ->save('uploads/'.$new_file_name.'.'.$this->file->extension, ['quality' => 85]);
            }

        }
        if(!array_search(3, $c_steps)){
            $user->reg_step = $user->reg_step." 3";
            $user->save();
        }
        
		return true;
    }
}

?>