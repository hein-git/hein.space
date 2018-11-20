<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css" media="screen">', 0);

// 값정리
$boset['modal'] = (isset($boset['modal'])) ? $boset['modal'] : '';
$boset['list_skin'] = (isset($boset['list_skin']) && $boset['list_skin']) ? $boset['list_skin'] : 'basic';

//창열기
$is_modal_js = $is_link_target = '';
if($boset['modal'] == "1") { //모달
	$is_modal_js = apms_script('modal');
} else if($boset['modal'] == "2") { //링크#1
	$is_link_target = ' target="_blank"';
}

$list_skin_url = $board_skin_url.'/list/'.$boset['list_skin'];
$list_skin_path = $board_skin_path.'/list/'.$boset['list_skin'];

?>

<section class="board-list<?php echo (G5_IS_MOBILE) ? ' font-14' : '';?>"> 
	<?php if($boset['tsearch']) { ?>
		<div class="list-search">
			<form class="form" role="form" name="msearch" method="get">
				<input type="hidden" name="bo_table" value="<?php echo $bo_table;?>">
				<div class="row row-15">
					<div class="col-sm-2 col-sm-offset-2 col-xs-6 col-15">
						<div class="form-group">
							<select name="mfs" id="mfs" class="form-control input-sm">
								<option value="mb_nick">닉네임</option>
								<option value="mb_id">아이디</option>
								<option value="mb_name">이름</option>
							</select>
							<script>document.getElementById("mfs").value = "<?php echo $mfs ?>";</script>
						</div>
					</div>
					<div class="col-sm-3 col-xs-6 col-15">
						<div class="form-group">
							<div class="form-group">
								<label for="mtx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
								<input type="text" name="mtx" value="<?php echo $mtx ?>" id="mtx" required class="form-control input-sm" maxlength="20" placeholder="검색어">
							</div>
						</div>
					</div>
					<div class="col-sm-3 col-xs-12 col-15">
						<div class="form-group">
							<button type="submit" class="btn btn-<?php echo $boset['tsearch'];?> btn-sm btn-block"><i class="fa fa-search"></i> 검색</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	<?php } ?>

	<?php @include_once($list_skin_path.'/list.head.skin.php'); // 헤드영역 ?>

	<div class="list-wrap">
		<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post" role="form" class="form">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
			<input type="hidden" name="stx" value="<?php echo $stx ?>">
			<input type="hidden" name="spt" value="<?php echo $spt ?>">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<input type="hidden" name="sst" value="<?php echo $sst ?>">
			<input type="hidden" name="sod" value="<?php echo $sod ?>">
			<input type="hidden" name="page" value="<?php echo $page ?>">
			<input type="hidden" name="sw" value="">
			<?php 
				// 목록스킨
				if(is_file($list_skin_path.'/list.skin.php')) {
					include_once($list_skin_path.'/list.skin.php');
				} else {
					echo '<div class="well text-center"><i class="fa fa-bell red"></i> 설정하신 목록스킨('.$boset['list_skin'].')이 존재하지 않습니다.</div>';
				}
			?>
			<div class="list-btn">
				<?php if ($list_href || $write_href) { ?>
					<div class="form-group pull-right">
						<div class="btn-group" role="group">
							<?php if ($list_href) { ?><a role="button" href="<?php echo $list_href ?>" class="btn btn-<?php echo $btn1;?> btn-sm"><i class="fa fa-bars"></i> 목록</a><?php } ?>
							<?php if ($write_href) { ?><a role="button" href="<?php echo $write_href ?>" class="btn btn-<?php echo $btn2;?> btn-sm"><i class="fa fa-pencil"></i> 글쓰기</a><?php } ?>
						</div>
					</div>
				<?php } ?>
				<?php if ($setup_href || $admin_href) { ?>
					<div class="form-group pull-left">
						<div class="btn-group" role="group">
							<?php if ($admin_href) { ?>
								<a role="button" href="<?php echo $admin_href; ?>" class="btn btn-<?php echo $btn1;?> btn-sm"><i class="fa fa-cog"></i><span class="hidden-xs"> 보드설정</span></a>
							<?php } ?>
							<?php if ($setup_href) { ?>
								<a role="button" href="<?php echo $setup_href; ?>" class="btn btn-<?php echo $btn2;?> btn-sm win_memo"><i class="fa fa-cogs"></i><span class="hidden-xs"> 추가설정</span></a>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>

			<div class="list-page text-center">
				<ul class="pagination en no-margin">
					<?php if($prev_part_href) { ?>
						<li><a href="<?php echo $prev_part_href;?>">이전검색</a></li>
					<?php } ?>
					<?php echo apms_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './board.php?bo_table='.$bo_table.$qstr.'&amp;page=');?>
					<?php if($next_part_href) { ?>
						<li><a href="<?php echo $next_part_href;?>">다음검색</a></li>
					<?php } ?>
				</ul>
			</div>

			<div class="clearfix"></div>

		</form>

	</div>

	<?php @include_once($list_skin_path.'/list.tail.skin.php'); // 테일영역 ?>

</section>

<div class="h20"></div>