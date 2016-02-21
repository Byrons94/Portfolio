<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://icanwp.com
 * @since      1.0.0
 *
 * @package    Portfolio_Gallery_Master
 * @subpackage Portfolio_Gallery_Master/admin/partials
 */
?>
<h2>Portfolio Gallery Master Styles</h2>
<p>Copy and paste the following shortcode in the contents area:</p>
<input type="text" name="pgm_shortcode" value="[show-portfolio-gallery]" class="pgm-shortcode-display" readonly="readonly" />
<br />

<form class="pgm-settings" method="post" action="options.php"> 
<?php 
	settings_fields( 'pgm_styles_menu' );
	do_settings_sections( 'pgm_styles_menu' ); 
	submit_button(); 
?>
</form>