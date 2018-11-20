<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!$is_admin)
	alert('관리자만 가능합니다.', G5_BBS_URL.'/board.php?bo_table='.$bo_table);

?>