<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://icanwp.com
 * @since      1.0.0
 *
 * @package    Portfolio_Gallery_Master
 * @subpackage Portfolio_Gallery_Master/public
 */

/**
 * The public-facing functionality of the plugin.
 * @package    Portfolio_Gallery_Master
 * @subpackage Portfolio_Gallery_Master/public
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class Portfolio_Gallery_Master_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . '-pgm-public-css', plugin_dir_url( __FILE__ ) . 'css/portfolio-gallery-master-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name . '-pgm-public-js' , plugin_dir_url( __FILE__ ) . 'js/portfolio-gallery-master-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-pgm-public-hoverdir-js', plugin_dir_url( __FILE__ ) . 'js/jquery.hoverdir.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-pgm-public-modernizer-js', plugin_dir_url( __FILE__ ) . 'js/modernizr.custom.97074.js', array( 'jquery' ), $this->version, false );
		$pgm_loc = array(
			'pgm_display_mode' => get_option( 'pgm_portfolio_display_mode' ),
			'pgm_per_row'=> get_option( 'pgm_display_per_row' ),
			'pgm_min_width' => get_option( 'pgm_display_min_width' ),
			'pgm_max_width' => get_option( 'pgm_display_max_width' ),
			'pgm_init_width' => get_option( 'pgm_portfolio_initial_width' ),
			'pgm_init_height' => get_option( 'pgm_portfolio_initial_height' ),
			'pgm_margin' => get_option( 'pgm_portfolio_margin' ),
			'pgm_padding' => get_option( 'pgm_portfolio_padding' )
		);
		wp_localize_script( $this->plugin_name . '-pgm-public-js', 'pgm_loc', $pgm_loc );
	}

	public function pgm_register_shortcode(){
		add_shortcode( 'show-portfolio-gallery', array( $this, 'pgm_public_display'));
	}
	public function pgm_public_display(){
	
		$html = '<div class="pgm-portfolio-container"><ul class="pgm-portfolio-list">';
		$args = array(
			'post_type' => 'pgm-portfolio'
		);
		
		$pgm_query = null;
		$pgm_query = new WP_Query($args);
		
		//When there are is any portfolio it outputs the result
		if( $pgm_query->have_posts() ) {
			$thumb_x = intval( get_option( 'pgm_portfolio_initial_width' ) );
			$thumb_y = intval( get_option( 'pgm_portfolio_initial_height' ) );
			$thumb_min_width = intval( get_option( 'pgm_display_min_width' ) );
			$thumb_max_width = intval( get_option( 'pgm_display_max_width' ) );
			$pgm_margin = intval( get_option( 'pgm_portfolio_margin' ) );
			$pgm_padding = intval( get_option( 'pgm_portfolio_padding' ) );
			
			$pgm_disable_link = intval( get_option( 'pgm_disable_post_link' ) );
			$pgm_disable_hover_display = intval( get_option( 'pgm_disable_hover_display' ) );
			$pgm_display_mode = intval( get_option( 'pgm_portfolio_display_mode' ) );
			
			
			
			//If no value is specified for width, height, padding, and margin, use the following default.
			if( empty($thumb_x) ){
				$thumb_x = 250;
			}
			if( empty($thumb_y) ){
				$thumb_y = 250;
			}
			if( empty($pgm_margin) && $pgm_margin !== 0 ){
				$pgm_margin = 1;
			}
			if( empty($pgm_padding) && $pgm_padding !== 0 ){
				$pgm_padding = 1;
			}

			$thumb_margin = $thumb_x * $pgm_margin / 100;
			$thumb_padding = $thumb_x * $pgm_padding / 100;
			$pgm_display_width = $thumb_x;
			$pgm_display_height = $thumb_y;
			
			
			//Calculate actual width and height to use in row mode
			if( $pgm_display_mode === 3 ){
				if( $thumb_x < $thumb_min_width ){
					$pgm_display_width = $thumb_min_width;
					$pgm_display_height = $thumb_y / $thumb_x * $pgm_display_width;
				} elseif( $thumb_x > $thumb_max_width ){
					$pgm_display_width = $thumb_max_width;
					$pgm_display_height = $thumb_y / $thumb_x * $pgm_display_width;
				} 
			}
			
			while ($pgm_query->have_posts()) : $pgm_query->the_post();
				if( has_post_thumbnail() ){
					$pgm_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array( $thumb_x, $thumb_y ), false );
					$pgm_thumb_src = $pgm_thumb[0];
				} else {
					$pgm_thumb_src = plugin_dir_url( __FILE__ ) . 'assets/pgm-placeholder.jpg';
				}

				$html .= '
				<li class="pgm-portfolio-list-item" style="' . ( $pgm_display_mode === 1 ? 'width:' . $pgm_display_width .'px;height:' . $pgm_display_height .'px;' : '') . ';margin:' . $thumb_margin . 'px;padding:' . $thumb_padding . 'px;background:' . get_option( 'pgm_portfolio_frame_color' ) . ';">
					<a href="' . ( $pgm_disable_link === 1 ? '#' : get_permalink() ) . '" class="pgm-portfolio-list-item-link" style="background-image:url(' . $pgm_thumb_src . ');background-repeat: no-repeat;background-size:cover;' . ( $pgm_disable_link === 1 ? 'pointer-events: none;cursor: default;' : '' )  . '">';
				if ( $pgm_disable_hover_display !== 1 ){	
					$html .= '
						<div class="pgm-portfolio-list-item-desc" style="background:' . get_option( 'pgm_portfolio_overlay_color' ) . ';">
							<div class="pgm-portfolio-title-container">
								<div class="pgm-portfolio-title-header"></div>
								<span style="color:' . get_option( 'pgm_portfolio_overlay_font_color' ) . ';">' . get_the_title() . '</span>
								<div class="pgm-portfolio-title-footer"></div>
							</div>	
						</div>
					';
				}
				$html .='
					</a>
				</li>				
				';
			endwhile;
		}
		
		$html .= '</ul></div>';
		
		return $html;
	}
}
