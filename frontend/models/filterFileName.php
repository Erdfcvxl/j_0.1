<?php

namespace frontend\models;

use yii\helpers\BaseFileHelper;


class filterFileName
{
    public $extract;
    public $ext;

	public static function filter($filename)
	{
		
		$parts = explode("/", $filename);

		$name = $parts[count($parts)-1];

		$extracts = filterFileName::nameExtraction($name);

		$complete = "BFl".$extracts['pure']."EFl".$extracts['lastChar'];
		$file = '';

		if(count($parts) > 1){
			for($i = 0; $i < count($parts) - 1; $i++){
				$file = $file.$parts[$i]."/";
			}

			$file = $file.$complete;
		}else{
			$file = $complete;
		}

		return $file;
	}

	public static function nameExtraction($n)
    {
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

        $bePradzios = substr($n, 3);

        $irBeGalo = substr($bePradzios, 0, (strlen($bePradzios) - ($i - 3) * -1));

        $ext = substr($n, -3);


        $complete['pure'] = $irBeGalo;
        $complete['pirmostrys'] = $pirmostrys;
        $complete['lastChar'] = $lastChar;
        $complete['ext'] = $ext;
        $complete['ownerId'] = $ownerId;

        return $complete;
    }

    public function convertToFull($file)
    {
        $parts = self::nameExtraction($file);

        if($parts['pirmostrys'] != "BFl"){
            $file = "BFl".$parts['pure']."EFl".$parts['lastChar'];
        }

        return $file;

    }

    public function extract($pure, $id)
    {
        $model = Photos::getPhoto($pure, $id);

        if($model->ext)
            $this->ext = $model->ext;
        else{
            $dir = 'uploads/'.$id;
            $photos = BaseFileHelper::findFiles($dir);

            foreach ($photos as $photo){
                if (strpos($photo, $pure) !== false) {
                    $photo = BaseFileHelper::normalizePath($photo, '/');
                    $parts = explode('/', $photo);
                    $name = getPhotoList::nameExtraction($parts[count($parts)-1]);

                    $this->extract = $name;

                    break;
                }
            }

        }


    }

    public function getFullFl()
    {
        $e =$this->extract;
        $result = 'BFl'.$e['pure'].'EFl'.$e['lastChar'];

        if(file_exists ('uploads/'.$e['ownerId'].'/'.$result))
            return $result;

        return null;
    }

    public function getFullTh()
    {
        $e =$this->extract;
        $result = 'BTh'.$e['pure'].'ETh'.$e['lastChar'];

        if(file_exists ('uploads/'.$e['ownerId'].'/'.$result))
            return $result;

        return null;
    }

}

?>