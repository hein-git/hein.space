<?php
include_once('./_common.php');
if(is_ajax()){ 
    if(isset($_POST['cmd']) && !empty($_POST['cmd'])){
        $mb_id = $member['mb_id'];
        $cmd = $_POST['cmd'];
        switch($cmd){
            case "getTreeData":
                getTreeData();
                break;
            case "getNavBar":
                getNavBar();
                break;
            case "getFileList":
                getFileList();
                break;
            
        }
    } else {
        echo "올바른 요청이 아닙니다.";
    }
} else {
    echo "<script>alert('올바른 접근이 아닙니다.');history.go(-1);</script>";
    die();
}

function getTreeData(){
    global $mb_id;
    $sql = "WITH RECURSIVE FOLD AS ( "
            . "SELECT fold_id, up_fold_id,fold_nm FROM he_mbr_fold  WHERE up_fold_id = '$mb_id'  "
            ." UNION ALL "
            ." SELECT a.fold_id, a.up_fold_id,a.fold_nm FROM he_mbr_fold a INNER JOIN FOLD b ON a.up_fold_id = b.fold_id ) "
            ." SELECT fold_id, up_fold_id,fold_nm from FOLD";
    $result = sql_query($sql);
    $nodes = array();
    for($i=0; $row=sql_fetch_array($result); $i++) {
        if( empty($nodes[$row['up_fold_id']])) $nodes[$row['up_fold_id']] = Array();
        $nodedata = (object)[];
        $nodedata->text = $row['fold_nm'];
        $nodedata->id = $row['fold_id'];
        array_push($nodes[$row['up_fold_id']], $nodedata);
    }
    $rtnval = nodemake($nodes, $mb_id);
    echo json_encode($rtnval);
}

function getNavBar(){
    global $mb_id;
    $fold_id = $_POST["id"];
    $sql = "WITH RECURSIVE FOLD AS ( "
            . "SELECT fold_id, up_fold_id,fold_nm FROM he_mbr_fold  WHERE fold_id = '$fold_id' and mb_id = '$mb_id'  "
            ." UNION ALL "
            ." SELECT a.fold_id, a.up_fold_id,a.fold_nm FROM he_mbr_fold a INNER JOIN FOLD b ON a.fold_id = b.up_fold_id ) "
            ." SELECT fold_id, up_fold_id,fold_nm from FOLD";
    $result = sql_query($sql);
    $rtn = array();
    while($row=sql_fetch_array($result)) {
        $nodedata = (object)[];
        $nodedata->id = $row['fold_id'];
        $nodedata->name = $row['fold_nm'];
        array_push($rtn, $nodedata);        
    }
    echo json_encode(array_reverse($rtn));
}


function getFileList(){
    global $mb_id;
    $fold_id = $_POST["id"];
    $sql = "SELECT a.file_id, a.file_oname, b.file_type, b.file_size,b.file_reg_dtm ";
    $sql .= "FROM he_mbr_file a ";
    $sql .= "INNER JOIN he_repo_file b ON a.file_id = b.file_id ";
    $sql .= "WHERE a.fold_id = '$fold_id' ";
    $sql .= "AND a.mb_id = '$mb_id' ";
    
    $result = sql_query($sql);
    $rtn = array();
    while($row=sql_fetch_array($result)) {
        $nodedata = (object)[];
        $nodedata->id = $row['file_id'];
        $nodedata->name = $row['file_oname'];
        $nodedata->type = $row['file_type'];
        $nodedata->size = addSizeUnit($row['file_size']);
        $nodedata->reg_dt = $row['file_reg_dtm'];
        array_push($rtn, $nodedata);        
    }
    echo json_encode($rtn);
}

class TreeData {
    public $text;
    public $href = "#";
    public $color = "#888888";
    public $backColor = "rgba(80,80,180,0.1)";
    public $nodes = array();
}

function nodemake($nodes, $ukey){
    if(empty($nodes[$ukey])){
        return "";
    } else {
        $arrNode = array();
        foreach( $nodes[$ukey] as $val){
            $node =  new TreeData;
            $node->text = $val->text;
            $node->href = "javascript:view('{$val->id}')";
            $node->nodes = nodemake($nodes, $val->id);
            array_push($arrNode,$node);
        }
        return $arrNode;
    }
}

function is_ajax(){
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}