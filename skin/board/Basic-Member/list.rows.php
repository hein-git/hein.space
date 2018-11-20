<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 레벨출력
$is_lvl = ($board['as_level']) ? 'yes' : 'no';

// 공지사항
$notice = array();
for($i=0; $i < count($list); $i++) {

	if(!$list[$i]['is_notice']) break;

	$notice[$i] = $list[$i];
}
unset($list);

// 회원정보
$sql_common = " from {$g5['member_table']} ";
$sql_search = " where mb_id <> '{$config['cf_admin']}' and mb_leave_date = '' and mb_intercept_date = '' ";

// 검색
if ($mtx) {
	if(!$mfs) $mfs = 'mb_nick';
	$sql_search .= " and {$mfs} like '%{$mtx}%' ";
}

// 정렬
$orderby = '';
if ($mfl) {
	$orderby .= ($mfl == 'mb_name' || $mfl == 'mb_nick' || $mfl == 'mb_datetime') ? $mfl.' asc, ' : $mfl.' desc, ';
}

$sql_order = " order by $orderby as_exp desc, mb_point desc ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = (G5_IS_MOBILE) ? $board['bo_mobile_page_rows'] : $board['bo_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
$page = ($page > 0) ? $page : 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	if(!$row['mb_open']) {
		$row['mb_email'] = '';
		$row['mb_homepage'] = '';
	}
	$list[$i] = $row;
	$list[$i]['photo'] = apms_photo_url($row['mb_id']);
	$ml = 'xp_grade'.$row['mb_level'];
	$list[$i]['grade'] = $xp[$ml];
	$list[$i]['nick'] = apms_sideview($row['mb_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage'], $row['as_level'], $is_lvl);
	$list[$i]['as_exp'] = ($xp['exp_point']) ? $row['mb_point'] : $row['as_exp'];

	list($mb_level, $mb_exp, $mb_exp_min, $mb_exp_max) = chk_xp_num($row['as_exp'], $xp['xp_point'], $xp['xp_max'], $xp['xp_rate']);

	if($mb_level != $row['as_level']) {
		list($mb_level, $mb_exp, $mb_exp_min, $mb_exp_max) = check_xp($row['mb_id']);
	}

	$list[$i]['login'] = strtotime($row['mb_today_login']);
	$list[$i]['join'] = strtotime($row['mb_datetime']);

	$list[$i]['exp'] = $mb_exp;
	$list[$i]['exp_min'] = $mb_exp_min;
	$list[$i]['exp_max'] = $mb_exp_max;

	if($row['as_level'] >= $xp['xp_max']) {
		$list[$i]['exp_per'] = 100;
		$list[$i]['exp_up'] = 0;
	} else {
		$total_exp = $list[$i]['exp_max'] - $list[$i]['exp_min'];
		$now_exp = $list[$i]['exp'] - $list[$i]['exp_min'];
		$list[$i]['exp_per'] = ($total_exp > 0) ? round(($now_exp / $total_exp) * 100, 1) : 0;
		$list[$i]['exp_up'] = $total_exp - $now_exp;
	}

	$list[$i]['num'] = ($page - 1) * $rows + $i + 1;
}

$list_cnt = count($list);

?>
