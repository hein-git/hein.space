<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$list_skin_url.'/list.css" media="screen">', 0);

// 헤드스킨
$head_class = '';
if(isset($boset['hskin']) && $boset['hskin']) {
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/head/'.$boset['hskin'].'.css" media="screen">', 0);
} else {
	$head_class = (isset($boset['hcolor']) && $boset['hcolor']) ? ' border-'.$boset['hcolor'] : ' border-black';
}

// 포토
$fa_photo = (isset($boset['ficon']) && $boset['ficon']) ? apms_fa($boset['ficon']) : '<i class="fa fa-user"></i>';		

// 출력설정
$num_hidden = ($is_thumb) ? ' hidden-xs' : '';
$num_notice = ($is_thumb) ? '*' : '<span class="wr-icon wr-notice"></span>';

?>
<?php if($is_thumb) { ?>
	<style>
		.list-board .list-body .thumb-icon a { 
			<?php echo (isset($boset['ibg']) && $boset['ibg']) ? 'background:'.apms_color($boset['icolor']).'; color:#fff' : 'color:'.apms_color($boset['icolor']);?>; 
		}
	</style>
<?php } ?>
<div class="list-board">
	<div class="list-head div-head<?php echo $head_class;?>">
		<?php if($is_num) { ?>
			<span class="wr-num<?php echo $num_hidden;?>">번호</span>
		<?php } ?>
		<?php if($is_thumb) { ?>
			<span class="wr-thumb">포토</span>
		<?php } ?>
		<span class="wr-nick">별명</span>
		<?php if($is_name) { ?>
			<span class="wr-name">이름</span>
		<?php } ?>
		<?php if($is_grade) { ?>
			<span class="wr-grade hidden-xs">등급</span>
		<?php } ?>
		<?php if($is_point) { ?>
			<span class="wr-point hidden-xs">포인트</span>
		<?php } ?>
		<?php if($is_login) { ?>
			<span class="wr-login hidden-xs">접속일</span>
		<?php } ?>
		<?php if($is_join) { ?>
			<span class="wr-join hidden-xs">가입일</span>
		<?php } ?>
		<?php if($is_exp) { ?>
			<span class="wr-exp">경험치</span>
		<?php } ?>
	</div>
	<ul class="list-body">
	<?php for ($i=0; $i < count($notice); $i++) { //공지 
		// 링크이동
		$notice[$i]['target'] = '';
		if($is_link_target && !$notice[$i]['is_notice'] && $notice[$i]['wr_link1']) {
			$notice[$i]['target'] = $is_link_target;
			$notice[$i]['href'] = $notice[$i]['link_href'][1];
		}
	?>
		<li class="list-item bg-light">
			<?php if($is_num) { ?>
				<div class="wr-num<?php echo $num_hidden;?>">
					<?php echo $num_notice;?>
				</div>
			<?php } ?>
			<?php if($is_thumb) { ?>
				<div class="wr-thumb">
					<span class="wr-icon wr-notice"></span>
				</div>
			<?php } ?>
			<div class="wr-subject">
				<a href="<?php echo $notice[$i]['href']; ?>"<?php echo $notice[$i]['target'];?><?php echo $is_modal_js;?>>
					<b><?php echo $notice[$i]['subject']; ?></b>
					<?php if ($notice[$i]['wr_comment']) { ?>
						<span class="count orangered"><?php echo $notice[$i]['wr_comment']; ?></span>
					<?php } ?>
				</a>
			</div>
			<div class="wr-date">
				<?php echo apms_datetime($notice[$i]['date'], "Y.m.d");?>
			</div>
		</li>
	<?php } ?>

	<?php for ($i=0; $i < $list_cnt; $i++) { // 멤버리스트 ?>
		<li class="list-item">
			<?php if($is_num) { ?>
				<div class="wr-num<?php echo $num_hidden;?>"><?php echo $list[$i]['num']; ?></div>
			<?php } ?>
			<?php if($is_thumb) { ?>
				<div class="wr-thumb">
					<div class="thumb-icon">
						<a>
							<?php if($list[$i]['photo']) { ?>
								<img src="<?php echo $list[$i]['photo'];?>" alt="">
							<?php } else { ?>
								<?php echo $fa_photo;?>
							<?php } ?>
						</a>
					</div>
				</div>
			<?php } ?>
			<div class="wr-nick">
				<?php echo $list[$i]['nick'];?>
			</div>
			<?php if($is_name) { ?>
				<div class="wr-name">
					<?php echo $list[$i]['mb_name'];?>
				</div>
			<?php } ?>
			<?php if($is_grade) { ?>
				<div class="wr-grade hidden-xs">
					<?php echo $list[$i]['grade'];?>
				</div>
			<?php } ?>
			<?php if($is_point) { ?>
				<div class="wr-point hidden-xs">
					<?php echo number_format($list[$i]['mb_point']);?>
				</div>
			<?php } ?>
			<?php if($is_login) { ?>
				<div class="wr-login hidden-xs">
					<?php echo apms_datetime($list[$i]['login'], "Y.m.d");?>
				</div>
			<?php } ?>
			<?php if($is_join) { ?>
				<div class="wr-join hidden-xs">
					<?php echo date("Y.m.d", $list[$i]['join']);?>
				</div>
			<?php } ?>
			<?php if($is_exp) { ?>
				<div class="wr-exp">
					<div class="div-progress progress progress-striped no-margin">
						<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($list[$i]['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($list[$i]['exp_per']);?>%;">
							<span class="sr-only"><?php echo number_format($list[$i]['exp']);?> (<?php echo $list[$i]['exp_per'];?>%)</span>
						</div>
					</div>
				</div>
			<?php } ?>
		</li>
	<?php } ?>
	</ul>
	<div class="clearfix"></div>
	<?php if (!$list_cnt) { ?>
		<div class="wr-none">등록된 회원이 없습니다.</div>
	<?php } ?>
</div>
