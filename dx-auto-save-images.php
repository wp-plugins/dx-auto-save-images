<?php 
/*
Plugin Name: DX-auto-save-images
Plugin URI: http://www.daxiawp.com/dx-auto-save-images.html
Description: Automatically keep the remote picture to the local, and automatically generate thumbnails. 自动保持远程图片到本地，并且自动生成缩略图。
Version: 1.0
Author: 大侠wp
Author URI: http://www.daxiawp.com/dx-auto-save-images.html
Copyright: daxiawp开发的原创插件，任何个人或团体不可擅自更改版权。
*/

class DX_Auto_Save_Images{

	function __construct(){		
		//filter
		add_filter( 'content_save_pre',array($this,'post_save_images') );
	}
	
	//save post exterior images
	function post_save_images($content){
		set_time_limit(240);
		if($_POST['save'] || $_POST['publish']){
			global $post;
			$post_id=$post->ID;
			$preg=preg_match_all('/src="(.*?)"/',stripslashes($content),$matches);
			if($preg){
				foreach($matches[1] as $image_url){
					if(empty($image_url)) continue;
					$pos=strpos($image_url,get_bloginfo('url'));
					if($pos===false){
						$res=$this->save_images($image_url,$post_id);
						$replace=$res['url'];
						$content=str_replace($image_url,$replace,$content);
					}
				}
			}
		}
		return $content;
	}
	
	//save exterior images
	function save_images($image_url,$post_id){
		$file=file_get_contents($image_url);
		$filename=basename($image_url);
		$res=wp_upload_bits($filename,'',$file);
		$this->insert_attachment($res['file'],$post_id);
		return $res;
	}
	
	//insert attachment
	function insert_attachment($file,$id){
		$dirs=wp_upload_dir();
		$filetype=wp_check_filetype($file);
		$attachment=array(
			'guid'=>$dirs['baseurl'].'/'._wp_relative_upload_path($file),
			'post_mime_type'=>$filetype['type'],
			'post_title'=>preg_replace('/\.[^.]+$/','',basename($file)),
			'post_content'=>'',
			'post_status'=>'inherit'
		);
		$attach_id=wp_insert_attachment($attachment,$file,$id);
		$attach_data=wp_generate_attachment_metadata($attach_id,$file);
		wp_update_attachment_metadata($attach_id,$attach_data);
		return $attach_id;
	}		

}


new DX_Auto_Save_Images();