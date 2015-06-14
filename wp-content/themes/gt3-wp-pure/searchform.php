<?php $search_rand = mt_rand(0, 999); ?>
<div class="search_form_cont">
    <form name="search_form" method="get" action="<?php echo home_url(); ?>" class="search_form" id="search-<?php echo $search_rand; ?>">
        <span class="sicon" onclick="javascript:document.getElementById('search-<?php echo $search_rand; ?>').submit();"><i class="icon-search"></i> <?php _e('Search','theme_localization'); ?></span>
        <input type="text" name="s" placeholder="<?php _e('Search the site...','theme_localization'); ?>" value="" title="<?php _e('Search the site...','theme_localization'); ?>" class="field_search">
        <div class="clear"></div>
    </form>
</div>