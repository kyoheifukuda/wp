<?php if(! defined('SWPA_PLUGIN_PREFIX')) return;

/**
 * Informational alert. Value: 0
 */
define('SWPA_PLUGIN_ALERT_INFO', 0);
/**
 * Low alert. Value: 1
 */
define('SWPA_PLUGIN_ALERT_LOW', 1);
/**
 * Medium alert. Value: 2
 */
define('SWPA_PLUGIN_ALERT_MEDIUM', 2);
/**
 * Critical alert. Value: 3
 */
define('SWPA_PLUGIN_ALERT_CRITICAL', 3);

define('SWPA_PLUGIN_ALERT_TYPE_OVERWRITE', 0);
define('SWPA_PLUGIN_ALERT_TYPE_STACK', 1);

//#! The max number of stacked alerts to keep
define('SWPA_PLUGIN_ALERT_STACK_MAX_KEEP', 10);

//#! Database settings
define('SWPA_PLUGIN_ALERT_TABLE_NAME', '_wsd_plugin_alerts');
//
define('SWPA_PLUGIN_LIVE_TRAFFIC_TABLE_NAME', '_wsd_plugin_live_traffic');

define('SWPA_PLUGIN_BACKUPS_DIR', SWPA_PLUGIN_DIR.'res/backups/');

define('SWPA_PLUGIN_TEXT_DOMAIN', 'WSDWP_SECURITY');

define('SWPA_PLUGIN_SETTINGS_OPTION_NAME', 'wsdplugin_settings');

/**
 * Set the path to the WebsiteDefender.com feed
 */
define('SWPA_PLUGIN_BLOG_FEED','http://feeds.acunetix.com/acunetixwebapplicationsecurityblog');

/**
 * Sets the list of files to check for permissions
 * @type array
 */
$_wsdplugin_base_path  = trailingslashit(ABSPATH);
$_wsdplugin_wpAdmin    = $_wsdplugin_base_path.'wp-admin';
$_wsdplugin_wpContent  = $_wsdplugin_base_path.'wp-content';
$_wsdplugin_wpIncludes = $_wsdplugin_base_path.'wp-includes';
$_wsdpluginWpConfigPath ='';
    //$_wsdplugin_base_path.'wp-config.php';
if(! is_file($_wsdpluginWpConfigPath)){
    // try one level up
    $_tmpPath = realpath($_wsdplugin_base_path.'../wp-config.php');
    if(is_file($_tmpPath)){
        $_wsdpluginWpConfigPath = $_tmpPath;
    }
    // not found
    else { $_wsdpluginWpConfigPath = ''; }
}

$acxFileList = array(
//@@ Directories
    'root directory' => array( 'filePath' => $_wsdplugin_base_path, 'suggestedPermissions' => '0755'),
    'wp-admin' => array( 'filePath' => $_wsdplugin_wpAdmin, 'suggestedPermissions' => '0755'),
    'wp-content' => array( 'filePath' => $_wsdplugin_wpContent, 'suggestedPermissions' => '0755'),
    'wp-includes' => array( 'filePath' => $_wsdplugin_wpIncludes, 'suggestedPermissions' => '0755'),

//@@ Files
    '.htaccess' => array( 'filePath' => $_wsdplugin_base_path.'.htaccess', 'suggestedPermissions' => '0644'),
    'readme.html' => array( 'filePath' => $_wsdplugin_base_path.'readme.html', 'suggestedPermissions' => '0400'),
    'wp-config.php' => array( 'filePath' => $_wsdpluginWpConfigPath, 'suggestedPermissions' => '0644'),
    'wp-admin/index.php' => array( 'filePath' => $_wsdplugin_wpAdmin.'/index.php', 'suggestedPermissions' => '0644'),
    'wp-admin/.htaccess' => array( 'filePath' => $_wsdplugin_wpAdmin.'/.htaccess', 'suggestedPermissions' => '0644'),
);
