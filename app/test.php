<?php
include_once('./_common.php');
if(!$mb_id) {
    alert("로그인한 사용자만 이용이 가능합니다.");
    exit;
}
makeMbrRoot();
$row = sql_fetch("SELECT fold_id FROM he_mbr_fold  WHERE up_fold_id = '$mb_id'");
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
        <div id="tree" class="col-md-3 col-sm-3" style="display:none"></div>
        <div class="col-md-9 col-sm-9" id="contentBox">
            <div id="content">
                <nav class='navbar navbar-default' role='navigation'>
                    <div class='navbar-header'><a class='navbar-brand' href='#'>Home</a></div>
                    <div><ul class='nav navbar-nav' id='navdata'></ul></div>
                    <div><p class='navbar-text navbar-right'>
                            <button type='button' class='btn btn-default' id='svBt'>
                                <span class='glyphicon glyphicon-inbox'></span>
                            </button>
                            <button type='button' class='btn btn-default' id='tgBt'>
                                <span class='glyphicon glyphicon-th-large'></span>
                            </button>
                        </p></div>
                </nav>
                <table class='table'>
                    <thead>
                        <tr>
                            <th>파일명</th>
                            <th>유형</th>
                            <th>크기</th>
                            <th>등록일</th>
                        </tr>
                    </thead>
                    <tbody id="filelist"></tbody>
                </table>
            </div>
        </div>
        <div id="drop-area" style="display: none">
            <nav class="navbar navbar-default" role="navigation">
                <div class='navbar-text navbar-right'>
                <button class="btn btn-success" onclick="sendFormData()">파일업로드</button>
                </div>
                
            </nav>
            <ul id="uploadList"></ul>
            <div class="drop-text">
            <h4>이곳에 파일을 놓으세요.</h4>
            <h5>또는</h5>
            <h3><button class="btn btn-default">파일을 선택하세요</button></h3>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="foldId"  id="foldId" value="<?=$row['fold_id']?>"/>
</body>
</html> 