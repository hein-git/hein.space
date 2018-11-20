<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once($board_skin_path.'/list.rows.php');

// 분류설정
unset($categories);

// 보임설정
$is_name = (isset($boset['lname']) && $boset['lname']) ? true : false;
$is_grade = (isset($boset['lgrade']) && $boset['lgrade']) ? true : false;
$is_join = (isset($boset['ljoin']) && $boset['ljoin']) ? true : false;

// 숨김설정
$is_num = (isset($boset['lnum']) && $boset['lnum']) ? false : true;
$is_thumb = (isset($boset['lthumb']) && $boset['lthumb']) ? false : true;
$is_point = (isset($boset['lpoint']) && $boset['lpoint']) ? false : true;
$is_login = (isset($boset['llogin']) && $boset['llogin']) ? false : true;
$is_exp = (isset($boset['lexp']) && $boset['lexp']) ? false : true;

$categories[] = array('', '레벨순');
$categories[] = array('mb_nick', '닉네임순');
if($is_name) $categories[] = array('mb_name', '이름순');
if($is_point) $categories[] = array('mb_point', '포인트순');
if($is_grade) $categories[] = array('mb_level', '등급순');
if($is_join) $categories[] = array('mb_datetime', '가입순');
if($is_login) $categories[] = array('mb_today_login', '접속순');

include_once($board_skin_path.'/category.skin.php'); // 카테고리

?>
