window.jQuery = window.$ = jQuery;

jQuery(function ($) {

    /* SIDEBAR MANAGER */
    $(document).on('click', '.admin_create_new_sidebar_btn', function () {
        var sidebar_name = $(this).parents('.add_new_sidebar').find('.admin_create_new_sidebar').val();
        if (sidebar_name == "") {
            alert("Sidebar must be named");
            return false;
        }
        $(this).parents('.admin_mix-tab-control').find('.admin_sidebars_list').append('<div class="admin_sidebar_item"><input type="hidden" name="theme_sidebars[]" value="' + sidebar_name + '"><span class="admin_sidebar_name admin_visual_style1">' + sidebar_name + '</span><input type="button" class="admin_delete_this_sidebar admin_img_button cross" name="delete_this_sidebar" value="X"></div>');
        $(this).parents('.add_new_sidebar').find('.create_new_sidebar').val("");
    });
    $(document).on('click', '.admin_delete_this_sidebar', function () {
        var agree = confirm("Are you sure?");
        if (!agree)
            return false;
        $(this).parents('.admin_sidebar_item').remove();
    });
    /* END SIDEBAR MANAGER */


    /*
     Hide/Show tabs
     */
    jQuery('.admin_l-mix-tabs-item').click(function () {
        jQuery('.admin_l-mix-tabs-item').removeClass('active');
        jQuery('.admin_mix-tab').hide();

        var data_tabname = jQuery(this).find('.admin_l-mix-tab-title').attr('data-tabname');

        jQuery(this).addClass('active');
        jQuery('.' + data_tabname).show();
        jQuery('#form-tab-id').val(data_tabname);

        return false;
    });

    /*
     Hide/Show tabs
     */
    jQuery('.admin_l-mix-tabs-list li').first().addClass('active');
    jQuery('.admin_mix-tabs .admin_mix-tab').first().show();

    /*
     Autoopen tab in admin
     */
    var admin_tab_now_open = jQuery('#form-tab-id').val();
    if (admin_tab_now_open !== "") {
        jQuery('.admin_l-mix-tabs-item').removeClass('active');
        jQuery('#' + admin_tab_now_open).addClass('active');
        jQuery('.admin_mix-tab').hide();
        jQuery('.' + admin_tab_now_open).show();
    }

    jQuery('.fadeout').delay(2000).fadeOut("slow");


    // ajax button
    $('.admin_mix_ajax_button').click(function () {

        var $this = $(this),
            $loader = $this.next(),
            $msgs = $loader.next(),
            id = $this.data('id'),
            _confirm = $this.data('confirm') || true,
            data = window.ajaxButtonData[id];

        if (_confirm) {
            if (!confirm('Are you sure?')) {
                return false;
            }
            ;
        }
        ;

        $loader.show();
        $.post(admin_ajax, data, function (data) {
            $loader.hide();
        }, 'json');

        return false;
    });

    $(document).on('keyup', '.itemTitle', function () {
        var thistitle = $(this).val();
        $(this).parents(".thisitem").find(".echotitle").html(thistitle);
    });

    $(document).on('keyup', '.price_feature .expanded_text1', function () {
        var thistitle = $(this).val();
        $(this).parents(".price_feature").find(".option_title").html(thistitle);
    });

    $(document).on("click", ".deleteThisSlide", function () {

        var temp = $(this).parents(".mainPageSliderItem").find("li");

        $(this).parents("li").remove();

        var tempi = -1;
        temp.each(function (index) {
            $(this).find(".itemorder").val(tempi);
            tempi = tempi + 1;
        });

    });

    $(document).on("click", ".editThisSlide", function () {
        $(this).parents(".thisitem").find(".hiddenArea").fadeToggle();
    });

    $(document).on("click", ".uploadImg", function () {
        formfield = jQuery('.uploadImg').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.thisUploadButton = $(this);

        window.send_to_editor = function (html) {
            imgurl = jQuery('img', html).attr('src');
            thisUploadButton.parents(".fr").find(".itemImage").val(imgurl);
            tb_remove();
        }

        return false;
    });

    $(document).on("click", ".gt3UploadImg", function () {
        formfield = $(this).attr('name');
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        window.thisUploadButton = $(this);

        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            thisUploadButton.val(imgurl);
            tb_remove();
        }

        return false;
    });


    $(window).load(function () {
        /* COLOR PICKER */
        $('.cpicker').ColorPicker({
            onSubmit:function (hsb, hex, rgb, el) {
                $(el).val(hex);
                $(el).ColorPickerHide();
                $(".cpicker.focused").next().css("background-color", "#" + hex);
            },
            onBeforeShow:function () {
                $(this).ColorPickerSetColor(this.value);
            },
            onHide:function () {
                $("input").removeClass("focused");
            },
            onChange:function (hsb, hex, rgb) {
                $(".cpicker.focused").val(hex);
                $(".cpicker.focused").next().css("background-color", "#" + hex);
            }
        })
            .bind('keyup', function () {
                $(this).ColorPickerSetColor(this.value);
            });


        /* POST FORMATS */
        /* list of all containers: #portslides_sectionid_inner, #audio_sectionid_inner, #video_sectionid_inner, #default_sectionid_inner */
        var nowpostformat = $('#post-formats-select input:checked').val();
        var nowNEWpostformat = $('.post-format-options a.active').attr("data-wp-format");

        if (nowpostformat == 'image' || nowNEWpostformat == 'image') {
            $('#portslides_sectionid_inner').show();
        }
        if (nowpostformat == 'video') {
            $('#video_sectionid_inner').show();
        }
        if (nowpostformat == '0' || nowNEWpostformat == 'standard') {
            $('#default_sectionid_inner').show();
        }

        /* ON CHANGE */
        /* WP <=3.5 */
        $('#post-formats-select input').click(function () {
            $('#portslides_sectionid_inner, #audio_sectionid_inner, #video_sectionid_inner, #default_sectionid_inner').hide();
            var nowclickformat = $(this).val();
            if (nowclickformat == 'image') {
                $('#portslides_sectionid_inner').show();
            }
            if (nowclickformat == 'audio') {
                $('#audio_sectionid_inner').show();
            }
            if (nowclickformat == 'video') {
                $('#video_sectionid_inner').show();
            }
            if (nowclickformat == '0') {
                $('#default_sectionid_inner').show();
            }
        });
        /* WP >=3.6 */
        $('.post-format-options a').click(function () {
            $('#portslides_sectionid_inner, #audio_sectionid_inner, #video_sectionid_inner, #default_sectionid_inner').hide();
            var nowclickformat = $(this).attr("data-wp-format");
            if (nowclickformat == 'image') {
                $('#portslides_sectionid_inner').show();
            }
            if (nowclickformat == 'standard') {
                $('#default_sectionid_inner').show();
            }
        });

        /* Show tab on start */
        if ($("#form-tab-id").val() == "") {
            $("#form-tab-id").val($(".l-mix-tabs-list li.active a").attr("data-tabname"))
        }

        $(".cpicker.admin_textoption").each(function (index) {
            var already_selected_color = $(this).val();
            $(this).next().css("background-color", "#" + already_selected_color);
        });

        $('.cpicker.admin_textoption').keyup(function (event) {
            var now_enter_color = $(this).val();
            $(this).next().css("background-color", "#" + now_enter_color);
        });

    });

    $('.cpicker').focus(function () {
        $(this).addClass("focused");
    });

    /* SELECT BOX */
    $(".admin_mix-container select, .admin_newselect").selectBox();
    /* END SELECT BOX */

    $(document).ready(function () {
		$('.custom_select_img_preview').click(function(){
			$(this).find('img').remove();
			$('.custom_select_img_attachid').val('');
		});
		
		if ($('.sidebar_layout').val() == 'none') {
			$('.sidebar_none').slideUp(1);
		}
		if ($('.sidebar_layout').val() == 'default') {
			if ($('.select_sidebar').hasClass('sidebar_none')) {
				$('.sidebar_none').slideUp(1);
			}			
		}
		
		$('.sidebar_layout').change(function(){
			if ($(this).val() == 'no-sidebar') {
				$('.select_sidebar').stop().slideUp(300);
			} else {
				$('.select_sidebar').stop().slideDown(300);				
			}
			if ($(this).val() == 'default') {
				if ($('.select_sidebar').hasClass('sidebar_none')) {
					$('.select_sidebar').stop().slideUp(300);
				} else {
					$('.select_sidebar').stop().slideDown(300);
				}
			}
		});

		if ($('.page_layout').val() == 'clean') {
			$('.boxed_options').slideUp(1);
		}
		if ($('.page_layout').val() == 'default') {
			if ($('.boxed_options').hasClass('no_boxed')) {
				$('.boxed_options').slideUp(1);
			}			
		}

		$('.page_layout').change(function(){			
			if ($(this).val() == 'clean') {
				$('.boxed_options').stop().slideUp(300);
			} else {
				$('.boxed_options').stop().slideDown(300);
			}
			if ($(this).val() == 'default') {
				if ($('.boxed_options').hasClass('no_boxed')) {
					$('.boxed_options').stop().slideUp(300);
				} else {
					$('.boxed_options').stop().slideDown(300);
				}
			}
		});
		
        $('select.fontselector').change(function () {
            var newval = $(this).val();

            var customfontstatus = "disabled";

            if(fontsarray.length>0){
                for ( keyVar in fontsarray ) {
                    if (newval==fontsarray[keyVar]) {
                        customfontstatus = "enabled";
                    }
                }
            }

            if (customfontstatus!=="enabled") {
                newval_font = newval.replace(new RegExp(" ", 'g'), "+");
                if (newval_font !== "Arial" && newval_font !== "Verdana" && newval_font !== "Times New Roman" && newval_font !== "Helvetica" && newval_font !== "Courier New" && newval_font !== "Tahoma") {
                    $("head").append("<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=" + newval_font + "'>");
                }
                $(this).parents(".admin_input").find(".font_preview").css("font-family", newval);
            } else {
                $(this).parents(".admin_input").find(".font_preview").css("font-family", newval);
            }
        });

        $("select.fontselector").each(function(){
            $(this).triggerHandler("change");
        })

    });

});

function remove_responce_message () {
    $("#wpwrap").css("opacity", "1");
    $(".result_message").remove();
}

/* SAVING ADMIN SETTINGS WITH AJAX */
jQuery("document").ready(function($) {
    $(".admin_page_settings .admin_save_all").click(function() {
        $("#wpwrap").css("opacity", "0.5");
        var data = $(".admin_page_settings").serialize();
        $.post(ajaxurl, { action:'save_admin_settings', json_string:data }, function(response) {
            $("body").append("<div class='result_message'>"+response+"</div>");
            setTimeout(remove_responce_message , 2000);
        });
        return false;
    });
    $(".admin_page_settings .admin_reset_settings").click(function() {
        var agree = confirm("Are you sure?");
        if (!agree)
            return false;
        $("#wpwrap").css("opacity", "0.5");
        $.post(ajaxurl, { action:'reset_admin_settings' }, function(response) {
            $("body").append("<div class='result_message'>"+response+"</div>");
            setTimeout(remove_responce_message , 2000);
            window.location.reload();
        });
        return false;
    });

    $(".add-new-strip").click(function(){
        var data = {
            action:'get_unused_id_ajax'
        };
        var striproottag = $(this);

        waiting_state_start();

        $.post(ajaxurl, data, function (response) {


            striproottag.parents(".gt3settings_box_content").find(".append_items").append('<li><div class="sort_drug strip_head">Strip item</div><input type="text" value="" name="pagebuilder[strips][' + response + '][striptitle1]" placeholder="Title 1"><input type="text" value="" name="pagebuilder[strips][' + response + '][striptitle2]" placeholder="Title 2"><input type="text" value="" name="pagebuilder[strips][' + response + '][striptitle3]" placeholder="Title 3"><input type="text" value="" name="pagebuilder[strips][' + response + '][striptitle4]" placeholder="Title 4"><input type="text" value="" name="pagebuilder[strips][' + response + '][striptitle5]" placeholder="Title 5"><input type="text" placeholder="Link" name="pagebuilder[strips][' + response + '][link]" value=""><input type="text" placeholder="Image" name="pagebuilder[strips][' + response + '][image]" value="" class="gt3UploadImg"><span class="remove_strip">[x]</span></li>');
            $('.strip_cont .append_items').sortable({ placeholder:'ui-state-highlight', handle:'.sort_drug' });
            waiting_state_end();
        });
    });

    $('.strip_cont .append_items').sortable({ placeholder:'ui-state-highlight', handle:'.sort_drug' });

    $(document).on('click', '.remove_strip', function () {
        $(this).parents("li").remove();
    });
});


var file_frame;
jQuery('.add_image_from_wordpress_library_popup').live('click', function( event ){
    var custom_select_select_image = jQuery(this).parents(".boxed_options");
    event.preventDefault();

    if ( file_frame ) {
        file_frame.open();
        return;
    }

    file_frame = wp.media.frames.file_frame = wp.media({
        title: jQuery( this ).data( 'uploader_title' ),
        button: {
            text: jQuery( this ).data( 'uploader_button_text' ),
        },
        multiple: false
    });

    file_frame.on( 'select', function() {
        attachment = file_frame.state().get('selection').first().toJSON();
        custom_select_select_image.find(".custom_select_img_attachid").val(attachment.id);
       	custom_select_select_image.find(".custom_select_img_preview").html("<img src='"+attachment.url+"' alt=''>");
    });

    file_frame.open();
});

var file_frame_new;
jQuery('.select_attach_id_from_media_library').live('click', function( event ){
    var select_image_root = jQuery(this).parents(".select_image_root");
    event.preventDefault();

    if ( file_frame_new ) {
        file_frame_new.open();
        return;
    }

    file_frame_new = wp.media.frames.file_frame = wp.media({
        title: jQuery( this ).data( 'uploader_title' ),
        button: {
            text: jQuery( this ).data( 'uploader_button_text' ),
        },
        multiple: false
    });

    file_frame_new.on( 'select', function() {
        attachment = file_frame_new.state().get('selection').first().toJSON();
        select_image_root.find(".select_img_attachid").val(attachment.id);
        select_image_root.find(".select_img_preview").html("<img src='"+attachment.url+"' alt=''>");
    });

    file_frame_new.open();
});

function add_menu_item() {
	$('.field-css-classes').each(function(){
		if($(this).find('.show_menu_icon').size() > 0) {} else {
			$(this).find('label').before('<label class="choose_icon_label">Choose menu icon:</label><div class="mymenu-icon-ribbon show_menu_icon" data-id="'+$(this).find('input.edit-menu-item-classes').attr('id')+'"></div>');
			$(this).find('.edit-menu-item-classes').val('mymenu-icon-ribbon');
		}
	});			
}