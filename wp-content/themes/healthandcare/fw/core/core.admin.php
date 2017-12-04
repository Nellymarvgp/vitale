<?php
/**
 * HealthandCARE Framework: Admin functions
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Admin actions and filters:
------------------------------------------------------------------------ */

if (is_admin()) {

	/* Theme setup section
	-------------------------------------------------------------------- */
	
	if ( !function_exists( 'healthandcare_admin_theme_setup' ) ) {
		add_action( 'healthandcare_action_before_init_theme', 'healthandcare_admin_theme_setup', 11 );
		function healthandcare_admin_theme_setup() {
			if ( is_admin() ) {
				add_action("admin_head",			'healthandcare_admin_prepare_scripts');
				add_action("admin_enqueue_scripts",	'healthandcare_admin_load_scripts');
				add_action('tgmpa_register',		'healthandcare_admin_register_plugins');

				// AJAX: Get terms for specified post type
				add_action('wp_ajax_healthandcare_admin_change_post_type', 		'healthandcare_callback_admin_change_post_type');
				add_action('wp_ajax_nopriv_healthandcare_admin_change_post_type','healthandcare_callback_admin_change_post_type');
			}
		}
	}
	
	// Load required styles and scripts for admin mode
	if ( !function_exists( 'healthandcare_admin_load_scripts' ) ) {
		//add_action("admin_enqueue_scripts", 'healthandcare_admin_load_scripts');
		function healthandcare_admin_load_scripts() {
			healthandcare_enqueue_script( 'healthandcare-debug-script', healthandcare_get_file_url('js/core.debug.js'), array('jquery'), null, true );
			//if (healthandcare_options_is_used()) {
				healthandcare_enqueue_style( 'healthandcare-admin-style', healthandcare_get_file_url('css/core.admin.css'), array(), null );
				healthandcare_enqueue_script( 'healthandcare-admin-script', healthandcare_get_file_url('js/core.admin.js'), array('jquery'), null, true );
			//}
			if (healthandcare_strpos($_SERVER['REQUEST_URI'], 'widgets.php')!==false) {
				healthandcare_enqueue_style( 'healthandcare-fontello-style', healthandcare_get_file_url('css/fontello-admin/css/fontello-admin.css'), array(), null );
				healthandcare_enqueue_style( 'healthandcare-animations-style', healthandcare_get_file_url('css/fontello-admin/css/animation.css'), array(), null );
			}
		}
	}
	
	// Prepare required styles and scripts for admin mode
	if ( !function_exists( 'healthandcare_admin_prepare_scripts' ) ) {
		//add_action("admin_head", 'healthandcare_admin_prepare_scripts');
		function healthandcare_admin_prepare_scripts() {
			?>
			<script>
				if (typeof HEALTHANDCARE_GLOBALS == 'undefined') var HEALTHANDCARE_GLOBALS = {};
				jQuery(document).ready(function() {
					HEALTHANDCARE_GLOBALS['admin_mode']	= true;
					HEALTHANDCARE_GLOBALS['ajax_nonce'] 	= "<?php echo wp_create_nonce('ajax_nonce'); ?>";
					HEALTHANDCARE_GLOBALS['ajax_url']	= "<?php echo admin_url('admin-ajax.php'); ?>";
					HEALTHANDCARE_GLOBALS['user_logged_in'] = true;
				});
			</script>
			<?php
		}
	}
	
	// AJAX: Get terms for specified post type
	if ( !function_exists( 'healthandcare_callback_admin_change_post_type' ) ) {
		//add_action('wp_ajax_healthandcare_admin_change_post_type', 		'healthandcare_callback_admin_change_post_type');
		//add_action('wp_ajax_nopriv_healthandcare_admin_change_post_type',	'healthandcare_callback_admin_change_post_type');
		function healthandcare_callback_admin_change_post_type() {
			if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) )
				die();
			$post_type = $_REQUEST['post_type'];
			$terms = healthandcare_get_list_terms(false, healthandcare_get_taxonomy_categories_by_post_type($post_type));
			$terms = healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $terms);
			$response = array(
				'error' => '',
				'data' => array(
					'ids' => array_keys($terms),
					'titles' => array_values($terms)
				)
			);
			echo json_encode($response);
			die();
		}
	}

	// Return current post type in dashboard
	if ( !function_exists( 'healthandcare_admin_get_current_post_type' ) ) {
		function healthandcare_admin_get_current_post_type() {
			global $post, $typenow, $current_screen;
			if ( $post && $post->post_type )							//we have a post so we can just get the post type from that
				return $post->post_type;
			else if ( $typenow )										//check the global $typenow — set in admin.php
				return $typenow;
			else if ( $current_screen && $current_screen->post_type )	//check the global $current_screen object — set in sceen.php
				return $current_screen->post_type;
			else if ( isset( $_REQUEST['post_type'] ) )					//check the post_type querystring
				return sanitize_key( $_REQUEST['post_type'] );
			else if ( isset( $_REQUEST['post'] ) ) {					//lastly check the post id querystring
				$post = get_post( sanitize_key( $_REQUEST['post'] ) );
				return !empty($post->post_type) ? $post->post_type : '';
			} else														//we do not know the post type!
				return '';
		}
	}
	
	// Register optional plugins
	if ( !function_exists( 'healthandcare_admin_register_plugins' ) ) {
		function healthandcare_admin_register_plugins() {

			$plugins = apply_filters('healthandcare_filter_required_plugins', array(
				array(
					'name' 		=> 'Healthandcare Utilities',
					'slug' 		=> 'healthandcare-utils',
					'source'	=> healthandcare_get_file_dir('plugins/healthandcare-utils.zip'),
					'required' 	=> true
				),
				array(
					'name' 		=> 'Visual Composer',
					'slug' 		=> 'js_composer',
					'source'	=> healthandcare_get_file_dir('plugins/js_composer.zip'),
					'required' 	=> true
				),
				array(
					'name' 		=> 'Revolution Slider',
					'slug' 		=> 'revslider',
					'source'	=> healthandcare_get_file_dir('plugins/revslider.zip'),
					'required' 	=> true
				),
                array(
                    'name' 		=> 'Booked',
                    'slug' 		=> 'booked',
                    'source'	=> healthandcare_get_file_dir('plugins/booked.zip'),
                    'required' 	=> true
                ),
                array(
                    'name' 		=> 'Essential Grid',
                    'slug' 		=> 'essgrids',
                    'source'	=> healthandcare_get_file_dir('plugins/essential-grid.zip'),
                    'required' 	=> true
                ),
				array(
					'name' 		=> 'WooCommerce',
					'slug' 		=> 'woocommerce',
					'required' 	=> true
				),
				array(
					'name' 		=> 'WP Social Login',
					'slug' 		=> 'wordpress-social-login',
					'required' 	=> true
				),
				array(
					'name' 		=> 'Instagram Widget',
					'slug' 		=> 'wp-instagram-widget',
					//'source'	=> healthandcare_get_file_dir('plugins/wp-instagram-widget.zip'),
					'required' 	=> false
				)
			));

            $config = array(
                'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
                'default_path' => '',                      // Default absolute path to bundled plugins.
                'menu'         => 'tgmpa-install-plugins', // Menu slug.
                'parent_slug'  => 'themes.php',            // Parent menu slug.
                'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
                'has_notices'  => true,                    // Show admin notices or not.
                'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
                'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => true,                    // Automatically activate plugins after installation or not.
                'message'      => ''                       // Message to output right before the plugins table.
            );
	
			tgmpa( $plugins, $config );
		}
	}

	require_once( healthandcare_get_file_dir('lib/tgm/class-tgm-plugin-activation.php') );

	require_once( healthandcare_get_file_dir('tools/emailer/emailer.php') );
	require_once( healthandcare_get_file_dir('tools/po_composer/po_composer.php') );
}

?>