<?php
/*
Template Name: 只做测试
*/
?>
<style>
	.limgrinfo{
		border: 0 solid #888;
		position:relative;
		background:#cc0;
		padding:0;
		width:175px;
		margin:2px 0;
		}
	.limg{height:40px;border: 0}
	.limg img{border:0;}
	.rinfo{
		border: 0 dotted #F00;
		position: absolute;
		left: 50px;
		top: 0px;
		line-height:40px;
		background:#ccc;
		width:135px;
		overflow: hidden;
		white-space: nowrap;
		word-wrap: normal;
		-o-text-overflow: ellipsis;
		text-overflow: ellipsis;
	}
</style>

<ul>
<?php 
$query_args = array('fields' => 'ids');
$authors = get_users( $query_args );
foreach ( $authors as $author_id ) {
$display_name=get_the_author_meta( 'display_name' ,$author_id); 
?>
<li>
<a href="<?php echo get_author_posts_url( $author_id ); ?>" title="浏览所有 <?php echo $display_name; ?> 的文章">
<div class="limgrinfo">
	<div class="limg"><?php echo get_avatar( $author_id, 30 ); ?></div>
	<div class="rinfo">
		<?php echo $display_name;?>
	</div>
</div>
</a>
</li>
<?php 
}
?>
</ul>