<?php
include_once('./_common.php');
if(!isset($_FILES['ufiles']['error'])){
    rtnErr("[EU-001]파일이 첨부되지 않았습니다.");
}
$error = $_FILES['ufiles']['error'];
if($error != UPLOAD_ERR_OK){
    switch($error) {
    case UPLOAD_ERR_INT_SIZE:
    case UPLOAD_ERR_FROM_SIZE:
        rtnErr("[EU-002]파일이 너무 큽니다. ($error)");
    case UPLOAD_ERR_INT_SIZE:
        rtnErr("[EU-003]파일이 첨부되지 않았습니다. ($error)");
    default:
        rtnErr("[EU-004]파일이 제대로 업로드되지 않았습니다. ($error)");
    }
}
$member_id = $member['mb_id'];
$fold_id = $_POST["foldId"];

FileUpload($member_id, $fold_id, $_FILES);
echo json_encode(array(
	'status' => 'ok',    
	'message' => "업로드성공"
));
/*
 * 파일을 업로드 하고 디비에 저장함.
 * - 중복파일을 제거한다.
 * - md5sum이 동일한 파일이 있는 경우 업로드하지 않고 기존 값을 복제한다. 
 * 
 */
function FileUpload($member_id, $fold_id, $file){
    $base = "/home/webadmin/docRoot/hein/upload/";
    $tmp_name = $file['ufiles']['tmp_name'];
    $file_oname = trim($file['ufiles']['name']);
    $md5sum = md5_file($tmp_name);
    $row = sql_fetch("select file_id from he_repo_file where md5sum = '$md5sum'");
    $row2 = sql_fetch("select file_no from he_mbr_file where folder_id = '$fold_id' and file_oname = '$file_oname'");
    if (!empty($row['file_id'])) { // 동일한 md5sum 값으로 조회된 결과가 있는지 확인
        /* 동일한 폴더에 동일 파일(md5sum 과 파일명이 동일)을 업로드하면 무시함. */
        if (!empty($row2['file_no']))  return; 
        $file_id = $row['file_id'];
    } else {
        /* 동일한 폴더에 파일명이 동일하고 다른 파일을 업로드하면 기존 파일삭제 하고 업로드 */
        if (!empty($row2['file_no'])) {
            sql_query("update he_mbr_file set del_yn = 'Y' where file_id = {$row2['file_no']} ");
        }
        $file_id = getId("FL");
        $type = $file['ufiles']['type'];
        $size = $file['ufiles']['size'];
        $dtm =  $file['ufiles']["lastModified"];
        $tgFold = date("Y/m/");
        mkdir("$base$tgFold",0755, true);
        move_uploaded_file($file['ufiles']['tmp_name'],"$base$tgFold$file_id");
        $sql = "insert into he_repo_file (file_id, md5sum, file_path, file_rname, "
            . "file_oname, file_type,  file_size, file_reg_dtm, reg_dtm)"
            . "values ('$file_id', '$md5sum', '$tgFold', '$file_id', "
            . "'$file_oname', '$type', '$size', now(), now())";
        sql_query($sql,true);
    }
//    $ext = array_pop(explode('.',$oname));
    $sql = "insert into he_mbr_file (mb_id, folder_id, file_id, file_oname,  reg_dtm)"
            . "values ('$member_id','$fold_id', '$file_id', '$file_oname', now())";
    sql_query($sql) or die( "$sql");
    
}
function rtnErr($msg){
    echo json_encode(array(
        'status' => 'error',
        'message' => $msg
    ));
    exit;
}
?>
