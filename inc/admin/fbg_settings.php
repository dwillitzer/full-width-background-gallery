<?php
function settings_fbgallery(){
	global $fbg_message; 
    global $wpdb;
	$table_name = $wpdb->prefix . "fbgallery"; 
    $fbg_data = $wpdb->get_results("SELECT * FROM $table_name where active='1' ORDER BY id DESC");
	$fbg_getOpts = get_option('fbgallery_settings');
?>
	<div class="fbg_extmsg_chk"><label class="fbg_mkchk <?php if($fbg_getOpts['fbg_global']){ ?>checked<?php } ?>" for="fbg_settchk"></label><input type="checkbox" class="fbg_chkbox" id="fbg_settchk"  name="fbgallery_settings[fbg_global]" <?php if($fbg_getOpts['fbg_global']){ ?> checked <?php } ?> value="true"/>&nbsp;&nbsp;&nbsp;<?php _e('Enable "Global FBG Gallery" ','fbgallery'); ?></div>
	<div class="fbg_setblock" style="margin-left:0px;<?php if($fbg_getOpts['fbg_global']){ ?>display:block;<?php }else{ ?>display:none;<?php } ?>">
		<div class="fbg_midbdr">
			<div class="fbg_setting">
				<table style="width: 97%" class="fbg_settbl" cellpadding="9" >
					<tr>
						<td style="width: 232px;width:46%\9;" class="fbg_tdbt"><?php _e("Default FUll BG Gallery",'fbgallery'); ?></td>
						<td>:&nbsp;&nbsp;
							<select id="fbgallery_setselct" class="fbg_gredient" name="fbgallery_settings[fbg_globalfbg]">
								<?php
								foreach ($fbg_data as $data) { 
								   ?><option  value="<?php echo $data->id; ?>" <?php if($fbg_getOpts['fbg_globalfbg'] == $data->id ){ echo 'selected="selected"'; }?>><?php echo $data->option_name; ?></option><?php
								}
								?>
							</select>
							<a class="fbg_tooltip" title="<?php _e('This FBG Gallery will be used for all Posts,Pages and Categories until you have not selected in page/post editor.','fbgallery'); ?>"></a>
						</td>
					</tr>
					<tr><td colspan="2" class="fbg_tdbt" style="width: 230px !important;"><?php _e("Where to show Default FBG Gallery &nbsp;&nbsp;&nbsp;:",'fbgallery'); ?></td></tr>
					<tr>
						<td colspan="2">
							<label for="fbg_pages" class="<?php if($fbg_getOpts['fbg_pages']){ ?> checked <?php } ?>" ><input type="checkbox" class="fbg_smallchkbox" name="fbgallery_settings[fbg_pages]" id="fbg_pages" <?php if($fbg_getOpts['fbg_pages']){ ?> checked <?php } ?> value="true" />&nbsp;<?php _e("Pages",'fbgallery'); ?></label>
							<label for="fbg_posts" class="<?php if($fbg_getOpts['fbg_posts']){ ?> checked <?php } ?>" ><input type="checkbox" class="fbg_smallchkbox" name="fbgallery_settings[fbg_posts]" id="fbg_posts" <?php if($fbg_getOpts['fbg_posts']){ ?> checked <?php } ?> value="true" />&nbsp;<?php _e("Posts",'fbgallery'); ?></label>
							<label for="fbg_homep" class="<?php if($fbg_getOpts['fbg_frontpg']){ ?> checked <?php } ?>" ><input type="checkbox" class="fbg_smallchkbox" name="fbgallery_settings[fbg_frontpg]" id="fbg_homep" <?php if($fbg_getOpts['fbg_frontpg']){ ?> checked <?php } ?> value="true" />&nbsp;<?php _e("Home Page",'fbgallery'); ?></label>
							<label for="fbg_blogp" class="<?php if($fbg_getOpts['fbg_blogpg']){ ?> checked <?php } ?>" ><input type="checkbox" class="fbg_smallchkbox" name="fbgallery_settings[fbg_blogpg]" id="fbg_blogp" <?php if($fbg_getOpts['fbg_blogpg']){ ?> checked <?php } ?> value="true" />&nbsp;<?php _e("Blog Page",'fbgallery'); ?></label>		
							<label for="fbg_catgs" class="<?php if($fbg_getOpts['fbg_cats']){ ?> checked <?php } ?>" ><input type="checkbox" class="fbg_smallchkbox" name="fbgallery_settings[fbg_cats]" id="fbg_catgs" <?php if($fbg_getOpts['fbg_cats']){ ?> checked <?php } ?> value="true" />&nbsp;<?php _e("Categories",'fbgallery'); ?></label>	
							<label for="fbg_ctaxs" class="<?php if($fbg_getOpts['fbg_ctax']){ ?> checked <?php } ?>" ><input type="checkbox" class="fbg_smallchkbox" name="fbgallery_settings[fbg_ctax]" id="fbg_ctaxs" <?php if($fbg_getOpts['fbg_ctax']){ ?> checked <?php } ?> value="true" />&nbsp;<?php _e("Custom Taxonomies",'fbgallery'); ?></label>		
							<label for="fbg_tags"  class="<?php if($fbg_getOpts['fbg_tags']){ ?> checked <?php } ?>" ><input type="checkbox"  class="fbg_smallchkbox" name="fbgallery_settings[fbg_tags]" id="fbg_tags" <?php if($fbg_getOpts['fbg_tags']){ ?> checked <?php } ?> value="true" />&nbsp;<?php _e("Tags",'fbgallery'); ?></label>		
							<label for="fbg_date"  class="<?php if($fbg_getOpts['fbg_date']){ ?> checked <?php } ?>" ><input type="checkbox"  class="fbg_smallchkbox" name="fbgallery_settings[fbg_date]" id="fbg_date" <?php if($fbg_getOpts['fbg_date']){ ?> checked <?php } ?> value="true" />&nbsp;<?php _e("Date Archive",'fbgallery'); ?></label>													
							<label for="fbg_auth"  class="<?php if($fbg_getOpts['fbg_author']){ ?> checked <?php } ?>" ><input type="checkbox"  class="fbg_smallchkbox" name="fbgallery_settings[fbg_author]" id="fbg_auth" <?php if($fbg_getOpts['fbg_author']){ ?> checked <?php } ?> value="true" />&nbsp;<?php _e("Author Page",'fbgallery'); ?></label>													
							<label for="fbg_srch"  class="<?php if($fbg_getOpts['fbg_search']){ ?> checked <?php } ?>" ><input type="checkbox"  class="fbg_smallchkbox" name="fbgallery_settings[fbg_search]" id="fbg_srch" <?php if($fbg_getOpts['fbg_search']){ ?> checked <?php } ?> value="true" />&nbsp;<?php _e("Search Page",'fbgallery'); ?></label>													
							<div class="fbg_clear"></div>
						</td>                                             
					</tr>
				</table>
			</div>
		</div>
	</div>
	
<?php
}

//-- Update FBG Settigs ----------------------
if(isset($_REQUEST['fbg_settingsave'])) {
    update_option('fbgallery_settings',fbg_updateSettings());
}
function fbg_updateSettings(){
		$fbg_settOptn = $_REQUEST['fbgallery_settings'];
	    $fbg_updtSett = array(
		'fbg_global' => $fbg_settOptn['fbg_global'],
		'fbg_globalfbg' => $fbg_settOptn['fbg_globalfbg'],
		'fbg_pages' => $fbg_settOptn['fbg_pages'],
		'fbg_posts' => $fbg_settOptn['fbg_posts'],
		'fbg_frontpg' => $fbg_settOptn['fbg_frontpg'],
		'fbg_blogpg' => $fbg_settOptn['fbg_blogpg'],
		'fbg_cats' => $fbg_settOptn['fbg_cats'],
		'fbg_ctax' => $fbg_settOptn['fbg_ctax'],
		'fbg_tags' => $fbg_settOptn['fbg_tags'],
		'fbg_date' => $fbg_settOptn['fbg_date'],
		'fbg_author' => $fbg_settOptn['fbg_author'],
		'fbg_search' => $fbg_settOptn['fbg_search']
	);
return $fbg_updtSett;
}
?>