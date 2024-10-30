<?php 
if (isset($_POST['wpcf_easyform_submit'])) {

	$easyform_row['name'] = $_POST['formname'];
	$easyform_row['destinatary'] = $_POST['destinatary'];
	$wpdb->insert($table_name, $easyform_row);
	$form_id = $wpdb->insert_id;
	
	if ($form_id > 0) {
		foreach ($_POST['field_type'] as $index=>$value) {
			$easyform_settings_row['form_id'] = $form_id;
			$easyform_settings_row['name'] = preg_replace("/[^a-z0-9_]/i", "", $_POST['field_name'][$index]);
			$easyform_settings_row['label'] = $_POST['field_label'][$index];
			$easyform_settings_row['type'] = $_POST['field_type'][$index];
			$easyform_settings_row['value'] = $_POST['field_value'][$index];
			$easyform_settings_row['required'] = $_POST['field_required'][$index];
			$easyform_settings_row['position'] = $index;
			
			$wpdb->insert($settings_table_name, $easyform_settings_row);
		}
		$message = 'The form has been saved.';
	}
	else {
		$wpdb->show_errors();
		$error = true;
	}
}

?>
<h3><?php _e('Add New Form');?></h3>
<form method="POST" accept-charset="utf-8" target="_self" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">
                <label for="formname">
                    <?php _e('Form name'); ?>
                </label>
            </th>
            <td>
                <input type="text" class="field required" name="formname" value="" size="30"/>*
                <br/>
                <span class="description"><?php _e('Name of the form (internal use)'); ?></span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="destinatary">
                    <?php _e('Destinatary Email'); ?>
                </label>
            </th>
            <td>
                <input type="text" class="field required email" name="destinatary" value="" size="30"/>*
                <br/>
                <span class="description"><?php _e('Email that will receive submissions from this form'); ?></span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="show_label_inside">
                    <?php _e('Use Labels As Text Field Values'); ?>
                </label>
            </th>
            <td>
                <input type="checkbox" class="checkbox" value="1" name="show_label_inside"> <span class="description"><?php _e('The label will show inside the field and disappear when you click to edit the value. (Apply to text fields)'); ?></span>
            </td>
        </tr>
    </table>
    <br/>
	<?php 
		if($error == true){
		$wpdb->print_error();
	}
	?>
	<br />
    <h3><?php _e('Form Fields');?></h3>
	
	<p>
		<h4><?php _e('Instructions');?></h4>
		<ul>
			<li><?php _e('For For <b>dropdown</b>, <b>checkboxes</b>, <b>radio buttons</b> please enter values separated by comma');?></li>
		</ul>
	</p>

    <table id="form_builder">
        <thead>
            <tr>
                <th>
                    <label>
                        <?php _e('Field Name'); ?>
                    </label>
                </th>
                <th>
                    <label>
                        <?php _e('Field Label'); ?>
                    </label>
                </th>
                <th>
                    <label>
                        <?php _e('Field Type'); ?>
                    </label>
                </th>
                <th>
                    <label>
                        <?php _e('Value'); ?>
                    </label>
                </th>
                <th>
                    <label>
                        <?php _e('Required'); ?>
                    </label>
                </th>
                <th>
                    <label>
                        &nbsp;
                    </label>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr id="field_num_<?php echo $field->ID; ?>">
                <td>
                    <input class="field required" type="text" name="field_name[]" value="<?php echo $field->name; ?>"/>
                </td>
                <td>
                    <input class="field" type="text" name="field_label[]" value="<?php echo $field->label; ?>"/>
                </td>
                <td>
                    <select class="select" name="field_type[]">
                        <option value="text"><?php _e('Text'); ?></option>
                        <option value="textarea"><?php _e('Text Area'); ?></option>
                        <option value="email"><?php _e('Email'); ?></option>
                        <option value="url"><?php _e('URL'); ?></option>
                        <option value="dropdown"><?php _e('Dropdown'); ?></option>
                        <option value="checkbox"><?php _e('Checkbox (Multi choice)'); ?></option>
                        <option value="radio"><?php _e('Radio Button (1 choice)'); ?></option>
                        <option value="submit"><?php _e('Submit Button'); ?></option>
                    </select>
                </td>
                <td>
                    <input type="text" class="field" name="field_value[]" value=""/><span></span>
                </td>
                <td>
                    <input type="checkbox" class="checkbox" value="1" name="field_required[<?php echo $i; ?>]"/> <span><?php _e('Yes'); ?></span>
                </td>
                <td>
                    <img class="minus_btn" src="<?php echo EASYFORM_PLUGIN_PATH.'style/minus.png'; ?>" alt="" />
					<img class="plus_btn" src="<?php echo EASYFORM_PLUGIN_PATH.'style/plus.png'; ?>" alt="" />
					<img class="drag" src="<?php echo EASYFORM_PLUGIN_PATH.'style/drag.png'; ?>" alt="" />
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
    <br/>
    <input class="button-primary" type="submit" name="wpcf_easyform_submit" value="<?php _e('Save Form'); ?>" />
    <p>
        <?php echo $message; ?>
    </p>
</form>
