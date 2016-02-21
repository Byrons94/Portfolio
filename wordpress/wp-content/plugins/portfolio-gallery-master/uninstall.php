<?php

/**
 * Fired when the plugin is uninstalled.
 * @link       https://icanwp.com
 * @since      1.0.0
 *
 * @package    Portfolio_Gallery_Master
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
$pgm_options = array(
	'pgm_portfolio_initial_width',
	'pgm_portfolio_initial_height',
	'pgm_portfolio_margin',
	'pgm_portfolio_padding',
	'pgm_portfolio_frame_color',
	'pgm_portfolio_overlay_font_color',
	'pgm_portfolio_overlay_color',
	'pgm_disable_hover_display',
	'pgm_disable_post_link',
	'pgm_portfolio_display_mode',
	'pgm_display_per_row',
	'pgm_display_min_width',
	'pgm_display_max_width'
);
foreach($pgm_options as $option){
delete_option($option);
}