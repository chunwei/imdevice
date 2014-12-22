<?php
/*
Template Name: All Tags
*/
?>
<?php 
$tags = get_tags();
$html = '';
foreach ( $tags as $tag ) {
	$html .= strtolower($tag->name) . ';';
}
echo $html;
?>
