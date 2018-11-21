<?php
include_once('./_common.php');

$row = sql_fetch("SELECT fold_id FROM he_mbr_fold WHERE up_fold_id = '{$member['mb_id']}'")
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link href="/thema/Basic/assets/bs3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/bootstrap-treeview.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/app/upload.css" rel="stylesheet" type="text/css"/>
    <script src="/js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="/js/bootstrap-treeview.min.js" type="text/javascript"></script>
    <script src="/js/app/upload.js" type="text/javascript"></script>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
 <div class="navbar-header" id="navTitle">
 <a class="navbar-brand" href="#">Test PHP</a>
 </div>
 <div>
 <form class="navbar-form navbar-left" role="search">
 <div class="form-group">
 <input type="text" class="form-control" placeholder="Search">
 </div>
 <button type="submit" class="btn btn-default">검색</button>
 </form>
 </div>
</nav>
<div id="wrapper">
    <div class="row">
        <div id="tree" class="col-md-3 col-sm-3"></div>
        <div class="col-md-9 col-sm-9" id="contentBox">
            <div id="content"></div>
            <div id="drop-area">
            <h3 class="drop-text">Drag & Drop Here</h3>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="foldId" id="foldId" value="<?=$row['fold_id']?>"/>
</body>
</html>  