<?php 
global $wpdb;
global $table_name;
global $settings_table_name;
global $wpcf_easyform_version;

define('EASYFORM_PLUGIN_PATH', WP_PLUGIN_URL.'/contactform/');
define('EASYFORM_PLUGIN_NAME','ContactForm');

$wpcf_easyform_version = '1.0.0';
$table_name = $wpdb->prefix."easyform";
$settings_table_name = $wpdb->prefix."easyform_settings";

?>
