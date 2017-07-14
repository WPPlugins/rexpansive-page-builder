<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.neweb.info/
 * @since      1.0.0
 *
 * @package    Rexpansive_Builder_Test
 * @subpackage Rexpansive_Builder_Test/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rexpansive_Builder_Test
 * @subpackage Rexpansive_Builder_Test/admin
 * @author     http://rexpansive.neweb.info/ <info@neweb.info>
 */
class Rexpansive_Builder_Test_Admin {

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

		$this->plugin_options = get_option( $this->plugin_name . '_options' );

		if( isset( $this->plugin_options['post_types'] ) ) :
			$post_to_activate = $this->plugin_options['post_types'];

			// Call the construction of the metabox
			require_once plugin_dir_path( __FILE__ ) . '/class-rexpansive-builder-test-meta-box.php';

			foreach( $post_to_activate as $key => $value ) :

				if( 1 == $value ) :

					$page_builder = new Rexpansive_Builder_Test_Meta_Box( 
						$this->plugin_name,
						'rexbuilder', 
						'Rexpansive Builder <a class="rex-premium-button" href="http://rexpansive.neweb.info/" target="_blank">Get Premium</a>',
						$key, 
						'normal', 
						'high',
						'rexpansive-builder rexbuilder-materialize-wrap'
					);

					$page_builder->add_fields( array(
						array(
							'id' => '_rexbuilder_active',
							'type' => 'hidden_field',
							'default' => 'true',
						),
						array(
							'label' => 'Rexbuilder Header',
							'desc'	=>	'',
							'id'	=>	'_rexbuilder_custom_css',
							'type'	=>	'rexbuilder_header'
						),
						array(
							'label' => 'Rexbuilder',
							'desc' => 'Expand your mind',
							'id' => '_rexbuilder',
							'type'	=>	'rexpansive_plugin',
						),
					) );

				endif;

			endforeach;

		endif;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rexpansive_Builder_Test_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rexpansive_Builder_Test_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :
			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
					wp_enqueue_style( 'material-design-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $this->version, 'all' );
					wp_enqueue_style( 'materialize', plugin_dir_url( __FILE__ ) . 'css/materialize.min.css', array(), $this->version, 'all' );
					
					wp_enqueue_style( 'spectrum-style', plugin_dir_url( __FILE__ ) . 'spectrum/spectrum.css', array(), $this->version, 'all' );

					wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'font-awesome-4.3.0/css/font-awesome.min.css', array(), $this->version, 'all' );
					wp_enqueue_style( 'rex-custom-fonts', plugin_dir_url( __FILE__ ) . 'rexpansive-font/font.css', array(), $this->version, 'all' );

					wp_enqueue_style( 'gridster-style', plugin_dir_url( __FILE__ ) . 'css/jquery.gridster.css', array(), $this->version, 'all' );
					wp_enqueue_style( 'custom-editor-buttons-style', plugin_dir_url( __FILE__ ) . 'css/rex-custom-editor-buttons.css', array(), $this->version, 'all' );
					wp_enqueue_style( 'rexbuilder-style', plugin_dir_url( __FILE__ ) . 'css/builder.css', array(), $this->version, 'all' );
				endif;
			endif;
		endif;

	}

	/**
	 * Register the stylesheets for the admin area for production version
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles_production( $hook ) {
		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :
			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
					wp_enqueue_style( 'material-design-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $this->version, 'all' );

					wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'font-awesome-4.3.0/css/font-awesome.min.css', array(), $this->version, 'all' );
					wp_enqueue_style( 'rex-custom-fonts', plugin_dir_url( __FILE__ ) . 'rexpansive-font/font.css', array(), $this->version, 'all' );

					wp_enqueue_style( 'admin-style', plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );
				endif;
			endif;
		endif;
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rexpansive_Builder_Test_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rexpansive_Builder_Test_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Retrieve the page information
		// Get current screen works only from 3.1, but allows me to retrieve more specific information
		// compared to the $hook.
		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :

			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
					wp_enqueue_media();
					wp_enqueue_script('jquery');
					wp_enqueue_script("jquery-ui-draggable");

					wp_enqueue_script( 'materialize-scripts', plugin_dir_url( __FILE__ ) . 'materialize/js/materialize.js', array('jquery'), $this->version, true );
					wp_enqueue_script( 'gridster', plugin_dir_url( __FILE__ ) . 'js/jquery.gridster.js', array('jquery'),  $this->version, true );
					
					wp_enqueue_script( 'spectrum-scripts', plugin_dir_url( __FILE__ ) . 'spectrum/spectrum.js', array('jquery'),  $this->version, true );

					wp_enqueue_script( 'ace-scripts', plugin_dir_url( __FILE__ ) . 'ace/src-min-noconflict/ace.js', array('jquery'),  $this->version, true );
					wp_enqueue_script( 'ace-mode-css-scripts', plugin_dir_url( __FILE__ ) . 'ace/src-min-noconflict/mode-css.js', array('jquery'),  $this->version, true );

					wp_enqueue_script( 'rexbuilder', plugin_dir_url( __FILE__ ) . 'js/rexbuilder.js', array('jquery'),  $this->version, true );
					wp_localize_script( 'rexbuilder', '_plugin_backend_settings', array(
						'activate_builder'	=>	'true',
					) );
					wp_enqueue_script( 'rexbuilder-admin', plugin_dir_url( __FILE__ ) . 'js/rexpansive-builder-test-admin.js', array( 'jquery' ), $this->version, true );
				endif;
			endif;
		endif;

	}

	/**
	 * Register the JavaScript for the admin area for production version
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts_production( $hook ) {
		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :

			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
					wp_enqueue_media();
					wp_enqueue_script('jquery');
					wp_enqueue_script("jquery-ui-draggable");

					wp_enqueue_script( 'ace-scripts', plugin_dir_url( __FILE__ ) . 'ace/src-min-noconflict/ace.js', array('jquery'),  $this->version, true );
					wp_enqueue_script( 'ace-mode-css-scripts', plugin_dir_url( __FILE__ ) . 'ace/src-min-noconflict/mode-css.js', array('jquery'),  $this->version, true );

					wp_enqueue_script( 'admin-plugins', plugin_dir_url( __FILE__ ) . 'js/plugins.js', array('jquery'),  $this->version, true );
					wp_localize_script( 'admin-plugins', '_plugin_backend_settings', array(
						'activate_builder'	=>	'true',
					) );
					wp_enqueue_script( 'rexbuilder-admin', plugin_dir_url( __FILE__ ) . 'js/rexpansive-builder-test-admin.js', array( 'jquery' ), $this->version, true );
				endif;
			endif;
		endif;
	}

	/**
	 *	Register the administration menu for the plugin.
	 *
	 * 	@since    1.0.0
	 */
	public function add_plugin_options_menu() {
		add_menu_page( 'Rexpansive Builder', 'Rexpansive Builder', 'manage_options', $this->plugin_name, array( $this, 'display_plugin_options_page' ), plugin_dir_url( __FILE__ ) . 'img/favicon.ico', '80.5' );
	}

	/**
	 *	Add settings action link to the plugin page.
	 *
	 * 	@since    1.0.0
	 */
	public function add_action_links( $links ) {
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>',
		);
		return array_merge( $settings_link, $links );
	}

	/**
	 *	Render the settings page for the plugin
	 *
	 * 	@since    1.0.0
	 */
	public function display_plugin_options_page() {
		include_once( 'partials/rexpansive-builder-test-admin-display.php' );
	}

	/**
	 *	Validate the plugin settings
	 *
	 * 	@since    1.0.0
	 */
	public function plugin_options_validate( $input ) {
		$valid = array();

		foreach( $input['post_types'] as $key => $value ) :
			$valid['post_types'][$key] = ( isset( $value ) && !empty( $value ) ) ? 1 : 0;
		endforeach;

		//$valid['post_types'] = $input['post_types'];
		$valid['animation'] = ( isset( $input['animation'] ) && !empty( $input['animation'] ) ) ? 1 : 0;

		return $valid;
	}

	/**
	 *	Update the plugin settings
	 *
	 * 	@since    1.0.0
	 */
	public function plugin_options_update() {
		//register_setting( $this->plugin_name, $this->plugin_name, array( $this, 'plugin_options_validate' ) );
		register_setting( $this->plugin_name . '_options', $this->plugin_name . '_options', array( $this, 'plugin_options_validate' ) );
	}

	/**
	 *	Add notifier update page
	 *
	 *	@since	1.0.3
	 */
	public function update_notifier_menu() {  
		$xml = $this->get_latest_theme_version(21600); // This tells the function to cache the remote call for 21600 seconds (6 hours)
		
		$theme_data = get_plugin_data( WP_PLUGIN_DIR . '/rexpansive-page-builder/rexpansive-page-builder.php' ); // Get theme data from style.css (current version is what we want)
		
		if(version_compare($theme_data['Version'], $xml->latest) == -1) {
			add_dashboard_page( $theme_data['Name'] . 'Plugin Updates', $theme_data['Name'] . '<span class="update-plugins count-1"><span class="update-count">Updates</span></span>', 'administrator', strtolower($theme_data['Name']) . '-updates', array( $this, 'update_notifier' ) );
		}
	}

	/**
	 *	Render the page
	 */
	public function update_notifier() { 
		$xml = $this->get_latest_theme_version(21600); // This tells the function to cache the remote call for 21600 seconds (6 hours)
		$theme_data = get_plugin_data( WP_PLUGIN_DIR . '/rexpansive-page-builder/rexpansive-page-builder.php' ) // Get theme data from style.css (current version is what we want) ?>

		<div class="wrap">
		
			<div id="icon-tools" class="icon32"></div>
			<h2><?php echo $theme_data['Name']; ?> Plugin Updates</h2>
		    <div id="message" class="updated below-h2"><p><strong>There is a new version of the <?php echo $theme_data['Name']; ?> plugin available.</strong> You have version <?php echo $theme_data['Version']; ?> installed. Update to version <?php echo $xml->latest; ?>.</p></div>
	        
	        <a href="https://rexpansive.neweb.info/download/1450/" class="update-notify-link" title="Update" style="background-image:url(<?php echo WP_PLUGIN_DIR . '/rexpansive-page-builder/screenshot.png'; ?>);">
	        	<h2>Version <?php echo $xml->latest; ?></h2>
	        	Download this update
	    		<?php 
	    			// echo do_shortcode( '[rexArrow type="download" target="_self" color="#ffffff" link="http://rexpansive.neweb.info/download/1450/" isinsidelink="true"]Download this update[/rexArrow]' ); 
	    		?>
	        </a>
	        <!-- <img style="float: left; margin: 0 20px 20px 0; border: 1px solid #ddd;" src="<?php echo WP_PLUGIN_DIR . '/rexpansive-builder-test/screenshot.png'; ?>" /> -->
	        
	        <div id="instructions" style="max-width: 800px;">
	            <h3>Update Download and Instructions</h3>
	            <p><strong>Please note:</strong> make a <strong>backup</strong> of the Plugin inside your WordPress installation folder <strong>/wp-content/plugins/<?php echo strtolower($theme_data['Name']); ?>/</strong></p>
	            <p>To update the Plugin, login to your account, head over to your <strong>downloads</strong> section and re-download the plugin like you did when you bought it.</p>
	            <p>Extract the zip's contents, look for the extracted plugin folder, and after you have all the new files upload them using FTP to the <strong>/wp-content/plugins/<?php echo strtolower($theme_data['Name']); ?>/</strong> folder overwriting the old ones (this is why it's important to backup any changes you've made to the plugin files).</p>
	            <p>If you didn't make any changes to the plugin files, you are free to overwrite them with the new ones without the risk of losing plugin settings, pages, posts, etc, and backwards compatibility is guaranteed.</p>
	        </div>
	        
	            <div class="clear"></div>
		    
		    <h3 class="title">Changelog</h3>
		    <?php echo $xml->changelog; ?>

		</div>
	    
	<?php }

	// This function retrieves a remote xml file on my server to see if there's a new update 
	// For performance reasons this function caches the xml content in the database for XX seconds ($interval variable)
	public function get_latest_theme_version($interval) {
		// remote xml file location
		$notifier_file_url = 'https://rexpansive.neweb.info/notifier-builder-free.xml';
		
		$db_cache_field = 'rexpansive-builder-free-notifier-cache';
		$db_cache_field_last_updated = 'rexpansive-builder-free-notifier-last-updated';
		$last = get_option( $db_cache_field_last_updated );
		$now = time();
		// check the cache
		if ( !$last || (( $now - $last ) > $interval) ) {
			// cache doesn't exist, or is old, so refresh it
			if( function_exists('curl_init') ) { // if cURL is available, use it...
				$ch = curl_init($notifier_file_url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				$cache = curl_exec($ch);
				curl_close($ch);
			} else {
				$cache = file_get_contents($notifier_file_url); // ...if not, use the common file_get_contents()
			}
			
			if ($cache) {			
				// we got good results
				update_option( $db_cache_field, $cache );
				update_option( $db_cache_field_last_updated, time() );			
			}
			// read from the cache file
			$notifier_data = get_option( $db_cache_field );
		}
		else {
			// cache file is fresh enough, so read from it
			$notifier_data = get_option( $db_cache_field );
		}
		
		$xml = simplexml_load_string($notifier_data); 
		
		return $xml;
	}

	/**
	 *	Add a swtich button under the post title/permalink to activate/deactivate the builder
	 *
	 * 	@since    1.0.0
	 */
	public function add_switch_under_post_title() {
		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :

			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
	?>
		<div class="builder-heading rexpansive-builder rexbuilder-materialize-wrap">
			<img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/rexpansive-builder.png" alt="logo" width="260" />
			<div class="builder-switch-wrap">
				<div class="switch">
					<label>
						<input type="checkbox" id="builder-switch" checked />
						<span class="lever"></span>
					</label>
				</div>
			</div>
		</div>
	<?php
				endif;
			endif;
		endif;
	}

	/**
	 * Create the variuos modal editors of the builder.
	 *
	 * @since    1.0.0
	 */
	public function create_builder_modals() {
		$page_info = get_current_screen();

		if ( !current_user_can('edit_posts') &&  !current_user_can('edit_pages') ) { 
			return; 
		}
		if( !isset( $this->plugin_options['post_types'] ) ) {
			return;
		}
		if ( get_user_option('rich_editing') == 'true') { 
			$post_to_activate = $this->plugin_options['post_types'];
			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
						include_once( 'partials/rexpansive-builder-test-modals-display.php' );
				endif;
			endif;
		}
	}

	/**
	 * Create the templates for the builder used by the scripts.
	 *
	 * @since    1.0.0
	 */
	public function create_builder_templates() {
		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :

			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
						include_once( 'partials/rexpansive-builder-test-templates.php' );
				endif;
			endif;
		endif;
	}

	/**
	 * Function that adds the scripts for the handle of the custom buttons.
	 *
	 * @since    1.0.0
	 */
	public function rexbuilder_add_tinymce_plugin( $plugin_array ) {
		$plugin_array['rexbuilder_textfill_button'] = plugin_dir_url( __FILE__ ) . 'js/textfill-button.js';
		//$plugin_array['rexbuilder_animation_button'] = plugin_dir_url( __FILE__ ) . 'js/animation-button.js';
		$plugin_array['rexbuilder_embed_video_button'] = plugin_dir_url( __FILE__ ) . 'js/embed-video.js';
		return $plugin_array;
	}

	/**
	 * Function that registers the new custom buttons.
	 *
	 * @since    1.0.0
	 */
	public function rexbuilder_register_custom_buttons( $buttons ) {
		array_push( $buttons, 'rexbuilder_textfill_button' );
		//array_push( $buttons, 'rexbuilder_animation_button' );
		array_push( $buttons, 'rexbuilder_embed_video_button' );
		return $buttons;
	}


	function rexbuilder_add_custom_buttons() {
		global $typenow;

		if ( !current_user_can('edit_posts') &&  !current_user_can('edit_pages') ) { 
			return; 
		}
		if( !isset( $this->plugin_options['post_types'] ) ) {
			return;
		}
		if( ! array_key_exists( $typenow, $this->plugin_options['post_types'] ) ) {
			return;
		}
		if ( get_user_option('rich_editing') == 'true') { 
			add_filter('mce_external_plugins', array( $this, 'rexbuilder_add_tinymce_plugin' ) ); 
			add_filter('mce_buttons', array( $this, 'rexbuilder_register_custom_buttons' ) ); 
		}
	}

	/**
	 *
	 *	Add link to Rexpansive site
	 */
	function rexbuilder_custom_admin_menu_button($wp_admin_bar){
		$args = array(
			'id' => 'custom-button',
			'title' => 'Get Rexpansive Builder Premium',
			'href' => 'http://rexpansive.neweb.info/',
			'meta' => array(
				'class' => 'rex-premium-button',
				'target' => '_blank',
			)
		);
		$wp_admin_bar->add_node($args);
	}

	/**
	 *	Customize the top button
	 */
	public function rexbuilder_custom_admin_menu_button_style() {
		echo '<style>.rex-premium-button{background-color:#f05 !important;transition: 0.3s !important;}.rex-premium-button:hover a{background-color:#000!important;color:#fff !important;}</style>';
	}

}
