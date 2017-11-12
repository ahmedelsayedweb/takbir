<?php
/*
Plugin Name: VO Store Locator
Plugin URI: http://www.vitalorganizer.com/vo-locator-wordpress-store-locator-plugin/
Description: Simple wordpress store locator plugin to manage multiple business locations and other any places using Google Maps. Manage a few or thousands of locations effortlessly with setup in minutes.
Version: 3.1.1
Author: Jurski
Author URI: http://www.vitalorganizer.com
*/
$vosl_version = 3.11;
define('VOSL_VERSION', $vosl_version);
$vosl_db_version = 1.4;

if(!session_id()) {
	session_start();
}

include_once("vosl-define.php");
include_once("vosl-functions.php");
//echo $vosl_admin_classes_dir; die;
require $vosl_inc_classes_dir.'/vosl-locator.php';
$vosl_output = new VoStoreLocator(); 

register_activation_hook( __FILE__, 'vosl_install_tables');
register_deactivation_hook( __FILE__, 'vosl_deactivation');

load_plugin_textdomain(VOSL_TEXT_DOMAIN, FALSE, dirname(plugin_basename(__FILE__)).'/languages/');

function vosl_update_db_check() {
    global $vosl_db_version;
    if (vosl_data('vosl_db_version') != $vosl_db_version) {
        vosl_install_tables();
    }
}
add_action('plugins_loaded', 'vosl_update_db_check');
?>