<?php

/**
 * Fired during plugin activation
 *
 * @link       https://icanwp.com
 * @since      1.0.0
 *
 * @package    Portfolio_Gallery_Master
 * @subpackage Portfolio_Gallery_Master/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Portfolio_Gallery_Master
 * @subpackage Portfolio_Gallery_Master/includes
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class Portfolio_Gallery_Master_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		flush_rewrite_rules();
	}

}
