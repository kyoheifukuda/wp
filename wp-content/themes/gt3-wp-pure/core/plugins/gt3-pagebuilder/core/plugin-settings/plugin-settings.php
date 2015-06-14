<?php

add_action('wp_ajax_save_pb_settings', 'save_pb_settings');
if (!function_exists('save_pb_settings')) {
    function save_pb_settings() {
        global $tabs;

        $json_string = stripslashes($_POST["json_string"]);
        unset ($_POST["json_string"]);

        parse_str($json_string, $json_array);

        if (isset($json_array) && is_array($json_array)) {
            foreach ($json_array as $name => $value) {
                $_REQUEST[$name] = $value;
            }
            $tabs->save();
            echo "Successfully saved!";
        } else {
            echo "json_array is not array";
        }

        die();
    }
}

add_action('wp_ajax_reset_pb_settings', 'reset_pb_settings');
if (!function_exists('reset_pb_settings')) {
    function reset_pb_settings() {
        global $tabs;

        $tabs->reset_to_default();
        echo "Successfully reseted!";

        die();
    }
}

if (isset($_POST['reset_pb_settings'])) {
    $tabs->reset_to_default();
    header('Location: admin.php?page=gt3pb&reset=ok');
    exit;
}


add_action( 'plugins_loaded', 'check_if_pbplugin_istalled' );
function check_if_pbplugin_istalled() {
    if (gt3pb_get_option("gt3pb_is_installed") !== "true") {
        global $tabs;
        $tabs->reset_to_default();
        gt3pb_update_option("gt3pb_is_installed", "true");
        header('Location: admin.php?page=gt3pb');
        exit;
    }
}




function gt3pb_settings_page()
{

global $tabs;

if (!current_user_can('manage_options'))  {
    wp_die( 'You do not have sufficient permissions to access this page.' );
}

?>

<script type="text/javascript" charset="utf-8">
    var admin_ajax = '<?php echo admin_url("admin-ajax.php"); ?>';
    jQuery(document).ready(function(){
        jQuery('.btn_upload_image').each(function(){

            var clickedObject = jQuery(this);
            var clickedID = jQuery(this).attr('id');
            new AjaxUpload(clickedID, {
                action: '<?php echo admin_url("admin-ajax.php"); ?>',
                name: clickedID, // File upload name
                data: { // Additional data to send
                    action: 'mix_ajax_post_action',
                    type: 'upload',
                    data: clickedID },
                autoSubmit: true, // Submit file after selection
                responseType: false,
                onChange: function(file, extension){},
                onSubmit: function(file, extension){
                    clickedObject.text('Uploading'); // change button text, when user selects file
                    this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
                    interval = window.setInterval(function(){
                        var text = clickedObject.text();
                        if (text.length < 13){	clickedObject.text(text + '.'); }
                        else { clickedObject.text('Uploading'); }
                    }, 200);
                },
                onComplete: function(file, response) {

                    window.clearInterval(interval);
                    clickedObject.text('Upload Image');
                    this.enable(); // enable upload button

                    // If there was an error
                    if(response.search('Upload Error') > -1){
                        var buildReturn = '<span class="upload-error">' + response + '</span>';
                        jQuery(".upload-error").remove();
                        clickedObject.parent().after(buildReturn);

                    }
                    else{
                        var buildReturn = '<a href="'+response+'" class="uploaded-image" target="_blank"><img class="hide option-image" id="image_'+clickedID+'" src="'+response+'" alt="" /></a>';

                        jQuery(".upload-error").remove();
                        jQuery("#image_" + clickedID).remove();
                        clickedObject.parent().next().after(buildReturn);
                        jQuery('img#image_'+clickedID).fadeIn();
                        clickedObject.next('span').fadeIn();
                        clickedObject.parent().prev('input').val(response);
                    }
                }
            });
        });

        //AJAX Remove (clear option value)
        jQuery('.btn_reset_image').click(function(){

            var clickedObject = jQuery(this);
            var clickedID = jQuery(this).attr('id');
            var theID = jQuery(this).attr('title');

            var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';

            var data = {
                action: 'mix_ajax_post_action',
                type: 'image_reset',
                data: theID
            };

            jQuery.post(ajax_url, data, function(response) {
                var image_to_remove = jQuery('#image_' + theID);
                var button_to_hide = jQuery('#reset_' + theID);
                image_to_remove.fadeOut(500,function(){ jQuery(this).remove(); });
                //button_to_hide.fadeOut();
                clickedObject.parent().prev('input').val('');
            });

            return false;

        });

        <?php
            if (isset($_GET['open']) && strlen($_GET['open'])>0) {
                ////For open on start
                echo 'jQuery(".l-mix-tabs-item").removeClass("active");';
                echo 'jQuery(".mix-tab").hide();';
                echo 'jQuery("#'.$_GET['open'].'").addClass("active");';
                echo 'jQuery(".'.$_GET['open'].'").show();';

            }
        ?>

    });
</script>

<form action="" method="post" class="plugin_page_settings">
    <input type="hidden" id="form-tab-id" name="tab" value="<?php if (isset($_POST['tab'])) {echo $_POST['tab'];} ?>" />
    <input type="hidden" id="what_open_after_save" name="what_open_after_save" value="" />
    <div id="wrap">

        <?php

        echo "<div class='message_area'>";

        if (isset($_GET['saved']) && $_GET['saved']=="ok") {
            echo messagebox("Successfully saved!");
        }
        if (isset($_GET['reset']) && $_GET['reset']=="ok") {
            echo messagebox("Successfully reseted!");
        }

        echo "</div>";

        echo $tabs->render();
        ?>
        <div class="clear"></div>
    </div>
</form>



<?php } ?>