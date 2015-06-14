(function($) {
    tinymce.create('tinymce.plugins.shortcodes', {
        init : function(ed, url) {
			
            ed.addButton('shortcodes', {
                title : 'Get custom shortcodes',
                image : url+'/shortcode.png',
                onclick : function() {
                    jQuery(function ($) {
                        $('.shortcodebox_fadder').fadeIn(500);
                        $('.shortcodebox').fadeIn(500);
                    });

                    jQuery.post(ajaxurl, {action:'getshortcodesUI'}, function (response) {
                        jQuery('.shortcodebox .shortcodebox_content').html(response);
						reactivate_selectbox();
						reactivate_color_picker();						
                    });

                    var shortcodes_costyl = false;
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
                            /*alert(shortcodes_costyl);*/
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
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Shortcodes",
                author : 'GT3',
                authorurl : 'http://gt3themes.com/',
                infourl : 'http://gt3themes.com/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('shortcodes', tinymce.plugins.shortcodes);
})();