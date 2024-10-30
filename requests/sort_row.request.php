<?php
include_once '../../../../wp-config.php';
include '../define.php';

global $wpdb;

foreach ($_POST['field_num'] as $position=>$field_id) {
	
	if ($field_id > 0) {
		$query = "
			UPDATE $settings_table_name 
			SET position = '".$position."' 
			WHERE ID = $field_id";
		$wpdb->query($query);
	}

}

?>