<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://icanwp.com
 * @since      1.0.0
 *
 * @package    Portfolio_Gallery_Master
 * @subpackage Portfolio_Gallery_Master/admin
 */

/**
 * The admin-specific functionality of the plugin.
 * @package    Portfolio_Gallery_Master
 * @subpackage Portfolio_Gallery_Master/admin
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class Portfolio_Gallery_Master_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . '-pgm-admin-css', plugin_dir_url( __FILE__ ) . 'css/portfolio-gallery-master-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-pgm-minicolors-css', plugin_dir_url( __FILE__ ) . 'css/jquery.minicolors.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name . '-pgm-admin-js', plugin_dir_url( __FILE__ ) . 'js/portfolio-gallery-master-admin.js', array(), $this->version, 'all' );
		wp_enqueue_script( $this->plugin_name . '-pgm-minicolors-js', plugin_dir_url( __FILE__ ) . 'js/jquery.minicolors.min.js', array( 'jquery' ), $this->version, 'all' );
	}

	//Add Plugin Menu Pages
	public function pgm_add_admin_menu(){
		add_menu_page(
			'Portfolio Gallery Master',
			'PGM Portfolio',
			'manage_options',
			'pgm_main_menu',
			'',
			plugin_dir_url( __FILE__ ) . 'assets/admin-icon.png',
			137.835
		);
		add_submenu_page(
			'pgm_main_menu',
			'Portfolio Gallery Master Styles',
			'Styles',
			'manage_options',
			'pgm_styles_menu',
			array($this, 'display_pgm_styles_menu_page')			
		);
		add_submenu_page(
			'pgm_main_menu',
			'Portfolio Gallery Master Settings',
			'Settings',
			'manage_options',
			'pgm_settings_menu',
			array($this, 'display_pgm_settings_menu_page')			
		);
	}
	
	//Initialize plugin options and settings
	public function pgm_init_options(){
		add_settings_section(
			'settings_section_pgm_style_dimension_section',
			'General Settings',
			array($this, 'callback_section_pgm_styles_dimension_section'),
			'pgm_styles_menu'
		);
		add_settings_section(
			'settings_section_pgm_style_general_section',
			'Color Style Settings',
			array($this, 'callback_section_pgm_styles_general_section'),
			'pgm_styles_menu'
		);
		add_settings_section(
			'settings_section_pgm_main_menu',
			'Portfolio Gallery Master Main Settings',
			array($this, 'callback_section_pgm_settings_menu'),
			'pgm_settings_menu'
		);
		add_settings_field( 
			'pgm_portfolio_initial_width',
			'Individual Box Width',
			array($this, 'callback_pgm_portfolio_initial_width'),
			'pgm_styles_menu',
			'settings_section_pgm_style_dimension_section',
			array('<strong>px</strong> (Please Enter Numbers Only.)')
		);
		add_settings_field( 
			'pgm_portfolio_initial_height',
			'Individual Box Height',
			array($this, 'callback_pgm_portfolio_initial_height'),
			'pgm_styles_menu',
			'settings_section_pgm_style_dimension_section',
			array('<strong>px</strong> (Please Enter Numbers Only.)')
		);
		add_settings_field( 
			'pgm_portfolio_margin',
			'Individual Box Margin',
			array($this, 'callback_pgm_portfolio_margin'),
			'pgm_styles_menu',
			'settings_section_pgm_style_dimension_section',
			array('<strong>%</strong> (Please Enter Numbers Only.)')
		);
		add_settings_field( 
			'pgm_portfolio_padding',
			'Individual Box Padding',
			array($this, 'callback_pgm_portfolio_padding'),
			'pgm_styles_menu',
			'settings_section_pgm_style_dimension_section',
			array('<strong>%</strong> (Please Enter Numbers Only.)')
		);
		add_settings_field( 
			'pgm_portfolio_overlay_font_color',
			'Choose Box Overlay Font Color',
			array($this, 'callback_pgm_overlay_font_color'),
			'pgm_styles_menu',
			'settings_section_pgm_style_general_section',
			array('Specify a font color for texts displayed on the overlay on mouse hover over each portfolio item.')
		);
		add_settings_field( 
			'pgm_portfolio_frame_color',
			'Choose Box Frame Color',
			array($this, 'callback_pgm_frame_color'),
			'pgm_styles_menu',
			'settings_section_pgm_style_general_section',
			array('Specify a color for the portfolio box frames.')
		);
		add_settings_field( 
			'pgm_portfolio_overlay_color',
			'Choose Box Overlay Color',
			array($this, 'callback_pgm_overlay_color'),
			'pgm_styles_menu',
			'settings_section_pgm_style_general_section',
			array('Specify a color for the overlay background on mouse hover over each portfolio item.')
		);
		
		add_settings_field( 
			'pgm_disable_post_link',
			'Disable Link to Portfolio Page',
			array($this, 'callback_pgm_disable_post_link'),
			'pgm_settings_menu',
			'settings_section_pgm_main_menu',
			array('Check this option to disable link to portfolio detail post.')
		);
		add_settings_field( 
			'pgm_disable_hover_display',
			'Disable Hover Display',
			array($this, 'callback_pgm_disable_hover_display'),
			'pgm_settings_menu',
			'settings_section_pgm_main_menu',
			array('Check this option to disable hover display.')
		);
		add_settings_field( 
			'pgm_portfolio_display_mode',
			'Display Mode',
			array($this, 'callback_pgm_display_mode'),
			'pgm_settings_menu',
			'settings_section_pgm_main_menu'
		);
		add_settings_field( 
			'pgm_display_per_row',
			'Portfolio Boxes per Row',
			array($this, 'callback_pgm_display_mode_rows'),
			'pgm_settings_menu',
			'settings_section_pgm_main_menu'
		);
		add_settings_field( 
			'pgm_display_min_width',
			'Min Width (Optional)',
			array($this, 'callback_pgm_display_mode_min_width'),
			'pgm_settings_menu',
			'settings_section_pgm_main_menu'
		);
		add_settings_field( 
			'pgm_display_max_width',
			'Max Width (Optional)',
			array($this, 'callback_pgm_display_mode_max_width'),
			'pgm_settings_menu',
			'settings_section_pgm_main_menu'
		);
		register_setting(
			'pgm_styles_menu',
			'pgm_portfolio_initial_width',
			array($this, 'sanitize_number_input')
		);
		register_setting(
			'pgm_styles_menu',
			'pgm_portfolio_initial_height',
			array($this, 'sanitize_number_input')
		);
		register_setting(
			'pgm_styles_menu',
			'pgm_portfolio_margin',
			array($this, 'sanitize_number_input')
		);
		register_setting(
			'pgm_styles_menu',
			'pgm_portfolio_padding',
			array($this, 'sanitize_number_input')
		);
		register_setting(
			'pgm_styles_menu',
			'pgm_portfolio_overlay_font_color',
			array($this, 'sanitize_text_input')
		);
		register_setting(
			'pgm_styles_menu',
			'pgm_portfolio_frame_color',
			array($this, 'sanitize_text_input')
		);
		register_setting(
			'pgm_styles_menu',
			'pgm_portfolio_overlay_color',
			array($this, 'sanitize_text_input')
		);
		register_setting(
			'pgm_settings_menu',
			'pgm_disable_hover_display'
		);
		register_setting(
			'pgm_settings_menu',
			'pgm_disable_post_link'
		);
		register_setting(
			'pgm_settings_menu',
			'pgm_portfolio_display_mode'
		);
		register_setting(
			'pgm_settings_menu',
			'pgm_display_per_row',
			array($this, 'sanitize_number_input')
		);
		register_setting(
			'pgm_settings_menu',
			'pgm_display_min_width',
			array($this, 'sanitize_number_input')
		);
		register_setting(
			'pgm_settings_menu',
			'pgm_display_max_width',
			array($this, 'sanitize_number_input')
		);

		if ( get_option( 'pgm_portfolio_initial_width' ) === false ) {
			update_option( 'pgm_portfolio_initial_width', 250 );
		}
		if ( get_option( 'pgm_portfolio_initial_height' ) === false ) {
			update_option( 'pgm_portfolio_initial_height', 250 );
		}
		if ( get_option( 'pgm_portfolio_margin' ) === false ) {
			update_option( 'pgm_portfolio_margin', 1 );
		}
		if ( get_option( 'pgm_portfolio_padding' ) === false ) {
			update_option( 'pgm_portfolio_padding', 1 );
		}
		if ( get_option( 'pgm_portfolio_display_mode' ) === false ) {
			update_option( 'pgm_portfolio_display_mode', 1 );
		}

		if ( get_option( 'pgm_display_per_row' ) === false ) {
			update_option( 'pgm_display_per_row', 4 );
		}

		if ( get_option( 'pgm_display_min_width' ) === false ) {
			update_option( 'pgm_display_min_width', 200 );
		}

		if ( get_option( 'pgm_display_max_width' ) === false ) {
			update_option( 'pgm_display_max_width', 400 );
		}

	}
	
	//register custom post type
	public function pgm_register_custom_post_type(){
		$labels = array(
			'name'               => 'PGM Portfolios',
			'singular_name'      => 'PGM Portfolio',
			'menu_name'          => 'Portfolio Gallery Master',
			'name_admin_bar'     => 'Portfolio Gallery Master',
			'add_new'            => 'Add New Portfolio',
			'add_new_item'       => 'Add New Portfolio',
			'new_item'           => 'New Portfolio',
			'edit_item'          => 'Edit Portfolio',
			'view_item'          => 'View Portfolio',
			'all_items'          => 'All Portfolios',
			'search_items'       => 'Search Portfolio',
			'parent_item_colon'  => 'Parent Portfolio:',
			'not_found'          => 'No Portfolio Found',
			'not_found_in_trash' => 'No Portfolio Found in Trash.'
		);

		$args = array(
			'labels'             => $labels,
			'description'        => 'Portfolio for Portfolio Gallery Master',
			'public'             => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui'            => true,
			'show_in_menu'       => 'pgm_main_menu',
			'menu_position'		 => 20.87,
			'query_var'          => false,
			'rewrite'            => true,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'revisions')
		);

		register_post_type( 'pgm-portfolio', $args );
		flush_rewrite_rules();
	}
	
	//Menu Page & settings section callback
	public function callback_section_pgm_styles_dimension_section(){
		require_once('partials/settings-section-pgm-style-dimension.php');
	}
	public function callback_section_pgm_styles_general_section(){
		require_once('partials/settings-section-pgm-style-settings.php');
	}
	public function callback_section_pgm_settings_menu(){
		require_once('partials/settings-section-pgm-main-settings.php');
	}
	public function display_pgm_styles_menu_page(){
		require_once('partials/menu-pgm-styles-display.php');
	}
	public function display_pgm_settings_menu_page(){
		require_once('partials/menu-pgm-settings-display.php');
	}
	
	//Styles Callback
	public function callback_pgm_portfolio_initial_width( $options ){
		$html = '<input type="number" min="0" class="pgm-number-field" id="pgm_portfolio_initial_width" name="pgm_portfolio_initial_width" value="' . get_option('pgm_portfolio_initial_width') .'" />';
		$html .= '<label for="pgm_portfolio_initial_width"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	public function callback_pgm_portfolio_initial_height( $options ){
		$html = '<input type="number" min="0" class="pgm-number-field" id="pgm_portfolio_initial_height" name="pgm_portfolio_initial_height" value="' . get_option('pgm_portfolio_initial_height') .'" />';
		$html .= '<label for="pgm_portfolio_initial_height"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	public function callback_pgm_portfolio_margin( $options ){
		$html = '<input type="number" min="0" class="pgm-number-field" id="pgm_portfolio_margin" name="pgm_portfolio_margin" value="' . get_option('pgm_portfolio_margin') .'" />';
		$html .= '<label for="pgm_portfolio_margin"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	public function callback_pgm_portfolio_padding( $options ){
		$html = '<input type="number" min="0" class="pgm-number-field" id="pgm_portfolio_padding" name="pgm_portfolio_padding" value="' . get_option('pgm_portfolio_padding') .'" />';
		$html .= '<label for="pgm_portfolio_padding"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	public function callback_pgm_frame_color( $options ){
		$html = '<input type="text" id="pgm_portfolio_frame_color" name="pgm_portfolio_frame_color" data-format="rgb" data-opacity="" value="' . get_option('pgm_portfolio_frame_color') .' />';
		$html .= '<label for="pgm_portfolio_frame_color"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	public function callback_pgm_overlay_font_color( $options ){
		$html = '<input type="text" id="pgm_portfolio_overlay_font_color" name="pgm_portfolio_overlay_font_color" value="' . get_option('pgm_portfolio_overlay_font_color') .' />';
		$html .= '<label for="pgm_portfolio_overlay_font_color"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	public function callback_pgm_overlay_color( $options ){
		$html = '<input type="text" id="pgm_portfolio_overlay_color" name="pgm_portfolio_overlay_color" data-format="rgb" data-opacity="" value="' . get_option('pgm_portfolio_overlay_color') .' />';
		$html .= '<label for="pgm_portfolio_overlay_color"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	
	//Settings Callback
	public function callback_pgm_disable_hover_display( $options ){
		$html = '<input type="checkbox" id="pgm_disable_hover_display" name="pgm_disable_hover_display" value="1" ' . checked(1, get_option('pgm_disable_hover_display'), false) . '/>'; 
		$html .= '<label for="pgm_disable_hover_display"> '  . $options[0] . '</label>';
		echo $html;
	}
	public function callback_pgm_disable_post_link( $options ){
		$html = '<input type="checkbox" id="pgm_disable_post_link" name="pgm_disable_post_link" value="1" ' . checked(1, get_option('pgm_disable_post_link'), false) . '/>'; 
		$html .= '<label for="pgm_disable_post_link"> '  . $options[0] . '</label>';
		echo $html;
	}

	public function callback_pgm_display_mode( $options ) {
		$mode = get_option( 'pgm_portfolio_display_mode' );
		
		$html = '<input type="radio" id="pgm_display_mode_1" name="pgm_portfolio_display_mode" value="1"' . checked( 1, $mode, false ) . '/>';
		$html .= '<label for="pgm_display_mode_1">Fixed Size</label> ';
		$html .= '<input type="radio" id="pgm_display_mode_2" name="pgm_portfolio_display_mode" value="2"' . checked( 2, $mode, false ) . '/>';
		$html .= '<label for="pgm_display_mode_2">Auto Resize</label> ';
		$html .= '<input type="radio" id="pgm_display_mode_3" name="pgm_portfolio_display_mode" value="3"' . checked( 3, $mode, false ) . '/>';
		$html .= '<label for="pgm_display_mode_3">Portfolio Boxes per Row</label> ';
		$html .= '<hr />
		<ul id="pgm_display_mode_desc">
			<li><strong>Fixed Size:</strong> Always use the width and height specified in style settings</li>
			<li><strong>Auto Resize:</strong> Resizes the gallery in proportion of gallery to the container width when the browser first loads the gallery.</li>
			<li><strong>Portfolio Boxes per Row:</strong> Will resize to fit the specified number of portfolio item(s) per row with "min-width" and "max-width" exceptions.</li>
		</ul>
		<div class="pgm_notice_section">
			<p><span class="pgm_notice">In order to edit the options below, please select "Portfolio Boxes per Row" mode in the Display Mode setting.</span></p>
		</div>
		';
		
		echo $html;
	}
	
	public function callback_pgm_display_mode_rows( $options ){
		$mode = get_option( 'pgm_portfolio_display_mode' );
		
		$html .= '
		<div class="pgm_portfolio_display_mode_settings">
			<label for="pgm_display_per_row">Number of portfolios to display per row:</label>
			<input type="number" min="0" class="pgm_portfolio_display_mode_input" id="pgm_display_per_row" name="pgm_display_per_row" value="' . get_option('pgm_display_per_row') .'"' . ( $mode != 3 ? 'disabled="disabled"' : '' ) . ' />
		</div>
		<div class="pgm_info_section">
			<p><span class="pgm_info">If Min Width and Max Width is not specified, it will always display the number of rows specified in Portfolio Boxes per Row setting, which may cause the portfolio to display too small or too big.</span></p>
		</div>
		';
		echo $html;
	}
	public function callback_pgm_display_mode_min_width( $options ){
		$mode = get_option( 'pgm_portfolio_display_mode' );
		
		$html .= '
		<div class="pgm_portfolio_display_mode_settings">
			<label for="pgm_display_min_width">Min width of each portfolio gallery item:</label>
			<input type="number" min="0" class="pgm_portfolio_display_mode_input" id="pgm_display_min_width" name="pgm_display_min_width" value="' . get_option('pgm_display_min_width') .'"' . ( $mode != 3 ? 'disabled="disabled"' : '' ) . ' />
		</div>
		';
		echo $html;
	}
	public function callback_pgm_display_mode_max_width( $options ){
		$mode = get_option( 'pgm_portfolio_display_mode' );
		
		$html .= '
		<div class="pgm_portfolio_display_mode_settings">
			<label for="pgm_display_max_width">Max width of each portfolio gallery item:</label> 
			<input type="number" min="0" class="pgm_portfolio_display_mode_input" id="pgm_display_max_width" name="pgm_display_max_width" value="' . get_option('pgm_display_max_width') .'" ' . ( $mode != 3 ? 'disabled="disabled"' : '' ) . ' />
		</div>
		';
		echo $html;
	}

	//Sanitization
	public function sanitize_text_input( $input ) {
		return sanitize_text_field( $input );
	}
	public function sanitize_number_input( $input ) {
		if ( !empty( $input ) ){
			$input = sanitize_text_field( $input );
			$input = intval( $input );
			if ( $input < 0 ) {
				$input = $input * -1;
			}
		} 	
		return $input;
	}
}
