<?php
if(!is_admin()){
	include_once('fbgFrontClass.php');
	$fobj = new FbgFront();
	
	$fbg_settingOpts = get_option('fbgallery_settings');
	global $wp_query;
	$fbg_pageId = $wp_query->post->ID;
	$fbg_disable = get_post_meta($fbg_pageId, 'fbg_disable', true);
	$fbg_check = get_post_meta($fbg_pageId, 'fbg_check', true);
	
	if(!$fbg_disable){
		if($fbg_check){
			$fbg_getgallryID = get_post_meta($fbg_pageId, 'fbg_selection', true);
			$fbg_gallryName = $fobj->fbg_getgallryName($fbg_getgallryID);
			$fbg_active = $fobj->fbg_isActive($fbg_getgallryID);
			if($fbg_active){
				$fobj->fbg_display($fbg_gallryName);
			}
			else{}
		}//if fbg gallery set on the page
		else{
			if($fbg_settingOpts['fbg_global']){
				$fbg_globalfbgID = $fbg_settingOpts['fbg_globalfbg'];
				$fbg_gallryName = $fobj->fbg_getgallryName($fbg_globalfbgID);
				$fbg_active = $fobj->fbg_isActive($fbg_globalfbgID);

				if(($fbg_settingOpts['fbg_pages'] || $fbg_settingOpts['fbg_posts'] || $fbg_settingOpts['fbg_frontpg'] || $fbg_settingOpts['fbg_blogpg']) && $fbg_active){
					if(is_page() && $fbg_settingOpts['fbg_pages'] && !is_front_page()){
						$fobj->fbg_display($fbg_gallryName);
					}
					elseif(is_front_page() && $fbg_settingOpts['fbg_frontpg']){
						$fobj->fbg_display($fbg_gallryName);
					}
					elseif(is_single() && $fbg_settingOpts['fbg_posts']){
						$fobj->fbg_display($fbg_gallryName);
					}
					elseif(is_home() && $fbg_settingOpts['fbg_blogpg']){
						$fobj->fbg_display($fbg_gallryName);
					}
					elseif(is_category() && $fbg_settingOpts['fbg_cats']){
						$fobj->fbg_display($fbg_gallryName);
					}
					elseif(is_tax() && $fbg_settingOpts['fbg_ctax']){
						$fobj->fbg_display($fbg_gallryName);
					}
					elseif(is_tag() && $fbg_settingOpts['fbg_tags']){
						$fobj->fbg_display($fbg_gallryName);
					}		
					elseif(is_date() && $fbg_settingOpts['fbg_date']){
						$fobj->fbg_display($fbg_gallryName);
					}
					elseif(is_author() && $fbg_settingOpts['fbg_author']){
						$fobj->fbg_display($fbg_gallryName);
					}
					elseif(is_search() && $fbg_settingOpts['fbg_search']){
						$fobj->fbg_display($fbg_gallryName);
					}
				}//if fbg gallery is enable for pages or posts or homepage or blogpage 
				else{}
			}//if default fbg gallery is enable
			else{}
		}
	}//if fbg gallery not disable for page/post
	else{}
}//if is not admin 
?>