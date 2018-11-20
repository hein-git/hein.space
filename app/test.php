<?php
include_once('./_common.php');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/app/upload.css">
    <script type="text/javascript" src="/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="/js/app/upload.js"></script>
</head>
<body>
<div id="wrapper">
 <input type="file">
 <div id="drop-area">
  <h3 class="drop-text">Drag & Drop Here <?php 
  $start = get_time();
  //for($i=0;$i<10000;$i++) {getId();}
  //echo get_time() - $start; 

  print getId();
  ?></h3>
 </div>
</div>
<input type="hidden" name="foldId" value="FDuPvCmDXsWKIgMBab" id="foldId"/>
</body>
</html> 