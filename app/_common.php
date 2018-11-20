<?php
include_once '../common.php';
/*
 * 중복되지 않는 아이디를 발생시킨다.
*/
function getId($pre){
    $uniq = uniqid("",true);
    $ua = explode(".",$uniq);
    $uuid = $ua[1].$ua[0];
    $aa = str_split($uuid,3);
    $rs = "";
    $src = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",1);
    foreach ($aa as &$value){
        $v = hexdec($value) / 62;
        if ($v > 62) {
            $v = $v - 62;
        }
        $rs .= $src[(int)$v]; 
        $rs .= $src[hexdec($value) % 62]; 
//        $rs .= $src[$v];
//        $rs .= $src[(int)$value % 62];
    }
    
    return $pre.$rs;
}

function get_time() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function addSizeUnit($size){
    if($size < 1024) return $size." byte";
    $size = round($size / 1024, 2);
    if($size < 1024) return $size." KB";
    $size = round($size / 1024, 2);
    if($size < 1024) return $size." MB";
    $size = round($size / 1024, 2);
    if($size < 1024) return $size." GB";
    $size = round($size / 1024, 2);
    return $size." TB";
}