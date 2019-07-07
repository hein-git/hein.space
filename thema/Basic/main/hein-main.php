<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 위젯 대표아이디 설정
$wid = 'CMB';

// 게시판 제목 폰트 설정
$font = 'font-16 en';

// 게시판 제목 하단라인컬러 설정 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line = 'green';

// 사이드 위치 설정 - left, right
$side = ($at_set['side']) ? 'left' : 'right';

?>
<style>
	.widget-index .at-main,
	.widget-index .at-side { padding-bottom:0px; }
	.widget-index .div-title-underbar { margin-bottom:15px; }
	.widget-index .div-title-underbar span { padding-bottom:4px; }
	.widget-index .div-title-underbar span b { font-weight:500; }
	.widget-index .widget-img img { display:block; max-width:100%; /* 배너 이미지 */ }
	.widget-box { margin-bottom:25px; }
</style>

<div class="at-container widget-index">

	<div class="h20"></div>

	<div class="row at-row">
		<!-- 메인 영역 -->
		<div class="col-md-9<?php echo ($side == "left") ? ' pull-right' : '';?> at-col at-main">

			<!-- 웹진 시작 -->
			<div class="widget-box">
				<?php echo apms_widget('basic-post-hein', $wid.'-wm4', 'bold=1 date=1'); ?>
			</div>
			<!-- 웹진 끝 -->	


		</div>
		<!-- 사이드 영역 -->
		<div class="col-md-3<?php echo ($side == "left") ? ' pull-left' : '';?> at-col at-side">

			<?php if(!G5_IS_MOBILE) { //PC일 때만 출력 ?>
				<div class="hidden-sm hidden-xs">
					<!-- 로그인 시작 -->
					<div class="div-title-underbar">
						<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
							<b><?php echo ($is_member) ? 'Profile' : 'Login';?></b>
						</span>
					</div>

					<div class="widget-box">
						<?php echo apms_widget('basic-outlogin'); //외부로그인 ?>
					</div>
					<!-- 로그인 끝 -->
				</div>
			<?php } ?>

			<div class="row">
				<div class="col-md-12 col-sm-6">

					<!-- 알림 시작 -->
					<div class="div-title-underbar">
						<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=basic">
							<span class="pull-right lightgray <?php echo $font;?>">+</span>
							<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
								<b>Notice</b>
							</span>
						</a>
					</div>
					<div class="widget-box">
						<?php echo apms_widget('basic-post-list', $wid.'-ws1', 'icon={아이콘:bell} date=1 strong=1,3'); ?>
					</div>
					<!-- 알림 끝 -->
			
				</div>
				<div class="col-md-12 col-sm-6">

					<!-- 댓글 시작 -->
					<div class="div-title-underbar">
						<a href="<?php echo $at_href['new'];?>?view=c">
							<span class="pull-right lightgray <?php echo $font;?>">+</span>
							<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
								<b>Comments</b>
							</span>
						</a>
					</div>
					<div class="widget-box">
						<?php echo apms_widget('basic-post-list', $wid.'-ws2', 'icon={아이콘:comment} comment=1 date=1 strong=1,2'); ?>
					</div>
					<!-- 댓글 끝 -->
		
				</div>
			</div>

			<!-- 설문 시작 -->
			<?php // 설문조사
				$is_poll_list = apms_widget('basic-poll', $wid.'-ws3', 'icon={아이콘:commenting}');
				if($is_poll_list) {
			?>
				<div class="div-title-underbar">
					<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
						<b>Poll</b>
					</span>
				</div>
				<div class="widget-box">
					<?php echo $is_poll_list; ?>
				</div>					
			<?php } ?>
			<!-- 설문 끝 -->

			<!-- 통계 시작 -->
			<div class="div-title-underbar">
				<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
					<b>State</b>
				</span>
			</div>
			<div class="widget-box">
				<ul style="padding:0; margin:0; list-style:none;">
					<li><i class="fa fa-bug red"></i>  <a href="<?php echo $at_href['connect'];?>">
						현재 접속자 <span class="pull-right"><?php echo number_format($stats['now_total']); ?><?php echo ($stats['now_mb'] > 0) ? '(<b>'.number_format($stats['now_mb']).'</b>)' : ''; ?> 명</span></a>
					</li>
					<li><i class="fa fa-bug"></i> 오늘 방문자 <span class="pull-right"><?php echo number_format($stats['visit_today']); ?> 명</span></li>
					<li><i class="fa fa-bug"></i> 전체 방문자 <span class="pull-right"><?php echo number_format($stats['visit_total']); ?> 명</span></li>
					</li>
				</ul>
			</div>
			<!-- 통계 끝 -->

			<!-- SNS아이콘 시작 -->
			<div class="widget-box text-center">
				<?php echo $sns_share_icon; // SNS 공유아이콘 ?>
			</div>
			<!-- SNS아이콘 끝 -->

		</div>
	</div>
</div>
