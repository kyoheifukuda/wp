<?php

require_once(GT3PBPLUGINPATH . "core/aq_resizer.php");
require_once(GT3PBPLUGINPATH . "config.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/shortcodesUI.php");
require_once(GT3PBPLUGINPATH . "core/registrator/css-js.php");
require_once(GT3PBPLUGINPATH . "core/registrator/misc.php");
require_once(GT3PBPLUGINPATH . "core/pb-functions.php");
require_once(GT3PBPLUGINPATH . "core/registrator/custom-post-types.php");
require_once(GT3PBPLUGINPATH . "core/pb-modules.php");
require_once(GT3PBPLUGINPATH . "core/pb-parser.php");

/*require_once(GT3PBPLUGINPATH . "core/plugin-settings/admin-tabs-controls.php");
require_once(GT3PBPLUGINPATH . "core/plugin-settings/admin-tabs-list.php");
require_once(GT3PBPLUGINPATH . "core/plugin-settings/admin-tabs-option-types.php");
require_once(GT3PBPLUGINPATH . "core/plugin-settings/options.php");
require_once(GT3PBPLUGINPATH . "core/plugin-settings/plugin-settings.php");*/

/*Shortcodes*/
require_once(GT3PBPLUGINPATH . "core/shortcodes/accordion.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/title.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/toggles.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/faq.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/counter.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/before-after.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/blockquote.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/blog.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/buttons.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/contacts.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/dropcaps.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/diagram.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/divider.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/feature_posts.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/feature_portfolio.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/gallery.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/wall.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/iconboxes.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/list.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/map.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/messageboxes.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/partners.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/portfolio.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/pricetable.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/promotext.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/sitemap.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/social_icons.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/tabs.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/team.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/testimonials.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/textarea.php");
require_once(GT3PBPLUGINPATH . "core/shortcodes/video.php");

require_once(GT3PBPLUGINPATH . "core/pb-ajax-handlers.php");

?>