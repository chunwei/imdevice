		<?php if( is_front_page() || is_page_template( 'template-landing-page.php' ) || ( is_home() && ! is_paged() ) ) : ?>
			<?php get_sidebar( 'footer-wide' ); ?>
		<?php endif; ?>
		<div id="footer">
			<?php get_sidebar( 'footer' ); ?>
			<div id="copyright">
				<p class="copyright twocol"><?php pinboard_copyright_notice(); ?></p>
				<?php if( pinboard_get_option( 'theme_credit_link' ) || pinboard_get_option( 'author_credit_link' )  || pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
					<p class="credits twocol">
						<?php $theme_credit_link = '<a href="' . esc_url( 'http://www.onedesigns.com/wordpress-themes/pinboard' ) . '" title="' . esc_attr( __( 'Pinboard Theme', 'pinboard' ) ) . '">' . __( 'Pinboard Theme', 'pinboard' ) . '</a>'; ?>
						<?php $author_credit_link = '<a href="' . esc_url( 'http://www.onedesigns.com/' ) . '" title="' . esc_attr( __( 'One Designs', 'pinboard' ) ) . '">' . __( 'One Designs', 'pinboard' ) . '</a>'; ?>
						<?php $wordpress_credit_link = '<a href="' . esc_url( 'http://wordpress.org/' ) . '" title="' . esc_attr( __( 'WordPress', 'pinboard' ) ) . '">' . __( 'WordPress', 'pinboard' ) . '</a>';; ?>
						<?php if( pinboard_get_option( 'theme_credit_link' ) && pinboard_get_option( 'author_credit_link' ) && pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s by %2$s and %3$s', 'pinboard' ), $theme_credit_link, $author_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( pinboard_get_option( 'theme_credit_link' ) && pinboard_get_option( 'author_credit_link' ) && ! pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s by %2$s', 'pinboard' ), $theme_credit_link, $author_credit_link ); ?>
						<?php elseif( pinboard_get_option( 'theme_credit_link' ) && ! pinboard_get_option( 'author_credit_link' ) && pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s and %2$s', 'pinboard' ), $theme_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( ! pinboard_get_option( 'theme_credit_link' ) && pinboard_get_option( 'author_credit_link' ) && pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s and %2$s', 'pinboard' ), $author_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( pinboard_get_option( 'theme_credit_link' ) && ! pinboard_get_option( 'author_credit_link' ) && ! pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'pinboard' ), $theme_credit_link ); ?>
						<?php elseif( ! pinboard_get_option( 'theme_credit_link' ) && pinboard_get_option( 'author_credit_link' ) && ! pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'pinboard' ), $author_credit_link ); ?>
						<?php elseif( ! pinboard_get_option( 'theme_credit_link' ) && ! pinboard_get_option( 'author_credit_link' ) && pinboard_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'pinboard' ), $wordpress_credit_link ); ?>
						<?php endif; ?>
					</p>
				<?php endif; ?>
				<div class="clear"></div>
			</div><!-- #copyright -->
		</div><!-- #footer -->
	</div><!-- #wrapper -->
</div><!-- #wrapper-bg -->
<?php wp_footer(); ?>
    
    <div class="sb-slidebar sb-left">
      <!-- Your left Slidebar content. -->
<!--	<nav>
		<ul class="list-unstyled sb-nav">
			<li><img src="http://plugins.adchsm.me/slidebars/images/slidebars-logo-white@2x.png" alt="Slidebars" width="118" height="40"></li>
			<li><a href="http://plugins.adchsm.me/slidebars/">Home</a></li>
			<li><a href="http://plugins.adchsm.me/slidebars/index.php#download">Download</a></li>
			<li><a href="http://plugins.adchsm.me/slidebars/usage.php">Usage</a></li>
			<li><a href="http://plugins.adchsm.me/slidebars/usage.php#api">API</a></li>
			<li><a href="http://plugins.adchsm.me/slidebars/compatibility.php">Compatibility</a></li>
			<li><a href="http://plugins.adchsm.me/slidebars/add-ons.php">Add-ons</a></li>
			<li><a href="http://plugins.adchsm.me/slidebars/issues.php">Issues</a></li>
			<li><a href="http://plugins.adchsm.me/slidebars/contact.php">Contact</a></li>
			<li><a href="https://github.com/adchsm/Slidebars">Github</a></li>
			<li><span class="sb-open-right">About the Author</span></li>
			<li><small>Slidebars &copy; 2013 <a href="http://www.adchsm.me/">Adam Smith</a></small></li>
		</ul>
	</nav>
-->
<nav>
<ul>
<?php if ( ( '' != get_header_image() ) &&  ( false != get_header_image() ) ) : ?>
<a href="<?php echo home_url( '/' ); ?>" rel="home" title="<?php bloginfo( 'name' ); ?>"><img src="<?php header_image(); ?>" width="74px" height="40px"/></a>
<?php endif; ?>
<li>
<a href="http://www.imdevice.com/author/imdevice/" title="浏览所有 IMDevice 爱米 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/09/im-cycle-black-150x150.png" width="30" height="30" alt="IMDevice 爱米" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		IMDevice 清爽阅读</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/36kr/" title="浏览所有 36氪 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/07/36kr-150x150.png" width="30" height="30" alt="36氪" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		36氪	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/cnbeta/" title="浏览所有 cnbeta 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2014/02/cnbeta-150x150.jpg" width="30" height="30" alt="cnbeta" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		cnBeta</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/engadgetchina/" title="浏览所有 Engadget 中国版 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/08/photo.jpg" width="30" height="30" alt="Engadget中国版" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		Engadget中国版	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/evolife/" title="浏览所有 Evolife 爱活网 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/07/evolife-150x150.jpg" width="30" height="30" alt="Evolife 爱活网" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		爱活网 Evolife</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/geekpark/" title="浏览所有 GeekPark 极客公园 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/07/geekpark-150x150.jpg" width="30" height="30" alt="GeekPark 极客公园" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		极客公园 GeekPark	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/huxiu/" title="浏览所有 虎嗅网 Huxiu 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/08/1-150x150.jpg" width="30" height="30" alt="虎嗅网 Huxiu" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		虎嗅网 Huxiu	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/ifanr/" title="浏览所有 iFanr 爱范儿 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/07/ifanr-150x150.png" width="30" height="30" alt="iFanr 爱范儿" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		爱范儿 iFanr	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/leiphone/" title="浏览所有 leiphone 雷锋网 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/07/leiphone-150x150.png" width="30" height="30" alt="leiphone 雷锋网" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		雷锋网 leiphone	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/mydrivers/" title="浏览所有 驱动之家 MyDrivers 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/08/11-150x150.jpg" width="30" height="30" alt="驱动之家 MyDrivers" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		驱动之家 MyDrivers	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/tech2ipo/" title="浏览所有 tech2ipo 创见 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/07/tech2ipo-150x150.jpg" width="30" height="30" alt="tech2ipo 创见" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		创见 tech2ipo	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/tmtpost/" title="浏览所有 钛媒体 TMTpost 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/08/0-150x150.jpg" width="30" height="30" alt="钛媒体 TMTpost" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		钛媒体 TMTpost	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/wpdang/" title="浏览所有 WPDang 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/09/wpdang-150x150.jpg" width="30" height="30" alt="WPDang" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		WPDang	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/pingwest/" title="浏览所有 PingWest中文网 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2013/10/pingwest-150x150.jpg" width="30" height="30" alt="PingWest中文网" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		PingWest中文网	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/dgtle/" title="浏览所有 数字尾巴 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2014/02/dgtle-150x150.jpg" width="30" height="30" alt="数字尾巴" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		数字尾巴	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/reynold/" title="浏览所有 互联网er的早读课 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2014/02/reynold-150x150.jpg" width="30" height="30" alt="互联网er的早读课" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		互联网er的早读课	</div>
</div>
</a>
</li>
<li>
<a href="http://www.imdevice.com/author/yseeker/" title="浏览所有 YSeeker 的文章">
<div class="limgrinfo">
	<div class="limg"><img src="http://www.imdevice.com/wp-content/uploads/2014/02/yseeker-150x150.jpg" width="30" height="30" alt="Evolife 爱活网" class="wp-user-avatar wp-user-avatar-30 alignwp_user_avatar avatar avatar avatar-30 photo"></div>
	<div class="rinfo">
		YSeeker 品味雅虎</div>
</div>
</a>
</li>
</ul>
</nav>

    </div>

    <div class="sb-slidebar sb-right">
      <!-- Your right Slidebar content. -->
<p style="text-align: center;color: #00FF7F;margin-bottom:0px;">关注IMDevice新浪微博</p>
<p style="text-align: center;margin:10px 25px;">
<iframe width="100%" height="350" class="share_self"  frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=350&fansRow=2&ptype=1&speed=0&skin=1&isTitle=0&noborder=1&isWeibo=1&isFans=0&uid=1934512913&verifier=a6769878&colors=a8e61d,ffffff,666666,0082cb,ecfbfd&dpc=1"></iframe>
</p>
<p style="text-align: center;color: #00FF7F;margin-bottom:0px;">微信扫描下图关注IMDevice并建立直接联系</p>
<img class="aligncenter" title="扫描关注官方微信，直接取得联系" alt="" src="http://www.imdevice.com/wp-content/uploads/2014/01/qrcode_for_gh_2ae8c9fa6d1b_258.jpg" width="258" height="258">
    </div>
</div><!--end of #sb-site-->
    <!-- Slidebars -->
    <script>
      (function($) {
        $(document).ready(function() {
          $.slidebars();
        });
      }) (jQuery);
    </script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20863408-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>