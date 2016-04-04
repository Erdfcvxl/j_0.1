<?php

namespace frontend\models;


class filterFileName
{

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

    public function convertToFull($file)
    {
        $parts = self::nameExtraction($file);

        if($parts['pirmostrys'] != "BFl"){
            $file = "BFl".$parts['pure']."EFl".$parts['lastChar'];
        }

        return $file;

    }

}

?>