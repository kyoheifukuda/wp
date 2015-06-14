/* RUN */
window.jQuery = window.$ = jQuery;

$.fn.tinymce_textareas = function(selector){
};

function getRandomInt(min, max)
{
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

/* FIX FOR ALL OTHER ADMIN PAGES */
if (post_id < 1) {
    var post_id = 0;
}

function waiting_state_start() {
    $(".waiting-bg").show();
}

function waiting_state_end() {
    $(".waiting-bg").hide();
}

/* AUTO HEIGHT FOR POPUP */
function popupAutoH() {
    nowWinH = $(window).height();
    popupH = nowWinH - 150;
    $(".pop_scrollable_area").height(popupH);
}

function reactivate_color_picker() {
    /* REACTIVATE COLOR PICKER */
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

    $('.cpicker').focus(function () {
        $(this).addClass("focused");
    });
}


function reactivate_sortable() {
    $('.sections').sortable({ placeholder:'ui-state-highlight-sections', handle:'.some-element.move' });
    $('.feature-list').sortable({ placeholder:'ui-state-highlight-sections', handle:'.some-element2.move' });
    $('.sortable_icons_list').sortable();
}

function reactivate_selectbox() {
    $(".mix-container select, .newselect, .shortcodebox_content select").selectbox();
}

/* SHOW / HIDE content */
$(document).ready(function () {
    $(document).on('click', '.show-hide-container', function () {
        $(this).parents('.pb-cont').find('.hideable-content').toggle('fast');
    });
});


/* COLORBOX */
$(document).ready(function () {
    /* ADD IMAGE TO AVAILABLE MEDIA */
    $('.add_image_to_sliders_available_media').colorbox({
        href:'media-upload.php?post_id=' + post_id + '&type=image&pg=gallery',
        iframe:true,
        innerWidth:660,
        innerHeight:500,
        onClosed:function () {
            $.post(ajaxurl, {
                action:'get_media_for_postid',
                post_id:post_id,
                page:1
            }, function (data) {
                $('.available_media .ajax_cont').html(data);
            }, 'text');
        }
    });
	$('body').append('<div class="shortcodebox_fadder shortcodebox_hided"></div><div class="shortcodebox shortcodebox_hided" style="height:'+($(window).height()-200)+'px"><div class="shortcodebox_title"><h2>Shortcodes</h2><span class="shortcodebox_close"></span></div><div class="shortcodebox_content" style="height:'+($(window).height()-290)+'px"></div></div>');
	$('.shortcodebox_fadder').fadeOut(1, function(){
		$(this).removeClass('shortcodebox_hided');
	});
	$('.shortcodebox').fadeOut(1, function(){
		$(this).removeClass('shortcodebox_hided');
	});
	$('.shortcodebox_close').click(function(){
		$('.shortcodebox_fadder').fadeOut(300);
		$('.shortcodebox').fadeOut(300);
		shortcodes_costyl = true;
	});
	$('.shortcodebox_fadder').click(function(){
		$('.shortcodebox_fadder').fadeOut(300);
		$('.shortcodebox').fadeOut(300);
		shortcodes_costyl = true;
	});
});

$(document).ready(function () {
	$(".mix-container select, .newselect").selectbox();

    $(document).on('click', '.available_media_arrow', function(){
        if ($(this).hasClass("left_arrow")) {
            show_img_media_library_page = show_img_media_library_page-1;
        }
        if ($(this).hasClass("right_arrow")) {
            show_img_media_library_page = show_img_media_library_page+1;
        }

        if (show_img_media_library_page<1) {show_img_media_library_page=1;}

        $.post(ajaxurl, {
            action:'get_media_for_postid',
            post_id:post_id,
            page:show_img_media_library_page
        }, function (data) {
            if (data!=="no_items") {
                $('.available_media .ajax_cont').html(data);
            } else {
                show_img_media_library_page = show_img_media_library_page-1;
            }
        }, 'text');
    });

	$(window).resize(function(){
		$('.shortcodebox').height($(window).height()-200);
		$('.shortcodebox_content').height($(window).height()-290);
	});
    /*TipTip*/
    $(".tiptip").tipTip({maxWidth: "190px", edgeOffset: 0, defaultPosition: "top", delay: "0"});
	tiny_present = false;
	if ($('.tinyCont').size() > 0 || $('.tinytextarea').size() > 0) {
		tiny_present = true;
	}

    if (typeof(tinyMCE)=="undefined" || tiny_present == false) {
		our_tiny_firstrun = true;
	} else {
		run_Tiny();
    }
});

function run_Tiny() {
    if (typeof(tinyMCE)=="undefined") {} else {
        tinymce.PluginManager.add('gt3_code', function(editor) {
            function gt3_showDialog() {
                editor.windowManager.open({
                    title: "Source code",
                    body: {
                        type: 'textbox',
                        name: 'code',
                        multiline: true,
                        minWidth: editor.getParam("code_dialog_width", 600),
                        minHeight: editor.getParam("code_dialog_height", Math.min(tinymce.DOM.getViewPort().h - 200, 500)),
                        value: editor.getContent({source_view: true}),
                        spellcheck: false,
                        style: 'direction: ltr; text-align: left'
                    },
                    onSubmit: function(e) {
                        editor.focus();

                        editor.undoManager.transact(function() {
                            editor.setContent(e.data.code);
                        });

                        editor.selection.setCursorLocation();
                        editor.nodeChanged();
                    }
                });
            }

            editor.addCommand("mceCodeEditor", gt3_showDialog);

            editor.addButton('gt3_code', {
                icon: 'code',
                tooltip: 'Source code',
                onclick: gt3_showDialog
            });

            editor.addMenuItem('gt3_code', {
                icon: 'code',
                text: 'Source code',
                context: 'tools',
                onclick: gt3_showDialog
            });
        });

        our_tiny_firstrun = false;
        tinyMCE.init({
            menubar : false,
            plugins: "textcolor image wplink gt3_code",
            toolbar: "bold italic underline alignleft aligncenter alignright alignjustify blockquote bullist numlist undo redo link unlink image hr removeformat forecolor backcolor pbshortcodes gt3_code",
            setup : function(ed, shortcodes_costyl) {
                ed.addButton('pbshortcodes', {
                    title : 'Shortcodes',
                    image : GT3PBPLUGINROOTURL+'js/shortcode.png',
                    onclick : function() {
                        jQuery(function ($) {
                            console.log('sgh');
                            jQuery('.shortcodebox_fadder').fadeIn(500);
                            jQuery('.shortcodebox').fadeIn(500);
                            shortcodes_costyl = false;
                        });

                        jQuery.post(ajaxurl, {action:'getshortcodesUI'}, function (response) {
                            jQuery('.shortcodebox .shortcodebox_content').html(response);
                            reactivate_selectbox();
                            reactivate_color_picker();
                        });

                        if (shortcodes_costyl == false) {
                            jQuery(document).on("click", ".insertshortcode", function(){
                                var thisShortCodeName = jQuery(this).parents(".shortcodeitem").attr("shortcodename");

                                /* exec shortcode compiller */
                                handlerName = thisShortCodeName + "_handler";
                                var thisHandler = window[handlerName];
                                thisHandler();

                                jQuery('.shortcodebox').fadeOut(500);
                                jQuery('.shortcodebox_fadder').fadeOut(500);

                                var whatInsert = jQuery(this).parents(".shortcodeitem").find(".whatInsert").html();
                                if (shortcodes_costyl == false) {
                                    ed.execCommand('mceInsertContent', false, whatInsert);
                                    shortcodes_costyl = true;
                                }
                            });

                            jQuery(document).on("click", ".shortcodebox_close", function(){
                                var whatInsert = "";
                                if (shortcodes_costyl == false) {
                                    ed.execCommand('mceInsertContent', false, whatInsert);
                                    shortcodes_costyl = true;
                                }
                            });

                            jQuery(document).on("click", ".shortcodebox_fadder", function(){
                                var whatInsert = "";
                                if (shortcodes_costyl == false) {
                                    ed.execCommand('mceInsertContent', false, whatInsert);
                                    shortcodes_costyl = true;
                                }
                            });

                            jQuery(document).on("change", ".select_shortcode", function(){
                                var nowSelect = jQuery(this).val();
                                jQuery(".shortcodeitem").hide();
                                jQuery("."+nowSelect).show();
                            });
                        }
                    }
                });
            },
            skin : "lightgray",
            selector: ".tinyCont textarea, .tinytextarea",
            relative_urls : false,
            width: "100%",
            language: "",
            height: 500
        });
    }
}

function check_visual_part_for_toggles() {
    $(".radio_toggle_cont").each(function (index) {
        var yes_state = $(this).find('.yes_state').attr('checked');
        var no_state = $(this).find('.no_state').attr('checked');

        if (yes_state == 'checked') {
            //alert("yes");
            $(this).find(".no_state").removeAttr("checked");
            $(this).find(".radio_toggle_mirage").removeClass("not_checked").addClass("checked");
            $(this).find(".radio_toggle_mirage").stop().animate({backgroundPosition:'0% 0%'}, {duration:'fast'});
        } else {
            //alert("no");
            $(this).find(".yes_state").removeAttr("checked");
            $(this).find(".radio_toggle_mirage").removeClass("checked").addClass("not_checked");
            $(this).find(".radio_toggle_mirage").stop().animate({backgroundPosition:'100% 0%'}, {duration:'fast'});
        }

    });
}


/* Document ready for all elements */
$(document).ready(function () {

    /* SLIDER */
    function resetSliderAtts(li_for_this_slider) {

        $(li_for_this_slider).each(function (index) {
            $(this).find(".itemorder").val(index);
        });
    }

    $(".sortable").sortable({
        out:function (event, ui) {
            var li_for_this_slider = $(this).find("li");
            resetSliderAtts(li_for_this_slider);
        },
        create:function (event, ui) {
            var li_for_this_slider = $(this).find("li");
            resetSliderAtts(li_for_this_slider);
        },
        delay:200
    });

    $(document).on('click', '.img-item .inter_x', function () {
        $(this).parents(".img-item").hide('fast', function () {
            $(this).remove();
        });
    });

    $(document).on('click', '.add_new_port_skills', function () {
        var skill_rand = getRandomInt(0, 99999);
        $(this).parents(".port_skills_cont").find(".all_added_skills").append("<li class='stand_iconsweet ui-state-default new_added' style='display:none'> <input type='text' class='itt_type1 ww10 select_icon_and_insert_here' name='pagebuilder[page_settings][portfolio][skills]["+skill_rand+"][icon]' placeholder='Icon' value=''> <input type='text' class='itt_type1 ww43' name='pagebuilder[page_settings][portfolio][skills]["+skill_rand+"][name]' placeholder='Field name' value=''> <input type='text' class='itt_type1 ww43' name='pagebuilder[page_settings][portfolio][skills]["+skill_rand+"][value]' placeholder='Field value' value=''> <span class='remove_skill'><i class='stand_icon icon-remove'></i></span></li>");
		$('.new_added').slideDown(300).removeClass('.new_added');
    });

    $(document).on('click', '.remove_skill', function () {
        $(this).parents("li").slideUp(300,function(){
			$(this).remove();
		});
    });


    /* add image in slider */
    $(document).on('click', '.slider_type .available_media_item', function () {
        var available_media_item_this_attach_id = $(this).find('.previmg').attr('data-attach-id');
        var available_media_item_this_thumburl = $(this).find('.previmg').attr('data-thumb-url');
        var parent_root = $(this).parents('.bg_or_slider_option');
        var settings_type = $(this).parents('.bg_or_slider_option').find('.settings_type').val();

        var data = {
            action:'get_unused_id_ajax'
        };

        waiting_state_start();

        $.post(ajaxurl, data, function (response) {
            parent_root.find(".selected_media .append_block .sortable-img-items").append('<li><div class="img-item item-with-settings append_animation"><input type="hidden" name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][attach_id]" value="' + available_media_item_this_attach_id + '"><input type="hidden" name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][slide_type]" value="image"><div class="img-preview"><img src="' + available_media_item_this_thumburl + '" alt=""><div class="hover-container"><div class="inter_x"></div><div class="inter_drag"></div><div class="inter_edit"></div></div></div><div class="edit_popup"><h2>Image Settings</h2><span class="edit_popup_close"></span><div class="this-option img-in-slider"><div class="padding-cont"><div class="fl w9"><h4>Title</h4><input name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][title][value]" type="text" value="" class="textoption type1"></div><div class="right_block fl w1"><h4>color</h4><div class="color_picker_block"><span class="sharp">#</span><input type="text" value="" name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][title][color]" maxlength="25" class="medium cpicker textoption type1"><input type="text" value="" class="textoption type1 cpicker_preview" disabled="disabled"></div></div><div class="clear"></div></div><div class="hr_double"></div><div class="padding-cont"><div class="fl w9"><h4>Caption</h4><textarea name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][caption][value]" type="text" class="textoption type1 big"></textarea></div><div class="right_block fl w1"><h4>color</h4><div class="color_picker_block"><span class="sharp">#</span><input type="text" value="" name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][caption][color]" maxlength="25" class="medium cpicker textoption type1"><input type="text" value="" class="textoption type1 cpicker_preview" disabled="disabled"></div></div><div class="clear"></div></div></div><div class="padding-cont"><input type="button" value="Done" class="done-btn green-btn" name="ignore_this_button"><div class="clear"></div></div></div></div></li>');
            $('.img-item.append_animation').fadeIn('fast');
            setTimeout("$('.img-item.append_animation').removeClass('append_animation')", 200);
            reactivate_selectbox();
            /* REACTIVATE COLOR PICKER */
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

            $('.cpicker').focus(function () {
                $(this).addClass("focused");
            });

            waiting_state_end();
        });
    });


    /* add video in slider */
    $(document).on('click', '.slider_type .add_video_slider', function () {
        var available_media_item_this_url = $(this).find('.previmg').attr('data-full-url');
        var parent_root = $(this).parents('.bg_or_slider_option');
        var settings_type = $(this).parents('.bg_or_slider_option').find('.settings_type').val();

        var data = {
            action:'get_unused_id_ajax'
        };

        waiting_state_start();

        $.post(ajaxurl, data, function (response) {
            parent_root.find(".selected_media .append_block .sortable-img-items").append('<li><div class="img-item item-with-settings append_animation"><input type="hidden" name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][src]" value=""><input type="hidden" name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][slide_type]" value="video"><div class="img-preview"><img src="' + available_media_item_this_url + '" alt=""><div class="hover-container"><div class="inter_x"></div><div class="inter_drag"></div><div class="inter_edit"></div></div></div><div class="edit_popup"><h2>Video settings</h2><span class="edit_popup_close"></span><div class="this-option"><div class="padding-cont"><h4>Video URL (Vimeo or YouTube)</h4><input name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][src]" type="text" value="" class="textoption type1"><div class="example">Examples:<br>Youtube - http://www.youtube.com/watch?v=YW8p8JO2hQw<br>Vimeo - http://vimeo.com/47989207</div></div><div class="padding-cont" style="padding-top:0;"><div class="fl w9" style="width:601px;"><h4>Title and thumbnail</h4><input name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][title][value]" type="text" value="" class="textoption type1"></div><div class="right_block fl w1" style="width:115px;"><h4>color</h4><div class="color_picker_block"><span class="sharp">#</span><input type="text" value="" name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][title][color]" maxlength="25" class="medium cpicker textoption type1"><input type="text" value="" class="textoption type1 cpicker_preview" disabled="disabled"></div></div><div class="preview_img_video_cont"><div class="select_image_root"><input type="hidden" name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][attach_id]" value="" class="select_img_attachid"><div class="select_img_preview"></div><input type="button" class="button button-secondary button-large select_attach_id_from_media_library" value="Select"></div></div><div class="clear"></div></div><div class="hr_double"></div><div class="padding-cont"><div class="fl w9" style="width:601px;"><h4>Caption</h4><textarea name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][caption][value]" type="text" class="textoption type1 big" style="height:70px;"></textarea></div><div class="right_block fl w1" style="width:115px;"><h4>color</h4><div class="color_picker_block"><span class="sharp">#</span><input type="text" value="" name="pagebuilder[sliders][' + settings_type + '][slides][' + response + '][caption][color]" maxlength="25" class="medium cpicker textoption type1"><input type="text" value="" class="textoption type1 cpicker_preview" disabled="disabled"></div></div><div class="clear"></div></div></div><div class="hr_double"></div><div class="padding-cont"><input type="button" value="Done" class="done-btn green-btn" name="ignore_this_button"><div class="clear"></div></div></div></div></li>');
            reactivate_color_picker();
            reactivate_selectbox();
            reactivate_ajax_image_upload();
            $('.img-item.append_animation').fadeIn('fast');
            setTimeout("$('.img-item.append_animation').removeClass('append_animation')", 200);
            waiting_state_end();
        });
    });

    /* SHOW/HIDE CONTAINER (SLIDER TYPE) */
    $(document).on('click', '.pb-cont .line_option .toggler .radio_toggle_mirage', function () {
        $(this).parents('.bg_or_slider_option').find('.hideable-area').toggle('fast');
    });
	$(document).on('click', '.edit_popup_close', function () {
        close_settings_popup();
    });


    /* OPEN POPUP EDIT */
    function show_settings_popup(thisTrigger, popupContainerClass) {
        popupAutoH();
        if (typeof popupContainerClass != 'undefined') {
            var edit_popup_area = $("."+popupContainerClass);
            var gt3_popup_initialed = thisTrigger;
        } else {
            var edit_popup_area = thisTrigger.parents('.item-with-settings').find('.edit_popup');
        }
        edit_popup_area.fadeToggle('fast').addClass('nowOpen');
        $('.popup-bg').fadeIn('fast');
        var pop_width = $('.edit_popup.nowOpen').width();
        var pop_height = $('.edit_popup.nowOpen').height();
        var offset_width = pop_width / 2;
        var offset_height = pop_height / 2;
        $('.edit_popup.nowOpen').css('marginLeft', '-' + offset_width + 'px');
        $('.edit_popup.nowOpen').css('marginTop', '-' + offset_height + 'px');

	    if ($('.edit_popup.nowOpen').find('.tinyCont').size() > 0) {
			$('.edit_popup.nowOpen').find('.tinyCont').each(function(){
				set_id = $(this).find('textarea').attr('id')
                tinymce.execCommand('mceAddEditor', false, set_id);
            });
		}
        thisTrigger.addClass("popup_open_from_here");
    }

    $(document).on('click', '.all_available_port_skills_icons i', function () {
        $('.popup_open_from_here').val($(this).attr('class'));
        close_settings_popup();
    });

    /* CLOSE POPUP EDIT */
    function close_settings_popup() {
	    if ($('.edit_popup.nowOpen').find('.tinyCont').size() > 0) {
			$('.edit_popup.nowOpen').find('.tinyCont').each(function(){
				set_id = $(this).find('textarea').attr('id')
				tinymce.execCommand('mceRemoveControl',true, set_id);
			});
		}
        $('.edit_popup.nowOpen').fadeOut('fast');
        $('.popup-bg').fadeOut('fast');
        setTimeout("$('.edit_popup.nowOpen').css('marginLeft', '0px').css('marginTop', '0px').removeClass('nowOpen')", 300);
        $('.popup_open_from_here').removeClass('popup_open_from_here');
    }

    $(document).on('click', '.inter_edit, .module-cont .edit.box-with-icon .control-element', function () {
        show_settings_popup($(this));
    });

    $(document).on("click", ".select_icon_and_insert_here", function () {
        show_settings_popup($(this), "all_available_port_skills_icons");
    });

    $(document).on('click', '.popup-bg, .done-btn', function () {
        close_settings_popup();
    });

    $('.sortable-img-items').sortable({ placeholder:'ui-state-highlight', handle:'.inter_drag' });
    $('.sortable-modules').sortable({ placeholder:'ui-state-highlight', handle:'.dragger' });
    $('.sections').sortable({ placeholder:'ui-state-highlight-sections', handle:'.some-element.move' });
    $('.feature-list').sortable({ placeholder:'ui-state-highlight-sections', handle:'.some-element2.move' });

    /* Click & add img to background container */
    $(document).on('click', '.bg_or_slider_option.bg_type .available_media_item', function () {
        var for_bg_data_full_url = $(this).find('.previmg').attr('data-full-url');
        var for_bg_data_preview_bg_image = $(this).find('.previmg').attr('data-thumb-url');
        $('.bg_or_slider_option.bg_type .preview_bg_image').fadeOut('fast', function () {
            $('.bg_or_slider_option.bg_type .preview_bg_image').delay(200).attr('src', for_bg_data_preview_bg_image).fadeIn('fast');
        });
        $('.bg_or_slider_option.bg_type .bg_image_src').val(for_bg_data_full_url);
    });


    /* VISIBLE BLOCKS LOGIC FOR BG & SLIDER SETTINGS */
    function closeToggles(toggleClass) {
        $.each(toggleClass, function () {
            $('.radio_toggle_cont.' + this + '').find('.yes_state').removeAttr('checked');
            $('.radio_toggle_cont.' + this + '').find('.no_state').attr('checked', 'checked');
            $('.radio_toggle_cont.' + this + '').find('.radio_toggle_mirage').removeClass('checked').addClass('not_checked');
            $('.radio_toggle_cont.' + this + '').parents('.bg_or_slider_option').find('.hideable-area').hide('fast');
            $('.radio_toggle_cont.' + this + '').find('.radio_toggle_mirage').removeClass("checked").addClass("not_checked");
            $('.radio_toggle_cont.' + this + '').find('.radio_toggle_mirage').stop().animate({backgroundPosition:'100% 0%'}, {duration:'fast'});
        });
    }

    $(document).on('click', '.bg_slide_sett', function () {
        /* WORK ONLY IF WE OPEN SOME TOGGLER */
        if ($(this).find('.yes_state').attr('checked')) {
            /* fullscreen_toggler */
            if ($(this).hasClass('fullscreen_toggler')) {
                var click_on = 'fullscreen_toggler';
                hide_items = new Array("fullwidth_toggler", "bgimage_toggler", "bgcolor_toggler");
                closeToggles(hide_items);
            }
            /* fullwidth_toggler */
            if ($(this).hasClass('fullwidth_toggler')) {
                var click_on = 'fullwidth_toggler';
                hide_items = new Array("fullscreen_toggler");
                closeToggles(hide_items);
            }
            /* bgimage_toggler */
            if ($(this).hasClass('bgimage_toggler')) {
                var click_on = 'bgimage_toggler';
                hide_items = new Array("fullscreen_toggler");
                closeToggles(hide_items);
            }
            /* bgcolor_toggler */
            if ($(this).hasClass('bgcolor_toggler')) {
                var click_on = 'bgcolor_toggler';
                hide_items = new Array("fullscreen_toggler");
                closeToggles(hide_items);
            }
        }
    });


    /* SLIDE CHECK BOX */

    /* START STATE */
    check_visual_part_for_toggles();
    /* END START STATE */


    $(document).on('click', '.radio_toggle_cont .radio_toggle_mirage', function () {

        var this_click_btn = $(this);
        var radio_toggle_cont = this_click_btn.parents(".radio_toggle_cont");

        if (this_click_btn.hasClass("checked")) {
            this_click_btn.stop().animate({backgroundPosition:'100% 0%'}, {duration:'fast'});
            this_click_btn.removeClass("checked").addClass("not_checked");
            radio_toggle_cont.find('.yes_state').removeAttr("checked");
            radio_toggle_cont.find('.no_state').attr("checked", "checked");
        } else {

            /* only one accordion can be expanded */
            this_click_btn.parents('.edit_popup').find('.accordion_expanded_toggle').find('.radio_toggle_mirage').each(function (index) {
                if ($(this).not(".checked")) {
                    var radio_toggle_cont2 = $(this).parents(".radio_toggle_cont");
                    $(this).stop().animate({backgroundPosition:'100% 0%'}, {duration:'fast'});
                    $(this).removeClass("checked").addClass("not_checked");
                    radio_toggle_cont2.find('.yes_state').removeAttr("checked");
                    radio_toggle_cont2.find('.no_state').attr("checked", "checked");
                }
            });

            this_click_btn.stop().animate({backgroundPosition:'0% 0%'}, {duration:'fast'});
            this_click_btn.removeClass("not_checked").addClass("checked");
            radio_toggle_cont.find('.no_state').removeAttr("checked");
            radio_toggle_cont.find('.yes_state').attr("checked", "checked");
        }
    });
    /* END SLIDE CHECK BOX */

    /* PAGE BUILDER MODULE SIZER */
    function change_size_pb(parent_module_cont, new_size) {
        parent_module_cont.removeClass('block_1_4');
        parent_module_cont.removeClass('block_1_3');
        parent_module_cont.removeClass('block_1_2');
        parent_module_cont.removeClass('block_2_3');
        parent_module_cont.removeClass('block_3_4');
        parent_module_cont.removeClass('block_1_1');
        parent_module_cont.find('.current_size').val(new_size);
    }

    /* MORE */
    $(document).on('click', '.right.box-with-icon .control-element', function () {
        parent_module_cont = $(this).parents('.module-cont');
        var now_size = parent_module_cont.find('.current_size').val();

        if (now_size == "block_1_4") {
            change_size_pb(parent_module_cont, "block_1_3");
            parent_module_cont.addClass("block_1_3");
            parent_module_cont.find(".control-element span").html("1/3");
        }
        if (now_size == "block_1_3") {
            change_size_pb(parent_module_cont, "block_1_2");
            parent_module_cont.addClass("block_1_2");
            parent_module_cont.find(".control-element span").html("1/2");
        }
        if (now_size == "block_1_2") {
            change_size_pb(parent_module_cont, "block_2_3");
            parent_module_cont.addClass("block_2_3");
            parent_module_cont.find(".control-element span").html("2/3");
        }
        if (now_size == "block_2_3") {
            change_size_pb(parent_module_cont, "block_3_4");
            parent_module_cont.addClass("block_3_4");
            parent_module_cont.find(".control-element span").html("3/4");
        }
        if (now_size == "block_3_4") {
            change_size_pb(parent_module_cont, "block_1_1");
            parent_module_cont.addClass("block_1_1");
            parent_module_cont.find(".control-element span").html("1/1");
        }
    });
    /* LESS */
    $(document).on('click', '.left.box-with-icon .control-element', function () {
        parent_module_cont = $(this).parents('.module-cont');
        var now_size = parent_module_cont.find('.current_size').val();

        if (now_size == "block_1_1") {
            change_size_pb(parent_module_cont, "block_3_4");
            parent_module_cont.addClass("block_3_4");
            parent_module_cont.find(".control-element span").html("3/4");
        }
        if (now_size == "block_3_4") {
            change_size_pb(parent_module_cont, "block_2_3");
            parent_module_cont.addClass("block_2_3");
            parent_module_cont.find(".control-element span").html("2/3");
        }
        if (now_size == "block_2_3") {
            change_size_pb(parent_module_cont, "block_1_2");
            parent_module_cont.addClass("block_1_2");
            parent_module_cont.find(".control-element span").html("1/2");
        }
        if (now_size == "block_1_2") {
            change_size_pb(parent_module_cont, "block_1_3");
            parent_module_cont.addClass("block_1_3");
            parent_module_cont.find(".control-element span").html("1/3");
        }
        if (now_size == "block_1_3") {
            change_size_pb(parent_module_cont, "block_1_4");
            parent_module_cont.addClass("block_1_4");
            parent_module_cont.find(".control-element span").html("1/4");
        }
    });
    /* END PAGE BUILDER MODULE SIZER */


    /* ADD MODULE */
    $(document).on('click', '.pb-module', function () {
        var add_module_name = $(this).attr('data-module-name');
        var add_module_caption = $(this).find('span.module-name').text();
        waiting_state_start();
        var tinyrand = "tiny"+getRandomInt(0, 9999);

        var data = {
            action:'get_module_html',
            module_name:add_module_name,
            module_caption:add_module_caption,
            tinymce_activation_class:tinyrand,
            postid_for_module:post_id
        };

        $.post(ajaxurl, data, function (response) {
            $('.pb-list-active-modules .sortable-modules').append(response).tinymce_textareas("."+tinyrand);
            reactivate_color_picker();
            reactivate_sortable();
            waiting_state_end();
            reactivate_selectbox();
            check_visual_part_for_toggles();
			if (our_tiny_firstrun == true && $('body').find('.tinyCont').size() == 1) {
				run_Tiny();
			}
        });
    });
    /* END ADD MODULE */

    $(document).on('click', '.module-cont .delete .control-element', function () {
        $(this).parents(".module-cont").remove();
    });

    $(document).on('click', '.delete.some-element2', function () {
        $(this).parents(".price_feature").remove();
    });

    $(document).on('click', '.section .some-element.delete', function () {
        $(this).parents(".section").remove();
    });

    $(document).on('click', '.section .some-element.edit', function () {
        $(this).parents(".section").find(".hide_area").slideToggle("fast");
    });

    $(document).on('click', '.some-element2.edit2', function () {
        $(this).parents(".price_feature").find(".hide_area2").slideToggle("fast");
    });

    /* add new section accordion */
    $(document).on('click', '.add_new_accordion_section', function () {
        var target1 = $(this).parents(".edit_popup").find(".sections");
        var this_key1 = $(this).parents(".module-cont").find(".module_key").val();
        var tinyrand = "tiny"+getRandomInt(0, 9999);
        var data = {
            tinymce_activation_class:tinyrand,
            action:'get_unused_id_ajax'
        };

        var already_added_elemts_count = target1.find("li").length;

        waiting_state_start();

        $.post(ajaxurl, data, function (response) {
            if (already_added_elemts_count>0) {
                var this_append = "<li class='section'><div class='heading line_option visual_style1 big_type'><div class='option_title text-shadow1'>Section</div><div class='some-element clickable edit hovered'></div><div class='pre_toggler'></div><div class='some-element movable move hovered'></div><div class='pre_toggler'></div><div class='some-element clickable delete hovered'></div><div class='pre_toggler'></div></div><div class='clear'></div><div class='hide_area'><div class='some-padding'><input type='text' class='expanded_text1 type1 section_name' name='pagebuilder[modules][module_id][module_items][section_id][title]' value='Section'><textarea class='expanded_text1 type2 mt tinytextarea' id='ajax"+response+"' name='pagebuilder[modules][module_id][module_items][section_id][description]'></textarea></div><div class='expanded_state_cont'><span class='text-shadow1'>Expanded</span><div class='radio_toggle_cont accordion_expanded_toggle'><input type='radio' class='checkbox_slide yes_state' value='yes' name='pagebuilder[modules][module_id][module_items][section_id][expanded_state]'><input type='radio' class='checkbox_slide no_state' value='no' checked='checked' name='pagebuilder[modules][module_id][module_items][section_id][expanded_state]'><div class='radio_toggle_mirage' style='background-position: 100% 0%;'></div></div></div></div></li>";
            } else {
                var this_append = "<li class='section'><div class='heading line_option visual_style1 big_type'><div class='option_title text-shadow1'>Section</div><div class='some-element clickable edit hovered'></div><div class='pre_toggler'></div><div class='some-element movable move hovered'></div><div class='pre_toggler'></div><div class='some-element clickable delete hovered'></div><div class='pre_toggler'></div></div><div class='clear'></div><div class='hide_area'><div class='some-padding'><input type='text' class='expanded_text1 type1 section_name' name='pagebuilder[modules][module_id][module_items][section_id][title]' value='Section'><textarea class='expanded_text1 type2 mt tinytextarea' id='ajax"+response+"' name='pagebuilder[modules][module_id][module_items][section_id][description]'></textarea></div><div class='expanded_state_cont'><span class='text-shadow1'>Expanded</span><div class='radio_toggle_cont accordion_expanded_toggle'><input type='radio' class='checkbox_slide yes_state' value='yes' checked='checked' name='pagebuilder[modules][module_id][module_items][section_id][expanded_state]'><input type='radio' class='checkbox_slide no_state' value='no' name='pagebuilder[modules][module_id][module_items][section_id][expanded_state]'><div class='radio_toggle_mirage' style='background-position: 0% 0%;'></div></div></div></div></li>";
            }

            this_append = this_append.replace(new RegExp("section_id", 'g'), response);
            this_append = this_append.replace(new RegExp("module_id", 'g'), this_key1);
			set_acc_id = 'ajax'+response;

            target1.append(this_append).tinymce_textareas("."+tinyrand);
			if (our_tiny_firstrun == true && $('body').find('.tinytextarea').size() == 1) {
				run_Tiny();
			}
            tinymce.execCommand('mceAddEditor', false, set_acc_id);

            reactivate_sortable();
            waiting_state_end();
        });
    });

    /* add new section diagramm */
    $(document).on('click', '.add_new_diagramm_section', function () {
        var target1 = $(this).parents(".edit_popup").find(".sections");
        var this_key1 = $(this).parents(".module-cont").find(".module_key").val();
        var data = {
            action:'get_unused_id_ajax'
        };

        waiting_state_start();

        $.post(ajaxurl, data, function (response) {

            var this_append = "<li class='section'><div class='heading line_option visual_style1 big_type'><div class='option_title text-shadow1'>Section</div><div class='some-element clickable edit hovered'></div><div class='pre_toggler'></div><div class='some-element movable move hovered'></div><div class='pre_toggler'></div><div class='some-element clickable delete hovered'></div><div class='pre_toggler'></div></div><div class='clear'></div><div class='hide_area'><div class='some-padding'><input type='text' class='expanded_text1 type1 section_name' name='pagebuilder[modules][module_id][module_items][section_id][title]' value='Section'> Percent: <input type='text' value='' style='width:88px; text-align: center; margin-right: 2px; float: right;' name='pagebuilder[modules][module_id][module_items][section_id][percent]' class='expanded_text1 type1 section_name skill_percent'><input type='text' value='' name='pagebuilder[modules][module_id][module_items][section_id][description]' class='expanded_text1 type1 section_name skill_description'></div></div></li>";

            this_append = this_append.replace(new RegExp("section_id", 'g'), response);
            this_append = this_append.replace(new RegExp("module_id", 'g'), this_key1);

            target1.append(this_append);

            reactivate_sortable();
            waiting_state_end();

        });
    });

    /* add new toggle section */
    $(document).on('click', '.add_new_toggle_section', function () {
        var target1 = $(this).parents(".edit_popup").find(".sections");
        var tinyrand = "tiny"+getRandomInt(0, 9999);
        var this_key1 = $(this).parents(".module-cont").find(".module_key").val();
        var data = {
            tinymce_activation_class:tinyrand,
            action:'get_unused_id_ajax'
        };

        waiting_state_start();

        $.post(ajaxurl, data, function (response) {

            var this_append = "<li class='section'><div class='heading line_option visual_style1 big_type'><div class='option_title text-shadow1'>Section</div><div class='some-element clickable edit hovered'></div><div class='pre_toggler'></div><div class='some-element movable move hovered'></div><div class='pre_toggler'></div><div class='some-element clickable delete hovered'></div><div class='pre_toggler'></div></div><div class='clear'></div><div class='hide_area'><div class='some-padding'><input type='text' class='expanded_text1 type1 section_name' name='pagebuilder[modules][module_id][module_items][section_id][title]' value='Section'><textarea class='expanded_text1 type2 mt tinytextarea' id='ajax"+response+"' name='pagebuilder[modules][module_id][module_items][section_id][description]'></textarea></div><div class='expanded_state_cont'><span class='text-shadow1'>Expanded</span><div class='radio_toggle_cont toggles_expanded_toggle'><input type='radio' class='checkbox_slide yes_state' value='yes' name='pagebuilder[modules][module_id][module_items][section_id][expanded_state]'><input type='radio' class='checkbox_slide no_state' value='no' checked='checked' name='pagebuilder[modules][module_id][module_items][section_id][expanded_state]'><div class='radio_toggle_mirage' style='background-position: 100% 0%;'></div></div></div></div></li>";

            this_append = this_append.replace(new RegExp("section_id", 'g'), response);
            this_append = this_append.replace(new RegExp("module_id", 'g'), this_key1);

            target1.append(this_append).tinymce_textareas("."+tinyrand);

			set_acc_id = 'ajax'+response;
			if (our_tiny_firstrun == true && $('body').find('.tinytextarea').size() == 1) {
				run_Tiny();
			}
            tinymce.execCommand('mceAddEditor', false, set_acc_id);

            reactivate_sortable();
            waiting_state_end();

        });
    });

    /* add new row */
    $(document).on('click', '.add_new_row_section', function () {
        var target3 = $(this).parents(".rows_must_be_here").find(".row-list");
        var this_key3 = $(this).parents(".rows_must_be_here").find(".moduleid").val();
        var data = {
            action:'get_unused_id_ajax'
        };

        waiting_state_start();

        $.post(ajaxurl, data, function (response) {

            var this_append = "<li class='section'><div class='heading line_option visual_style1 big_type'><div class='option_title text-shadow1'>&nbsp;</div><div class='some-element clickable edit hovered'></div><div class='pre_toggler'></div><div class='some-element movable move hovered'></div><div class='pre_toggler'></div><div class='some-element clickable delete hovered'></div><div class='pre_toggler'></div></div><div class='clear'></div><div class='hide_area'><div class='some-padding'><textarea class='expanded_text1 type2 mt' id='ajax"+response+"' name='pagebuilder[modules][module_id][module_items][section_id][text]'></textarea></div></div></li>";

            this_append = this_append.replace(new RegExp("section_id", 'g'), response);
            this_append = this_append.replace(new RegExp("module_id", 'g'), this_key3);

            target3.append(this_append);
			set_row_id = 'ajax'+response;
			if (our_tiny_firstrun == true && $('body').find('.tinytextarea').size() == 1) {
				run_Tiny();
			}
            tinymce.execCommand('mceAddEditor', false, set_row_id);

            reactivate_sortable();
            waiting_state_end();

        });
    });

    /* add new price feature */
    $(document).on('click', '.add_new_price_feature', function () {
        var target3 = $(this).parent().find(".feature-list");
        var this_key3 = $(this).parent().find(".moduleid").val();
        var this_sectionid = $(this).parent().find(".sectionid").val();
        var data = {
            action:'get_unused_id_ajax'
        };

        waiting_state_start();

        $.post(ajaxurl, data, function (response) {

            var this_append3 = "<li class='price_feature'><div class='heading line_option visual_style1 big_type'><div class='option_title text-shadow1'>&nbsp;</div><div class='some-element2 clickable edit2 hovered'></div><div class='pre_toggler'></div><div class='some-element2 movable move hovered'></div><div class='pre_toggler'></div><div class='some-element2 clickable delete hovered'></div><div class='pre_toggler'></div></div><div class='clear'></div><div class='hide_area2'><div class='some-padding'><textarea class='expanded_text1 type2 mt' id='ajax"+response+"' name='pagebuilder[modules][module_id][module_items][" + this_sectionid + "][price_features][" + response + "]'></textarea></div></div></li>";

            this_append3 = this_append3.replace(new RegExp("module_id", 'g'), this_key3);

            target3.append(this_append3);
			set_row_id = 'ajax'+response;

            reactivate_sortable();
            waiting_state_end();

        });
    });


    /* add new price block */
    $(document).on('click', '.add_new_price_block', function () {
        var target3 = $(this).parents(".rows_must_be_here").find(".row-list");
        var this_key3 = $(this).parents(".rows_must_be_here").find(".moduleid").val();
        var data = {
            action:'get_unused_id_ajax'
        };

        waiting_state_start();

        $.post(ajaxurl, data, function (response) {

            var this_append = "<li class='section'><div class='heading line_option visual_style1 big_type'><div class='option_title text-shadow1'>&nbsp;</div><div class='some-element clickable edit hovered'></div><div class='pre_toggler'></div><div class='some-element movable move hovered'></div><div class='pre_toggler'></div><div class='some-element clickable delete hovered'></div><div class='pre_toggler'></div></div><div class='clear'></div><div class='hide_area'><div class='some-padding'><div class='caption'>Name</div><input class='expanded_text type3' name='pagebuilder[modules][module_id][module_items][section_id][block_name]'><div class='caption'>Price</div><input class='expanded_text type3' name='pagebuilder[modules][module_id][module_items][section_id][block_price]'><div class='caption'>Period</div><input class='expanded_text type3' name='pagebuilder[modules][module_id][module_items][section_id][block_period]'><div class='rows_must_be_here dark_lined'><input type='hidden' name='moduleid' class='moduleid' value='module_id'><input type='hidden' name='sectionid' class='sectionid' value='" + response + "'><div class='heading line_option visual_style1 small_type hovered clickable add_new_price_feature'><div class='option_title text-shadow1'>Add feature</div><div class='some-element cross'></div><div class='pre_toggler'></div></div><ul class='feature-list'></ul></div><div class='caption'>\"Get it now\" Link</div><input class='expanded_text type3' name='pagebuilder[modules][module_id][module_items][section_id][block_link]'><div class='caption'>\"Get it now\" caption</div><input class='expanded_text type3' name='pagebuilder[modules][module_id][module_items][section_id][get_it_now_caption]'><div class='caption' style='float:left; margin-top: 13px; margin-right: 15px;'>Most popular</div><div class='radio_toggle_cont toggles_expanded_toggle most_popular'><input type='radio' class='checkbox_slide yes_state' value='yes' name='pagebuilder[modules][module_id][module_items][section_id][most_popular]'><input type='radio' class='checkbox_slide no_state' value='no' checked='checked' name='pagebuilder[modules][module_id][module_items][section_id][most_popular]'><div class='radio_toggle_mirage' style='background-position: 100% 0%;'></div></div><div class='clear'></div></div></div></li>";

            this_append = this_append.replace(new RegExp("section_id", 'g'), response);
            this_append = this_append.replace(new RegExp("module_id", 'g'), this_key3);

            target3.append(this_append);

            reactivate_sortable();
            waiting_state_end();

        });
    });

    $(document).on('click', '.all_part', function () {
        var cat_part_cont = $(this).parents(".checkbox_wrapper").find(".category_part").toggleClass("cat_hided");
        if ($(this).attr("checked")) {$(this).parents(".checkbox_wrapper").find(".category_part").removeAttr("checked");}
    });

    $(document).on('click', '.category_part', function () {
        $(this).parents(".checkbox_wrapper").find(".all_part").removeAttr("checked");
    });

    $(document).on('keyup', '.section_name', function () {
        var thistitle = $(this).val();
        $(this).parents(".section").find(".option_title").text(thistitle);
    });

    /* ADD IMAGE FOR POST FORMAT */
    $(document).on('click', '.available-images-for-pf .ajax_cont .img-item', function(){
        //$(this).removeClass("available_media_item").clone().appendTo(".selected-images-for-pf");
        var pffullurl = $(this).find(".previmg").attr("data-full-url");
        var pfattach_id = $(this).find(".previmg").attr("data-attach-id");
        var previewurl = $(this).find(".previmg").attr("src");

        var data = {
            action:'get_unused_id_ajax'
        };

        waiting_state_start();

        $.post(ajaxurl, data, function (response) {
            $(".selected-images-for-pf").append("<div class='img-item append_animation style_small'><div class='img-preview'><img src='"+previewurl+"' data-full-url='"+pffullurl+"' data-thumb-url='"+previewurl+"' alt='' class='previmg'><div class='hover-container'></div></div><input type='hidden' name='pagebuilder[post-formats][images]["+response+"][attach_id]' value='"+pfattach_id+"'></div>");

            $('.img-item.append_animation').fadeIn('fast');
            setTimeout("$('.img-item.append_animation').removeClass('append_animation')", 200);
            waiting_state_end();
        });

    });

    /* DELETE IMAGE FOR POST FORMAT */
    $(document).on('click', '.selected-images-for-pf .img-item', function(){
        $(this).fadeOut('fast');
        var tmpthis = $(this);
        setTimeout(function() {
            tmpthis.remove();
        }, 1000);
    });

    popupAutoH();

    $(document).on("click", ".upload_and_insert", function () {
        tb_show('', 'media-upload.php?type=audio&amp;TB_iframe=true');
        window.thisUploadButton = $(this);

        window.send_to_editor = function (html) {
            audiourl = $(html).attr('href');
            thisUploadButton.parent().next().val(audiourl);
            tb_remove();
        }

        return false;
    });

    /*Select icons*/
    $(document).on("click", ".all_available_font_icons .stand_icon", function () {
        $(this).parents(".enter_option_row").find(".icon_type").val($(this).attr("data-icon-code"));
        $(this).parents(".enter_option_row").find("li").removeClass("active");
        $(this).parents("li").addClass("active");
    });

    $(document).on("click", ".remove_me", function () {
        $(this).parents(".added_icons .stand_iconsweet").slideUp(300, function(){
			$(this).remove();
		});
    });

    $(document).on("click", ".remove_any_icons", function () {
        $(this).parents(".already_added_icons .stand_iconsweet").slideUp(300, function(){
			$(this).remove();
		});
    });


    /*Create any icons for page settings*/
    $(document).ready(function () {
       $('.sortable_icons_list').sortable();
    });
    $(document).on("click", ".social_list_for_select i", function () {
        var clicked_icon = $(this).attr("data-icon-code");
        var rnd_team = getRandomInt(1000, 9999);
        $(this).parents(".hright").find(".added_icons").append("<div class='stand_iconsweet new_added ui-state-default' style='display:none'><span class='stand_icon-container'><i class='stand_icon "+clicked_icon+"'></i></span><input type='hidden' name='pagebuilder[page_settings][icons]["+clicked_icon+rnd_team+"][data-icon-code]' value='"+clicked_icon+"'><input type='text' class='icon_name' name='pagebuilder[page_settings][icons]["+clicked_icon+rnd_team+"][name]' value='' placeholder='Give some name'><input type='text' class='icon_link' name='pagebuilder[page_settings][icons]["+clicked_icon+rnd_team+"][link]' value='' placeholder='Give some link'><input class='cpicker' type='text' name='pagebuilder[page_settings][icons]["+clicked_icon+rnd_team+"][fcolor]' value='313131' placeholder='Foreground color'><input type='text' value='' class='cpicker_preview' disabled='disabled' style='background:#ffffff'><span class='remove_me'><i class='stand_icon icon-remove'></i></span></div>");
		$('.new_added').slideDown(300).removeClass('new_added');
        reactivate_color_picker();
        reactivate_sortable();
    });

    /*Create any icons for modules*/
    $(document).on("click", ".all_available_font_icons_for_any_icons i.stand_icon", function () {
        var clicked_icon = $(this).attr("data-icon-code");
        var any_icons_settingname = $(this).parents(".all_available_font_icons_for_any_icons_cont").find(".any_icons_settingname").val();
        var any_icons_moduleid = $(this).parents(".all_available_font_icons_for_any_icons_cont").find(".any_icons_moduleid").val();
        var rnd_any_icon = getRandomInt(1000, 9999);

        $(this).parents(".all_available_font_icons_for_any_icons_cont").find(".already_added_icons").append("<div class='stand_iconsweet new_added ui-state-default' style='display:none'><span class='stand_icon-container'><i class='stand_icon "+clicked_icon+"'></i></span><input type='hidden' name='pagebuilder[modules]["+any_icons_moduleid+"]["+any_icons_settingname+"]["+clicked_icon+rnd_any_icon+"][data-icon-code]' value='"+clicked_icon+"'><input type='text' class='icon_name textoption type1' name='pagebuilder[modules]["+any_icons_moduleid+"]["+any_icons_settingname+"]["+clicked_icon+rnd_any_icon+"][name]' value='' placeholder='Give some name'><input type='text' class='icon_link textoption type1' name='pagebuilder[modules]["+any_icons_moduleid+"]["+any_icons_settingname+"]["+clicked_icon+rnd_any_icon+"][link]' value='' placeholder='Give some link'><input class='cpicker textoption type1' type='text' name='pagebuilder[modules]["+any_icons_moduleid+"]["+any_icons_settingname+"]["+clicked_icon+rnd_any_icon+"][fcolor]' value='ffffff' placeholder='Foreground color'><input type='text' value='' class='cpicker_preview textoption type1' disabled='disabled' style='background:#ffffff'><input class='cpicker textoption type1' type='text' name='pagebuilder[modules]["+any_icons_moduleid+"]["+any_icons_settingname+"]["+clicked_icon+rnd_any_icon+"][bcolor]' value='c5c5c5' placeholder='Background color'><input style='background:#c5c5c5' type='text' value='' class='cpicker_preview textoption type1' disabled='disabled'><span class='remove_me'><i class='remove_any_icons icon-remove'></i></span></div>");

		$('.new_added').slideDown(300).removeClass('new_added');
        reactivate_color_picker();
        reactivate_sortable();
    });


    /*Create any icon for modules*/
    $(document).on("click", ".select_only_one_fa_icon i.stand_icon", function () {
        var clicked_icon = $(this).attr("data-icon-code");
        $(this).parents(".select_only_one_fa_icon").find(".any_icons_settingname").val(clicked_icon);
        $(this).parents(".select_only_one_fa_icon").find(".active").removeClass("active");
        $(this).parent().addClass("active");
    });
});


/* WORK ON LOAD */
$(document).ready(function () {
    /* OPEN ALL PARENT CONTAINERS IF TOGGLER ON */
    $(".pb-cont .line_option .toggler .yes_state").each(function (index) {
        var yes_state = $(this).attr('checked');
        if (yes_state == 'checked') {
            $(this).parents('.bg_or_slider_option').find('.hideable-area').show('fast');
        }
    });

    /* OPEN ALL PARENT CONTAINERS IF TOGGLER ON */
    $(".pb-cont .line_option .toggler .yes_state").each(function (index) {
        var yes_state = $(this).attr('checked');
        if (yes_state == 'checked') {
            $(this).parents('.bg_or_slider_option').find('.hideable-area').show('fast');
        }
    });

    /*SET HOVER TO ACTIVE ICONS*/
    $(".all_available_font_icons .icon_type").each(function (index) {
        $(this).parents(".enter_option_row").find("i[data-icon-code='"+$(this).val()+"']").parent().addClass("active");
    });
});