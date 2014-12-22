<?php
/*
Template Name: 微信数据接口
*/
?>
<?php 
$articles=array();
$article=array();
$args = array( 'posts_per_page' => 5);//输出不大于5篇文字（微信api要求不超过10篇）
$postslist = get_posts( $args );
foreach ( $postslist as $post ) {
		setup_postdata( $post );

		$article["title"]=get_the_title();
		$article["description"]=get_the_excerpt();
		$article["picUrl"]=imdevice_get_first_image(false);
		$article["url"]=get_permalink();
		array_push($articles, $article);
	
}
wp_reset_postdata();
$json=json_encode($articles);
echo $json;
?>