<?php
class FbgFront
{
	// Display fbg gallery
	function fbg_display($fbg_option)
	{
		$options = get_option($fbg_option);
		$fbg_overlay = $options["fbg_overlay"];
		$fbg_oveffect = $options["fbg_oveffect"];
		$fbg_bgclrchk = $options["fbg_bgclrchk"];
		$fbg_bgcolor = $options["fbg_bgcolor"];
		$fbg_bgvdochk = $options["fbg_bgvdochk"];
		$fbg_bgvdourl = $options["fbg_bgvdourl"];
		$fbg_bgvdrept = $options["fbg_bgvdrept"];
		$fbg_img = $options["fbg_img"];
		if(!$fbg_bgvdrept){$fbg_bgvdrept=0;}
	?>
	<!-- FBG GALLERY LITE Starts Here -->
		<?php if(!$fbg_bgclrchk && !$fbg_bgvdochk){ ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){jQuery.fbgallery('#fbgallery',{});});
		</script>
		<?php } ?>
		
		<?php 
		if($fbg_bgvdochk)
		{ 
			$query_string = @parse_url($fbg_bgvdourl, PHP_URL_QUERY);
			@parse_str($query_string, $youtubeid);
			if($youtubeid['v'])
			{ ?>
				<script type="text/javascript">
					jQuery(window).load(function(){
						setTimeout(function() {
							jQuery('#fbg-youtube-wrap').css({'visibility':'visible'});
							jQuery('#fbgallery-loader').remove();
							jQuery('body').append('<div id="fbg-yt-controls"><a href="javascript:void(0);" class="yt-play" title="play"></a><a href="javascript:void(0);" class="yt-pause" title="pause"></a><a href="javascript:void(0);" class="yt-mute" title="mute/unmute"></a></div>');
							jQuery('#fbg-yt-controls a.yt-mute').click(function(){
								if(!jQuery(this).hasClass('active')){
									jQuery(this).addClass('active');
								}else{
									jQuery(this).removeClass('active');
								}
							});
						}, 1000);
					});
					
					jQuery(document).ready(function(){
						jQuery('body').append('<div id="fbgallery-loader">Loading video...</div>');
						var options = { videoId: '<?php echo $youtubeid['v']; ?>',repeat:<?php echo $fbg_bgvdrept; ?>};
						jQuery('body').tubular(options);
					});
				</script>
			  <?php 
			} 
			else 
			{ 
			?>
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery('body').css('padding-bottom','50px').append('<div id="fbgallery-loader">Loading video...</div>').append('<div id="fbg_scroll"></div>');
						var FBGV = new jQuery.FbgVideo();
						FBGV.init();
						FBGV.show('<?php echo $fbg_bgvdourl; ?>',{doLoop:<?php echo $fbg_bgvdrept; ?>});
					});
					jQuery(window).load(function(){
						setTimeout(function() {
							jQuery('#fbg-video-wrap,#fbg-video-control-container').css({'visibility':'visible'});
							jQuery('#fbgallery-loader').remove();
						}, 1000);
						obj = jQuery('#fbg-video-control-container');
						objscroll = jQuery('#fbg_scroll');
						objscroll.mouseenter(function(){obj.stop(true,true).animate({'height':'50px'},0)});
						obj.mouseleave(function(){obj.stop(true,true).animate({'height': '0'},0)});
						
						jQuery('#fbg_hidecont').click(function(){
							jQuery('body').find('div').not('#fbg-video-wrap,#fbg-video-control-container,#fbg_scroll').not(jQuery('#fbg-video-wrap').children()).not(jQuery('#fbg-video-control-container').find('*')).hide();
						
						});
						
					});
				</script>
			<?php 
			} 
		} 
		?>
		<?php if(!$fbg_bgvdochk){ ?>
		<div id="fbgallery" class="<?php echo 'fbg_'.$fbg_option; ?>"><?php
			$from_this = "http://www.wpfruits.com/full-width-background-gallery-wordpress-plugin/?fbglite_refs=".$_SERVER['SERVER_NAME'];
			if($fbg_bgclrchk){ ?><div class="fbg_bgcolor" style="background:<?php echo $fbg_bgcolor; ?>;"></div><?php }
			else{
				if(!empty($fbg_img)){
					?><img class="fbg_bg" src="<?php echo $fbg_img; ?>" /><?php
				}
			}
			if($fbg_overlay){ ?><div class="fbgoverlay" style="background:url('<?php echo plugins_url('',dirname(__FILE__)).'/'.$fbg_oveffect; ?>')"></div><?php }
			?>
		</div>
		<a id="fbg_fromthis" href="<?php echo $from_this; ?>" target="_blank"></a>
		<?php } ?>
	<!-- FBG GALLERY LITE Ends Here -->
	<?php
	}

	function fbg_getgallryName($fbgID)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "fbgallery"; 
		$fbg_fetchgallry = $wpdb->get_results("SELECT * FROM $table_name WHERE id=$fbgID",ARRAY_A);
		$fbg_optionNm = $fbg_fetchgallry[0]['option_name'];
		return $fbg_optionNm;
	}

	function fbg_isActive($fbgID)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "fbgallery"; 
		$fbg_fetchgallry = $wpdb->get_results("SELECT * FROM $table_name WHERE id=$fbgID",ARRAY_A);
		$fbg_active = $fbg_fetchgallry[0]['active'];
		return $fbg_active;
	}
}
?>