<?php
//-- Get all Galleries from Database ----
function get_fbgalleries()
{  
	global $wpdb;$num=1;
	$table_name = $wpdb->prefix . "fbgallery"; 
	$fbg_data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id");
	?>
	<div class="fbg_midbdr" style="padding-bottom:0;">
	
		<table class="fbg_tbl1" border="0" cellspacing="0" style="width:100%;">
			<thead>
				<tr class="fbg_tr1"><th><?php _e('ID','fbgallery'); ?></th><th><?php _e('FBG Name','fbgallery'); ?></th><th><?php _e('Edit FBG','fbgallery'); ?></th><th><?php _e('Status','fbgallery'); ?></th><th><?php _e('Delete FBG','fbgallery'); ?></th></tr>
			</thead>
			<tbody>
				<?php
				foreach ($fbg_data as $data) { 
					
					if($data->active == '1')
					{ $active='<a href="?page=fbgallery&fbg_deactivate='.$data->id.'" class="fbgdeactive_button"></a>';
					  $disabled='';
					}
					else{
						if($data->active == '0'){
							$active='<a href="?page=fbgallery&fbg_activate='.$data->id.'" class="fbgactive_button"></a>';
							$disabled='disabled="disabled"';
							}
						}
					
					echo '<tr><td>'.$data->id.'</td><td valign="middle" style="text-align:center;"> '.$data->option_name.' </td><td>
					<a href="?page=fbg_edit&edit='.$data->option_name.'" class="fbgedit_button" '.$disabled.'></a>        
					</td><td> '.$active.' </td>
					<td> <a href="?page=fbgallery&fbg_delete='.$data->option_name.'" id="'.$data->option_name.'" class="fbg_del"></a> </td></tr>';
					$num++;
				}
				?>
			</tbody>
		</table>
		
		<form method="post" action="?page=fbgallery&add=1">
			<table cellspacing="0" class="fbg_tr2">
			   <tr> 
				   <td><?php echo ($data->id+1); ?></td>
				   <td><input class="large_text_box" type="text" id="fbg_option_name" name="fbg_option_name"  /></td>
				   <td style="text-align:center;"><font class="fbg_addmsg">&nbsp;<?php _e("* Do not use spaces or special characters.",'fbgallery'); ?></font></td>    
				   <td colspan="2"><input type="submit" style="margin-top: 2px;" value="" name="fbg_newadd" /></td>
			   </tr>
			</table>
		</form>
		<div class="fbg_clear"></div>
	</div>
	<?php
}

//-- Add Gallery (Function) -----
function add_fbgallery()
{
$fbgobj = new FbGallery();
?>
<div id="fbg_delOption" title="" style="display:none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php _e('This gallery will be permanently deleted and cannot be recovered. Are you sure?','fbgallery'); ?></p>
</div>
<div id="fbg_wrapper">
	<div class="fbg_head"><div class="fbg_title"><a href="http://www.wpfruits.com/" title="wpfruits.com" target="_blank" class="fbg_wpflogo"></a><div class="fbg_title_txt"><?php _e('( Version '.fbg_get_version().' )','fbgallery'); ?></div><a href="Javascript:void(0);" title="Expand/Collapse" class="fbg_expCol"></a></div></div>
	
	<div id="fbg_addwrap" class="fbg_cont">
	
		<div class="fbg_leftbox">
			<?php			
			if(isset($_GET['add']) && isset($_POST['fbg_newadd']))
			{
				$option=$_POST['fbg_option_name'];
				if(!get_option($_POST['fbg_option_name']))
				{
				 if($option){
						$option = preg_replace('/[^a-z0-9\s]/i', '', $option);  
						$option = str_replace(" ", "_", $option);
						global $wpdb;
						$table_name = $wpdb->prefix . "fbgallery"; 
						 $options = get_option($option);
						if($options)
						{
							$fbg_message= 'Unable to Add FBG Gallery, please try another name';
						}else{
							$sql = "INSERT INTO " . $table_name . " values ('','".$option."','1');";
							if ($wpdb->query( $sql )){
									add_option($option, $fbgobj->fbg_defaults());
									$fbgobj->fbg_register_new_option($option);
									$fbg_message= 'FBG Gallery successfully added';
								}
							else{
									$fbg_message= 'Unable to Add FBG Gallery, can not insert FBG Gallery';
								}
							};
						}else{
								$fbg_message= 'Unable to Add FBG Gallery';
							}
				}else{
					$fbg_message= 'Unable to Add FBG Gallery, please try another name';
				}
				?>
			<div class="fbg_updated" id="fbg_message"><?php _e($fbg_message,'fbgallery'); ?></div>
			<?php
			}
			if(isset($_GET['fbg_delete']))
			{
				$option=$_GET['fbg_delete'];
				delete_option($option);
				global $wpdb;
				$table_name = $wpdb->prefix . "fbgallery"; 
				$sql = "DELETE FROM " . $table_name . " WHERE option_name='".$option."';";
				$wpdb->query( $sql );
			?>
			<div class="fbg_updated" id="fbg_message"><?php _e('FBG Gallery Deleted','fbgallery'); ?></div>
			<?php
			}

			if(isset($_GET['fbg_deactivate'])){
				$id=$_GET['fbg_deactivate'];
				global $wpdb;
				$table_name = $wpdb->prefix . "fbgallery"; 
				$sql = "UPDATE " . $table_name . " SET active='0' WHERE id='".$id."';";
				$wpdb->query( $sql );
			?>
			<div class="fbg_updated" id="fbg_message"><?php _e('FBG Gallery Deactivated','fbgallery'); ?></div>
			<?php
			}

			if(isset($_GET['fbg_activate'])){
				$id=$_GET['fbg_activate'];
				global $wpdb;
				$table_name = $wpdb->prefix . "fbgallery"; 
				$sql = "UPDATE " . $table_name . " SET active='1' WHERE id='".$id."';";
				$wpdb->query( $sql );
			?>
			<div class="fbg_updated" id="fbg_message"><?php _e('FBG Gallery Activated','fbgallery'); ?></div>
			<?php
			}
			?>
			<div id="fbg_addwrap">
				<form class="fbg_editform" id="fbg_settings" name="fbg_settings" method="post" action="">
					<div class="fbg_settings">
						<div class="fbg_sicon fbg_sset fbg_setdiv"></div>
						<div class="fbg_distxt fbg_setdiv">
							<?php _e('DEFAULT (GLOBAL) SETTINGS','fbgallery'); ?>
							<div class="fbg_savebtn"><input type="submit" name="fbg_settingsave" value="Save Setting"></div>
						</div>
						<div class="fbg_setdiv fbg_pm_wrap"><a class="fbg_plus_minus" href="Javascript:void(0);"></a></div>
						<div class="fbg_clear"></div>
					</div>
					<div class="fbg_extendbox">
						<?php settings_fbgallery(); ?>
					</div>
				</form>

				<div class="fbg_settings">
					<div class="fbg_sicon fbg_sadd fbg_setdiv"></div>
					<div class="fbg_distxt fbg_setdiv">
						<?php _e('LIST OF ALL FBG GALLERIES','fbgallery'); ?>
					</div>
					<div class="fbg_setdiv fbg_pm_wrap"><a class="fbg_plus_minus" href="Javascript:void(0);"></a></div>
					<div class="fbg_clear"></div>
				</div>
				<div class="fbg_extendbox">
					<?php get_fbgalleries(); ?>
				</div>
			</div>
		</div>
		<div class="fbg_clear"></div>
	</div>
</div>
<?php
}
?>