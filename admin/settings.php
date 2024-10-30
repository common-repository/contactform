<?php 
if (isset($_POST['wpcf_easyform_submit'])) {
	update_option('wpcf_easyform_bordercolor', $_POST['wpcf_easyform_bordercolor']);
	update_option('wpcf_easyform_button_bgcolor', $_POST['wpcf_easyform_button_bgcolor']);
	update_option('wpcf_easyform_button_color', $_POST['wpcf_easyform_button_color']);

	if ($_POST['wpcf_easyform_recaptcha'] == 'yes') {
		update_option('wpcf_easyform_recaptcha', 'yes');
		update_option('wpcf_easyform_recaptcha_public', $_POST['wpcf_easyform_recaptcha_public']);
		update_option('wpcf_easyform_recaptcha_private', $_POST['wpcf_easyform_recaptcha_private']);
	}
	else {
		delete_option('wpcf_easyform_recaptcha');
	}
}

?>
<h3>General Options</h3>
<form method="POST" accept-charset="utf-8" target="_self" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">
                <label for="wpcf_easyform_recaptcha">
                    <?php _e('Use Recaptcha'); ?>
                </label>
            </th>
            <td>
            	<?php
				$checked = get_option('wpcf_easyform_recaptcha')=='yes'?'checked="checked"':'';
				?>
                <input type="checkbox" class="checkbox" name="wpcf_easyform_recaptcha" value="yes" <?php echo $checked; ?>/> Yes
                <br/>
                <span class="description"><?php _e('Recaptcha makes sure that forms are submitted by humans and not by spam softwares'); ?></span>
            </td>
        </tr>
		
        <tr valign="top">
            <th scope="row">
                <label for="wpcf_easyform_bordercolor">
                    <?php _e('Border Color'); ?>
                </label>
            </th>
            <td>
            	<input name="wpcf_easyform_bordercolor" class="color" value="<?php echo get_option('wpcf_easyform_bordercolor'); ?>">
                <span class="description"><?php _e("Border color of each field and button"); ?></span>
            </td>
		</tr>
		
        <tr valign="top">
            <th scope="row">
                <label for="wpcf_easyform_button_bgcolor">
                    <?php _e('Buttons Background Color'); ?>
                </label>
            </th>
            <td>
            	<input name="wpcf_easyform_button_bgcolor" class="color" value="<?php echo get_option('wpcf_easyform_button_bgcolor'); ?>">
                <span class="description"><?php _e("Background color of buttons"); ?></span>
            </td>
		</tr>
		
        <tr valign="top">
            <th scope="row">
                <label for="wpcf_easyform_button_color">
                    <?php _e('Buttons Text Color'); ?>
                </label>
            </th>
            <td>
            	<input name="wpcf_easyform_button_color" class="color" value="<?php echo get_option('wpcf_easyform_button_color'); ?>">
                <span class="description"><?php _e("Foreground color of buttons"); ?></span>
            </td>
		</tr>
		
    </table>
    <br/>
    <input class="button-primary" type="submit" name="wpcf_easyform_submit" value="<?php _e('Save Options'); ?>" />
</form>