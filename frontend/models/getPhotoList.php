<?php

namespace frontend\models;

use Yii;

class getPhotoList
{

    public static function makeArray($dir)
    {
        $dir = substr($dir, 1);

        $dh = opendir($dir);

        while (false !== ($filename = readdir($dh))) {
            
            
            if(strlen($filename) > 2){

                $pirmostrys = substr($filename, 0, 3);

                if($pirmostrys == "BTh"){
                    $files[] = $filename;
                }
            }
        }

        if(isset($files)){

            sort($files);

	        foreach($files as $file){


        	    $i = -5;
                for($ratas = 0; $ratas < 100; $ratas++){
                    if(substr($file, $i, 2) != "th"){
                        $i--;
                    }else{
                        break;
                    }
                }
                $i = $i + 2;

                $lastChar = substr($file, $i);
                $ownerId = substr($lastChar, 0, (strlen($lastChar) - 4));

                $bePradzios = substr($file, 3);

                $irBeGalo = substr($bePradzios, 0, (strlen($bePradzios) - ($i - 3) * -1));

	            $fullname = "BFl".$irBeGalo."EFl".$lastChar;


	            $result[] = $fullname;
	        }

        }else{
        	$result = null;
        }
    

        return $result;
    }

    public static function nameExtraction($n)
    {
        $pirmostrys = substr($n, 0, 3);

        if($pirmostrys){
            if(substr($n, 0, 1) == "B" && strlen($n) > 10){

                $i = -5;
                while(true){
                    if(substr($n, $i, 2) != "Fl"){
                        if(substr($n, $i, 2) != "th"){
                            $i--;
                        }else{
                            break;
                        }
                    }else{
                        break;
                    }
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
}