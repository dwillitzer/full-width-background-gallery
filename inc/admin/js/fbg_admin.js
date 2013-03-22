/*-- FBG GALLERY PRO Admin script
---------------------------------------*/
jQuery(document).ready(function(){

	/*post/page mata option script start*/
		if(jQuery("#fbg_post_metas #fbg_disable").is(':checked')){jQuery('#fbg_post_metas .fbg_disable').hide();}
		if(!jQuery("#fbg_post_metas #fbg_check").is(':checked')){jQuery('#fbg_post_metas .fbg_selection').hide();}

		jQuery("#fbg_post_metas #fbg_check").click(function(){
			if(jQuery("#fbg_post_metas #fbg_check").is(':checked')){jQuery('#fbg_post_metas .fbg_selection').slideDown();}
			else{jQuery('#fbg_post_metas .fbg_selection').slideUp();}
		});

		jQuery("#fbg_post_metas #fbg_disable").click(function(){
			if(jQuery("#fbg_post_metas #fbg_disable").is(':checked')){
				jQuery('#fbg_post_metas .fbg_disable').slideUp();
				jQuery("#fbg_post_metas #fbg_check").prop("checked", false);
			}
			else{jQuery('#fbg_post_metas .fbg_disable').slideDown();}
		});
	/*post/page mata option script end*/
	
	jQuery('#fbg_wrapper .fbg_onoff_chkbox,#fbg_wrapper .fbg_wrap_chkbox,#fbg_wrapper .fbg_chkbox').click(function(){
		if(jQuery(this).is(':checked')){jQuery(this).prev('label').addClass('checked');}
		else{jQuery(this).prev('label').removeClass('checked');}
	});
	
	jQuery('#fbg_wrapper .fbg_rdlb').click(function(){jQuery('#fbg_wrapper .fbg_rdlb').removeClass('active');jQuery(this).addClass('active');}); 

	jQuery('#fbg_wrapper .fbg_settings').click(function(){
		jQuery('#fbg_wrapper .fbg_settings').removeClass('fbgbox_active');
		jQuery('#fbg_wrapper .fbg_extendbox').removeClass('fbgbox_active');
		jQuery(this).toggleClass('fbgbox_active');
		jQuery(this).find('.fbg_plus_minus').toggleClass('active');
		jQuery('#fbg_wrapper .fbg_expCol').addClass('active');
		jQuery(this).next('.fbg_extendbox').stop(true,true).slideToggle('fast',function(){jQuery(this).toggleClass('fbgbox_active');if (!jQuery('.fbg_extendbox:visible').length){ jQuery('#fbg_wrapper .fbg_expCol').removeClass('active');}});
	});
	
	jQuery('#fbg_wrapper .fbg_settings .fbg_savebtn input').click(function(e) {
        e.stopPropagation();
    });
	
	jQuery('#fbg_wrapper .fbg_expCol').click(function(){
		var fbg_expcol = jQuery(this);
		if(jQuery(this).is('.active')){
			jQuery('#fbg_wrapper .fbg_extendbox').slideUp('fast',function(){
				jQuery('#fbg_wrapper .fbg_plus_minus').removeClass('active');
				jQuery(fbg_expcol).removeClass('active');
			});
			
		}else{
			jQuery('#fbg_wrapper .fbg_extendbox').slideDown('fast',function(){
				jQuery('#fbg_wrapper .fbg_plus_minus').addClass('active');
				jQuery(fbg_expcol).addClass('active');
			});
		}
	});
	
	jQuery('#fbg_wrapper .fbg_smallchkbox').click(function(){
		if(jQuery(this).is(':checked')){jQuery(this).parent('label').addClass('checked');}
		else{jQuery(this).parent('label').removeClass('checked');}
	});
	
	jQuery('#fbg_wrapper .fbg_td').click(function(){
		jQuery('#fbg_wrapper .fbg_td').removeClass('checked');
		jQuery(this).addClass('checked');
	}); 
	
	jQuery('#fbg_wrapper .fbg_nvps').click(function(){
		jQuery('#fbg_wrapper .fbg_nvps').removeClass('checked');
		jQuery(this).addClass('checked');
	}); 
	
	/*settings check jquery start*/
	jQuery("#fbg_settchk").click(function(){
		if(jQuery(this).is(':checked')){jQuery('#fbg_settings .fbg_setblock').slideDown('fast');}
		else{jQuery('#fbg_settings .fbg_setblock').slideUp('fast');}
	});
	/*settings check jquery end*/
	

//-- Upload image & video jquery start -----------------
	var targetfield= '';
	var fbg_send_to_editor = window.send_to_editor;
	jQuery('.fbg_uploadbtn').live('click',function(){
		targetfield = jQuery(this).prev('.fbg_uploadimg');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			jQuery(targetfield).val(imgurl);
			tb_remove();
			window.send_to_editor = fbg_send_to_editor;
		}
		return false;
	});	
	
	var vdfield= '';
	var fbg_send_to_editor = window.send_to_editor;
	jQuery('.fbg_vdupbtn').live('click',function(){
		vdfield = jQuery(this).prev('.fbg_upvdo');
		tb_show('', 'media-upload.php?type=video&TB_iframe=true');
		window.send_to_editor = function(html) {
			vdourl = jQuery(html).attr('href');
			jQuery(vdfield).val(vdourl);
			tb_remove();
			window.send_to_editor = fbg_send_to_editor;
		}
		return false;
	});	
	
	
	
//---------------------------------------------------

//-- color picker jquery start ----------------------
	if (jQuery("#fbg_wrapper .fbg_bgcolor").length > 0){
		jQuery('#fbg_wrapper .fbg_bgcolor').farbtastic('#fbg_bgcolor');
	}
	jQuery('html').click(function() {jQuery("#fbg_wrapper .farbtastic").fadeOut('fast');});
	jQuery('#fbg_wrapper .fbg_colsel').click(function(event){
		jQuery("#fbg_wrapper .farbtastic").hide();
		jQuery(this).find(".farbtastic").fadeIn('fast');event.stopPropagation();
	});
//-- color picker jquery end ----------------------

//-- delete gallery confirm dialogbox -------------	
	jQuery('a.fbg_del').click(function(){
		var del_option =  jQuery(this).attr('id');
		var pass_msg = "Delete <b style='color: #000000;padding-left: 2px;padding-right: 2px;text-decoration: blink;'>" + del_option + "</b> FBG Gallery.. ?";
		jQuery('#fbg_delOption').attr('title',pass_msg);
		
		jQuery("#fbg_delOption").dialog({
			autoOpen: true, 
			resizable: false,
			height:150,
			modal: true,
			buttons: {
				"Delete Gallery" : function(){
					window.location.href = window.location.href + "&fbg_delete="+del_option;
					jQuery(this).dialog("destroy");
				},
				"No" : function() {
					jQuery(this).dialog("destroy");
				}
			}
		});
		return false;
	});
//-------------------------------------------------	

//-- Saved Hover Script ---------------------------
	if(jQuery('input[name*="fbg_settingsave"]').length > 0 || jQuery('input[name*="fbg_saves"]').length > 0){
		jQuery('input[name*="fbg_settingsave"],input[name*="fbg_saves"]').after('<span class="fbg_sv_hover"></span>');
		jQuery('input[name*="fbg_settingsave"],input[name*="fbg_saves"]').hover(
		function(){jQuery(this).next('span').stop().fadeIn('fast');},
		function(){jQuery(this).next('span').stop().fadeOut('fast');});
	}
	// add colon jquery --------------------------
	if(jQuery('#fbg_saveform').length > 0){
		jQuery('#fbg_saveform').find('table th').append('<span><span class="fbg_colon">:</span><div class="fbg_clear"></div></span>');
	}

//-------------------------------------------------
	
});

//-- FBG GALLERY Tooltip jquery script ------------------
fbg_ShowTooltip = function(e){
	var text = jQuery(this).find('.fbg_tooltip_txt');
	if (text.attr('class') != 'fbg_tooltip_txt')
		return false;
	text.stop(true,true).fadeIn('fast')
	return false;
}
fbg_HideTooltip = function(e){
	var text = jQuery(this).find('.fbg_tooltip_txt');
	if (text.attr('class') != 'fbg_tooltip_txt')
	return false;
	text.stop(true,true).fadeOut('fast');
}

fbg_SetupTooltips = function(){
	jQuery('.fbg_tooltip')
		.each(function(){
			jQuery(this).append('.');
			jQuery(this)
				.append(jQuery('<span/>')
					.attr('class', 'fbg_tooltip_txt')
					.html(jQuery(this).attr('title')))
				.attr('title', '');
		})
		.hover(fbg_ShowTooltip, fbg_HideTooltip);
}
jQuery(document).ready(function() {
	fbg_SetupTooltips();
	jQuery('span.fbg_tooltip_txt').prepend('<div class="fbg_tarr"></div>');
});
/*---------------------------------------------------*/
jQuery(document).ready(function($) {
	jQuery("form#fbg_saveform").submit(function(event){
		var data = jQuery(this).serializeArray();
		
		jQuery.ajax({	
			url:ajaxurl,
			data:data,
			type: "POST",
			beforeSend: function(){
				jQuery('#fbg_ajaxloader').fadeIn('fast');
				jQuery('.fbg_overlay').fadeIn('fast');
				jQuery('#fbg_settsaved').html('');
			},
			success: function(response) {
				if(response == 1){
					jQuery('#fbg_ajaxloader').fadeOut('fast');
					fbg_show_message(1);
					t = setTimeout('fbg_fade_message()', 1000);
				}else{
					jQuery('#fbg_ajaxloader').fadeOut('fast');
					fbg_show_message(0);
					t = setTimeout('fbg_fade_message()', 2700);
				}    
			}
		});
		return false;
	});
});
function fbg_show_message(n){
	if(n == 1){ jQuery('#fbg_settsaved').html('<div class="updated_msg"></div>').fadeIn(500);} 
	else if(n == 0){
		jQuery('#fbg_settsaved').html('<div class="info_msg"></div>').fadeIn(500);
	}
}
function fbg_fade_message(){jQuery('#fbg_settsaved').fadeOut(1000);jQuery('.fbg_overlay').fadeOut(1000);	clearTimeout(t);}