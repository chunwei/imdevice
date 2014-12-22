<?php get_header(); ?>
	<div id="container">
		<section id="content" <?php pinboard_content_class(); ?>>
			<?php if( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<div class="entry">
						<header class="entry-header">
							<<?php pinboard_title_tag( 'post' ); ?> class="entry-title"><?php the_title(); ?></<?php pinboard_title_tag( 'post' ); ?>>
							<?php pinboard_entry_meta(); ?>
<?php
/*
$posttags = wp_get_post_tags(get_the_id());// get_the_tags();

if ($posttags) {
	$c=1;
	echo '<div class="top_tags">';
	foreach($posttags as $tag) {
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
*/
?>
						</header><!-- .entry-header -->
						<div class="entry-content">
							<?php if( has_post_format( 'audio' ) ) : ?>
								<p><?php pinboard_post_audio(); ?></p>
							<?php elseif( has_post_format( 'video' ) ) : ?>
								<p><?php pinboard_post_video(); ?></p>
							<?php endif; ?>
							<?php the_content(); ?>
							<div class="clear"></div>
						</div><!-- .entry-content -->
						<footer class="entry-utility">
							<?php wp_link_pages( array( 'before' => '<p class="post-pagination">' . __( 'Pages:', 'pinboard' ), 'after' => '</p>' ) ); ?>
							<?php the_tags( '<div class="entry-tags">', ' ', '</div>' ); ?>
							<?php /*pinboard_social_bookmarks(); */?>
							<?php pinboard_post_author(); ?>
<p>本站收集和分享移动互联网及智能设备的最新信息，大部分内容来自互联网，版权归原作者所有，如不慎侵犯您的权利,请及时联系我们,我们将在第一时间予以更改或删除。</p>
						</footer><!-- .entry-utility -->
					</div><!-- .entry -->
				<div class="nav-single">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span>上一篇</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '<span>下一篇</span> %title' ); ?></div>
				</div><!-- .nav-single -->
				<div class="clear"></div>
					<?php /*comments_template(); */ ?>
<!-- sina weibo comments-->
<div class="weibocomments">
<h3 style="padding:15px 0 0 15px;">评论</h3>
<wb:comments url="auto" border="y" width="auto" color="ffffff,ffffff,4c4c4c,5093d5,cccccc,f0f0f0" ></wb:comments>
<div>
				</article><!-- .post -->
			<?php else : ?>
				<?php pinboard_404(); ?>
			<?php endif; ?>
		</section><!-- #content -->
		<?php if( ( 'no-sidebars' != pinboard_get_option( 'layout' ) )/* && ( 'full-width' != pinboard_get_option( 'layout' ) )*/ ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div><!-- #container -->
<?php get_footer(); ?>