<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://icanwp.com
 * @since             1.0.0
 * @package           Portfolio_Gallery_Master
 *
 * @wordpress-plugin
 * Plugin Name:       Portfolio Gallery Master
 * Plugin URI:        https://icanwp.com/plugins/portfolio-gallery-master/
 * Description:       Portfolio Gallery Master is designed to provide a very simple portfolio administrations using custom post type post. Each post users create under the PGM Portfolio becomes a gallery on the page where they put the shortcode. Each post needs a featured image assigned to the post and it will automatically scaled in the original ratio to be displayed. Each portfolio gallery has a mouse overlay effect that shows the title of the portfolio post. Users can adjust the frame color, font color, overlay background color, and many more from the styles and settings. This plugin also features a responsive mode by default that always show the galleries centered to the parent container and there is a mode where you can set to show a specific number or galleries per row and automatically scale when the browser size changes.
 * Version:           1.0.0
 * Author:            Web Marketing Smart
 * Author URI:        https://icanwp.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       portfolio-gallery-master
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-portfolio-gallery-master-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-gallery-master-activator.php';
	Portfolio_Gallery_Master_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-portfolio-gallery-master-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-gallery-master-deactivator.php';
	Portfolio_Gallery_Master_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-gallery-master.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_portfolio_gallery_master() {

	$plugin = new Portfolio_Gallery_Master();
	$plugin->run();

}
run_portfolio_gallery_master();
