<?php

namespace App\Classes;

class Conversoes {

    public static function bytesToHuman($size, $precision=2)
    {
        $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $step = 1024;
        $i = 0;
        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }
        return round($size, $precision).' '.$units[$i];
    }   
}