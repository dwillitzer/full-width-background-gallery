<?php
/*
Plugin Name:Full Width Background Gallery
Plugin URI: http://www.wpfruits.com/
Description: This plugin will generate full width background galleries for individual pages and posts.
Author: Nishant Jain, rahulbrilliant2004, tikendramaitry
Version: 1.0.0
Author URI: http://www.wpfruits.com/
*/
// ----------------------------------------------
define('FBGALLERY_URL', plugin_dir_url(__FILE__));
define('FBGALLERY_PATH', plugin_dir_path(__FILE__));
include_once('fbgClass.php');
include_once('inc/admin/fbg_admin.php');
//------------------------------------------------
$fbgobj = new FbGallery(); 
if(isset($fbgobj))
{
   register_activation_hook(__FILE__, array($fbgobj,'fbg_plugin_activation'));
   add_action('wp_ajax_fbg_saved' ,array($fbgobj,'fbg_options_saved'));
}
function fbg_get_version()
{
	if (!function_exists( 'get_plugins' ) )
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file = basename( ( __FILE__ ) );
	return $plugin_folder[$plugin_file]['Version'];
}

// add fbggallery on frontend 
function fbg_addon_front(){
	include_once('inc/front/fbg_front.php');
}
add_action('wp_footer','fbg_addon_front');
//------------------------------------------------
?>