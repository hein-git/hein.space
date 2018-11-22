<?php
include_once('./_common.php');
if(!isset($_FILES['ufiles']['error'])){
    rtnErr("[EU-001]파일이 첨부되지 않았습니다.");
}
$rtnMsg = array();
$error = $_FILES['ufiles']['error'];
$mb_id = $member['mb_id'];
$fold_id = $_POST["foldId"];
foreach($error as $cnt=>$value){
    $name = $_FILES['ufiles']['name'][$cnt];
    if($value == UPLOAD_ERR_OK){
        $tmp_name = $_FILES['ufiles']['tmp_name'][$cnt];
        $org_nmae = trim($_FILES['ufiles']['name'][$cnt]);
        $type = $_FILES['ufiles']['type'][$cnt];
        $size = $_FILES['ufiles']['size'][$cnt];      
        $umsg = FileUpload($mb_id, $fold_id, $tmp_name,$org_nmae,$type,$size);
        if ($umsg == "dup") {
            array_push($rtnMsg, array ('file' => "$name",'stat'=>"성공",'msg'=>"동일한 파일이 이미 있습니다."));
        } else {
            array_push($rtnMsg, array ('file' => "$name",'stat'=>"성공",'msg'=>"업로드에 성공하였습니다."));
        }
        
    } else {
        switch($value) {
        case UPLOAD_ERR_INT_SIZE:
        case UPLOAD_ERR_FROM_SIZE:
            array_push($rtnMsg, array('file' => "$name",'stat'=>"실패", 'msg'=>"파일의 크기가 너무 큽니다."));
            break;
        case UPLOAD_ERR_INT_SIZE:
            array_push($rtnMsg, array('file' => "$name",'stat'=>"실패", 'msg'=>"파일이 첨부되지 않았습니다."));
            break;
        default:
            array_push($rtnMsg, array('file' => "$name",'stat'=>"실패", 'msg'=>"파일이 제대로 업로드되지 않았습니다."));
            break;
        }
    }
}
echo json_encode($rtnMsg);
/*
 * 파일을 업로드 하고 디비에 저장함.
 * - 중복파일을 제거한다.
 * - md5sum이 동일한 파일이 있는 경우 업로드하지 않고 기존 값을 복제한다.
 *
 */
function FileUpload($mb_id, $fold_id, $tnm, $onm, $mime, $size){
    $base = "/web_app/upload/";
    $type = getFileType($mime);
    $md5sum = md5_file($tnm);
    $row = sql_fetch("select file_id from he_repo_file where md5sum = '$md5sum'");
    $row2 = sql_fetch("select file_no from he_mbr_file where fold_id = '$fold_id' and file_oname = '$onm'");
    if (!empty($row['file_id'])) { // 동일한 md5sum 값으로 조회된 결과가 있는지 확인
        /* 동일한 폴더에 동일 파일(md5sum 과 파일명이 동일)을 업로드하면 무시함. */
        if (!empty($row2['file_no']))  return "dup";
        $file_id = $row['file_id'];
    } else {
        /* 동일한 폴더에 파일명이 동일하고 다른 파일을 업로드하면 기존 파일삭제 하고 업로드 */
        if (!empty($row2['file_no'])) {
            sql_query("update he_mbr_file set del_yn = 'Y' where file_id = {$row2['file_no']} ");
        }
        $file_id = getId("FL");
        $tgFold = date("Y/m/");
        if (!is_dir("$base$tgFold")) mkdir("$base$tgFold",0755, true);
        move_uploaded_file($tnm,"$base$tgFold$file_id");
        $sql = "insert into he_repo_file (file_id, md5sum, file_path, file_rname, "
            . "file_oname, file_type,  file_size, file_reg_dtm, reg_dtm)"
            . "values ('$file_id', '$md5sum', '$tgFold', '$file_id', "
            . "'$onm', '$type', '$size', now(), now())";
        sql_query($sql,true);
    }
    $sql = "insert into he_mbr_file (mb_id, fold_id, file_id, file_oname,  reg_dtm)"
            . "values ('$mb_id','$fold_id', '$file_id', '$onm', now())";
    sql_query($sql) or die( "$sql");
    return "success";
}

function rtnErr($msg) {
    echo json_encode( array(
        'status' => 'error',
        'message' => $msg
    ));
    exit;
}
?>
