<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<div class="entry">
<header class="articleheader">
<div class="userprofile">
<?php if(!is_author()): ?>
	<a class="useravatar" title="浏览所有 <?php echo get_the_author_meta( 'display_name' ); ?> 的文章" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
</a>
<?php endif; ?>
	<div class="userinfo-left">
<a title="浏览所有 <?php echo get_the_author_meta( 'display_name' ); ?> 的文章" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
	<div class="displayname"><?php echo get_the_author_meta( 'display_name' ); ?></div>
</a>
	<span class="entry-date">
	<?php 
	$archive_year  = get_the_time('Y'); 
	$archive_month = get_the_time('m'); 
	$archive_day   = get_the_time('d'); 
	?>
<a title="浏览所有 当天 的文章"  href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>">
	<?php the_time(); ?>
</a>
	</span>
	</div>
</div>

<?php
$posttags = get_the_tags();
if ($posttags) {
	$c=1;
	echo '<div class="top_tags">';
	foreach($posttags as $tag) {
		if($c>5) break;
		if($c==1){
			$tabClasses='top_tag_tab top_tag_first_tab';
			$tagClasses='top_tag';
		}else{
			$tabClasses='top_tag_tab';
			$tagClasses='top_tag top_tag_switch';
		}
		echo '<div class="'.$tabClasses.'">';
		echo '<span class="top_tag_trip">&nbsp;</span>';		
		echo '<a class="'.$tagClasses.'" href="'.get_tag_link($tag->term_id).'">#'.$tag->name.'</a>';
		echo '</div><!--top_tag_tab-->';
		$c++;
	} //end foreach
	echo '</div><!--top_tags-->';
} //end if
?>
</header>
<div class="clear"></div>
<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="titleimg" target="_blank">
<?php 
/** Entry tile color **/
/*
$myTitle_colors=array("21AABD","87C032","00C688","FF9D00","615050","4DEE7A");
$myTitle_colorsRGB=array("33, 170, 189","135, 192, 50","0, 198, 136","255, 157, 0","97, 80, 80","77, 238, 122");
//$titleColorIndex=get_the_ID()%count($myTitle_colors); 
//echo get_the_time('G ');//G后面的空格是必须的
$titleColorIndex=get_the_time('G ')%count($myTitle_colors);
//style="background-color:#<?php echo $myTitle_colors[$titleColorIndex];?>;background-color:rgba(<?php echo $myTitle_colorsRGB[$titleColorIndex];?>,0.9);"
*/
?>
<header class="headline">
<?php the_title(); ?>
</header><!-- .entry-header -->
<!--img-->
<?php if( ( 'full-width' != pinboard_get_option( 'layout' ) && ! is_category( pinboard_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) || pinboard_is_teaser() ) : ?>
<?php 
imdevice_get_first_image();
?>
<?php /*imdevice_post_image();*/ ?>
<?php endif; ?>
</a>
		<div class="entry-container">
			<!-- .entry-header -->


			<?php if( ! is_category( pinboard_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			<?php endif; ?>
			<div class="clear"></div>
		</div><!-- .entry-container -->

		<?php if(/* 'full-width' != pinboard_get_option( 'layout' ) &&*/ ! is_category( pinboard_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( pinboard_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
			<?php pinboard_entry_meta(); ?>
		<?php endif; ?>
	</div><!-- .entry -->
</article><!-- .post -->