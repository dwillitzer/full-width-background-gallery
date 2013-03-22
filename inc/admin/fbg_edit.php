<?php
//-- Edit Gallery (Function) -----
function edit_fbgallery()
{
	$option=$_GET['edit'];
	global $wpdb;
	$table_name = $wpdb->prefix . "fbgallery"; 
	$fbg_gallries = $wpdb->get_results("SELECT * FROM $table_name where active='1' ORDER BY id DESC");
?>

<div id="fbg_wrapper">
	<div class="fbg_head"><div class="fbg_title"><a href="http://www.wpfruits.com/" title="wpfruits.com" target="_blank" class="fbg_wpflogo"></a><div class="fbg_title_txt"><?php _e('Edit ( '.$option.' )','fbgallery'); ?></div><a href="Javascript:void(0);" title="Expand/Collapse" class="fbg_expCol"></a></div></div>
	<div class="fbg_cont">
	
		<div class="fbg_selfbg" style="">
			<a title="goto back" class="fbg_backto" href="?page=fbgallery"></a>
			<div class="fbg_distxt"><?php _e('SELECT FBG GALLERY :','fbgallery'); ?></div>
			<form method="get" action="" style="float:left;margin-top:14px;">
				<div style="float:left;">
					<select class="fbg_gredient" name="edit"> 	
						<?php
						foreach ($fbg_gallries as $data) { 
						   ?><option <?php selected($data->option_name,$_REQUEST['edit']); ?>  value="<?php echo $data->option_name ?>"><?php echo $data->option_name; ?></option><?php
						}
						?>
					</select><a class="fbg_tooltip" title="<?php _e('Select Gallery to edit.','fbgallery'); ?>"></a>
				</div>
				<input type="hidden" name="page" value="fbg_edit" />
				<input id="fbg_seledit" type="submit" value="" />
				<div class="fbg_clear"></div>
			</form>
			<div class="fbg_clear"></div>
		</div>

		<div class="fbg_leftbox">

			<div id="fbg_settsaved"></div>
			<img id="fbg_ajaxloader" src="<?php echo FBGALLERY_URL; ?>inc/images/ajax-loader.gif" />
			<form method="post" action="/" class="fbg_form" id="fbg_saveform">

				<?php 
				settings_fields('fbg_plugin_options');
				if($_GET["edit"]){$option=$_GET['edit'];}
				else{$option='fbgallery_options';}
				$options = get_option($option);
				?>

				<div class="fbg_block">
					<div class="fbg_settings">
						<div class="fbg_sicon fbg_sove fbg_setdiv"></div>
						<div class="fbg_distxt fbg_setdiv">
							<?php _e('OVERLAY SETTINGS','fbgallery'); ?>
							<div class="fbg_savebtn"><input type="submit" name="fbg_saves" value="Save"></div>
						</div>
						<div class="fbg_setdiv fbg_pm_wrap"><a class="fbg_plus_minus" href="Javascript:void(0);"></a></div>
						<div class="fbg_clear"></div>
					</div>
					<div class="fbg_extendbox">
						<div class="fbg_topbdr"></div>
						<div class="fbg_midbdr">
							<table border="0">
								<tr><th style="width:32%\9;"><?php _e('Display Overlay','fbgallery'); ?></th><td>&nbsp;<label class="fbg_mkchk <?php if($options['fbg_overlay']){ ?>checked<?php } ?>" for="alloverlay"></label><input id="alloverlay" class="fbg_chkbox fbg_wrap_chkbox" type="checkbox" name="<?php echo $option; ?>[fbg_overlay]" value="1" <?php checked('1', $options['fbg_overlay']); ?> />&nbsp;<span class="fbg_fBitter"><?php _e('Check it, if you want "Overlay Effect".','fbgallery') ?></span>
									<a class="fbg_tooltip" title="<?php _e("Check if you want to use the overlay effect and select one of the following overlay effects.",'fbgallery'); ?>"></a></td></tr>		
								<tr>
								<td colspan="2">
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/01.png"){ echo "active";} ?>" for="fwe1" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/01.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/01.png"){ echo "checked";} ?> value="images/overlay/01.png" id="fwe1" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/02.png"){ echo "active";} ?>" for="fwe2" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/02.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/02.png"){ echo "checked";} ?> value="images/overlay/02.png" id="fwe2" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/03.png"){ echo "active";} ?>" for="fwe3" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/03.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/03.png"){ echo "checked";} ?> value="images/overlay/03.png" id="fwe3" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/04.png"){ echo "active";} ?>" for="fwe4" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/04.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/04.png"){ echo "checked";} ?> value="images/overlay/04.png" id="fwe4" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/05.png"){ echo "active";} ?>" for="fwe5" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/05.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/05.png"){ echo "checked";} ?> value="images/overlay/05.png" id="fwe5" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/06.png"){ echo "active";} ?>" for="fwe6" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/06.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/06.png"){ echo "checked";} ?> value="images/overlay/06.png" id="fwe6" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/07.png"){ echo "active";} ?>" for="fwe7" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/07.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/07.png"){ echo "checked";} ?> value="images/overlay/07.png" id="fwe7" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/08.png"){ echo "active";} ?>" for="fwe8" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/08.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/08.png"){ echo "checked";} ?> value="images/overlay/08.png" id="fwe8" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/09.png"){ echo "active";} ?>" for="fwe9" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/09.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/09.png"){ echo "checked";} ?> value="images/overlay/09.png" id="fwe9" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/10.png"){ echo "active";} ?>" for="fwe10" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/10.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/10.png"){ echo "checked";} ?> value="images/overlay/10.png" id="fwe10" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/11.png"){ echo "active";} ?>" for="fwe11" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/11.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/11.png"){ echo "checked";} ?> value="images/overlay/11.png" id="fwe11" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/12.png"){ echo "active";} ?>" for="fwe12" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/12.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/12.png"){ echo "checked";} ?> value="images/overlay/12.png" id="fwe12" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/13.png"){ echo "active";} ?>" for="fwe13" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/13.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/13.png"){ echo "checked";} ?> value="images/overlay/13.png" id="fwe13" ></label>
									<label class="fbg_rdlb <?php if($options['fbg_oveffect'] == "images/overlay/14.png"){ echo "active";} ?>" for="fwe14" style="background:#e7e7e7 url('<?php echo plugins_url('',dirname(__FILE__)) ?>/images/overlay/14.png');"><input type="radio" name="<?php echo $option; ?>[fbg_oveffect]" <?php if($options['fbg_oveffect'] == "images/overlay/14.png"){ echo "checked";} ?> value="images/overlay/14.png" id="fwe14" ></label>
									<div class="fbg_clear"></div>
								</td>
							</table>	
							<div class="fbg_clear"></div>
						</div>
						<div class="fbg_btmbdr"></div>
					</div>
				</div>
				
				<div class="fbg_block">
					<div class="fbg_settings">
						<div class="fbg_sicon fbg_sbgc fbg_setdiv"></div>
						<div class="fbg_distxt fbg_setdiv">
							<?php _e('BACKGROUND COLOR SETTINGS','fbgallery'); ?>
							<div class="fbg_savebtn"><input type="submit" name="fbg_saves" value="Save"></div>
						</div>
						<div class="fbg_setdiv fbg_pm_wrap"><a class="fbg_plus_minus" href="Javascript:void(0);"></a></div>
						<div class="fbg_clear"></div>
					</div>
					<div class="fbg_extendbox">
						<div class="fbg_topbdr"></div>
						<div class="fbg_midbdr">
							<table border="0">
								<tr><th><?php _e('Enable BG-Color','fbgallery'); ?></th><td><div><label class="fbg_mkchk <?php if($options['fbg_bgclrchk']){ ?> checked <?php } ?>" for="fbg_bgclrchk"></label><input type="checkbox" class="fbg_chkbox fbg_wrap_chkbox" id="fbg_bgclrchk" value="1"  <?php checked('1', $options['fbg_bgclrchk']); ?> name="<?php echo $option; ?>[fbg_bgclrchk]" />&nbsp;<span class="fbg_fBitter" style="margin-left: 4px;"><?php _e('Check it, if you want to use "BG Color instead of gallery images".','fbgallery'); ?></span></div></td></tr>
								<tr><th><?php _e("Background Color",'fbgallery'); ?></th><td><div class="fbg_colwrap"><input style="background-image: none;" type="text" id="fbg_bgcolor" class="fbg_color_inp" value="<?php if($options['fbg_bgcolor']) echo $options['fbg_bgcolor']; else echo "#111"; ?>" name="<?php echo $option; ?>[fbg_bgcolor]" /><div class="fbg_colsel fbg_bgcolor"></div></div>
									<a class="fbg_tooltip" title="<?php _e("Check if you want to use background color instead of images and select what color you want to use.",'fbgallery'); ?>"></a></td></tr>
							</table>	
							<div class="fbg_clear"></div>
						</div>
						<div class="fbg_btmbdr"></div>
					</div>
				</div>
				
				<div class="fbg_block">
					<div class="fbg_settings">
						<div class="fbg_sicon fbg_sbgv fbg_setdiv"></div>
						<div class="fbg_distxt fbg_setdiv">
							<?php _e('BACKGROUND VIDEO SETTINGS','fbgallery'); ?>
							<div class="fbg_savebtn"><input type="submit" name="fbg_saves" value="Save"></div>
						</div>
						<div class="fbg_setdiv fbg_pm_wrap"><a class="fbg_plus_minus" href="Javascript:void(0);"></a></div>
						<div class="fbg_clear"></div>
					</div>
					<div class="fbg_extendbox">
						<div class="fbg_topbdr"></div>
						<div class="fbg_midbdr">
							<table border="0">
								<tr><th><?php _e('Enable BG-Video','fbgallery'); ?></th><td><div><label class="fbg_mkchk <?php if($options['fbg_bgvdochk']){ ?> checked <?php } ?>" for="fbg_bgvdochk"></label><input type="checkbox" class="fbg_chkbox fbg_wrap_chkbox" id="fbg_bgvdochk" value="1"  <?php checked('1', $options['fbg_bgvdochk']); ?> name="<?php echo $option; ?>[fbg_bgvdochk]" />&nbsp;<span class="fbg_fBitter" style="margin-left: 4px;"><?php _e('Check it, if you want to use "BG Video instead of gallery images".','fbgallery'); ?></span></div></td></tr>
								<tr><th><label><?php _e('URL / PATH (.mp4 / YouTube)','fbgallery'); ?></label></th><td><input class="fbg_upvdo"  type="text" name="<?php echo $option; ?>[fbg_bgvdourl]" value="<?php echo $options['fbg_bgvdourl'] ?>" /> <input class="fbg_vdupbtn" type="button" /><a class="fbg_tooltip" style="left: 5px;top: 2px;" title="<?php _e("Check if you want to use background video instead of images & bg-color and enter video path/url that you want to show.",'fbgallery'); ?>"></a></td></tr>	
								<tr><th><?php _e("Repeat Video",'fbgallery'); ?></th><td><label class="fbg_setchk <?php if($options['fbg_bgvdrept']){ ?> checked <?php } ?>" for="fbg_bgvdrept"></label><input value="1" type="checkbox" class="fbg_onoff_chkbox" id="fbg_bgvdrept" name="<?php echo $option; ?>[fbg_bgvdrept]" <?php checked('1', $options['fbg_bgvdrept']); ?> />
									<a class="fbg_tooltip" title="<?php _e("Set No/Off Video looping.",'fbgallery'); ?>"></a></td></tr>
							</table>	
							<div class="fbg_clear"></div>
						</div>
						<div class="fbg_btmbdr"></div>
					</div>
				</div>
				
				<div class="fbg_block">
					<div class="fbg_settings">
						<div class="fbg_sicon fbg_simg fbg_setdiv"></div>
						<div class="fbg_distxt fbg_setdiv">
							<?php _e('BACKGROUND IMAGE SETTING','fbgallery'); ?>
							<div class="fbg_savebtn"><input type="submit" name="fbg_saves" value="Save"></div>
						</div>
						<div class="fbg_setdiv fbg_pm_wrap"><a class="fbg_plus_minus" href="Javascript:void(0);"></a></div>
						<div class="fbg_clear"></div>
					</div>
					<div class="fbg_extendbox">
						<div class="fbg_topbdr"></div>
						<div class="fbg_midbdr">
							<table border="0">
								<tr><th><label><?php _e('Enter BG-Image URL / PATH','fbgallery'); ?></label></th><td><input class="fbg_uploadimg"  type="text" name="<?php echo $option; ?>[fbg_img]" value="<?php echo $options['fbg_img']; ?>" /> <input class="fbg_uploadbtn" type="button" /> </td></tr>
							</table>
						</div>
						<div class="fbg_btmbdr"></div>						
					</div>
				</div>
				<input type="hidden" id="fbg_itemname" name="fbg_itemname" value="<?php echo $option; ?>" />	
				<input type="hidden" name="action" value="fbg_saved" />
				<input type="hidden" name="security" value="<?php echo wp_create_nonce('fbgallery-options-data'); ?>" />
				<input type="submit" value="" class="fbg_saveall"  name="fbg_saves">	
			</form>
		</div>
		<div class="fbg_overlay"></div>
		<div class="fbg_clear"></div>
	</div>
</div>
<?php
}