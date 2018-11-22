<?php
include_once '../common.php';
$mb_id = $member["mb_id"];
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
    $size = round($size / 1024, 1);
    if($size < 1024) return $size." KB";
    $size = round($size / 1024, 1);
    if($size < 1024) return $size." MB";
    $size = round($size / 1024, 1);
    if($size < 1024) return $size." GB";
    $size = round($size / 1024, 1);
    return $size." TB";
}

function makeMbrRoot(){
    global $mb_id;
    $row = sql_fetch("SELECT count(fold_id) cnt FROM he_mbr_fold  WHERE up_fold_id = '$mb_id'");
    if($row['cnt'] == 0) {
        $fdid = getId("FD");
        $sql = "insert into he_mbr_fold (fold_id, mb_id, up_fold_id, fold_nm,permission) ";
        $sql .= " values ('$fdid','$mb_id','$mb_id','사람과 교육 연구소','777')";
        sql_query($sql);
    }
}

function getFileType($mime){
    $arrType = explode("/",$mime);
    switch ($arrType[0]) {
        case "image":
            $type = "img";
            break;
        case "text":
            $type = "txt";
            break;
        case "audio":
            $type = "ado";
            break;
        case "video":
            $type = "vdo";
            break;
        case "application":
            switch(true){
                case stristr($arrType[1],"hwp"):
                case stristr($arrType[1],"doc"):
                case stristr($arrType[1],"ppt"):
                case stristr($arrType[1],"xls"):
                case stristr($arrType[1],"pdf"):
                    $type = "doc";
                    break;
                default:
                    $type = "app";
                    break;
            }
            break;
        default:
            $type = "etc";
            break;
    }
    return $type;
}
?>