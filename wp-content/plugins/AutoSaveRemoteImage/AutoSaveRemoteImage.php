<?php
/* 
Plugin Name: AutoSave_Image
Version: 0.0.1
Plugin URI: http://www.imdevice.com
Description: 自动保存远程图片-2013-7-12改为只有当第一张图片不是本地图片时才下载，且只下载一张
Author: Lu Chunwei
Author URI: http://www.imdevice.com
*/

add_action('save_post', 'Auto_Save_Image');

//保存或修改文章时自动保存远程图片
function Auto_Save_Image($post_id){
	//$Auto_Save_Image = get_option("Auto_Save_Image");
	//$Auto_Save_Image = split("@@@",$Auto_Save_Image);
$debug=false;
	$photo_savepath = "as_img/";//$Auto_Save_Image[0];
	
	global $wpdb;

	$post=get_post($post_id);
	$content=$post->post_content;
	$post_title =$post->post_title;

	//保存图片
		require_once(ABSPATH."wp-includes/class-snoopy.php");
		$snoopy_Auto_Save_Image = new Snoopy;
		// begin to save pic;
		$img_array = array();
		$content1 = stripslashes($content);
		if (get_magic_quotes_gpc()) $content1 = stripslashes($content1);		
		preg_match_all("/<img [^>]*?\bsrc=(\"|\'){0,}(http:\/\/(.+?))(\"|\')/i",$content1,$img_array);
		$img_array = array_unique(dhtmlspecialchars($img_array[2]));
		$imgChanged=false;
		foreach ($img_array as $key => $value){
			set_time_limit(180); //每个图片最长允许下载时间,秒
					if(str_replace(get_bloginfo('url'),"",$value)==$value&&str_replace(get_bloginfo('home'),"",$value)==$value){
				$fileext = substr(strrchr($value,'.'),1);
				$fileext = strtolower($fileext);
				if($fileext==""||strlen($fileext)>4)$fileext = "jpg";
				$savefiletype = array('jpg','gif','png','bmp');
				if (in_array($fileext, $savefiletype)){ 
					if($snoopy_Auto_Save_Image->fetch(str_replace(" ","%20",$value))){
						$get_file = $snoopy_Auto_Save_Image->results;
					}else{
						echo "error fetching file: ".$snoopy_Auto_Save_Image->error."<br>";
						echo "error url: ".$value;
						die();
					}
					$filetime = time();
					$filepath = "wp-content/uploads/".$photo_savepath.date("Y",$filetime)."/".date("m",$filetime)."/";//图片保存的路径目录
					!is_dir(ABSPATH.$filepath) ? mkdirs(ABSPATH.$filepath) : null; 
					$filename = date("His",$filetime).random(3);

					$fp = @fopen(ABSPATH.$filepath.$filename.".".$fileext,"w");
					@fwrite($fp,$get_file);
					fclose($fp);
			
					$wp_filetype = wp_check_filetype( $filename.".".$fileext, false );
					$type = $wp_filetype['type'];
					$title = $post_title;
					$url = get_bloginfo('url')."/".$filepath.$filename.".".$fileext;
					$file = $_SERVER['DOCUMENT_ROOT']."/".$filepath.$filename.".".$fileext;
					
					//添加数据库记录
					$attachment = array(
						'post_type' => 'attachment',
						'post_mime_type' => $type,
						'guid' => $url,
						'post_parent' => $post_id,
						'post_title' => $title,
						'post_content' => '',
					);
					$id = wp_insert_attachment($attachment, $file, $post_parent);
					
					$content1 = str_replace($value,$url,$content1); //替换文章里面的图片地址
					if(!$imgChanged){ //为第一张图片添加缩略图
						$attach_data = wp_generate_attachment_metadata( $id, $file );
						wp_update_attachment_metadata( $id,  $attach_data );
						$imgChanged=true;
						break;//-2013-7-12改为只有当第一张图片不是本地图片时才下载，且只下载一张
					}
				}//end if ext in 'jpg','gif','png','bmp'
			}//end if is remote images need to be downloaded
			else{ 
				break; //-2013-7-12改为只有当第一张图片不是本地图片时才下载，且只下载一张
			}
//$content1=$value.'<hr>'.$content1;
		}//end for; end save pic;
if($debug){
$temp="<hr>";
foreach ($img_array as $key => $value){
	$temp=$temp.$key."=>".$value."<hr>";
}
$content1=$content1.$temp;
}
		if($imgChanged){
		 	$content = $content1;
			if (get_magic_quotes_gpc()) $content = addslashes($content1);			
			$wpdb->update( $wpdb->posts, array( 'post_content' => $content ), array( 'ID' => $post_id ) );
			
			/****
			$post->post_content=$content;
			remove_action('save_post', 'Auto_Save_Image');
			wp_update_post($post);
			add_action('save_post', 'Auto_Save_Image');
			*/
		}
}

//用到的函数
function dhtmlspecialchars_old($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dhtmlspecialchars_old($val);
		}
	}else{
		$string = str_replace('&', '&', $string);
		$string = str_replace('"', '"', $string);
		$string = str_replace('<', '<', $string);
		$string = str_replace('>', '>', $string);
		$string = preg_replace('/&(#\d;)/', '&\1', $string);
	}
	return $string;
}
function dhtmlspecialchars($string) {
    if(is_array($string)) {
            foreach($string as $key => $val) {
                    $string[$key] = dhtmlspecialchars($val);
            }
    } else {
            $string = str_replace(array('&', '"', '<', '>'),
 array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
            if(strpos($string, '&#') !== false) {
                    $string = preg_replace('/&((#(\d{3,5}|x[a-fA-F0-9]{4}));)/',
 '&\\1', $string);
            }
    }
    return $string;
}

function random($length) {
	$hash = '';
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	$max = strlen($chars) - 1;
	mt_srand((double)microtime() * 1000000);
	for($i = 0; $i < $length; $i++) {
	  $hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}
 
function mkdirs($dir)
{
	if(!is_dir($dir))
	{
		mkdirs(dirname($dir));
		mkdir($dir);
	}
	return ;
}  
?>