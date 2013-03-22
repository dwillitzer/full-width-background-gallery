<?php
add_action('admin_menu', 'fbg_post_meta_box_options');
add_action('save_post', 'fbg_post_meta_box_save');

function fbg_post_meta_box_options(){
	if( function_exists( 'add_meta_box' ) ) {
		$post_types=get_post_types(); 
		foreach($post_types as $post_type) {
			add_meta_box("fbg_post_metas", "Select FBG Gallery for this page/post", "fbg_post_meta_box_add", $post_type, "normal", "high");
		}
	}
	else{}
}
function fbg_post_meta_box_add()
{
	global $post;
	$fbgobj = new FbGallery(); 
	$getcustom = get_post_custom($post->ID);
	$custom = $fbgobj->fbg_chk_metavals($getcustom);
	
	$fbg_selection = $custom["fbg_selection"][0];
	$fbg_disable = $custom["fbg_disable"][0];
	$fbg_check = $custom["fbg_check"][0];
    global $wpdb;
	$table_name = $wpdb->prefix . "fbgallery"; 
    $fbg_data = $wpdb->get_results("SELECT * FROM $table_name where active='1' ORDER BY id DESC");
?>
	<input type="checkbox" name="fbg_disable" id="fbg_disable" <?php checked('true', $fbg_disable); ?> value="true"/>&nbsp;<label for="fbg_disable" style="color:#F90000;"><?php _e('Check this, if you want to disable FBG Gallery for this post/page.','fbgallery'); ?> </label><br/>
	<div class="fbg_disable">
		<div class="fbg_checkbox">
			<input type="checkbox" name="fbg_check" id="fbg_check" <?php checked('true', $fbg_check); ?> value="true"/>&nbsp;<label for="fbg_check" style="color:#000;"><?php _e('Add "FBG Gallery" to this post/page..','fbgallery'); ?> </label>
		</div>
		<?php
		if($fbg_data){
				?><select name="fbg_selection" class="fbg_selection fbg_gredient">
				<?php
				foreach ($fbg_data as $data) { 
				   ?><option  value="<?php echo $data->id; ?>" <?php if($fbg_selection == $data->id ){ echo 'selected="selected"'; }?>><?php echo $data->option_name; ?></option><?php
				}
				?></select><?php
			}
			else{
				?><span style="color:red"><?php _e("FBG Gallery(s) not activated / created.",'fbgallery') ?></span><?php
			}
		?>
	</div>
	<input type="hidden" name="fbg_metasubmit" value="true" />
<?php
}
//update post custom fields
function fbg_post_meta_box_save(){
	global $post;
	if(isset($_REQUEST['fbg_metasubmit'])){
	update_post_meta($post->ID, "fbg_selection",$_POST['fbg_selection']);
	update_post_meta($post->ID, "fbg_disable",$_POST['fbg_disable']);
	update_post_meta($post->ID, "fbg_check",$_POST['fbg_check']);
	}
}
?>