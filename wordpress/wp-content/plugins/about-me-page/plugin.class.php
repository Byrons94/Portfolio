<?php

class WCP_Options_About_Me {

	public function __construct(){
		add_action( 'admin_menu', array($this,'wcp_about_me_page_admin') );
		add_action( 'admin_enqueue_scripts', array($this,'wcp_enqueue_script_media_uploader') );
		add_action( 'wp_ajax_wcp_save_all_pages', array($this,'save_all_pages') );
		add_shortcode( 'about-me', array($this, 'wcp_about_me_render_template') );
	}

	public function wcp_about_me_page_admin(){

		add_menu_page('About Me Page','About Me','manage_options', 'about_me_page' ,array($this,'display_options_page'), 'dashicons-admin-users');

	}


	public function display_options_page(){
		$allPages = get_option('wcp_about_me_page');
		?>
			<div class="wrap" id="about-me">
				<h2><?php _e( 'About Me Page', 'about-me-page' ); ?> <a title="<?php _e( 'Need Help', 'about-me-page' ); ?>?" target="_blank" href="http://webcodingplace.com/about-me-page-wordpress-plugin/"><span class="dashicons dashicons-editor-help"></span></a></h2>
				<?php if (isset($allPages) && $allPages != '') { ?>
				<div id="accordion">
					<?php foreach ($allPages as $page) { ?>
			  		<h3 class="tab-head"><?php echo $page['abname']; ?></h3>
			  		<div class="tab-content">
			  			<table class="form-table">
			  				<tr>
			  					<th><?php _e( 'Name', 'about-me-page' ); ?></th>
			  					<td>
			  						<input type="text" class="widefat abname" value="<?php echo $page['abname']; ?>" />
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Full Name of Person', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Picture', 'about-me-page' ); ?></th>
			  					<td>
			  						<input type="text" class="regular-text abpicture" value="<?php echo $page['abpicture']; ?>">
			  						<button class="button upload_image_button"><?php _e( 'Media', 'about-me-page' ); ?></button>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Paste URL or use Media', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Description', 'about-me-page' ); ?></th>
			  					<td>
			  						<textarea rows="3" class="widefat abdesc"><?php echo stripslashes($page['abdesc']); ?></textarea>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'You can use HTML tags here', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Services Title', 'about-me-page' ); ?></th>
			  					<td>
			  						<input type="text" class="widefat abservice" value="<?php echo $page['abservice']; ?>">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Services title text', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Skills Title', 'about-me-page' ); ?></th>
			  					<td>
			  						<input type="text" class="widefat abskill" value="<?php echo $page['abskill']; ?>">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Skills title text', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Services', 'about-me-page' ); ?></th>
			  					<td>
			  						<textarea rows="3" class="widefat abservices"><?php echo $page['abservices']; ?></textarea>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Names of services, each per line. Example: SEO Expert', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Skills', 'about-me-page' ); ?></th>
			  					<td>
			  						<textarea rows="3" class="widefat abskills"><?php echo $page['abskills']; ?></textarea>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Names of skills, each per line with value. Example: HTML,95', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Color Scheme', 'about-me-page' ); ?></th>
			  					<td>
									<select class="abskin widefat">
										<option value='default' <?php selected( $page['abskin'], 'default' ); ?>><?php _e( 'Default', 'about-me-page' ); ?></option>
										<option value='primary' <?php selected( $page['abskin'], 'primary' ); ?>><?php _e( 'Dark blue', 'about-me-page' ); ?></option>
										<option value='info' <?php selected( $page['abskin'], 'info' ); ?>><?php _e( 'Light blue', 'about-me-page' ); ?></option>
										<option value='warning' <?php selected( $page['abskin'], 'warning' ); ?>><?php _e( 'Orange', 'about-me-page' ); ?></option>
										<option value='danger' <?php selected( $page['abskin'], 'danger' ); ?>><?php _e( 'Red', 'about-me-page' ); ?></option>
										<option value='success' <?php selected( $page['abskin'], 'success' ); ?>><?php _e( 'Green', 'about-me-page' ); ?></option>
									</select>			  						
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Select Color Scheme', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  			</table>
						<div class="clearfix"></div>
						<hr style="margin-bottom: 10px;">
						<button class="button btndelete"><span class="dashicons dashicons-dismiss" title="Delete"></span><?php _e( 'Delete', 'about-me-page' ); ?></button>
						<button class="button btnadd"><span title="Add New" class="dashicons dashicons-plus-alt"></span><?php _e( 'Add New Page', 'about-me-page' ); ?></button>&nbsp;
						<p class="wcp-shortc"><button class="button-primary fullshortcode" id="<?php echo $page['counter']; ?>"><?php _e( 'Get Shortcode', 'about-me-page' ); ?></button></p>
						<div class="clearfix"></div>
					</div>
					<?php } ?>
				</div>

				<?php } else { ?>
				<div id="accordion">
			  		<h3 class="tab-head">About Me Page</h3>
			  		<div class="tab-content">
			  			<table class="form-table">
			  				<tr>
			  					<th><?php _e( 'Name', 'about-me-page' ); ?></th>
			  					<td>
			  						<input type="text" class="widefat abname" />
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Full Name of Person', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Picture', 'about-me-page' ); ?></th>
			  					<td>
			  						<input type="text" class="regular-text abpicture">
			  						<button class="button upload_image_button"><?php _e( 'Media', 'about-me-page' ); ?></button>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Paste URL or use Media', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Description', 'about-me-page' ); ?></th>
			  					<td>
			  						<textarea rows="3" class="widefat abdesc"></textarea>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'You can use HTML tags here', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Services Title', 'about-me-page' ); ?></th>
			  					<td>
			  						<input type="text" class="widefat abservice">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Services title text', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Skills Title', 'about-me-page' ); ?></th>
			  					<td>
			  						<input type="text" class="widefat abskill">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Skills title text', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Services', 'about-me-page' ); ?></th>
			  					<td>
			  						<textarea rows="3" class="widefat abservices"></textarea>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Names of services, each per line. Example: SEO Expert', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Skills', 'about-me-page' ); ?></th>
			  					<td>
			  						<textarea rows="3" class="widefat abskills"></textarea>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Names of skills, each per line with value. Example: HTML,95', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<th><?php _e( 'Color Scheme', 'about-me-page' ); ?></th>
			  					<td>
									<select class="abskin widefat">
										<option value='default'><?php _e( 'Default', 'about-me-page' ); ?></option>
										<option value='primary'><?php _e( 'Dark blue', 'about-me-page' ); ?></option>
										<option value='info'><?php _e( 'Light blue', 'about-me-page' ); ?></option>
										<option value='warning'><?php _e( 'Orange', 'about-me-page' ); ?></option>
										<option value='danger'><?php _e( 'Red', 'about-me-page' ); ?></option>
										<option value='success'><?php _e( 'Green', 'about-me-page' ); ?></option>
									</select>			  						
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Select Color Scheme', 'about-me-page' ); ?>.</p>
			  					</td>
			  				</tr>
			  			</table>
						<div class="clearfix"></div>
						<hr style="margin-bottom: 10px;">
						<button class="button btndelete"><span class="dashicons dashicons-dismiss" title="Delete"></span><?php _e( 'Delete', 'about-me-page' ); ?></button>
						<button class="button btnadd"><span title="Add New" class="dashicons dashicons-plus-alt"></span><?php _e( 'Add New Page', 'about-me-page' ); ?></button>&nbsp;
						<p class="wcp-shortc"><button class="button-primary fullshortcode" id="1"><?php _e( 'Get Shortcode', 'about-me-page' ); ?></button></p>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php } ?>

				<hr style="clear: both;">
				<button class="button-primary save-pages"><?php _e( 'Save Changes', 'about-me-page' ); ?></button>
				<span id="wcp-loader"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>images/ajax-loader.gif"></span>
				<span id="wcp-saved"><strong><?php _e( 'Changes Saved', 'about-me-page' ); ?>!</strong></span>					
			</div>
			<?php
		
	}
	

	/*
	*	Script for Media uploader
	 */
	function wcp_enqueue_script_media_uploader($slug){
		if ($slug == 'toplevel_page_about_me_page') {
			wp_enqueue_media();
			wp_enqueue_style( 'dashicons' );
			wp_enqueue_script( 'about-me-page-js', plugins_url( 'admin/script.js' , __FILE__ ), array('jquery', 'jquery-ui-accordion') );
			wp_enqueue_style( 'about-me-page-css', plugins_url( 'admin/style.css' , __FILE__ ));
			wp_localize_script( 'about-me-page-js', 'wcpAjax', array( 'url' => admin_url( 'admin-ajax.php' ), 'path' => plugin_dir_url( __FILE__ )));
		}
	}

	function save_all_pages(){
		update_option( 'wcp_about_me_page', $_REQUEST['pages'] );
	}


	function wcp_about_me_render_template($atts, $content, $the_shortcode){
		$allPages = get_option('wcp_about_me_page');
		if (isset($allPages) && is_array($allPages)) {
			foreach ($allPages as $page) {
				if ($atts['id'] == $page['counter']) {
					ob_start();
					wp_enqueue_style( 'bs-styles', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css' );
					wp_enqueue_script( 'custom-js-bs', plugin_dir_url( __FILE__ ) . 'js/script.js', array('jquery') );
					?>
					<style>
						.progress-bar {
						    -webkit-transition: width 5s !important;
						    transition: width 5s !important;
						    -moz-transition: width 5s !important;
						}
					</style>
					<div class="about-me-page-container">
						<div class="row">
							<div class="col-sm-4">
								<div class="thumbnail about-me-page-thumb">
									<img src="<?php echo $page['abpicture']; ?>" alt="<?php echo $page['abname']; ?>">
								</div>
							</div>
							<div class="col-sm-8">
								<div class="panel panel-<?php echo $page['abskin']; ?>">
								  <div class="panel-heading">
								    <h3 class="panel-title about-me-page-title"><?php echo $page['abname']; ?></h3>
								  </div>
								  <div class="panel-body about-me-page-bio">
									<p><?php echo stripslashes($page['abdesc']); ?></p>
								  </div>
								</div>	
							</div>
						</div>
						<div class="row">
						<?php if ($page['abservices'] != '') { ?>
							<div class="col-sm-6">
								<div class="panel panel-<?php echo $page['abskin']; ?>">
								  <div class="panel-heading">
								    <h3 class="panel-title"><?php echo $page['abservice']; ?></h3>
								  </div>
								  <div class="panel-body">
									<ul class="list-group" style="margin-left: 0 !important;">
										<?php $allServices = explode("\n", $page['abservices']);
										foreach ($allServices as $service) { ?>
											<li class="list-group-item text-<?php echo $page['abskin']; ?>"><?php echo $service; ?></li>
										<?php } ?>
									</ul>				    
								  </div>
								</div>				
							</div>
							<?php } ?>

							<?php if ($page['abskills'] != '') { ?>
							<div class="col-sm-6">
								<div class="panel panel-<?php echo $page['abskin']; ?>">
								  <div class="panel-heading">
								    <h3 class="panel-title"><?php echo $page['abskill']; ?></h3>
								  </div>
								  <div class="panel-body">
									<?php $allSkills = explode("\n", $page['abskills']);
									foreach ($allSkills as $skill) { 
									$oneSkill = explode(',', $skill); ?>
								  		<div class="progress">
										  <div class="progress-bar progress-bar-striped active progress-bar-<?php echo $page['abskin']; ?>" data-level="<?php echo $oneSkill[1]; ?>">
										    <?php echo $oneSkill[0]; ?> - <?php echo $oneSkill[1]; ?>%
										  </div>
										</div>
									<?php } ?>			    
								  </div>
								</div>				
							</div>
							<?php } ?>
						</div>
					</div>
						
					<?php

					return ob_get_clean();
				}
			}
		}

	}
}

?>