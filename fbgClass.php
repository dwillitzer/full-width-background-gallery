<?php
class FbGallery 
{
	function __construct()
	{
		add_action('admin_menu', array(&$this,'fbg_plugin_admin_menu'));
		add_action('admin_init', array(&$this,'fbg_register_settings'));
		add_action('init', array(&$this,'fbg_add_version'));
		add_action('admin_init', array(&$this,'fbg_backend_scripts'));
		add_action('wp_enqueue_scripts', array(&$this,'fbg_frontend_scripts'));
    }

	function fbg_plugin_admin_menu()
	{
		add_menu_page('FBG Lite Page', 'FBG Gallery Lite','administrator', 'fbgallery', 'add_fbgallery', plugins_url('inc/images/icon.png',__FILE__));
		add_submenu_page('fbgallery', 'Edit FBG Gallery', '', 'publish_posts','fbg_edit','edit_fbgallery');
	}
	
	function fbg_register_settings()
	{
		register_setting('fbg_plugin_options', 'fbgallery_options', array(&$this,'fbg_validate_options'));
		register_setting('fbg_plugin_options', 'fbgallery_settings', array(&$this,'fbg_validate_settings'));
		register_setting('fbg_plugin_options', 'fbg_version');
	}
	
	function fbg_register_new_option($option)
	{
		if(!get_option($option)){}
		else{
			register_setting('fbg_plugin_options', $option, array(&$this,'fbg_validate_options'));
		}
	}

	function fbg_add_version()
	{
		$fbg_version = get_option('fbg_version'); 
		if(!$fbg_version){ add_option('fbg_version',fbg_get_version()); }
		else{ update_option('fbg_version',fbg_get_version()); }
	}
	
	function fbg_backend_scripts()
	{
		if(is_admin())
		{
			wp_enqueue_script ('jquery');
			wp_enqueue_script( 'fbg_backend_scripts',plugins_url('inc/admin/js/fbg_admin.js',__FILE__), array('jquery'));
			wp_enqueue_style( 'fbg_backend_scripts',plugins_url('inc/admin/css/fbg_admin.css',__FILE__), false, '1.0.0' );
			wp_enqueue_script('farbtastic');
			wp_enqueue_style('farbtastic');	
			if(isset($_GET['page']) && ($_GET['page']=="fbgallery" || $_GET['page']=="fbg_edit"))
			{
				wp_enqueue_style('thickbox');
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_script('jquery-ui-core');	
				wp_enqueue_script('jquery-ui-dialog');
			}
			if(isset($_GET['page']) && $_GET['page']=="fbg_edit")
			{	
				wp_enqueue_script('jquery-ui-slider');
			}
		}
	}
	
	function fbg_frontend_scripts() 
	{	
		if(!is_admin())
		{
			wp_enqueue_script('jquery');
			wp_enqueue_script('fbgallery',plugins_url('inc/front/js/fbgallery.js',__FILE__), array('jquery'));
			wp_enqueue_style('fbgallery',plugins_url('inc/front/css/fbgallery.css',__FILE__));
			wp_enqueue_style('fbgvideo',plugins_url('inc/front/css/fbgvideo.css',__FILE__));
			wp_enqueue_script('jquery-ui-slider');
			wp_enqueue_script('imagesloaded',plugins_url('inc/front/js/jquery.imagesloaded.min.js',__FILE__), array('jquery'));
			wp_enqueue_script('videomin',plugins_url('inc/front/js/video.min.js',__FILE__), array('jquery'));
			wp_enqueue_script('fbgvideo',plugins_url('inc/front/js/fbgvideo.js',__FILE__), array('jquery'));
			wp_enqueue_script('tubular',plugins_url('inc/front/js/jquery.tubular.1.0.js',__FILE__), array('jquery'));
		}
	}
	
	function fbg_defaults()
	{
		$default = array(
		'fbg_overlay'=> 1,
		'fbg_oveffect'=>'images/overlay/01.png',
		'fbg_bgclrchk'=> 0,
		'fbg_bgcolor'=>'#111',
		'fbg_bgvdochk'=> 0,
		'fbg_bgvdourl'=> 'https://www.youtube.com/watch?v=DHuH7KaPbLc',
		'fbg_bgvdrept'=> 1,
		'fbg_img'=> plugins_url('inc/images/slide.jpg',__FILE__)
		);
	return $default;
	}
	
	function fbg_settings()
	{
		$defaultSettings = array(
		'fbg_global'   => 1,
		'fbg_globalfbg'=>'1',
		'fbg_pages'    => 1,
		'fbg_posts'    => 1,
		'fbg_frontpg'  => 1,
		'fbg_blogpg'   => 1,
		'fbg_cats'     => 1,
		'fbg_ctax'     => 1,
		'fbg_tags'     => 1,
		'fbg_date'     => 1,
		'fbg_author'   => 1,
		'fbg_search'   => 1
		);
	return $defaultSettings;
	}
	
	function fbg_createdb()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "fbgallery"; 
		$sql = "CREATE TABLE " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  option_name VARCHAR(255) NOT NULL DEFAULT  'fbgallery_options',
		  active tinyint(1) NOT NULL DEFAULT  '0',
		  PRIMARY KEY (`id`),
		  UNIQUE (
					`option_name`
			)
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
	public function fbg_plugin_activation() 
	{
		add_option('fbgallery_options', $this->fbg_defaults());
		add_option('fbgallery_settings', $this->fbg_settings());
		$this->fbg_createdb();
		global $wpdb;
		$table_name = $wpdb->prefix . "fbgallery"; 
		$sql = "INSERT INTO " . $table_name . " values ('','fbgallery_options','1');";
		$wpdb->query( $sql );
	}
	
	function fbg_validate_options($fbg_optval)
	{
		if(!isset($fbg_optval['fbg_overlay'])){$fbg_optval['fbg_overlay']=0;}
		if(!isset($fbg_optval['fbg_bgclrchk'])){$fbg_optval['fbg_bgclrchk']=0;}   
		
	return $fbg_optval;
	}

	function fbg_validate_settings($fbg_settval)
	{
		if(!isset($fbg_settval['fbg_global'])){$fbg_settval['fbg_global']=0;}
		if(!isset($fbg_settval['fbg_pages'])){$fbg_settval['fbg_pages']=0;}
		if(!isset($fbg_settval['fbg_posts'])){$fbg_settval['fbg_posts']=0;}
		if(!isset($fbg_settval['fbg_frontpg'])){$fbg_settval['fbg_frontpg']=0;}
		if(!isset($fbg_settval['fbg_blogpg'])){$fbg_settval['fbg_blogpg']=0;}
		if(!isset($fbg_settval['fbg_cats'])){$fbg_settval['fbg_cats']=0;}
		if(!isset($fbg_settval['fbg_tags'])){$fbg_settval['fbg_tags']=0;}
		if(!isset($fbg_settval['fbg_date'])){$fbg_settval['fbg_date']=0;}
		if(!isset($fbg_settval['fbg_author'])){$fbg_settval['fbg_author']=0;}
		if(!isset($fbg_settval['fbg_search'])){$fbg_settval['fbg_search']=0;}		

	return $fbg_settval;
	}
	
	function fbg_chk_metavals($custom)
	{
		if(!isset($custom['fbg_selection'][0])){$custom['fbg_selection'][0]=1;}
		if(!isset($custom['fbg_disable'][0])){$custom['fbg_disable'][0]=0;}
		if(!isset($custom['fbg_check'][0])){$custom['fbg_check'][0]=0;}
	return $custom;
	}
	
	function fbg_options_saved()
	{
		check_ajax_referer('fbgallery-options-data', 'security');
		$data = $_POST;
		unset($data['security'], $data['action']);
		$fbgr_itemnameopt = $data['fbg_itemname'];
		$data_arr = $data[$fbgr_itemnameopt];
		
		if(update_option($fbgr_itemnameopt, $data_arr)){
			die('1');
		} else {
			die('0');
		}
	}
}
?>