<?php

namespace frontend\models;

class Ago
{

    public static function timeAgo($ts)
    {
        $ts = (int)$ts;

        $timestamp = time() - $ts; 

        if($timestamp > 31104000){
            $ago = "prieš ".floor($timestamp / 31104000); 
            if(floor($timestamp / 31104000) > 1){$ago .= " m.";}else{$ago .= " m.";} $ago .= "";
        }elseif($timestamp > 2592000){
            $ago = "prieš ".floor($timestamp / 2592000); 
            if(floor($timestamp / 2592000) > 1){$ago .= " mėn.";}else{$ago .= " mėn.";} $ago .= "";
        }elseif($timestamp > 604800){
            $ago = "prieš ".floor($timestamp / 604800);
            if(floor($timestamp / 604800) > 1){$ago .= " sav.";}else{$ago .= " sav.";} $ago .= "";
        }elseif($timestamp > 86400){
            $ago = "prieš ".floor($timestamp / 86400);
            if(floor($timestamp / 86400) > 1){$ago .= " d.";}else{$ago .= " d.";} $ago .= "";
        }elseif($timestamp > 3600) {
            $ago = "prieš ".floor($timestamp / 3600);
            if(floor($timestamp / 3600) > 1){$ago .= " val.";}else{$ago .= " val.";} $ago .= "";
        }elseif($timestamp > 60){
            $ago = "prieš ".floor($timestamp / 60);
            if(floor($timestamp / 60) > 1){$ago .= " min.";}else{$ago .= " min.";} $ago .= "";
        }else{
            $ago = "prieš 1 min.";
        }

        return $ago;
    }
}