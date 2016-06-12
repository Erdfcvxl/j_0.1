<?php

namespace frontend\models;

use Yii;
use yii\helpers\BaseFileHelper;
use frontend\models\Photos;

class getPhotoList
{

    public static function makeArray($dir)
    {

        $prideti = true;
        $result = null;

        $dirParts = explode('/', $dir);

        $photos = BaseFileHelper::findFiles(substr($dir, 1));

        foreach ($photos as $photo){

            $photo = BaseFileHelper::normalizePath($photo, '/');
            $parts = explode('/', $photo);
            $truename = $name = $parts[count($parts)-1];


            if(count($parts) == 3)
                $name = $parts[count($parts)-1];
            else
                $name = $parts[count($parts)-2].'/'.$parts[count($parts)-1];

            if(strlen($name) > 2){

                $pirmostrys = substr($truename, 0, 3);

                if($pirmostrys == "BTh"){

                    $files[] = $name;
                }
            }
        }


        if(isset($files)){

            sort($files);



	        foreach($files as $file){
                $prideti = true;

        	    $i = -5;
                for($ratas = 0; $ratas < 100; $ratas++){
                    if(substr($file, $i, 2) == "Fl")
                        break;

                    if(substr($file, $i, 2) == "th")
                        break;

                    if(substr($file, $i, 2) == "Th")
                        break;

                    $i--;
                }
                $i = $i + 2;

                $lastChar = substr($file, $i);
                $ownerId = substr($lastChar, 0, (strlen($lastChar) - 4));

                $bePradzios = substr($file, 3);

                $irBeGalo = substr($bePradzios, 0, (strlen($bePradzios) - ($i - 3) * -1));

	            $fullname = "BFl".$irBeGalo."EFl".$lastChar;



                if($dirParts[2] != Yii::$app->user->id)
                    if($model = Photos::find()->where(['pureName' => $irBeGalo])->andWhere(['u_id' => $dirParts[2]])->one())
                        if($model->friendsOnly){
                            if(!\frontend\models\Friends::arDraugas($dirParts[2]))
                                $prideti = false;
                        }


                //
                if($prideti)
	                $result[] = $fullname;
	        }

        }else{
        	$result = [];
        }


        return $result;
    }

    public static function nameExtraction($n)
    {
        set_time_limit (3);

        $pirmostrys = substr($n, 0, 3);

        if($pirmostrys){
            if(substr($n, 0, 1) == "B" && strlen($n) > 10){

                $i = -5;
                while(true || $i < -100){
                    if(substr($n, $i, 2) == "Fl")
                        break;

                    if(substr($n, $i, 2) == "th")
                        break;

                    if(substr($n, $i, 2) == "Th")
                        break;

                    $i--;
                }
                $i = $i + 2;

            }
        }

        $lastChar = substr($n, $i);
        $ownerId = substr($lastChar, 0, (strlen($lastChar) - 4));
        $ownerId = reset(explode('.', $ownerId));

        $bePradzios = substr($n, 3);

        $irBeGalo = substr($bePradzios, 0, (strlen($bePradzios) - ($i - 3) * -1));

//        $ext = substr(substr($n, -5), strpos($n, ".") + 1);

        $ext = substr($n, -5);
//        $ext = substr($ext, strpos($n, ".") + 1);
        $ext = end(explode('.', $ext));

        $ending = substr($n, -3 - $i - 2, 2);


        $complete['pure'] = $irBeGalo;
        $complete['pirmostrys'] = $pirmostrys;
        $complete['lastChar'] = $lastChar;
        $complete['ending'] = $ending;
        $complete['ext'] = $ext;
        $complete['ownerId'] = $ownerId;

        return $complete;

    }

    public static function fixProfileDir($id)
    {

        $trinti = false;

        $photos = BaseFileHelper::findFiles("uploads/".$id."/");

        foreach ($photos as $photo){
            $photo = BaseFileHelper::normalizePath($photo, '/');
            $parts = explode('/', $photo);

            if($parts[2] == "profile"){
                $trinti = true;
                break;
            }
        }

        if($trinti)
            Photos::deleteProfileDir($id);


    }
}