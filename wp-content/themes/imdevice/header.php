<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns:wb="http://open.weibo.com/wb">
<head>
<meta name="google-site-verification" content="MxN6YO-Edb9fD-tXZ3sz2Ls0EotiEA_heES6O_lbf7o" />
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php if(is_from_weibo()): ?>
<meta http-equiv="mobile-agent" content="format=xhtml;url=<?php echo get_permalink(); ?>"/>
<?php endif; ?>
<meta name="keywords" content="<?php
if (is_singular()){
	$posttags = get_the_tags();
	if ($posttags) {
	  foreach($posttags as $tag) {
	    echo $tag->name . ','; 
	  }
	}
	echo '清爽阅读,智能订阅,智能手机,平板电脑,移动应用,科技新闻';
}else{
?>
清爽阅读,智能订阅,智能手机,平板电脑,移动应用,Windows Phone, Android, Apple, Nokia,BlackBerry,iOS,安卓游戏,安卓软件,安卓Rom,iPhone固件,iPhone软件,iPhone游戏,科技新闻, 移动互联网, 资讯平台,互联网创业,科技博客,IT业界资讯,IMDevice爱米手机网,IMDevice,爱米手机网<?php } ?>" />
<?php if(is_singular()): 
$description = mb_strimwidth(preg_replace("/\s+/","",strip_tags(apply_filters('the_content', $post->post_content))), 0, 300,"...");
printf('<meta name="description" content="%s" />', $description);

else: ?>
<meta name="description" content="关注智能设备和移动互联网，分享最潮的智能手机、平板电脑及最酷的互联网应用和业界信息" />
<?php endif; ?>

<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
<?php if(is_singular()): ?>
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo get_permalink(); ?>" />
<meta property="og:title" content="<?php wp_title();?>"/>
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=661558871" type="text/javascript" charset="utf-8"></script>
<?php endif; ?>
<meta name="application-name" content="IMDevice 清爽阅读"/>
<meta name="msapplication-TileColor" content="#0099ff"/>
<meta name="msapplication-TileImage" content="http://www.imdevice.com/wp-content/uploads/2013/04/tilelogo.png"/>
<title><?php wp_title(); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>

<!--百度异步统计-->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?8ab7338cc7c28667dd8398bd520b6e6a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</head>

<body <?php body_class() ?>>


		<header id="header" class="site-header fix-top sb-slide">
			<!-- Left Control -->
			<div class="sb-toggle-left navbar-left">
				<div class="navicon-line"></div>
				<div class="navicon-line"></div>
				<div class="navicon-line"></div>
			</div><!-- /.sb-control-left -->
			
			<!-- Right Control -->
			<div class="sb-toggle-right navbar-right">
				<div class="navicon-line"></div>
				<div class="navicon-line"></div>
				<div class="navicon-line"></div>
			</div><!-- /.sb-control-right -->

			<<?php pinboard_title_tag( 'site' ); ?> id="site-title">
				<?php if ( ( '' != get_header_image() ) &&  ( false != get_header_image() ) ) : ?>
					<a href="<?php echo home_url( '/' ); ?>" rel="home" title="<?php bloginfo( 'name' ); ?>"><img src="<?php header_image(); ?>" width="74px" height="40px"/></a>
				<?php endif; ?>
				<a class="home" href="<?php echo home_url( '/' ); ?>"  title="<?php bloginfo( 'description' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</<?php pinboard_title_tag( 'site' ); ?>>

			<?php if(false /*! is_active_sidebar( 1 ) */) : ?>
				<<?php pinboard_title_tag( 'desc' ); ?> id="site-description"><?php bloginfo( 'description' ); ?></<?php pinboard_title_tag( 'desc' ); ?>>
			<?php endif; ?>
<div class='bigCatelog'>
<a href='http://www.imdevice.com/' class='page-numbers'>科技</a>
<a href='http://meitu.imdevice.com/author/mtime/' class='page-numbers'>电影</a>
<a href='http://meitu.imdevice.com/author/leica/' class='page-numbers'>摄影</a>
</div>
			<?php get_sidebar( 'header' ); ?>
			
			<div class="clear"></div>
			<nav id="access">
				<a class="nav-show" href="#access">Show Navigation</a>
				<a class="nav-hide" href="#nogo">Hide Navigation</a>
				<?php wp_nav_menu( array( 'theme_location' => 'primary_nav' ) ); ?>
				<div class="clear"></div>
			</nav><!-- #access -->
		</header><!-- #header -->
	<div id="sb-site">

<div id="wrapper-bg">
	<div id="wrapper">