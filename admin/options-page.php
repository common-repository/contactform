<?php 
global $wpdb;
global $table_name;
global $settings_table_name;

?>
<style type="text/css">
    #form_builder .row {
    	margin-bottom: 5px;
    }
    
    #form_builder .col {
    	width: auto;
    }
    
    #form_builder .col label {
    	display: block;
    	font-weight: 600;
    	margin-bottom: 5px;
    }
    
    #form_builder .col span {
    	margin-left: 3px;
    }
    
    #form_builder .select {
    	height: auto;
    	font-size: auto;
    }
</style>
<div class="wrap wpcf_easyform">
    <h2>Contact Form Settings</h2>
    <div id="navmenu">
        <ul>
            <li>
                <a href="<?php echo '?page=wpcf_easycontact_admin&tab=settings'; ?>">Settings</a>|
            </li>
            <li>
                <a href="<?php echo '?page=wpcf_easycontact_admin&tab=editform'; ?>">Edit Saved Forms</a>|
            </li>
            <li>
                <a href="<?php echo '?page=wpcf_easycontact_admin&tab=addform'; ?>">Add New Form</a>
            </li>
        </ul>
    </div>
    <?php 
    switch ($_GET['tab']) {
    	case 'editform':
    		include 'editform.php';
    		break;
    		
    	case 'addform':
    		include 'addform.php';
    		break;
			
    	case 'settings':
		default:
    		include 'settings.php';
    		break;
    }
    ?>
</div>
