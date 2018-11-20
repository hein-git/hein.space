<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$ca_cnt = count($categories);
$boset['ctype'] = (isset($boset['ctype'])) ? $boset['ctype'] : '';
$boset['mctab'] = (isset($boset['mctab']) && $boset['mctab']) ? $boset['mctab'] : 'color';

//탭
$category_tabs = (isset($boset['tab']) && $boset['tab']) ? $boset['tab'] : '';
switch($category_tabs) {
	case '-top'		: $category_tabs .= ' tabs-'.$boset['mctab'].'-top'; break;
	case '-bottom'	: $category_tabs .= ' tabs-'.$boset['mctab'].'-bottom'; break;
	case '-line'	: $category_tabs .= ' tabs-'.$boset['mctab'].'-top tabs-'.$boset['mctab'].'-bottom'; break;
	case '-btn'		: $category_tabs .= ' tabs-'.$boset['mctab'].'-bg'; break;
	case '-box'		: $category_tabs .= ' tabs-'.$boset['mctab'].'-bg'; break;
	default			: $category_tabs .= ($boset['tabline']) ? ' tabs-'.$boset['mctab'].'-top' : ' trans-top'; break;
}

$cate_w = ($boset['ctype'] == "2") ? apms_bunhal($ca_cnt + 1, $boset['bunhal']) : ''; //전체 포함으로 +1 해줌

?>

<aside class="list-category<?php echo (G5_IS_MOBILE) ? ' list-category-mobile' : '';?>">
	<div class="tabs div-tab<?php echo $category_tabs;?> hidden-xs">
		<ul class="nav nav-tabs<?php echo ($boset['ctype'] == "1") ? ' nav-justified' : '';?><?php echo ($cate_w) ? ' text-center' :'';?>">
			<?php for ($i=0; $i < $ca_cnt; $i++) { ?>
				<li<?php echo ($categories[$i][0] === $mfl) ? ' class="active"' : '';?><?php echo $cate_w;?>>
					<a href="./board.php?bo_table=<?php echo $bo_table;?>&amp;mfl=<?php echo urlencode($categories[$i][0]);?>">
						<?php echo $categories[$i][1];?><?php if($categories[$i][0] === $mfl) echo '('.number_format($total_count).')';?>
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="dropdown visible-xs">
		<a id="categoryLabel" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-<?php echo $boset['mctab'];?> btn-block">
			<?php 
				$mfl_txt = '정렬하기';
				for ($i=0; $i < $ca_cnt; $i++) { 
					if($categories[$i][0] === $mfl) {
						$mfl_txt = $categories[$i][1];
						break;
					}
				}
				echo $mfl_txt.' ('.number_format($total_count).')';
			?>
		</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="categoryLabel">
			<?php for ($i=0; $i < $ca_cnt; $i++) { ?>
				<li<?php if($categories[$i][0] === $mfl) echo ' class="selected"';?>>
					<a href="./board.php?bo_table=<?php echo $bo_table;?>&amp;mfl=<?php echo urlencode($categories[$i][0]);?>"><?php echo $categories[$i][1];?></a>
				</li>
			<?php } ?>
		</ul>
	</div>
</aside>