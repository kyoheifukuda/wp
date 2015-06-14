/**
 * All Types Meta Box Class JS
 *
 * JS used for the custom metaboxes and other form items.
 *
 * Copyright 2011 Ohad Raz (admin@bainternet.info)
 * @since 1.0
 */

var $ =jQuery.noConflict();
function update_repeater_fields(){


    /**
     * Datepicker Field.
     *
     * @since 1.0
     */
    $('.at-date').each( function() {

      var $this  = $(this),
          format = $this.attr('rel');

      $this.datepicker( { showButtonPanel: true, dateFormat: format } );

    });

    /**
     * Timepicker Field.
     *
     * @since 1.0
     */
    $('.at-time').each( function() {

      var $this   = $(this),
          format   = $this.attr('rel'),
          aampm    = $this.attr('data-ampm');
      if ('true' == aampm)
        aampm = true;
      else
        aampm = false;

      $this.timepicker( { showSecond: true, timeFormat: format, ampm: aampm } );

    });

    /**
     * Colorpicker Field.
     *
     * @since 1.0
     */
    /*



    /**
     * Select Color Field.
     *
     * @since 1.0
     */
    $('.at-color-select').click( function(){
      var $this = $(this);
      var id = $this.attr('rel');
      $(this).siblings('.at-color-picker').farbtastic("#" + id).toggle();
      return false;
    });

    /**
     * Add Files.
     *
     * @since 1.0
     */
    $('.at-add-file').click( function() {
      var $first = $(this).parent().find('.file-input:first');
      $first.clone().insertAfter($first).show();
      return false;
    });

    /**
     * Delete File.
     *
     * @since 1.0
     */
    $('.at-upload').delegate( '.at-delete-file', 'click' , function() {

      var $this   = $(this),
          $parent = $this.parent(),
          data     = $this.attr('rel');

      $.post( ajaxurl, { action: 'at_delete_file', data: data }, function(response) {
        response == '0' ? ( alert( 'File has been successfully deleted.' ), $parent.remove() ) : alert( 'You do NOT have permission to delete this file.' );
      });

      return false;

    });

    /**
     * Reorder Images.
     *
     * @since 1.0
     */
    $('.at-images').each( function() {

      var $this = $(this), order, data;

      $this.sortable( {
        placeholder: 'ui-state-highlight',
        update: function (){
          order = $this.sortable('serialize');
          data   = order + '|' + $this.siblings('.at-images-data').val();

          $.post(ajaxurl, {action: 'at_reorder_images', data: data}, function(response){
            response == '0' ? alert( 'Order saved!' ) : alert( "You don't have permission to reorder images." );
          });
        }
      });

    });

    /**
     * Thickbox Upload
     *
     * @since 1.0
     */
    $('.at-upload-button').click( function() {

      var data       = $(this).attr('rel').split('|'),
          post_id   = data[0],
          field_id   = data[1],
          backup     = window.send_to_editor; // backup the original 'send_to_editor' function which adds images to the editor

      // change the function to make it adds images to our section of uploaded images
      window.send_to_editor = function(html) {

        $('#at-images-' + field_id).append( $(html) );

        tb_remove();

        window.send_to_editor = backup;

      };

      // note that we pass the field_id and post_id here
      tb_show('', 'media-upload.php?post_ID=' + post_id + '&field_id=' + field_id + '&type=image&TB_iframe=true');

      return false;
    });

    /**
     * repeater sortable
     * @since 2.1
     */
    $('.repeater-sortable').sortable();

  }
var Ed_array = Array;
jQuery(document).ready(function($) {

  /**
   * repeater sortable
   * @since 2.1
   */
  $('.repeater-sortable').sortable();

  /**
   * Code Editor Field
   * @since 2.1
   */
   var e_d_count = 0;
  $(".code_text").each(function() {
    var lang = $(this).attr("data-lang");
    //php application/x-httpd-php
    //css text/css
    //html text/html
    //javascript text/javascript
    switch(lang){
      case 'php':
        lang = 'application/x-httpd-php';
        break;
      case 'css':
        lang = 'text/css';
        break;
      case 'html':
        lang = 'text/html';
        break;
      case 'javascript':
        lang = 'text/javascript';
        break;
      default:
        lang = 'application/x-httpd-php';
    }
    var theme  = $(this).attr("data-theme");
    switch(theme){
      case 'default':
        theme = 'default';
        break;
      case 'light':
        theme = 'solarizedLight';
        break;
      case 'dark':
        theme = 'solarizedDark';;
        break;
      default:
        theme = 'default';
    }

    var editor = CodeMirror.fromTextArea(document.getElementById($(this).attr('id')), {
      lineNumbers: true,
      matchBrackets: true,
      mode: lang,
      indentUnit: 4,
      indentWithTabs: true,
      enterMode: "keep",
      tabMode: "shift"
    });
    editor.setOption("theme", theme);
    $(editor.getScrollerElement()).width(100); // set this low enough
    width = $(editor.getScrollerElement()).parent().width();
    $(editor.getScrollerElement()).width(width); // set it to
    editor.refresh();
    Ed_array[e_d_count] = editor;
    e_d_count++;
  });


  /**
   * repater Field
   * @since 1.1
   */
  //edit
  $(".at-re-toggle").live('click', function() {
    $(this).nextAll('table').toggle('fast');
  });


  /**
   * Datepicker Field.
   *
   * @since 1.0
   */
  $('.at-date').each( function() {

    var $this  = $(this),
        format = $this.attr('rel');

    $this.datepicker( { showButtonPanel: true, dateFormat: format } );

  });

  /**
   * Timepicker Field.
   *
   * @since 1.0
   */
  $('.at-time').each( function() {

    var $this   = $(this),
          format   = $this.attr('rel'),
          aampm    = $this.attr('data-ampm');
      if ('true' == aampm)
        aampm = true;
      else
        aampm = false;

      $this.timepicker( { showSecond: true, timeFormat: format, ampm: aampm } );

  });

  /**
   * Colorpicker Field.
   *
   * @since 1.0
   * better handler for color picker with repeater fields support
   * which now works both when button is clicked and when field gains focus.
   */
  $('.at-color').live('focus', function() {
    var $this = $(this);
    $(this).siblings('.at-color-picker').farbtastic($this).toggle();
  });

  $('.at-color').live('focusout', function() {
    var $this = $(this);
    $(this).siblings('.at-color-picker').farbtastic($this).toggle();
  });

  /**
   * Add Files.
   *
   * @since 1.0
   */
  $('.at-add-file').click( function() {
    var $first = $(this).parent().find('.file-input:first');
    $first.clone().insertAfter($first).show();
    return false;
  });

  /**
   * Delete File.
   *
   * @since 1.0
   */
  $('.at-upload').delegate( '.at-delete-file', 'click' , function() {

    var $this   = $(this),
        $parent = $this.parent(),
        data     = $this.attr('rel');

    $.post( ajaxurl, { action: 'at_delete_file', data: data }, function(response) {
      response == '0' ? ( alert( 'File has been successfully deleted.' ), $parent.remove() ) : alert( 'You do NOT have permission to delete this file.' );
    });

    return false;

  });


  /**
   * Thickbox Upload
   *
   * @since 1.0
   */
  $('.at-upload-button').click( function() {

    var data       = $(this).attr('rel').split('|'),
        post_id   = data[0],
        field_id   = data[1],
        backup     = window.send_to_editor; // backup the original 'send_to_editor' function which adds images to the editor

    // change the function to make it adds images to our section of uploaded images
    window.send_to_editor = function(html) {

      $('#at-images-' + field_id).append( $(html) );

      tb_remove();

      window.send_to_editor = backup;

    };

    // note that we pass the field_id and post_id here
    tb_show('', 'media-upload.php?post_ID=' + post_id + '&field_id=' + field_id + '&type=image&TB_iframe=true');

    return false;
  });


  /**
   * Helper Function
   *
   * Get Query string value by name.
   *
   * @since 1.0
   */
  function get_query_var( name ) {

    var match = RegExp('[?&]' + name + '=([^&#]*)').exec(location.href);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));

  }

  //new image upload field
  function load_images_muploader(){
    jQuery(".mupload_img_holder").each(function(i,v){
      if (jQuery(this).next().next().val() != ''){
        if (!jQuery(this).children().size() > 0){
          jQuery(this).append('<img src="' + jQuery(this).next().next().val() + '" style="height: 150px;width: 150px;" />');
          jQuery(this).next().next().next().val("Delete");
          jQuery(this).next().next().next().removeClass('at-upload_image_button').addClass('at-delete_image_button');
        }
      }
    });
  }

  load_images_muploader();
  //delete img button
  jQuery('.at-delete_image_button').live('click', function(e){
    var field_id = jQuery(this).attr("rel");
    var at_id = jQuery(this).prev().prev();
    var at_src = jQuery(this).prev();
    var t_button = jQuery(this);
    data = {
        action: 'at_delete_mupload',
        _wpnonce: $('#nonce-delete-mupload_' + field_id).val(),
        post_id: jQuery('#post_ID').val(),
        field_id: field_id,
        attachment_id: jQuery(at_id).val()
    };

    $.getJSON(ajaxurl, data, function(response) {
      if ('success' == response.status){
        jQuery(t_button).val("Upload Image");
        jQuery(t_button).removeClass('at-delete_image_button').addClass('at-upload_image_button');
        //clear html values
        jQuery(at_id).val('');
        jQuery(at_src).val('');
        jQuery(at_id).prev().html('');
        load_images_muploader();
      }else{
        alert(response.message);
      }
    });

    return false;
  });



  //upload button
    var formfield1;
    var formfield2;
    jQuery('.at-upload_image_button').live('click',function(e){
      formfield1 = jQuery(this).prev();
      formfield2 = jQuery(this).prev().prev();
      tb_show('', 'media-upload.php?post_ID='+ jQuery('#post_ID').val() + '&type=image&amp;TB_iframe=true');
      //store old send to editor function
      window.restore_send_to_editor = window.send_to_editor;
      //overwrite send to editor function
      window.send_to_editor = function(html) {
        imgurl = jQuery('img',html).attr('src');
        img_calsses = jQuery('img',html).attr('class').split(" ");
        att_id = '';
        jQuery.each(img_calsses,function(i,val){
          if (val.indexOf("wp-image") != -1){
            att_id = val.replace('wp-image-', "");
          }
        });

        jQuery(formfield2).val(att_id);
        jQuery(formfield1).val(imgurl);
        load_images_muploader();
        tb_remove();
        //restore old send to editor function
        window.send_to_editor = window.restore_send_to_editor;
      }
      return false;
    });

  //editor rezise fix
  $(window).resize(function() {
    $.each(Ed_array, function() {
      var ee = this;
      $(ee.getScrollerElement()).width(100); // set this low enough
      width = $(ee.getScrollerElement()).parent().width();
      $(ee.getScrollerElement()).width(width); // set it to
      ee.refresh();
    });
  });
});

