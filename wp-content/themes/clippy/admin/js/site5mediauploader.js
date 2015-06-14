//PORTFOLIO BUTTON
jQuery(document).ready(function($){

jQuery('#snbp_pitembutton').click(function() {
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 jQuery('#snbp_pitemlink').val(imgurl);
 jQuery('#snbp_pitemlink_img').attr('src',imgurl);
 tb_remove();
}


tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
});
});


//FEATUED BUTTON
jQuery(document).ready(function($){

jQuery('#snbf_fitembutton').click(function() {
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 jQuery('#snbf_slideimage_src').val(imgurl);
 jQuery('#snbf_slideimage_src_img').attr('src',imgurl);
 tb_remove();
}


tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
});
});