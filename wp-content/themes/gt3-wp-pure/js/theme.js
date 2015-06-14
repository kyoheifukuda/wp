"use strict";
jQuery(document).ready(function ($) {
    jQuery(".show_mobile_menu").click(function () {
        jQuery(".menu_mobile").slideToggle();
    });

    jQuery('.post_likes_add').click(function () {
        var post_likes_this = jQuery(this);
        if (!$.cookie('like' + post_likes_this.attr('data-postid'))) {
            $.post(gt3_ajaxurl, {
                action: 'add_like_post',
                post_id: jQuery(this).attr('data-postid')
            }, function (response) {
                $.cookie('like' + post_likes_this.attr('data-postid'), 'true', { expires: 7, path: '/' });
                post_likes_this.addClass('already_liked');
                post_likes_this.find("span").text(response);
                post_likes_this.find("i").removeClass("icon-heart-empty").addClass("icon-heart");
            });
        }
    });

    jQuery('.wpcf7-submit').wrap('<div class="temp_submit_cf7"></div>');
    jQuery('.temp_submit_cf7').html('<div class="shortcode_button btn_small btn_type5"><span class="ico_cont"><span class="ico_fader"></span><i class="ico_this icon-share-alt"></i></span><span class="btn_text">SEND COMMENT!</span></div>');
    jQuery('.temp_submit_cf7 .shortcode_button').live('click', function () {
        jQuery(this).parents(".wpcf7-form").submit();
    });
});

jQuery(window).load(function () {
    setTimeout(function(){jQuery('.op0').css('opacity', '1');} , 1000);
    setTimeout(function(){jQuery('.gt3_preloader').removeClass('gt3_preloader');} , 1000);
});