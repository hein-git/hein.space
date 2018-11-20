<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (isset($_REQUEST['mfl']))  {
    $mfl = trim($_REQUEST['mfl']);
    $mfl = preg_replace("/[\<\>\'\"\%\=\(\)\s]/", "", $mfl);
    if ($mfl)
        $qstr .= '&amp;mfl=' . urlencode($mfl); // 정렬필드
} else {
    $mfl = '';
}

if (isset($_REQUEST['mfs']))  {
    $mfs = trim($_REQUEST['mfs']);
    $mfs = preg_replace("/[\<\>\'\"\%\=\(\)\s]/", "", $mfs);
    if ($mfs)
        $qstr .= '&amp;mfs=' . urlencode($mfs); // search field (검색 필드)
} else {
    $mfs = '';
}

if (isset($_REQUEST['mtx']))  { // search text (검색어)
    $mtx = get_search_string(trim($_REQUEST['mtx']));
    if ($mtx)
        $qstr .= '&amp;mtx=' . urlencode(cut_str($mtx, 20, ''));
} else {
    $mtx = '';
}

// 버튼컬러
$btn1 = (isset($boset['btn1']) && $boset['btn1']) ? $boset['btn1'] : 'black';
$btn2 = (isset($boset['btn2']) && $boset['btn2']) ? $boset['btn2'] : 'color';

// 보드상단출력
$is_bo_content_head = false;

?>