<?php

include_once '../../../../wp-config.php';
include '../define.php';

$row = '
<tr>
    <td>
        <input class="field required" type="text" name="field_name[]" />
    </td>
	<td>
		<input class="field" type="text" name="field_label[]" />
	</td>
	<td>
		<select class="select" name="field_type[]">
			<option value="text">'.__('Text').'</option>
			<option value="textarea">'.__('Text Area').'</option>
			<option value="email">'.__('Email').'</option>
			<option value="url">'.__('URL').'</option>
			<option value="dropdown">'.__('Dropdown (1 choice)').'</option>
			<option value="checkbox">'.__('Checkbox (Multi choice)').'</option>
			<option value="radio">'.__('Radio Button (1 choice)').'</option>
			<option value="submit">'.__('Submit Button').'</option>
		</select>
	</td>
	<td>
		<input class="field" type="text" name="field_value[]" />
	</td>
	<td>
		<input type="checkbox" class="checkbox" value="1" name="field_required[]" /> <span>'.__('Yes').'</span>
	</td>
	<td>
		<img class="minus_btn" src="'.EASYFORM_PLUGIN_PATH.'style/minus.png" alt="" />
		<img class="plus_btn" src="'.EASYFORM_PLUGIN_PATH.'style/plus.png" alt="" />
		<img class="drag" src="'.EASYFORM_PLUGIN_PATH.'style/drag.png" alt="" />
	</td>
</tr>
';

echo $row;
?>