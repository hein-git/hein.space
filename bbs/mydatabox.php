<?php
include_once('./_common.php');

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_BBS_URL."/mydatabox.php"));


$mb_profile = ($member['mb_profile']) ? conv_content($member['mb_profile'],0) : '';
$mb_signature = ($member['mb_signature']) ? apms_content(conv_content($member['mb_signature'], 1)) : '';

// Page ID
$pid = ($pid) ? $pid : 'mydatabox';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_mypage_sub = false;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = $member['mb_nick'].'님 자료실';

if($is_mypage_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=member&amp;ts='.urlencode(THEMA);
}

//include_once($skin_path.'/mypage.skin.php');

?>


<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="/css/jquery.fileupload.css">
<link rel="stylesheet" href="/css/jquery.fileupload-ui.css">

<div class="row at-row">
	<div class="col-md-3 at-col at-main">
		<div id="mydatatree">
			<div id="tree"></div>
		</div>
	</div>
	<div class="col-md-9 at-col at-main">
		<div id="mydatafile">

    <form id="fileupload" action="https://jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data" class="">
        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>파일추가...</span>
                    <input type="file" name="files[]" multiple="">
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>업로드</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>취소</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>삭제</span>
                </button>
                <input type="checkbox" class="toggle">
                <span class="fileupload-process"></span>
            </div>
            <div class="col-lg-5 fileupload-progress fade">
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
    </form>	
			
		</div>
	</div>
</div>
<?php	
if($is_mypage_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>
<!-- The basic File Upload plugin -->
<script src="/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="/js/jquery.fileupload-ui.js"></script>

<script src="/js/bootstrap-treeview.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#tree').treeview({data:  [{text: "교육자료",nodes: [{text: "1학년", nodes: [ {text: "학습자료" }, { text: "놀이자료" }]},{text: "3학년" }] }, { text: "여행자료"},{text: "공문"}]});
});

</script>