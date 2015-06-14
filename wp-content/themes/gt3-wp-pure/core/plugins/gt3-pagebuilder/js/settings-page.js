jQuery(function ($) {
    /*
     Hide/Show tabs
     */
    jQuery('.l-mix-tabs-item').click(function () {
        jQuery('.l-mix-tabs-item').removeClass('active');
        jQuery('.mix-tab').hide();

        var data_tabname = jQuery(this).find('.l-mix-tab-title').attr('data-tabname');

        jQuery(this).addClass('active');
        jQuery('.' + data_tabname).show();
        jQuery('#form-tab-id').val(data_tabname);

        return false;
    });

    /*
     Hide/Show tabs
     */
    jQuery('.l-mix-tabs-list li').first().addClass('active');
    jQuery('.mix-tabs .mix-tab').first().show();

    /*
     Autoopen tab in admin
     */
    var admin_tab_now_open = jQuery('#form-tab-id').val();
    if (admin_tab_now_open !== "") {
        jQuery('.l-mix-tabs-item').removeClass('active');
        jQuery('#' + admin_tab_now_open).addClass('active');
        jQuery('.mix-tab').hide();
        jQuery('.' + admin_tab_now_open).show();
    }

    jQuery('.fadeout').delay(2000).fadeOut("slow");

    jQuery('body').append("<div class='shortcodesContainer'></div>");

    // ajax button
    $('.mix_ajax_button').click(function () {

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
        var nowpostformat = $('#post-formats-select input:checked').val();
        var nowNEWpostformat = $('.post-format-options a.active').attr("data-wp-format");

        if (nowpostformat == 'image' || nowNEWpostformat == 'image') {
            $('#portslides_sectionid_inner').show();
            $('.wp-admin.post-type-post #pb_section').show();
        }
        if (nowpostformat == 'video') {
            $('#video_sectionid_inner').show();
            $('.wp-admin.post-type-post #pb_section').show();
        }
        if (nowpostformat == '0' || nowNEWpostformat == 'standard') {
            $('#default_sectionid_inner').show();
            $('.wp-admin.post-type-post #pb_section').hide();
        }

        /* ON CHANGE */
        /* WP <=3.5 */
        $('#post-formats-select input').click(function () {
            $('#portslides_sectionid_inner, #audio_sectionid_inner, #video_sectionid_inner, #default_sectionid_inner').hide();
            var nowclickformat = $(this).val();
            if (nowclickformat == 'image') {
                $('#portslides_sectionid_inner').show();
                $('.wp-admin.post-type-post #pb_section').show();
            }
            if (nowclickformat == 'video') {
                $('#video_sectionid_inner').show();
                $('.wp-admin.post-type-post #pb_section').show();
            }
            if (nowclickformat == '0') {
                $('#default_sectionid_inner').show();
                $('.wp-admin.post-type-post #pb_section').hide();
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

        $(".cpicker.textoption").each(function (index) {
            var already_selected_color = $(this).val();
            $(this).next().css("background-color", "#" + already_selected_color);
        });

        $('.cpicker.textoption').keyup(function (event) {
            var now_enter_color = $(this).val();
            $(this).next().css("background-color", "#" + now_enter_color);
        });

    });

    $('.cpicker').focus(function () {
        $(this).addClass("focused");
    });

});

function remove_responce_message () {
    $("#wpwrap").css("opacity", "1");
    $(".result_message").remove();
}

/* SAVING ADMIN SETTINGS WITH AJAX */
jQuery("document").ready(function($) {
    $(".plugin_page_settings .admin_save_all").click(function() {
        $("#wpwrap").css("opacity", "0.5");
        var data = $(".plugin_page_settings").serialize();
        $.post(ajaxurl, { action:'save_pb_settings', json_string:data }, function(response) {
            $("body").append("<div class='result_message'>"+response+"</div>");
            setTimeout(remove_responce_message , 2000);
        });
        return false;
    });
    $(".plugin_page_settings .reset_settings").click(function() {
        var agree = confirm("Are you sure?");
        if (!agree)
            return false;
        $("#wpwrap").css("opacity", "0.5");
        $.post(ajaxurl, { action:'reset_pb_settings' }, function(response) {
            $("body").append("<div class='result_message'>"+response+"</div>");
            setTimeout(remove_responce_message , 2000);
            window.location.reload();
        });
        return false;
    });
});