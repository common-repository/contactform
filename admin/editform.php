<h3><?php _e('Edit Existing Form');?></h3>
<?php 
if ((!isset($_POST['wpcf_easyform_submit']) AND !isset($_POST['wpcf_easyform_update_submit'])) OR (isset($_POST['wpcf_easyform_submit']) AND isset($_POST['delete_form']))) {
	if (isset($_POST['delete_form'])) {
		$wpdb->query("DELETE FROM $table_name WHERE ID = ".$_POST['form_id']);
		$wpdb->query("DELETE FROM $settings_table_name WHERE form_id = ".$_POST['form_id']);
		$message = "The form has been deleted.";
	}
	
?>
<form method="POST" accept-charset="utf-8" target="_self" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">
                <label for="formname">
                    <?php _e('Form name'); ?>
                </label>
            </th>
            <td>
                <?php 
                $results = $wpdb->get_results("
					SELECT *
					FROM $table_name
					ORDER BY name
				");
                                				
                foreach ($results as $form) {
                	$options .= '<option value="'.$form->ID.'">'.$form->name.'</option>';
                }
                ?>
                <select class="select" name="form_id">
                    <?php echo $options; ?>
                </select>
                <br/>
                <span class="description"><?php _e('Select the form that you want to edit'); ?></span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="formname">
                    <?php _e('Delete This Form'); ?>
                </label>
            </th>
            <td>
                <input type="checkbox" class="checkbox" value="yes" name="delete_form"><?php _e('Confirm deletion'); ?>
                <br/>
                <span class="description"><?php _e('Check this box to delete the selected form'); ?></span>
            </td>
        </tr>
    </table>
    <br/>
    <br/>
    <input class="button-primary" type="submit" name="wpcf_easyform_submit" value="<?php _e('Edit Form'); ?>" />
    <p>
        <?php echo $message; ?>
    </p>
</form>
<?php 
}
else {
	if (isset($_POST['wpcf_easyform_update_submit'])) {
	
		$wpdb->query("DELETE FROM $settings_table_name WHERE form_id = ".$_POST['form_id']);
		$wpdb->query($wpdb->prepare("
			UPDATE $table_name 
			SET 
			name = '".$_POST['formname']."', 
			destinatary = '".$_POST['destinatary']."', 
			show_label_inside = '".$_POST['show_label_inside']."'
			WHERE ID = ".$_POST['form_id']));
			
		foreach ($_POST['field_name'] as $index=>$value) {
			//echo '$_POST["field_name"]['.$index.'] = '.$_POST['field_name'][$index].'<br />';
			
			$easyform_settings_row['form_id'] = $_POST['form_id'];
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
	
	$shortcode = '[easyform id="'.$_POST['form_id'].'"]';

	
	$form_id = $_POST['form_id'];
	$form = $wpdb->get_results("
            			SELECT *
            			FROM $table_name
            			WHERE ID = $form_id
            		");
	$form = stripslashes_deep($form);
	
	$form = $form[0];
	
	$form_fields = $wpdb->get_results("
            			SELECT *
            			FROM $settings_table_name
            			WHERE form_id = $form_id
            			ORDER BY position
            		");

	$form_fields = stripslashes_deep($form_fields);
	
?>
<form method="POST" accept-charset="utf-8" target="_self" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">
                <label for="formname">
                    <?php _e('Form name'); ?>
                </label>
            </th>
            <td>
                <input type="text" class="field required" name="formname" value="<?php echo $form->name; ?>" size="30"/>*
                <br/>
                <span class="description"><?php _e('Name of the form (internal use)'); ?></span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="show_label_inside">
                    <?php _e('Use Labels As Text Field Values'); ?>
                </label>
            </th>
            <td>
                <?php 
                $checked = $form->show_label_inside == 1 ? ' checked="checked"' : '';
                ?>
                <input type="checkbox" class="checkbox" value="1" name="show_label_inside"<?php echo $checked; ?>> <span class="description"><?php _e('The label will show inside the field and disappear when you click to edit the value. (Apply to text fields)'); ?></span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="destinatary">
                    <?php _e('Destinatary Email'); ?>
                </label>
            </th>
            <td>
                <input type="text" class="field required email" name="destinatary" value="<?php echo $form->destinatary; ?>" size="30"/>*
                <br/>
                <span class="description"><?php _e('Email that will receive submissions from this form'); ?></span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="shortcode">
                    <?php _e('Form shortcode'); ?>
                </label>
            </th>
            <td>
                <?php echo $shortcode; ?>
                <br/>
                <span class="description"><?php _e('Paste this shortcode into the page or post where you want to display this form'); ?></span>
            </td>
        </tr>
    </table>
    <br/>
    <h3><?php _e('Form Fields');?></h3>
	
	<p>
		<h4><?php _e('Instructions');?></h4>
		<ul>
			<li><?php _e('For <b>dropdown</b>, <b>checkboxes</b>, <b>radio buttons</b> please enter values separated by comma.');?></li>
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
            <?php 
            $i = 0;
            foreach ($form_fields as $field) {
            	
            ?>
            <tr id="field_num_<?php echo $field->ID; ?>">
                <td>
                    <input class="field required" type="text" name="field_name[]" value="<?php echo $field->name; ?>" field="field_name"/>
                </td>
                <td>
                    <input class="field" type="text" name="field_label[]" value="<?php echo $field->label; ?>" field="field_label"/>
                </td>
                <td>
                    <select class="select" name="field_type[]" field="field_type">
                        <option value="text"<?php echo($field->type == "text" ? ' selected="selected"' : ''); ?>><?php _e('Text'); ?></option>
                        <option value="textarea"<?php echo($field->type == "textarea" ? ' selected="selected"' : ''); ?>><?php _e('Text Area'); ?></option>
                        <option value="email"<?php echo($field->type == "email" ? ' selected="selected"' : ''); ?>><?php _e('Email'); ?></option>
                        <option value="url"<?php echo($field->type == "url" ? ' selected="selected"' : ''); ?>><?php _e('URL'); ?></option>
						<option value="dropdown"<?php echo($field->type == "dropdown" ? ' selected="selected"' : ''); ?>><?php _e('Dropdown (1 choice)'); ?></option>
						<option value="checkbox"<?php echo($field->type == "checkbox" ? ' selected="selected"' : ''); ?>><?php _e('Checkbox (Multi choice)'); ?></option>
						<option value="radio"<?php echo($field->type == "radio" ? ' selected="selected"' : ''); ?>><?php _e('Radio Button (1 choice)'); ?></option>
                        <option value="submit"<?php echo($field->type == "submit" ? ' selected="selected"' : ''); ?>><?php _e('Submit Button'); ?></option>
                    </select>
                </td>
                <td>
                    <input type="text" class="field" name="field_value[]" value="<?php echo $field->value; ?>" field="field_value"/><span></span>
                </td>
                <td>
                    <?php 
                    $checked = $field->required == 1 ? ' checked="checked"' : '';
                    ?>
                    <input type="checkbox" class="checkbox" value="1" name="field_required[<?php echo $i; ?>]" field="field_required"<?php echo $checked; ?>/><span><?php _e('Yes'); ?></span>
                </td>
                <td>
                    <img class="minus_btn" src="<?php echo EASYFORM_PLUGIN_PATH.'style/minus.png'; ?>" alt="" />
					<img class="plus_btn" src="<?php echo EASYFORM_PLUGIN_PATH.'style/plus.png'; ?>" alt="" />
					<img class="drag" src="<?php echo EASYFORM_PLUGIN_PATH.'style/drag.png'; ?>" alt="" />
                </td>
            </tr>
            <?php 
            $i++;
            }
            ?>
        </tbody>
    </table>
    <br/>
    <br/>
    <input class="button-primary" type="submit" name="wpcf_easyform_update_submit" value="<?php _e('Save Form'); ?>" /><input type="hidden" name="form_id" value="<?php echo $_POST['form_id']; ?>" />
    <p>
        <?php echo $message; ?>
    </p>
</form>
<?php 
}
?>
